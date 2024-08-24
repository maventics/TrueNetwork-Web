<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissions extends Model
{
    use HasFactory;
    protected $table='comissions';
    protected $fillable=[
        'user_id','member_id',
        "level",
        'amount',
        'commission',
        'transaction_id'
    ];
}