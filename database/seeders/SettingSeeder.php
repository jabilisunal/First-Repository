<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Settings::truncate();

        $settings = [
            [
                'name' => 'maintenance',
                'val' => 1,
                'type' => 'integer',
            ],
            [
                'name' => 'subscribe',
                'val' => 1,
                'type' => 'integer',
            ],
            [
                'name' => 'site_url',
                'val' => 'https://myselftravel.az',
                'type' => 'string',
            ],
            [
                'name' => 'site_name',
                'val' => 'Trendshop.az',
                'type' => 'string',
            ],
            [
                'name' => 'site_light_logo_url',
                'val' => '/storefront/assets/img/logo.png',
                'type' => 'string',
            ],
            [
                'name' => 'site_dark_logo_url',
                'val' => '/storefront/assets/img/logo.png',
                'type' => 'string',
            ],
            [
                'name' => 'phone',
                'val' => '+994105281717',
                'type' => 'string',
            ],
            [
                'name' => 'whatsapp_phone',
                'val' => '+994105281717',
                'type' => 'string',
            ],
            [
                'name' => 'email',
                'val' => 'info@myselftravel.az',
                'type' => 'string',
            ],
            [
                'name' => 'address',
                'val' => 'Lawrence, NY 11345, USA',
                'type' => 'string',
            ],
            [
                'name' => 'facebook',
                'val' => 'https://www.facebook.com/',
                'type' => 'string',
            ],
            [
                'name' => 'twitter',
                'val' => 'https://www.twitter.com/',
                'type' => 'string',
            ],
            [
                'name' => 'instagram',
                'val' => 'https://www.instagram.com/',
                'type' => 'string',
            ],
            [
                'name' => 'linkedin',
                'val' => 'https://www.linkedin.com/',
                'type' => 'string',
            ],
            [
                'name' => 'snapchat',
                'val' => 'https://www.snapchat.com/',
                'type' => 'string',
            ],
            [
                'name' => 'tiktok',
                'val' => 'https://www.tiktok.com/',
                'type' => 'string',
            ],
            [
                'name' => 'telegram',
                'val' => 'https://web.telegram.org/a/#-1001231063061',
                'type' => 'string',
            ],
            [
                'name' => 'visa_show',
                'val' => 1,
                'type' => 'integer',
            ],
            [
                'name' => 'master_show',
                'val' => 1,
                'type' => 'integer',
            ],
            [
                'name' => 'qr_code_show',
                'val' => 1,
                'type' => 'integer',
            ],
            [
                'name' => 'app_store_show',
                'val' => 1,
                'type' => 'integer',
            ],
            [
                'name' => 'play_store_show',
                'val' => 1,
                'type' => 'integer',
            ],
            [
                'name' => 'qr_code_url',
                'val' => '/storefront/assets/images/others/qr.png',
                'type' => 'string',
            ],
            [
                'name' => 'app_store_url',
                'val' => '#',
                'type' => 'string',
            ],
            [
                'name' => 'play_store_url',
                'val' => '#',
                'type' => 'string',
            ],
            [
                'name' => 'contact_hours',
                'val' => 'Mon-Sun : 24 hours',
                'type' => 'string',
            ],
            [
                'name' => 'latitude',
                'val' => 49.345,
                'type' => 'float',
            ],
            [
                'name' => 'longitude',
                'val' => 50.435,
                'type' => 'float',
            ],
            [
                'name' => 'zoom',
                'val' => 14,
                'type' => 'integer',
            ],
        ];

        Settings::insert($settings);
    }
}
