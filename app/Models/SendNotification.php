<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendNotification extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class, 'send_notifications', 'user_id', 'id');
    }

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];
}
