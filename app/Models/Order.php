<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_code',
        'magic_token',
        'name',
        'phone',
        'email',
        'address',
        'note',
        'payment_proof_path',
        'payment_proof_hash',
        'status',
        'is_read_by_admin',
        'download_count',
    ];

    protected $casts = [
        'is_read_by_admin' => 'boolean',
        'download_count' => 'integer',
    ];

    public function isVerified()
    {
        return $this->status === 'verified';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function canDownload()
    {
        return $this->isVerified();
    }
}
