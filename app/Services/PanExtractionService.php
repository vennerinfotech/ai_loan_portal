<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PanExtractionService
{
    /**
     * Extract data from PAN card image using OCR
     *
     * @param  string  $imagePath  Full path to the PAN card image
     * @return array|null Extracted data or null on failure
     */
    public function extractFromImage($imagePath)
    {
        try {
            if (!file_exists($imagePath)) {
                Log::error('PAN Image file not found for OCR', ['path' => $imagePath]);
                return null;
            }

            // 1. Try OCR.space API (if configured)
            $extractedData = $this->extractUsingOCRSpace($imagePath);
            if ($extractedData && !empty($extractedData['pan_number'])) {
                return $extractedData;
            }

            // 2. Fallback to Mock?
            // User requested proper extraction. If valid OCR fails, we should NOT return fake data
            // as it confuses the user. Logging the failure instead.
            Log::warning('Real OCR failed to extract PAN Number. Returning null.');

            // Uncomment next line ONLY for demo if you want random data on failure
            // return $this->extractUsingMock($imagePath);

            return null;
        } catch (\Exception $e) {
            Log::error('Error extracting PAN data: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Mock Extraction for Demo/Development
     */
    private function extractUsingMock($imagePath)
    {
        Log::info('Using Mock OCR for PAN Card', ['path' => $imagePath]);

        // Return plausible mock data
        return [
            'pan_number' => 'ABCDE' . rand(1000, 9999) . 'F',
            'name' => 'RAJESH KUMAR SHARMA',  // Standard demo name
            'father_name' => 'MOHAN LAL SHARMA',
            'date_of_birth' => '15/03/1985',
        ];
    }

    /**
     * Extract data using OCR.space API
     */
    private function extractUsingOCRSpace($imagePath)
    {
        try {
            // Use a default free key 'helloworld' if not set, or ensure config exists
            $apiKey = config('services.ocr_space.api_key', env('OCR_SPACE_API_KEY', 'helloworld'));

            $imageData = file_get_contents($imagePath);
            // Check file size (OCR.space free limit is 1MB usually, helloworld is strictly limited)
            $sizeKB = strlen($imageData) / 1024;
            if ($sizeKB > 1024 && $apiKey === 'helloworld') {
                Log::warning('Image too large for free OCR key: ' . $sizeKB . 'KB');
            }

            $base64Image = base64_encode($imageData);

            $response = Http::asForm()
                ->timeout(60)
                ->post('https://api.ocr.space/parse/image', [
                    'apikey' => $apiKey,
                    'base64Image' => 'data:image/jpeg;base64,' . $base64Image,
                    'language' => 'eng',
                    'isOverlayRequired' => 'true',
                    'detectOrientation' => 'true',  // Auto-rotate helps
                    'scale' => 'true',  // Upscale helps low-res
                    'OCREngine' => '2',  // Engine 2 is better for numbers/IDs
                ]);

            if ($response->successful()) {
                $result = $response->json();

                // Check if API returned an error message inside 200 OK
                if (isset($result['IsErroredOnProcessing']) && $result['IsErroredOnProcessing'] === true) {
                    Log::warning('OCR.space API Processing Error', ['details' => $result['ErrorMessage'] ?? 'Unknown']);
                    return null;
                }

                if (isset($result['ParsedResults'][0]['ParsedText'])) {
                    return $this->parsePanText($result['ParsedResults'][0]['ParsedText']);
                }
            } else {
                Log::error('OCR.space API HTTP Error', ['status' => $response->status(), 'body' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('OCR.space PAN extraction error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Parse extracted text to find PAN details
     */
    private function parsePanText($text)
    {
        $data = [
            'pan_number' => null,
            'name' => null,
            'father_name' => null,
            'date_of_birth' => null,
        ];

        // normalize newlines
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $lines = explode("\n", $text);

        // Clean and filter lines
        $cleanLines = [];
        foreach ($lines as $line) {
            $line = trim($line);
            $line = preg_replace('/[^\x20-\x7E]/', '', $line);  // Remove non-printable chars
            if (strlen($line) > 2) {  // Ignore very short noise
                $cleanLines[] = strtoupper($line);
            }
        }
        $lines = $cleanLines;

        $panIndex = -1;
        $dobIndex = -1;
        $headerIndex = -1;

        // 1. First Pass: Locate Anchors (PAN, DOB, Header)
        foreach ($lines as $index => $line) {
            // PAN regex: 5 chars, 4 digits, 1 char (Strict)
            if (!$data['pan_number'] && preg_match('/\b([A-Z]{5}[0-9]{4}[A-Z])\b/', $line, $matches)) {
                $data['pan_number'] = $matches[1];
                $panIndex = $index;
            }

            // DOB regex: Support /, -, ., and space separators. DD/MM/YYYY
            if (!$data['date_of_birth'] && preg_match('/\b(\d{2}[\/\-\.\s]\d{2}[\/\-\.\s]\d{4})\b/', $line, $matches)) {
                // Normalize to DD/MM/YYYY
                $rawDob = $matches[1];
                $data['date_of_birth'] = preg_replace('/[\.\s\-]/', '/', $rawDob);
                $dobIndex = $index;
            }

            // Header Detection (Top of card)
            if ($headerIndex === -1 && ($this->isHeaderLine($line))) {
                $headerIndex = $index;
            }
        }

        // 2. Zone Analysis for Names
        // Ideally, Name and Father Name are BETWEEN Header and DOB
        // If Header is missing (common in cropped images), assume start of file.
        // If DOB is missing, assume PAN line as bottom limit.

        $startIndex = ($headerIndex !== -1) ? $headerIndex + 1 : 0;
        $endIndex = ($dobIndex !== -1) ? $dobIndex : ($panIndex !== -1 ? $panIndex : count($lines));

        $candidateLines = [];

        for ($i = $startIndex; $i < $endIndex; $i++) {
            if (!isset($lines[$i]))
                continue;
            $line = $lines[$i];

            // Aggressive Noise Filtering
            if ($this->isHeaderLine($line))
                continue;
            if (str_contains($line, 'GOVT'))
                continue;
            if (str_contains($line, 'INDIA'))
                continue;
            if (str_contains($line, 'NAME'))
                continue;  // "Name" label
            if (str_contains($line, 'FATHER'))
                continue;  // "Father Name" label
            if (str_contains($line, 'SIGNATURE'))
                continue;
            if (preg_match('/^\d+$/', $line))
                continue;  // Digits only

            // Must contain at least 2 words (usually) and letters
            if (str_word_count($line) < 1)
                continue;
            if (strlen($line) < 3)
                continue;

            $candidateLines[] = $line;
        }

        // 3. Assign Candidates
        // Heuristic: 1st valid line is Name, 2nd is Father's Name
        if (count($candidateLines) > 0) {
            $data['name'] = $this->cleanName($candidateLines[0]);
        }
        if (count($candidateLines) > 1) {
            $data['father_name'] = $this->cleanName($candidateLines[1]);
        }

        // Fallback: If no father name found, but we have a bottom-up logic?
        // Sometimes Father's name is just above DOB.
        if (!$data['father_name'] && $dobIndex > 0) {
            // Check line immediately above DOB if not already used
            $lineAbove = $lines[$dobIndex - 1] ?? '';
            if ($this->isValidName($lineAbove) && $lineAbove !== ($data['name'] ?? '')) {
                $data['father_name'] = $this->cleanName($lineAbove);
            }
        }

        return $data;
    }

    private function isHeaderLine($line)
    {
        return (str_contains($line, 'INCOME') || str_contains($line, 'TAX') || str_contains($line, 'DEPARTMENT') || str_contains($line, 'SARKAAR') || str_contains($line, 'GOVT') || str_contains($line, 'INDIA'));
    }

    private function cleanName($text)
    {
        // Remove common labels if they stuck to the name line
        $text = str_replace(['NAME', 'FATHER', ':', '-', '.'], '', $text);
        return trim($text);
    }

    /**
     * Helper to validate a name string
     */
    private function isValidName($text)
    {
        if (strlen($text) < 3)
            return false;
        if (preg_match('/\d/', $text))
            return false;  // No numbers in names
        if ($this->isHeaderLine($text))
            return false;
        if (str_contains($text, 'SIGNATURE'))
            return false;
        return true;
    }
}
