<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NikValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove any non-numeric characters
        $nik = preg_replace('/[^0-9]/', '', $value);
        
        // Check if NIK is exactly 16 digits
        if (strlen($nik) !== 16) {
            $fail('NIK harus 16 digit angka.');
            return;
        }
        
        // Check if all characters are numeric
        if (!ctype_digit($nik)) {
            $fail('NIK harus berisi angka saja.');
            return;
        }
        
        // Basic validation: NIK should not be all the same digit
        if (count(array_count_values(str_split($nik))) === 1) {
            $fail('NIK tidak valid.');
            return;
        }
        
        // Additional validation: Check if it's a valid format
        // First 6 digits: province code (should be valid)
        // This is a simplified check - in production you might want more sophisticated validation
        $provinceCode = substr($nik, 0, 6);
        if (!is_numeric($provinceCode)) {
            $fail('Format NIK tidak valid.');
            return;
        }
    }
}
