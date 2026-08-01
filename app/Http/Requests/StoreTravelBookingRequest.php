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
            'passengers.*.nik'            => [
                'required_with:passengers',
                'string',
                'max:16',
                'regex:/^\d{16}$/',
            ],
            'passengers.*.phone'          => [
                'required_with:passengers',
                'string',
                'max:20',
                'regex:/^(\+62|62|0)[0-9]{8,15}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'route_id.required'                      => 'Pilih rute perjalanan.',
            'route_id.exists'                        => 'Rute yang dipilih tidak valid.',
            'scheduled_date.required_without'        => 'Tentukan tanggal keberangkatan.',
            'scheduled_date.after'                   => 'Tanggal keberangkatan harus minimal 1 hari ke depan.',
            'number_of_seats.required'               => 'Tentukan jumlah penumpang.',
            'number_of_seats.integer'                => 'Jumlah penumpang harus angka bulat.',
            'number_of_seats.min'                    => 'Minimal pesan 1 penumpang.',
            'number_of_seats.max'                    => 'Maksimal pesan 16 penumpang per sekali pesan.',
            'passengers.*.name.required_with'        => 'Nama penumpang wajib diisi.',
            'passengers.*.name.regex'                => 'Nama hanya boleh mengandung huruf, spasi, dan tanda hubung.',
            'passengers.*.nik.required_with'         => 'NIK penumpang wajib diisi.',
            'passengers.*.nik.regex'                 => 'NIK harus 16 digit angka.',
            'passengers.*.phone.required_with'       => 'Nomor telepon penumpang wajib diisi.',
            'passengers.*.phone.regex'               => 'Nomor telepon tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'route_id'                    => 'Rute Perjalanan',
            'scheduled_date'              => 'Tanggal Keberangkatan',
            'number_of_seats'             => 'Jumlah Penumpang',
            'passengers.*.name'           => 'Nama Penumpang',
            'passengers.*.nik'            => 'NIK Penumpang',
            'passengers.*.phone'          => 'Nomor Telepon Penumpang',
        ];
    }
}
