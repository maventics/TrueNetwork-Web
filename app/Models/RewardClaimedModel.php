<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardClaimedModel extends Model
{
    use HasFactory;
    protected $table='claimed_rewards';

    protected $fillable=[
        'user_id',
        'reward_id',
        'status',
        'last_deposit',
    ];

    function reward(){
        return $this->belongsTo(Reward::class,'reward_id');
    }

    function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
