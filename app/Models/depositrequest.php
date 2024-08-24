<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class depositrequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_id',
        'accountholder',
        'accountnumber',
        'depositamount',
        'description',
        'image',
        'status',
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

