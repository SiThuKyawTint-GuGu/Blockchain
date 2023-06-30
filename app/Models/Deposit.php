<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    public const PENDING = 1;
    public const SUCCESS = 2;
    public const REJECT = 3;


    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
