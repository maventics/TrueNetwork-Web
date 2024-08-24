<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\schemes;
use Illuminate\Database\Eloquent\Builder;

class Investment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'scheme_ref_id',
        'amount',
        'end_date_timestamp',
        'status',
        'created_at'
    ];


    public function scopeExpired(Builder $query)
    {
        return $query->where('end_date_timestamp', '<', now());
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scheme()
    {
        return $this->belongsTo(schemes::class, 'scheme_ref_id');
    }
}
