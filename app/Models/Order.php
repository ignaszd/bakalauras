<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = ['user_id','cart','city','address','first_name','last_name','phone_number','payment_id','status'];



    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function getOrders(){
        $orders = DB::table('orders')
            ->orderBy('created_at','ASC')
            ->get();

        return $orders;
    }

}
