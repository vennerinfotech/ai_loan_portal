<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AadhaarExtractionService
{
    /**
     * Extract data from Aadhaar card image using OCR
     *
     * @param  string  $imagePath  Full path to the Aadhaar card image
     * @return array|null Extracted data or null on failure
     */
    public function extractFromImage($imagePath)
    {
        try {
            // If the provided path is missing, try common alternate locations
            $resolvedPath = $this->resolveImagePath($imagePath);
            if (!$resolvedPath) {
                Log::error('Image file not found for OCR', ['original_path' => $imagePath]);

                return null;
            }

            // Method 1: Try OCR.space API (Free tier available)
            $extractedData = $this->extractUsingOCRSpace($resolvedPath);

            if ($extractedData) {
                return $extractedData;
            }

            // Method 2: Try Google Cloud Vision API (if configured)
            $extractedData = $this->extractUsingGoogleVision($resolvedPath);

            if ($extractedData) {
                return $extractedData;
            }

            // Method 3: Try Tesseract OCR (if available)
            $extractedData = $this->extractUsingTesseract($resolvedPath);

            return $extractedData;
        } catch (\Exception $e) {
            Log::error('Error extracting Aadhaar data: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Extract data using OCR.space API (Free tier)
     * Sign up at: https://ocr.space/ocrapi
     */
    private function extractUsingOCRSpace($imagePath)
    {
        try {
            // Get API key from config or env (you need to sign up at ocr.space for free API key)
            $apiKey = config('services.ocr_space.api_key', env('OCR_SPACE_API_KEY'));

            if (!$apiKey) {
                Log::warning('OCR.space API key not configured');

                return null;
            }

            // Read image file
            if (!file_exists($imagePath)) {
                Log::error('Image file not found: ' . $imagePath);

                return null;
            }

            $imageData = file_get_contents($imagePath);

            // Log file size to help troubleshoot very large images
            $imageSizeKb = round(strlen($imageData) / 1024, 2);
            if ($imageSizeKb > 4096) {  // >4 MB
                Log::warning('OCR.space: image is large; consider smaller size for faster OCR', [
                    'path' => $imagePath,
                    'size_kb' => $imageSizeKb,
                ]);
            }

            $base64Image = base64_encode($imageData);

            // Call OCR.space API
            $response = Http::asForm()
                ->timeout(120)  // extend timeout to handle slow uploads/responses
                ->post('https://api.ocr.space/parse/image', [
                    'apikey' => $apiKey,
                    'base64Image' => 'data:image/jpeg;base64,' . $base64Image,
                    'language' => 'eng',
                    // OCR.space expects string "true"/"false" for this flag
                    'isOverlayRequired' => 'false',
                ]);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['ParsedResults'][0]['ParsedText'])) {
                    $extractedText = $result['ParsedResults'][0]['ParsedText'];

                    return $this->parseAadhaarText($extractedText);
                }

                Log::warning('OCR.space: no ParsedText returned', [
                    'status' => $response->status(),
                    'result' => $result,
                ]);
            } else {
                Log::error('OCR.space HTTP error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('OCR.space extraction error: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Extract data using Google Cloud Vision API
     * Requires Google Cloud account and API key
     */
    private function extractUsingGoogleVision($imagePath)
    {
        try {
            $apiKey = config('services.google_vision.api_key', env('GOOGLE_VISION_API_KEY'));

            if (!$apiKey) {
                return null;
            }

            if (!file_exists($imagePath)) {
                return null;
            }

            $imageData = file_get_contents($imagePath);
            $base64Image = base64_encode($imageData);

            $response = Http::post('https://vision.googleapis.com/v1/images:annotate?key=' . $apiKey, [
                'requests' => [
                    [
                        'image' => [
                            'content' => $base64Image,
                        ],
                        'features' => [
                            [
                                'type' => 'TEXT_DETECTION',
                            ],
                        ],
                    ],
                ],
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['responses'][0]['textAnnotations'][0]['description'])) {
                    $extractedText = $result['responses'][0]['textAnnotations'][0]['description'];

                    return $this->parseAadhaarText($extractedText);
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Google Vision extraction error: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Extract data using Tesseract OCR (if installed on server)
     */
    private function extractUsingTesseract($imagePath)
    {
        try {
            // Check if Tesseract is available
            $tesseractPath = config('services.tesseract.path', 'tesseract');

            if (!file_exists($imagePath)) {
                return null;
            }

            // Execute Tesseract command
            $outputFile = storage_path('app/temp/ocr_output_' . time() . '.txt');
            $command = escapeshellcmd($tesseractPath) . ' ' . escapeshellarg($imagePath) . ' ' . escapeshellarg($outputFile) . ' 2>&1';

            exec($command, $output, $returnCode);

            if ($returnCode === 0 && file_exists($outputFile . '.txt')) {
                $extractedText = file_get_contents($outputFile . '.txt');
                unlink($outputFile . '.txt');  // Clean up

                return $this->parseAadhaarText($extractedText);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Tesseract extraction error: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Parse extracted text to find Aadhaar card details
     *
     * @param  string  $text  Extracted text from OCR
     * @return array Parsed data
     */
    private function parseAadhaarText($text)
    {
        $data = [
            'name' => null,
            'phone' => null,
            'email' => null,
            'aadhaar_number' => null,
            'date_of_birth' => null,
            'gender' => null,
            'address' => null,
            'father_name' => null,  // Added field
        ];

        // normalize newlines
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        // Clean text for Regex (keep newlines for line-by-line analysis)
        $cleanText = preg_replace('/[^\x20-\x7E\n]/', '', $text);

        // --- 1. KEY FIELDS EXTRACTION (Global Regex) ---

        // Aadhaar number (12 digits, spaced or unspaced)
        if (preg_match('/\b(\d{4}\s?\d{4}\s?\d{4})\b/', $cleanText, $matches)) {
            $data['aadhaar_number'] = preg_replace('/\s+/', '', $matches[1]);
        }

        // Phone number
        if (preg_match('/\b(\+?91[\s-]?)?([6-9]\d{9})\b/', $cleanText, $matches)) {
            $data['phone'] = preg_replace('/\D/', '', $matches[2]);
        }

        // Gender
        if (preg_match('/\b(MALE|FEMALE|TRANSGENDER)\b/i', $cleanText, $matches)) {
            $data['gender'] = strtoupper($matches[1]);
        }

        // DOB / YYYY
        $dobIndex = -1;
        $lines = explode("\n", strtoupper($cleanText));

        // Find DOB Line Index
        foreach ($lines as $i => $line) {
            // Full Date DD/MM/YYYY
            if (preg_match('/\b(\d{2}[\/\-]\d{2}[\/\-]\d{4})\b/', $line, $matches)) {
                $data['date_of_birth'] = str_replace('-', '/', $matches[1]);
                $dobIndex = $i;
                break;
            }
            // Year of Birth : YYYY
            if (preg_match('/YEAR\s*OF\s*BIRTH\s*[:\-]?\s*(\d{4})/', $line, $matches)) {
                $data['date_of_birth'] = '01/01/' . $matches[1];  // Approximate for YOB
                $dobIndex = $i;
                break;
            }
        }

        // --- 2. ADDRESS & FATHER NAME (S/O, C/O) ---
        // Look for 'S/O', 'D/O', 'C/O'
        foreach ($lines as $line) {
            if (preg_match('/\b(S\/O|D\/O|C\/O|W\/O)\s*[:\-]?\s*([A-Z\s\.]+)/', $line, $matches)) {
                $data['father_name'] = trim($matches[2]);
                // Address usually starts here or next line
            }
            if (preg_match('/ADDRESS[:\-]\s*(.*)/', $line, $matches)) {
                $data['address'] = trim($matches[1]);
            }
        }

        // --- 3. NAME EXTRACTION (Context Aware) ---
        // Strategy A: English "Name" Label? (Rare on Card, but check)
        // Strategy B: Lines below "GOVT OF INDIA"
        // Strategy C: Lines *ABOVE* DOB (Best heuristic)

        if (!$data['name'] && $dobIndex > 0) {
            // Check 1-2 lines above DOB
            // Line immediately above DOB is often the Name in simple cards
            // But sometimes it's "Father Name" if S/O is not used explicitly on front

            $candidate = trim($lines[$dobIndex - 1] ?? '');

            // If candidate is not noise
            if ($this->isValidName($candidate)) {
                $data['name'] = $candidate;
            } else {
                // Try one more line up (maybe line above was 'DOB:' label on separate line)
                $candidate2 = trim($lines[$dobIndex - 2] ?? '');
                if ($this->isValidName($candidate2)) {
                    $data['name'] = $candidate2;
                }
            }
        }

        // Strategy D: Classic "GOVT OF INDIA" flow
        if (!$data['name']) {
            foreach ($lines as $i => $line) {
                if (str_contains($line, 'GOVT') && str_contains($line, 'INDIA')) {
                    // Next non-empty line is likely Name
                    $next = trim($lines[$i + 1] ?? '');
                    if ($this->isValidName($next)) {
                        $data['name'] = $next;
                        break;
                    }
                }
            }
        }

        return $data;
    }

    private function isValidName($text)
    {
        if (strlen($text) < 3)
            return false;
        if (preg_match('/\d/', $text))
            return false;
        if (str_contains($text, 'GOVT'))
            return false;
        if (str_contains($text, 'INDIA'))
            return false;
        if (str_contains($text, 'DOB'))
            return false;
        if (str_contains($text, 'YEAR'))
            return false;
        if (str_contains($text, 'MALE'))
            return false;
        if (str_contains($text, 'FEMALE'))
            return false;
        if (str_contains($text, 'AADHAAR'))
            return false;
        return true;
    }

    /**
     * Try to resolve image path across common storage locations
     */
    private function resolveImagePath(string $imagePath): ?string
    {
        if (file_exists($imagePath)) {
            return $imagePath;
        }

        $basename = basename($imagePath);
        $candidates = [
            storage_path('app/private_uploads/aadhar_card/' . $basename),
            storage_path('app/private/private_uploads/aadhar_card/' . $basename),
            storage_path('app/storage/private_uploads/aadhar_card/' . $basename),
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    /**
     * Extract data from Aadhaar card image stored in storage
     *
     * @param  string  $imageFilename  Filename in storage
     * @return array|null
     */
    public function extractFromStoredImage($imageFilename)
    {
        // Try different possible storage paths
        $possiblePaths = [
            storage_path('app/private_uploads/aadhar_card/' . $imageFilename),
            storage_path('app/private/private_uploads/aadhar_card/' . $imageFilename),
            storage_path('app/storage/private_uploads/aadhar_card/' . $imageFilename),
        ];

        foreach ($possiblePaths as $imagePath) {
            if (file_exists($imagePath)) {
                return $this->extractFromImage($imagePath);
            }
        }

        Log::error('Aadhaar image not found in any expected location: ' . $imageFilename);

        return null;
    }
}
