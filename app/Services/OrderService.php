<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class OrderService
{
    public static function generateReceiptCode(): string
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // No I, O, 0, 1
        do {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                if ($i == 4) $code .= '-';
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while (Order::where('receipt_code', $code)->exists());
        
        return $code;
    }

    public static function generateMagicToken(): string
    {
        do {
            $token = Str::random(64);
        } while (Order::where('magic_token', $token)->exists());
        
        return $token;
    }

    public static function calculateFileHash(UploadedFile $file): string
    {
        return hash('sha256', $file->get());
    }

    public static function isDuplicateFileHash(string $hash): bool
    {
        return Order::where('payment_proof_hash', $hash)->exists();
    }
}
