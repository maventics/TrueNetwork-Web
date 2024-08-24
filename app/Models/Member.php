<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'referral_user_id',
        'deposit_id',
    ];

    // public function User()
    // {
    //     return $this->belongsTo(User::class,'user_id','id');
    // }


    public function referrals()
    {
        return $this->hasMany(Member::class, 'referral_user_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referralUser()
    {
        return $this->belongsTo(User::class, 'referral_user_id');
    }
}
