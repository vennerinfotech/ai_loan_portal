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
            if (! $resolvedPath) {
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
            Log::error('Error extracting Aadhaar data: '.$e->getMessage());

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

            if (! $apiKey) {
                Log::warning('OCR.space API key not configured');

                return null;
            }

            // Read image file
            if (! file_exists($imagePath)) {
                Log::error('Image file not found: '.$imagePath);

                return null;
            }

            $imageData = file_get_contents($imagePath);

            // Log file size to help troubleshoot very large images
            $imageSizeKb = round(strlen($imageData) / 1024, 2);
            if ($imageSizeKb > 4096) { // >4 MB
                Log::warning('OCR.space: image is large; consider smaller size for faster OCR', [
                    'path' => $imagePath,
                    'size_kb' => $imageSizeKb,
                ]);
            }

            $base64Image = base64_encode($imageData);

            // Call OCR.space API
            $response = Http::asForm()
                ->timeout(60) // extend timeout to handle slow uploads/responses
                ->post('https://api.ocr.space/parse/image', [
                    'apikey' => $apiKey,
                    'base64Image' => 'data:image/jpeg;base64,'.$base64Image,
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
            Log::error('OCR.space extraction error: '.$e->getMessage());

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

            if (! $apiKey) {
                return null;
            }

            if (! file_exists($imagePath)) {
                return null;
            }

            $imageData = file_get_contents($imagePath);
            $base64Image = base64_encode($imageData);

            $response = Http::post('https://vision.googleapis.com/v1/images:annotate?key='.$apiKey, [
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
            Log::error('Google Vision extraction error: '.$e->getMessage());

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

            if (! file_exists($imagePath)) {
                return null;
            }

            // Execute Tesseract command
            $outputFile = storage_path('app/temp/ocr_output_'.time().'.txt');
            $command = escapeshellcmd($tesseractPath).' '.escapeshellarg($imagePath).' '.escapeshellarg($outputFile).' 2>&1';

            exec($command, $output, $returnCode);

            if ($returnCode === 0 && file_exists($outputFile.'.txt')) {
                $extractedText = file_get_contents($outputFile.'.txt');
                unlink($outputFile.'.txt'); // Clean up

                return $this->parseAadhaarText($extractedText);
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Tesseract extraction error: '.$e->getMessage());

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
        ];

        // Clean text
        $text = preg_replace('/\s+/', ' ', $text);
        $text = strtoupper($text);

        // Extract Aadhaar number (12 digits)
        if (preg_match('/\b(\d{4}\s?\d{4}\s?\d{4})\b/', $text, $matches)) {
            $data['aadhaar_number'] = preg_replace('/\s+/', '', $matches[1]);
        }

        // Extract phone number (10 digits, may start with +91 or 91)
        if (preg_match('/\b(\+?91[\s-]?)?([6-9]\d{9})\b/', $text, $matches)) {
            $data['phone'] = preg_replace('/\D/', '', $matches[2]);
        }

        // Extract email (if present on card)
        if (preg_match('/\b([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,})\b/i', $text, $matches)) {
            $data['email'] = strtolower($matches[1]);
        }

        // Extract name - Multiple patterns to catch different Aadhaar card formats
        // Pattern 1: After "GOVERNMENT OF INDIA" or "भारत सरकार"
        if (preg_match('/(?:GOVERNMENT OF INDIA|भारत सरकार)[\s\n]+([A-Z\s]{5,60})/i', $text, $matches)) {
            $name = trim($matches[1]);
            // Clean name - remove common OCR errors
            $name = preg_replace('/[^A-Za-z\s\.]/', '', $name);
            $name = preg_replace('/\s+/', ' ', $name);
            if (strlen($name) >= 3) {
                $data['name'] = $name;
            }
        }

        // Pattern 2: After "Name" or "नाम" label
        if (! $data['name'] && preg_match('/(?:NAME|नाम)[\s:]*([A-Z\s]{5,60})(?:\s+(?:DOB|Date|जन्म|YEAR|Year))/i', $text, $matches)) {
            $name = trim($matches[1]);
            $name = preg_replace('/[^A-Za-z\s\.]/', '', $name);
            $name = preg_replace('/\s+/', ' ', $name);
            if (strlen($name) >= 3) {
                $data['name'] = $name;
            }
        }

        // Pattern 3: Between "GOVERNMENT OF INDIA" and "Male/Female" or DOB
        if (! $data['name'] && preg_match('/GOVERNMENT OF INDIA[\s\n]+([A-Z\s]{5,60})(?:\s+(?:Male|Female|M|F|DOB|Date))/i', $text, $matches)) {
            $name = trim($matches[1]);
            $name = preg_replace('/[^A-Za-z\s\.]/', '', $name);
            $name = preg_replace('/\s+/', ' ', $name);
            if (strlen($name) >= 3) {
                $data['name'] = $name;
            }
        }

        // Pattern 4: Look for capitalized words (at least 2 words, 3+ chars each)
        if (! $data['name'] && preg_match('/([A-Z][A-Za-z]{2,}\s+[A-Z][A-Za-z]{2,}(?:\s+[A-Z][A-Za-z]{2,})?)/', $text, $matches)) {
            $name = trim($matches[1]);
            // Make sure it's not a common word like "GOVERNMENT" or "INDIA"
            $excludeWords = ['GOVERNMENT', 'INDIA', 'AADHAAR', 'CARD', 'YEAR', 'DATE', 'MALE', 'FEMALE'];
            $nameWords = explode(' ', $name);
            $validName = [];
            foreach ($nameWords as $word) {
                if (! in_array(strtoupper($word), $excludeWords) && strlen($word) >= 2) {
                    $validName[] = $word;
                }
            }
            if (count($validName) >= 2) {
                $data['name'] = implode(' ', $validName);
            }
        }

        // Extract Date of Birth (DD/MM/YYYY or DD-MM-YYYY format)
        if (preg_match('/(?:DOB|Date of Birth|जन्म)[\s:]*(\d{2}[\/\-]\d{2}[\/\-]\d{4})/i', $text, $matches)) {
            $data['date_of_birth'] = $matches[1];
        }

        // Extract Gender (Male/Female/M/F)
        if (preg_match('/(?:Gender|लिंग)[\s:]*([MF]|MALE|FEMALE)/i', $text, $matches)) {
            $data['gender'] = strtoupper($matches[1]);
        }

        // Extract Address (usually appears after address label)
        if (preg_match('/(?:Address|पता)[\s:]*([A-Z0-9\s,.\-]{20,200})/i', $text, $matches)) {
            $data['address'] = trim($matches[1]);
        }

        return $data;
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
            storage_path('app/private_uploads/aadhar_card/'.$basename),
            storage_path('app/private/private_uploads/aadhar_card/'.$basename),
            storage_path('app/storage/private_uploads/aadhar_card/'.$basename),
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
            storage_path('app/private_uploads/aadhar_card/'.$imageFilename),
            storage_path('app/private/private_uploads/aadhar_card/'.$imageFilename),
            storage_path('app/storage/private_uploads/aadhar_card/'.$imageFilename),
        ];

        foreach ($possiblePaths as $imagePath) {
            if (file_exists($imagePath)) {
                return $this->extractFromImage($imagePath);
            }
        }

        Log::error('Aadhaar image not found in any expected location: '.$imageFilename);

        return null;
    }
}
