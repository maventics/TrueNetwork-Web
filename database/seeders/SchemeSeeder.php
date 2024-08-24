<?php

namespace Database\Seeders;

use App\Models\schemes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class SchemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scheme = schemes::create([
            'title' => 'ZCASH (6%)',
            'sub_title' => 'Daily Profit (60 - 180) PKR',
            'profit' => '6',
            'duration' => 2,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'CARDANO(ADA) (3%)',
            'sub_title' => 'Daily Profit (150 - 450) PKR',
            'profit' => '3',
            'duration' => 7,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'RIPPLE(XRP) (3.4%)',
            'sub_title' => 'Daily Profit (1750 - 2450) PKR',
            'profit' => '3.4',
            'duration' => 10,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'BNB (3.1%)',
            'sub_title' => 'Daily Profit (600 - 2000) PKR',
            'profit' => '3.1',
            'duration' => 15,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'BINANCE (3.2%)',
            'sub_title' => 'Daily Profit (1260 - 4200) PKR',
            'profit' => '3.2',
            'duration' => 22,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'ETHEREUM(ETH) (3.5%)',
            'sub_title' => 'Daily Profit (2250 - 6750) PKR',
            'profit' => '3.5',
            'duration' => 30,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'BITCOIN(BTC) (4%)',
            'sub_title' => 'Daily Profit (3500 - 15000) PKR',
            'profit' => '4',
            'duration' => 45,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'STELLAR(XLM) (5%)',
            'sub_title' => 'Daily Profit (7500 - 7500) PKR',
            'profit' => '5',
            'duration' => 60,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'OKEX (5.5%)	',
            'sub_title' => 'Daily Profit (11000 - 11000) PKR	',
            'profit' => '5.5',
            'duration' => 90,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'BITCOIN CASH(BCH)(6%)	',
            'sub_title' => 'Daily Profit (600 - 3000) PKR	',
            'profit' => '6',
            'duration' => 120,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);

        $scheme = schemes::create([
            'title' => 'BUSD (7%)	',
            'sub_title' => 'Daily Profit (700 - 7000) PKR',
            'profit' => '7',
            'duration' => 180,
            'user_investment_limit' => 3,
            'bg_image' => '1709717638.jpg',
            'status' => 1,
        ]);
    }
}
