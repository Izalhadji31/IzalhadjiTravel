<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class IndonesianPhoneValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove any non-numeric characters except + at the beginning
        $phone = preg_replace('/[^0-9+]/', '', $value);
        
        // Remove leading +62 or 62 and normalize to 0
        if (str_starts_with($phone, '+62')) {
            $phone = '0' . substr($phone, 3);
        } elseif (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }
        
        // Check if phone number starts with 0
        if (!str_starts_with($phone, '0')) {
            $fail('Nomor HP harus dimulai dengan 0 atau +62.');
            return;
        }
        
        // Check length: Indonesian phone numbers are typically 10-13 digits (including leading 0)
        if (strlen($phone) < 10 || strlen($phone) > 13) {
            $fail('Nomor HP harus 10-13 digit.');
            return;
        }
        
        // Check if all characters are numeric
        if (!ctype_digit($phone)) {
            $fail('Nomor HP harus berisi angka saja.');
            return;
        }
        
        // Validate Indonesian mobile prefixes
        $validPrefixes = [
            '0811', '0812', '0813', '0821', '0822', '0852', '0853',  // Telkomsel
            '0814', '0815', '0816', '0855', '0856', '0857', '0858',  // Indosat
            '0817', '0818', '0819', '0859', '0877', '0878',       // XL Axiata
            '0823', '0851', '0852', '0853',                          // Tri (3)
            '089',                                                   // Smartfren
            '088',                                                   // Smartfren
        ];
        
        $prefix = substr($phone, 0, 4);
        $prefix3 = substr($phone, 0, 3);
        
        $isValidPrefix = false;
        foreach ($validPrefixes as $validPrefix) {
            if (str_starts_with($phone, $validPrefix)) {
                $isValidPrefix = true;
                break;
            }
        }
        
        if (!$isValidPrefix) {
            $fail('Nomor HP tidak valid. Gunakan nomor operator Indonesia yang valid.');
            return;
        }
        
        // Additional validation: Phone number should not be all the same digit
        if (count(array_count_values(str_split($phone))) === 1) {
            $fail('Nomor HP tidak valid.');
            return;
        }
    }
}
