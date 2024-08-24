<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class passwordresetrequest extends Model
{
    use HasFactory;
    public $fillable = [
       'user_id',
       'email',
       'otp',
       'timeperiod',
       'status',
    ];
}
