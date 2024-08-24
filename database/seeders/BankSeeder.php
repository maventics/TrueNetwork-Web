<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bank = Bank::create([
            'bank' => 'EasyPasia',
            'status' => 0,
        ]);
        $bank = Bank::create([
            'bank' => 'JazzCash',
            'status' => 0,
        ]);
        $bank = Bank::create([
            'bank' => 'Bank Alfalah',
            'status' => 0,
        ]);
        $bank = Bank::create([
            'bank' => 'United Bank Limited',
            'status' => 0,
        ]);
        $bank = Bank::create([
            'bank' => 'Allied Bank',
            'status' => 0,
        ]);
        $bank = Bank::create([
            'bank' => 'HBL',
            'status' => 0,
        ]);
        $bank = Bank::create([
            'bank' => 'MCB Bank',
            'status' => 0,
        ]);
        $bank = Bank::create([
            'bank' => 'Natianol Bank Of Pakistan',
            'status' => 0,
        ]);

        $bank = Bank::create([
            'bank' => 'Meezan Bank',
            'status' => 0,
        ]);
        $bank = Bank::create([
            'bank' => 'Bank Islami',
            'status' => 0,
        ]);
    }
}
