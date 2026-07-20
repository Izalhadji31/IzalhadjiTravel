<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function validateCode(Request $request): JsonResponse
    {
        $code = strtoupper($request->get('code', ''));
        $amount = floatval($request->get('amount', 0));

        $voucher = Voucher::where('code', $code)->first();

        if (! $voucher) {
            return response()->json(['valid' => false, 'message' => 'Kode voucher tidak ditemukan']);
        }

        if (! $voucher->isValid()) {
            return response()->json(['valid' => false, 'message' => 'Voucher sudah tidak berlaku']);
        }

        $discount = 0;
        if ($voucher->type === 'percentage') {
            $discount = $amount * ($voucher->value / 100);
            if ($voucher->max_discount) {
                $discount = min($discount, $voucher->max_discount);
            }
        } else {
            $discount = min($voucher->value, $amount);
        }

        return response()->json([
            'valid' => true,
            'discount' => round($discount),
            'voucher_id' => $voucher->id,
        ]);
    }
}
