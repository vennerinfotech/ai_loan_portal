<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
            'name' => 'RAJESH KUMAR SHARMA', // Standard demo name
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
                    'base64Image' => 'data:image/jpeg;base64,'.$base64Image,
                    'language' => 'eng',
                    'isOverlayRequired' => 'true', 
                    'detectOrientation' => 'true', // Auto-rotate helps
                    'scale' => 'true',             // Upscale helps low-res
                    'OCREngine' => '2',            // Engine 2 is better for numbers/IDs
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
            Log::error('OCR.space PAN extraction error: '.$e->getMessage());
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

        $cleanedText = strtoupper(trim($text));
        $lines = explode("\n", $cleanedText);
        
        // Filter empty lines
        $lines = array_values(array_filter($lines, function($line) {
            return trim($line) !== '';
        }));

        $panIndex = -1;
        $dobIndex = -1;
        $govIndex = -1;

        foreach ($lines as $index => $line) {
            $line = trim($line);
            
            // 1. Extract PAN Number (Regex: 5 chars, 4 digits, 1 char)
            if (!$data['pan_number'] && preg_match('/\b([A-Z]{5}[0-9]{4}[A-Z])\b/', $line, $matches)) {
                $data['pan_number'] = $matches[1];
                $panIndex = $index;
            }

            // 2. Extract DOB (DD/MM/YYYY or DD-MM-YYYY)
            if (!$data['date_of_birth'] && preg_match('/\b(\d{2}[\/\-]\d{2}[\/\-]\d{4})\b/', $line, $matches)) {
                $data['date_of_birth'] = $matches[1];
                $dobIndex = $index;
            }

            // Detect Header
            if ($govIndex === -1 && (str_contains($line, 'INCOME') || str_contains($line, 'TAX') || str_contains($line, 'GOVT') || str_contains($line, 'INDIA'))) {
                $govIndex = $index;
            }
        }

        // Strategy A: Header Relative (Existing)
        if ($govIndex !== -1) {
            $candidateIndex = $govIndex + 1;
            
            // Skip extra header lines if they appear after the detected header
            while(isset($lines[$candidateIndex])) {
                $line = trim($lines[$candidateIndex]);
                if ($this->isHeaderLine($line)) {
                    $candidateIndex++;
                } else {
                    break;
                }
            }

            // Name is the first valid line after headers
            if (isset($lines[$candidateIndex])) {
                $possibleName = trim($lines[$candidateIndex]);
                if ($this->isValidName($possibleName)) {
                     $data['name'] = $possibleName;
                }
            }
            
            // Father's name is usually the next line
            if (isset($lines[$candidateIndex + 1])) {
                $possibleFather = trim($lines[$candidateIndex + 1]);
                 if ($this->isValidName($possibleFather)) {
                     // Verify it's not the DOB line
                     if ($candidateIndex + 1 !== $dobIndex) {
                        $data['father_name'] = $possibleFather;
                     }
                }
            }
        }

        // Strategy B: Fallback (Positional before DOB)
        // If Name or Father Name is still missing, look at lines BEFORE DOB (and before PAN)
        if (!$data['name'] || !$data['father_name']) {
            $limitIndex = ($dobIndex !== -1) ? $dobIndex : ($panIndex !== -1 ? $panIndex : count($lines));
            $candidates = [];

            for ($i = 0; $i < $limitIndex; $i++) {
                if ($i === $govIndex) continue; // Skip header
                
                $line = trim($lines[$i]);
                
                // Skip Header-like lines
                if ($this->isHeaderLine($line)) continue;
                // Skip label-like lines
                if (str_contains($line, 'SIGNATURE')) continue;

                if ($this->isValidName($line)) {
                    $candidates[] = $line;
                }
            }

            // If we have candidates, 1st is Name, 2nd is Father
            if (!empty($candidates)) {
                if (!$data['name']) {
                    $data['name'] = $candidates[0];
                }
                if (!$data['father_name'] && isset($candidates[1])) {
                    $data['father_name'] = $candidates[1];
                }
            }
        }

        return $data;
    }

    private function isHeaderLine($line)
    {
        return (str_contains($line, 'INCOME') || str_contains($line, 'TAX') || str_contains($line, 'GOVT') || str_contains($line, 'INDIA') || str_contains($line, 'PERMANENT') || str_contains($line, 'ACCOUNT') || str_contains($line, 'NUMBER') || str_contains($line, 'CARD') || str_contains($line, 'SIGNATURE'));
    }

    /**
     * Helper to validate a name string
     */
    /**
     * Helper to validate a name string
     */
    private function isValidName($text)
    {
        // Must contain letters, assume min length 3
        if (strlen($text) < 3) return false;
        // Should not contain digits (usually)
        if (preg_match('/\d/', $text)) return false;
        
        // Common unwanted keywords in UPPERCASE (since text is upper)
        // Removed 'NAME' and 'FATHER' from generic list to handle them partly specifically
        $invalidKeywords = ['MOTHER', 'SIGNATURE', 'NUMBER', 'CARD', 'NO.', 'PERMANENT', 'ACCOUNT', 'GOVT', 'INDIA', 'INCOME', 'TAX'];
        
        foreach ($invalidKeywords as $keyword) {
            if (str_contains($text, $keyword)) {
                // Hard fail for these administrative/label keywords
                return false;
            }
        }

        // Special check for "NAME" label
        // If line contains "NAME", it must be very long to be a valid person name (e.g. "SURNAME" is rare, "ANAMIKA" is ok)
        // But "FATHER'S NAME" or "FAT FTER'S NAME" is usually short (< 25)
        if (str_contains($text, 'NAME')) {
            // If it matches "NAME" as a whole word at the end of the string, it's likely a label
            // e.g. "FATHER NAME", "FAT FTER NAME"
            if (preg_match('/NAME$/', $text)) {
                 return false;
            }
            if (strlen($text) < 25) return false;
        }

        // Special check for "FATHER" related typos
        // Check for words starting with F, ending with R or S, followed by NAME
        if (str_contains($text, 'FATHER') || str_contains($text, 'FTER')) {
             return false;
        }
        
        return true;
    }
}
