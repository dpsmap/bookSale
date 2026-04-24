<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'order_open' => true,
                'book_published' => false,
                'pdf_file_key' => null,
                'epub_file_key' => null,
                'pdf_filename' => null,
                'epub_filename' => null,
            ]
        );
    }
}
