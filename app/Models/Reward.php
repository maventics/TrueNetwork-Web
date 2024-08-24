<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;
    protected $table = 'rewards';

    protected $fillable = [
        'reward_title',
        'reward_description',
        'amount',
        'status',
    ];
}
