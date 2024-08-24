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
            'key'=>"name",
            'value'=>"PSX_I",
        ]);
        Setting::create([
            'key'=>"logo",
            'value'=>"/images/logo.png",
        ]);
        Setting::create([
            'key'=>"fcm_token",
            'value'=>"AAAABmDste4:APA91bGcXkxulcwZy-XwdLVTj102k6wlTnzDdSuIr2Qo9UBkiAQZ0VHAKnqy2Wv4VscgBrHMPwPdTUAGuGirf_Jzt2qS7xHaoKT3J8j4e5xS7xGy267vWtDf2-EfL7lob0AZ4unXi8qT",
        ]);
        Setting::create([
            'key'=>"defualt_currency",
            'value'=>"PKR",
        ]);
        Setting::create([
            'key'=>"default_currency_symbol",
            'value'=>"RS",
        ]);
        Setting::create([
            'key'=>"deposit_bonus_percentage",
            'value'=>"5",
        ]);
        Setting::create([
            'key'=>"withdraw_fee_percentage",
            'value'=>"5",
        ]);
        Setting::create([
            'key'=>"level_1_commission_percentage",
            'value'=>"2.1",
        ]);
        Setting::create([
            'key'=>"level_2_commission_percentage",
            'value'=>"4.3",
        ]);
        Setting::create([
            'key'=>"level_3_commission_percentage",
            'value'=>"6.5",
        ]);
        Setting::create([
            'key'=>"android_app_version",
            'value'=>"1.0.1",
        ]);
        Setting::create([
            'key'=>"android_app_url",
            'value'=>"https://example.com",
        ]);
        Setting::create([
            'key'=>"ios_app_url",
            'value'=>"https://example.com",
        ]);
    }
}
