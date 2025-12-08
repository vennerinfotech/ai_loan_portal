<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Document;
use App\Models\User;
use App\Services\AadhaarExtractionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccountCreationService
{
    /**
     * Automatically create or get user and customer accounts based on Aadhaar number
     * If Aadhaar exists, use existing account; if not, create new account
     *
     * @param string $aadhaarNumber
     * @param string|null $panNumber
     * @param string|null $nameFromAadhaar Optional name extracted from Aadhaar card
     * @param string|null $aadhaarImagePath Optional path to Aadhaar image for extraction
     * @return array|null Returns ['user' => $user, 'customer' => $customer] on success, null on failure
     */
    public function createOrGetAccountsFromAadhaar($aadhaarNumber, $panNumber = null, $nameFromAadhaar = null, $aadhaarImagePath = null)
    {
        try {
            DB::beginTransaction();

            // 1. Perform OCR Extraction FIRST (if image provided)
            // We do this even if user exists, so we can update their details (name, address, etc.)
            $extractionService = new AadhaarExtractionService();
            $extractedData = null;
            
            if ($aadhaarImagePath && file_exists($aadhaarImagePath)) {
                $maxRetries = 2; // Reduced retries since we might just be updating
                $retryCount = 0;
                while ($retryCount < $maxRetries && !$extractedData) {
                    $retryCount++;
                    try {
                         $extractedData = $extractionService->extractFromImage($aadhaarImagePath);
                    } catch (\Exception $e) {
                        Log::error('OCR Extraction failed: ' . $e->getMessage());
                    }
                    if (!$extractedData && $retryCount < $maxRetries) sleep(1);
                }
            }

            // Prepare common data from extraction
            $updateData = [];
            if ($extractedData) {
                // Name
                if (!empty($extractedData['name']) && $extractedData['name'] !== 'N/A') {
                    $name = trim($extractedData['name']);
                    $name = preg_replace('/[^A-Za-z\s\.]/', '', $name);
                    $name = preg_replace('/\s+/', ' ', $name);
                    $updateData['name'] = ucwords(strtolower($name));
                }
                // Phone (careful with overwrite? let's trust OCR if valid)
                if (!empty($extractedData['phone']) && preg_match('/^[6-9]\d{9}$/', $extractedData['phone'])) {
                    // Update only if we want to trust OCR phone (User usually manually verifies this, but let's capture it)
                    // $updateData['phone'] = $extractedData['phone']; 
                }
                // DOB
                if (!empty($extractedData['date_of_birth'])) {
                    $updateData['date_of_birth'] = $this->parseDateOfBirth($extractedData['date_of_birth']);
                }
                // Gender
                if (!empty($extractedData['gender'])) {
                    $updateData['gender'] = $this->parseGender($extractedData['gender']);
                }
                // Address
                if (!empty($extractedData['address'])) {
                    $updateData['address'] = $extractedData['address'];
                }
            }

            // Check if user/customer already exists with this Aadhaar number
            $existingUser = User::where('aadhaar_card_number', $aadhaarNumber)->first();
            $existingCustomer = Customer::where('aadhaar_card_number', $aadhaarNumber)->first();

            if ($existingUser && $existingCustomer) {
                // Accounts already exist, update PAN and extracted details
                $updated = false;
                
                // Update PAN
                if ($panNumber) {
                    if ($existingUser->pan_card_number !== $panNumber) {
                        $existingUser->pan_card_number = $panNumber;
                        $updated = true;
                    }
                    if ($existingCustomer->pan_card_number !== $panNumber) {
                        $existingCustomer->pan_card_number = $panNumber;
                        $existingCustomer->save();
                    }
                }

                // Update extracted details (Name, DOB, Address, Gender)
                if (!empty($updateData)) {
                    foreach ($updateData as $key => $value) {
                         // Only update if value is different and not null
                         if ($value && $existingUser->$key !== $value) {
                             $existingUser->$key = $value;
                             $updated = true;
                         }
                         if ($value && $existingCustomer->$key !== $value) {
                             $existingCustomer->$key = $value;
                             $existingCustomer->save();
                         }
                    }
                }

                if ($updated) {
                    $existingUser->save();
                }

                Log::info('Using existing accounts for Aadhaar (Updated details)', [
                    'aadhaar' => $aadhaarNumber,
                    'user_id' => $existingUser->id,
                    'customer_id' => $existingCustomer->id,
                    'updated' => $updated,
                    'data' => $updateData
                ]);
                DB::commit();
                return ['user' => $existingUser, 'customer' => $existingCustomer];
            }

            // If only one exists, create the missing one
            if ($existingUser && !$existingCustomer) {
                $customer = Customer::create([
                    'name' => $updateData['name'] ?? $existingUser->name,
                    'email' => $existingUser->email,
                    'phone' => $existingUser->phone,
                    'pan_card_number' => $panNumber ?? $existingUser->pan_card_number,
                    'aadhaar_card_number' => $aadhaarNumber,
                    'password' => $existingUser->password,
                    'email_verified_at' => $existingUser->email_verified_at,
                    'date_of_birth' => $updateData['date_of_birth'] ?? $existingUser->date_of_birth,
                    'gender' => $updateData['gender'] ?? $existingUser->gender,
                    'address' => $updateData['address'] ?? $existingUser->address,
                ]);
                DB::commit();
                return ['user' => $existingUser, 'customer' => $customer];
            }

            if ($existingCustomer && !$existingUser) {
                $user = User::create([
                    'name' => $updateData['name'] ?? $existingCustomer->name,
                    'email' => $existingCustomer->email,
                    'phone' => $existingCustomer->phone,
                    'pan_card_number' => $panNumber ?? $existingCustomer->pan_card_number,
                    'aadhaar_card_number' => $aadhaarNumber,
                    'password' => $existingCustomer->password,
                    'email_verified_at' => $existingCustomer->email_verified_at,
                    'date_of_birth' => $updateData['date_of_birth'] ?? $existingCustomer->date_of_birth,
                    'gender' => $updateData['gender'] ?? $existingCustomer->gender,
                    'address' => $updateData['address'] ?? $existingCustomer->address,
                ]);
                DB::commit();
                return ['user' => $user, 'customer' => $existingCustomer];
            }

            // No existing accounts, create new ones
            // MANDATORY: Check if we have extracted data from the top
            
            if (!$extractedData) {
                // If we reached here without extracted data, and no accounts exist, we failed.
                // Re-check image path just to be sure we didn't skip extraction by mistake
                 if (!$aadhaarImagePath || !file_exists($aadhaarImagePath)) {
                    DB::rollback();
                    Log::error('Aadhaar image not found for extraction', [
                        'image_path' => $aadhaarImagePath,
                    ]);
                    throw new \Exception('Aadhaar card image is required to extract your information. Please upload a clear image and try again.');
                }
                
                // If we have image path but $extractedData is null, it means extraction failed silently above (or max retries reached)
                DB::rollback();
                throw new \Exception('Failed to extract information from Aadhaar card. Please ensure the image is clear and try again.');
            }


            // Extract and validate data from API response
            // ONLY use data extracted from API - NO generation allowed
            $name = null;
            $phone = null;
            $email = null;

            // Extract NAME from API data
            if (!empty($extractedData['name']) && $extractedData['name'] !== 'N/A' && $extractedData['name'] !== null) {
                $name = trim($extractedData['name']);
                // Clean name: remove special characters, keep only letters, spaces, and dots
                $name = preg_replace('/[^A-Za-z\s\.]/', '', $name);
                $name = preg_replace('/\s+/', ' ', $name);
                $name = ucwords(strtolower($name)); // Proper case
                
                // Validate name length
                if (strlen($name) < 3) {
                    $name = null;
                    Log::warning('Extracted name too short, ignoring', ['name' => $name]);
                }
            }

            // Extract PHONE from API data
            if (!empty($extractedData['phone']) && $extractedData['phone'] !== 'N/A' && $extractedData['phone'] !== null) {
                $phone = preg_replace('/\D/', '', $extractedData['phone']); // Remove non-digits
                
                // Handle +91 or 91 prefix
                if (strlen($phone) > 10) {
                    if (substr($phone, 0, 2) == '91') {
                        $phone = substr($phone, 2);
                    } else {
                        $phone = substr($phone, -10); // Take last 10 digits
                    }
                }
                
                // Validate Indian mobile number (10 digits, starts with 6-9)
                if (strlen($phone) == 10 && preg_match('/^[6-9]\d{9}$/', $phone)) {
                    // Valid phone number
                    Log::info('Valid phone number extracted', ['phone' => $phone]);
                } else {
                    $phone = null;
                    Log::warning('Invalid phone number format, ignoring', ['phone' => $extractedData['phone']]);
                }
            }

            // Extract EMAIL from API data (if present on Aadhaar card)
            if (!empty($extractedData['email']) && $extractedData['email'] !== 'N/A' && $extractedData['email'] !== null) {
                $email = filter_var(trim($extractedData['email']), FILTER_VALIDATE_EMAIL);
                if (!$email) {
                    $email = null;
                    Log::warning('Invalid email format, ignoring', ['email' => $extractedData['email']]);
                }
            }

            // FINAL VALIDATION: We MUST have name and phone from API
            // If missing, we CANNOT create account - throw error
            if (!$name || !$phone) {
                DB::rollback();
                Log::error('CRITICAL: Required data missing from OCR API extraction', [
                    'has_name' => !empty($name),
                    'has_phone' => !empty($phone),
                    'has_email' => !empty($email),
                    'extracted_data' => $extractedData,
                ]);
                throw new \Exception('Could not extract required information (Name and Phone) from your Aadhaar card. Please ensure the image is clear and all text is visible. Try uploading again with better lighting.');
            }

            // Email is optional (Aadhaar cards usually don't have email)
            // If not extracted from API, create a simple email from extracted name
            // This is the ONLY acceptable generation - based on real extracted name
            if (!$email) {
                // Create email from extracted name (real data from API)
                $emailPrefix = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $name));
                if (strlen($emailPrefix) < 3) {
                    // If name is too short, use first 3 letters of name + last 4 digits of Aadhaar
                    $emailPrefix = substr(strtolower($name), 0, 3) . substr($aadhaarNumber, -4);
                }
                $email = $emailPrefix.'@loanportal.local';
                
                // Ensure uniqueness
                $counter = 1;
                while (User::where('email', $email)->exists() || Customer::where('email', $email)->exists()) {
                    $email = $emailPrefix.'_'.$counter.'@loanportal.local';
                    $counter++;
                    if ($counter > 100) {
                        break; // Prevent infinite loop
                    }
                }
                
                Log::info('Email not found on Aadhaar card, created from extracted name', [
                    'extracted_name' => $name,
                    'created_email' => $email,
                ]);
            }

            // Log final extracted data that will be stored
            Log::info('✅ Final data to be stored in database (from OCR API)', [
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'aadhaar' => $aadhaarNumber,
            ]);

            // Generate a random password
            $password = Hash::make($this->generateRandomPassword());

            // Create Customer account
            $customerData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'pan_card_number' => $panNumber,
                'aadhaar_card_number' => $aadhaarNumber,
                'password' => $password,
                'email_verified_at' => now(),
            ];

            // Add extracted data if available
            if ($extractedData) {
                if (isset($extractedData['date_of_birth'])) {
                    $customerData['date_of_birth'] = $this->parseDateOfBirth($extractedData['date_of_birth']);
                }
                if (isset($extractedData['gender'])) {
                    $customerData['gender'] = $this->parseGender($extractedData['gender']);
                }
                if (isset($extractedData['address'])) {
                    $customerData['address'] = $extractedData['address'];
                }
            }

            $customer = Customer::create($customerData);

            Log::info('Customer account created automatically', [
                'customer_id' => $customer->id,
                'email' => $email,
                'phone' => $phone,
                'aadhaar' => $aadhaarNumber,
            ]);

            // Create User account
            $userData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'pan_card_number' => $panNumber,
                'aadhaar_card_number' => $aadhaarNumber,
                'password' => $password,
                'email_verified_at' => now(),
            ];

            // Add extracted data if available
            if ($extractedData) {
                if (isset($extractedData['date_of_birth'])) {
                    $userData['date_of_birth'] = $this->parseDateOfBirth($extractedData['date_of_birth']);
                }
                if (isset($extractedData['gender'])) {
                    $userData['gender'] = $this->parseGender($extractedData['gender']);
                }
                if (isset($extractedData['address'])) {
                    $userData['address'] = $extractedData['address'];
                }
            }

            $user = User::create($userData);

            Log::info('User account created automatically', [
                'user_id' => $user->id,
                'email' => $email,
                'phone' => $phone,
                'aadhaar' => $aadhaarNumber,
            ]);

            DB::commit();

            return [
                'user' => $user,
                'customer' => $customer,
            ];

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating/getting accounts: '.$e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'aadhaar' => $aadhaarNumber,
                'pan' => $panNumber,
            ]);
            return null;
        }
    }

    /**
     * Automatically create user and customer accounts when both Aadhaar and PAN are uploaded
     * This method is kept for backward compatibility
     *
     * @param string $aadhaarNumber
     * @param string $panNumber
     * @return array|null Returns ['user' => $user, 'customer' => $customer] on success, null on failure
     */
    public function createAccountsFromDocuments($aadhaarNumber, $panNumber)
    {
        return $this->createOrGetAccountsFromAadhaar($aadhaarNumber, $panNumber);
    }

    /**
     * Check if both Aadhaar and PAN documents exist and are uploaded
     *
     * @param string|null $aadhaarNumber
     * @param string|null $panNumber
     * @return array|null Returns document data if both exist, null otherwise
     */
    public function checkBothDocumentsExist($aadhaarNumber = null, $panNumber = null)
    {
        // First, try to find a single document with both
        $query = Document::query();
        
        if ($aadhaarNumber) {
            $query->where('aadhar_card_number', $aadhaarNumber);
        }
        
        if ($panNumber) {
            $query->where('pan_card_number', $panNumber);
        }

        // Get the latest document that has both
        $document = $query->whereNotNull('aadhar_card_number')
                          ->whereNotNull('aadhar_card_image')
                          ->whereNotNull('pan_card_number')
                          ->whereNotNull('pan_card_image')
                          ->latest()
                          ->first();

        if ($document) {
            return [
                'aadhaar_number' => $document->aadhar_card_number,
                'pan_number' => $document->pan_card_number,
                'document' => $document,
            ];
        }

        // If single document doesn't have both, check for separate documents
        // Get Aadhaar document
        $aadhaarQuery = Document::whereNotNull('aadhar_card_number')
                                ->whereNotNull('aadhar_card_image');
        
        if ($aadhaarNumber) {
            $aadhaarQuery->where('aadhar_card_number', $aadhaarNumber);
        }
        
        $aadhaarDoc = $aadhaarQuery->latest()->first();

        // Get PAN document
        $panQuery = Document::whereNotNull('pan_card_number')
                           ->whereNotNull('pan_card_image');
        
        if ($panNumber) {
            $panQuery->where('pan_card_number', $panNumber);
        }
        
        $panDoc = $panQuery->latest()->first();

        // If both documents exist, return their data
        if ($aadhaarDoc && $panDoc) {
            return [
                'aadhaar_number' => $aadhaarDoc->aadhar_card_number,
                'pan_number' => $panDoc->pan_card_number,
                'aadhaar_document' => $aadhaarDoc,
                'pan_document' => $panDoc,
            ];
        }

        return null;
    }

    // NOTE: All generation methods have been removed
    // Only OCR API extracted real data is used
    // No fallback generation is allowed for name, phone, or email

    /**
     * Generate random password
     */
    private function generateRandomPassword()
    {
        return substr(md5(uniqid(rand(), true)), 0, 12);
    }

    /**
     * Parse date of birth from various formats
     */
    private function parseDateOfBirth($dob)
    {
        if (!$dob) {
            return null;
        }

        // Try to parse DD/MM/YYYY or DD-MM-YYYY
        if (preg_match('/(\d{2})[\/\-](\d{2})[\/\-](\d{4})/', $dob, $matches)) {
            return $matches[3].'-'.$matches[2].'-'.$matches[1]; // Convert to YYYY-MM-DD
        }

        return null;
    }

    /**
     * Parse gender from various formats
     */
    private function parseGender($gender)
    {
        if (!$gender) {
            return null;
        }

        $gender = strtoupper(trim($gender));
        
        if (in_array($gender, ['M', 'MALE', 'पुरुष'])) {
            return 'Male';
        } elseif (in_array($gender, ['F', 'FEMALE', 'महिला'])) {
            return 'Female';
        }

        return $gender;
    }
}

