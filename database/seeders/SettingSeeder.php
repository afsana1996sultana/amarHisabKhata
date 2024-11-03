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
        Setting::create([
            'site_name' => 'Test Name',
            'site_title' => 'Test Title',
            'header_logo' => asset('images/no-image.png'),
            'footer_logo' => asset('images/no-image.png'),
            'fav_icon' =>asset('images/no-image.png'),
            'contact_number' => '012000000001',
            'email' =>'info@gmail.com',
            'address' =>'Dhaka Bangladesh',
            'fax' =>'0121011110',
        ]);
    }
}
