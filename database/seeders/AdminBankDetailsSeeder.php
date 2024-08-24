<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank\AdminBankDetail;
use Exception;
use Log;

class AdminBankDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 
    public function run(): void
    {
        $adminBankDetails = AdminBankDetail::create([
            'account_title' => 'PSX Bank',
            'account_number' => '0123456789', 
            'bank_id' => 1,
            'admin_id' => 1,
        ]);
    }
}