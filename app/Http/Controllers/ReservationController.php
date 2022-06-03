<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Constants\GlobalConstants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ReservationController extends Controller
{

    public function index(Request $request)
    {
        $reservations = Reservation::where(GlobalConstants::CURRENT_DAY)->get();
        return view('reservations.index',compact('reservations'));
    }


    public function getMoreReservations(Request $request)
    {
        $size = $request->date;
        Session::put('ss', $request->checked);
        if($request->ajax()){
            $reservations = Reservation::getReservations($size);
            return view('reservations/includes/reservation_data',compact('reservations','size'))->render();
        }
    }

    public function store(Request $request)
    {
        $temporaryWetsuitData = $request->input('wetsuitCount');
        $wetsuitsCount = substr($temporaryWetsuitData, strpos($temporaryWetsuitData, " ") + 1);

        $temporaryWakeboardsData = $request->input('wakeboardCount');
        $wakeboardCount = substr($temporaryWakeboardsData, strpos($temporaryWakeboardsData, " ") + 1);
        $timeCount = count($request->input('time'));

        $totalPrice = $timeCount * 10 + ($wakeboardCount + $wetsuitsCount) * 4;
        foreach ($request->input('time') as $time)
        {
                $reservation = Reservation::create([
                    'date' => $request->input('date'),
                    'time' => $time,
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'phone_number' => $request->input('phone_number'),
                    'wetsuits_count' => $wetsuitsCount,
                    'rental_wakeboards_count' => $wakeboardCount,
                    'user_id' => Auth::user()->id ?? '0',
                    'payment_status' => '0',
                    'price' => $totalPrice,
                ]);


        }
        return redirect()->back()
            ->with('message','Reservation has been completed successfully');
    }

    public function getPrepayment(Request $request)
    {
        $temporaryWetsuitsData = $request->input('wetsuitCount');
        $arr = explode(" ", $temporaryWetsuitsData, 2);
        $wetsuitsPrice = $arr[0];

        $temporaryWakeboardsData = $request->input('wakeboardCount');
        $arr = explode(" ", $temporaryWakeboardsData, 2);
        $wakeboardsPrice = $arr[0];

        $temporaryWetsuitData = $request->input('wetsuitCount');
        $wetsuitsCount = substr($temporaryWetsuitData, strpos($temporaryWetsuitData, " ") + 1);

        $temporaryWakeboardsData = $request->input('wakeboardCount');
        $wakeboardCount = substr($temporaryWakeboardsData, strpos($temporaryWakeboardsData, " ") + 1);

        $timestamp = strtotime($request->date);
        $day = date('l', $timestamp);

        if($day == "Sunday" || $day == "Saturday") {
            $interimPrice =0;
            $sup = implode("-",$request->time);
            $var2 = str_replace("-", " ", $sup);
            $var3 = str_replace(" ", "", $var2);
            $my_array1 = str_split($var3,5);

            $integerIDs = array_map('intval', $my_array1);

            $reservationCount = count($integerIDs);

            if($reservationCount>2)
            {
                foreach (range(1, $reservationCount, 2) as $key) {
                    unset($my_array1[$key]);
                }
                $my_array1 = array_merge($my_array1);

                for($i=0;$i<count($my_array1);$i++)
                {
                    $dates[] = strtotime($my_array1[$i]);
                }
                $pp=0;
                for($i=0;$i<count($dates);$i++) {
                    if (!empty($dates[$i+1]) && !empty($dates[$i+2])) {
                        if($dates[$i]+1200 == $dates[$i+1] && $dates[$i]+2400 == $dates[$i+2] && $dates[$i+1]+1200 == $dates[$i+2])
                        {
                            $pp++;
                            $i +=2;
                            $interimPrice += 40;
                            continue;
                        }
                    }
                    $interimPrice += 16;
                }
            }
            else
                $interimPrice = 16;


            $price = $interimPrice + $wetsuitsPrice + $wakeboardsPrice;
        }
        else{
            $interimPrice = 0;
            $sup = implode("-",$request->time);
            $var2 = str_replace("-", "", $sup);
            $var3 = str_replace(":", "", $var2);


            $my_array1 = str_split($var3,4);
            $integerIDs = array_map('intval', $my_array1);

            $reservationCount = count($integerIDs);
            for($i =0;$i<$reservationCount;$i++)
            {
                if($i % 2 == 0)
                {
                    if($integerIDs[$i]<1600)
                        $interimPrice += 14;
                    else
                        $interimPrice += 16;
                }
            }
            $price = $interimPrice + $wetsuitsPrice + $wakeboardsPrice;
        }



        \Stripe\Stripe::setApiKey('sk_test_51KaGgxCc3mCpUx3hDOv7IcaNbnMpUe8dC4eBvMxfHNo3T5YS3cBk0YpPAGAaH6rfALHq6FUWF6td52yZfLbzALMd00YUyIQNBD');
        $times = $request->time;
        if(count($times)>0){
            Session::put('time',$times);
            Session::put('date',$request->input('date'));
            Session::put('first_name',$request->input('first_name'));
            Session::put('last_name',$request->input('last_name'));
            Session::put('phone_number',$request->input('phone_number'));
            Session::put('wetsuits_count',$wetsuitsCount);
            Session::put('rental_wakeboards_count',$wakeboardCount);
            Session::put('price',$price);
        }
        $payment_intent = \Stripe\PaymentIntent::create([
                'description' => 'Stripe Reservation Test Payment',
                'amount' => $price*100,
                'currency' => 'EUR',
                'payment_method_types' => ['card'],
            ]
        );
        $intent = $payment_intent->client_secret;
        $id = $payment_intent->id;
        Session::forget($request->route('count'));
        return view('reservations.prepayment',compact('intent','id','price','times'));
    }

    public function postPrepayment(Request $request)
    {
        $times = Session::get('time');
        $date = Session::get('date');
        Session::get('time',$times);
        Session::get('date',$request->input('date'));

        foreach ($times as $time)
        {
                $reservation = Reservation::create([
                    'date' => $date,
                    'time' => $time,
                    'first_name' => Session::get('first_name'),
                    'last_name' => Session::get('last_name'),
                    'phone_number' => Session::get('phone_number'),
                    'wetsuits_count' => Session::get('wetsuits_count'),
                    'rental_wakeboards_count' => Session::get('rental_wakeboards_count'),
                    'user_id' => Auth::user()->id ?? '0',
                    'payment_status' => 1,
                    'price' => Session::get('price')
                ]);

        }

        Session::forget('time');
        return redirect()->route('reservations.index')->with('message', 'Reservation has been completed successfully');
    }

    public function reservetionsList()
    {
        $reservations = Reservation::reservationList();
        $a = 0;
        return view('reservations.reservationsList')
            ->with('reservations',$reservations)
            ->with('a',$a);
    }

    public function getReservationsList(Request $request)
    {
        $date = $request->date;
        if($request->ajax()){
            $reservations = Reservation::getReservationsList1($date);
            return view('reservations.includes.reservations_list_data',compact('reservations','date'))->render();
        }
    }

    public function show(Request $request)
    {
        $id = $request ->id;
        if($request->ajax()){
            $reservation = Reservation::find($id);
            return view('reservations.includes.showReservation')
                ->with('reservation',$reservation)
                ->render();
        }
    }

}
