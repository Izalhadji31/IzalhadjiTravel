<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'route_id'                    => 'required|exists:routes,id',
            'travel_date'                 => 'required_without:scheduled_date|date|after:today',
            'scheduled_date'              => 'required_without:travel_date|date|after:today',
            'number_of_seats'             => 'required|integer|min:1|max:16',
            'passengers'                  => 'nullable|array',
            'passengers.*.name'           => 'required_with:passengers|string|max:255|regex:/^[a-zA-Z\s\-\.\']+$/u',
            'passengers.*.id_type'        => 'required_with:passengers|in:nik,sim,passport',
            'passengers.*.id_number'      => [
                'required_with:passengers',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1] ?? 0;
                    $idType = $this->input("passengers.$index.id_type");

                    if ($idType === 'nik') {
                        if (!preg_match('/^\d{16}$/', $value)) {
                            $fail("NIK harus 16 digit angka (cth: 3201234567890123).");
                        }
                    } elseif ($idType === 'sim') {
                        if (!preg_match('/^[A-Z0-9]{8,12}$/', $value)) {
                            $fail("Nomor SIM tidak valid. Gunakan 8-12 karakter alfanumerik (cth: A1234567).");
                        }
                    } elseif ($idType === 'passport') {
                        // Indonesia passport: 2 letters + 8 digits OR 1 letter + 7 digits (old format)
                        if (!preg_match('/^[A-Z]{1,2}\d{7,8}$/', $value)) {
                            $fail("Nomor Paspor tidak valid (cth: A12345678 atau AB12345678).");
                        }
                    }
                },
            ],
            'passengers.*.seat_number'    => 'required_with:passengers|string|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'route_id.required'                      => 'Pilih rute perjalanan.',
            'route_id.exists'                        => 'Rute yang dipilih tidak valid.',
            'scheduled_date.required_without'        => 'Tentukan tanggal keberangkatan.',
            'scheduled_date.after'                   => 'Tanggal keberangkatan harus minimal 1 hari ke depan.',
            'number_of_seats.required'               => 'Tentukan jumlah kursi.',
            'number_of_seats.integer'                => 'Jumlah kursi harus angka bulat.',
            'number_of_seats.min'                    => 'Minimal pesan 1 kursi.',
            'number_of_seats.max'                    => 'Maksimal pesan 16 kursi per sekali pesan.',
            'passengers.*.name.required_with'        => 'Nama penumpang wajib diisi.',
            'passengers.*.name.regex'                => 'Nama hanya boleh mengandung huruf, spasi, dan tanda hubung.',
            'passengers.*.id_type.required_with'     => 'Jenis identitas wajib dipilih.',
            'passengers.*.seat_number.required_with' => 'Kursi untuk setiap penumpang wajib dipilih.',
        ];
    }

    public function attributes(): array
    {
        return [
            'route_id'                    => 'Rute Perjalanan',
            'scheduled_date'              => 'Tanggal Keberangkatan',
            'number_of_seats'             => 'Jumlah Kursi',
            'passengers.*.name'           => 'Nama Penumpang',
            'passengers.*.id_type'        => 'Jenis Identitas',
            'passengers.*.id_number'      => 'Nomor Identitas',
            'passengers.*.seat_number'    => 'Nomor Kursi',
        ];
    }
}
