<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable  = ['balance'];

    public static function generateUserId(){
        $user_id = random_int(100000, 999999);
        if(self::where('user_id',$user_id)->exists()){
            self::generateUserId();
        }
        return $user_id;
    }

    public static function boot(){
        parent::boot();


        static::creating(function($model){
            // $model->wallet_address = 'TR'.self::getRandomStringMtrand();
        });

    }

    public static function getRandomStringMtrand($length = 32)
    {

        $keys = range('a', 'z');
        $key = "";
        for ($i = 0; $i < 4; $i++) {
            $key .= $keys[mt_rand(0, count($keys) - 1)];
        }

        $keys = array_merge(range(0, 9), range('A', 'Z'),range('a', 'z'));
        for ($i = 0; $i < ($length - 4); $i++) {
            $key .= $keys[mt_rand(0, count($keys) - 1)];
        }

        $randomString = $key;
        return $randomString;
    }

    public function getRouteKeyName()
    {
        return 'user_id';
    }

    protected $casts = [
        'balance_checked_at' => 'datetime',
        'rewarded_at' => 'datetime',

    ];
}
