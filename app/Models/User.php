<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Auth;
use Exception;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'otp',
        'image',
        'password',
        'referral_link',
        'referral_id',
        'device_token',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    public function user_available_amount()
    {
        $userId = $this->id;
        try {

            
            $data = TransactionTable::where('user_id', $userId)->sum('avaiable_amount');

             $this->res = [
                'User_Avaiable_Amount' => $data,
            ];
        } catch (Exception $ex) {
            $this->res = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }
     protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
