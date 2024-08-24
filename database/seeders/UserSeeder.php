<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

    class UserSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            $user = User::create([
                'name' => 'Abdullah',
                'email' => 'abdullah@gmail.com',
                'phone' => '123456789',
                'password'=>Hash::make('123456'),
                'referral_link' => 'TMtc0GMj'
            ]);
        }
    }
