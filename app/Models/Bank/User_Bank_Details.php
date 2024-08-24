<?php

namespace App\Models\bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bank;
use App\Models\User;

class User_Bank_Details extends Model
{
    use HasFactory;
    protected $table ='user_bank_details';
    protected $fillable = [
        'account_title',
        'account_number',
        'bank_id',
        'user_id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
