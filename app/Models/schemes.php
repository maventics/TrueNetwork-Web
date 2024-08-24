<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schemes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sub_title',
        'profit',
        'duration',
        'user_investment_limit',
        'image',
        'status',
    ];
    public function investments()
    {
        return $this->hasMany(Investment::class, 'scheme_Ref_id', 'id');
    }

    public function investment()
    {
        return $this->hasMany(Investment::class, 'scheme_ref_id', 'id');
    }


}


