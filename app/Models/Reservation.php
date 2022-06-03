<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Constants\GlobalConstants;


class Reservation extends Model
{


    protected $table = 'reservations';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = ['date','time','first_name','last_name','phone_number','user_id','wetsuits_count','rental_wakeboards_count','payment_status','price'];
    public $timestamps = true;

    public static function getReservations($date){
        $reservations = DB::table('reservations')->get();
        if($date != GlobalConstants::CURRENT_DAY){
            $reservations = DB::table('reservations')->where('reservations.date',$date)->get();
        }
        return $reservations;
    }
    public static function reservationList()
    {
        $reservations = DB::table('reservations')
            ->orderby('date','ASC')
            ->orderBy('time','ASC')
            ->get();
        return $reservations;
    }

    public static function getReservationsList1($date){
        $reservations = DB::table('reservations')->get();
        if($date != GlobalConstants::CURRENT_DAY){
            $reservations = DB::table('reservations')->where('reservations.date',$date)
                ->orderby('date','ASC')
                ->orderBy('time','ASC')
                ->get();
        }
        return $reservations;
    }

    public function user(){
        $this->belongsTo(User::class);
    }
}
