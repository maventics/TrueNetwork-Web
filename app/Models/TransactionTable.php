<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTable extends Model
{
    use HasFactory;

    protected $table = 'transaction_tables';  
    
    protected $fillable = [
        'user_id',
        'type',
        'avaiable_amount',
        'status',
        'deposit_id',
        'withdraw_id',
        'investment_id'
    ];


    function withdraw(){
        return $this->belongsTo(Withdrawrequest::class,'withdraw_id');
    }
    function investment(){
        return $this->belongsTo(Investment::class,'investment_id');
    }
    function deposit(){
        return $this->belongsTo(depositrequest::class,'deposit_id');
    }

    public function user(){
       return $this->belongsTo(User::class, 'user_id');
    }
}
