<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_open',
        'book_published',
        'pdf_file_key',
        'epub_file_key',
        'pdf_filename',
        'epub_filename',
    ];

    protected $casts = [
        'order_open' => 'boolean',
        'book_published' => 'boolean',
    ];

    public static function getSettings()
    {
        return self::firstOrCreate(['id' => 1], [
            'order_open' => true,
            'book_published' => false,
        ]);
    }

    public function hasPdfFile()
    {
        return !empty($this->pdf_file_key);
    }

    public function hasEpubFile()
    {
        return !empty($this->epub_file_key);
    }

    public function isOrderOpen()
    {
        return $this->order_open;
    }

    public function isBookPublished()
    {
        return $this->book_published;
    }
}
