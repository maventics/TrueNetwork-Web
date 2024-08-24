<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bank;
use App\Models\admin;

class AdminBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_title',
        'account_number',
        'bank_id',
        'admin_id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id');
    }

    public function admin()
    {
        return $this->belongsTo(admin::class,'admin_id');
    }
}
