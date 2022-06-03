<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => [
                'string',
                'min:4',
                'max:30',
                'unique:users',
                'regex: /^(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/'
            ],
            'email' => [
                'string',
                'email',
                'max:50',
                'unique:users'
            ],
            'password' => [
                'min:5',
                'max:255'
            ],
            'password_confirmation' => [
                'same:password'
            ],
            'first_name' => [
                'max:30'
            ],
            'last_name' => [
                'max:30'
            ],
            'phone_number' =>[
                'max:15',
                'regex: /^[+0-9]*$/'
            ]
        ],
            [
                'username.required' => 'Username field is required',
                'username.min' => 'Username must contain 4 characters',
                'username.max' => 'Username cannot be longer than 30 characters',
                'username.unique' => 'Username already exists',
                'username.regex' => 'This username is not allowed',

                'email.required' => 'Email field is required',
                'email.email' => 'Please enter valid email address',
                'email.max' => 'Email cannot be longer than 50 characters',
                'email.unique'=> 'Email already exists',

                'password.min' => 'Password must contain 5 characters',
                'password.max' => 'Password cannot be longer than 255 characters',


                'password_confirmation.same' => 'Password confirmation has to be same as password',

                'first_name.required' => ' First name field is required',
                'first_name.max' => 'First name cannot be longer than 30 characters',

                'last_name.required' => 'Last name field is required',
                'last_name.max' => 'Last name cannot be longer than 30 characters',

                'phone_number.required' => 'Phone number field is required',
                'phone_number.max' => 'Phone number cannot be longer than 15 characters',
                'phone_number.regex' => 'Number cannot have any special chars or whitespaces'
            ]);
    }

    public function index($id)
    {
        if(Gate::denies('logged-in')){
            return redirect(route('index'));
        }
        if(Auth::user()->id == $id)
        {
            $user = User::find($id);
            $roles = Role::all();
            $count = Announcement::all()
                ->where('user_id',$id)
                ->where('status',1)
                ->count();

            $orders = Auth::user()->orders;
            $orders->transform(function ($order,$key){
                $order->cart = unserialize($order->cart);
                return $order;
            });
            return view('profile.profile',compact('user','count','roles'),['orders' => $orders]);
        }
        return redirect(route('index'));

    }
    public function userReservations()
    {

        $reservations = Reservation::all()
            ->where('user_id',Auth::id())
            ->sortBy('date');

        return view('profile.userReservations')
            ->with('reservations',$reservations);

    }

    public function cancelReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->back();
    }

    public function editProfile()
    {

        $user = User::find(Auth::id());
        return view('profile.edit')
            ->with('user', $user);

    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail($request->input('user-id'));
        if(Auth::id() == $user->id) {
            if(Auth::user()->username == $request->input('username') && Auth::user()->email == $request->input('email') && $request->input('password') == null)
            {
                $this->validator($request->except(['username','email','password']))->validate();
            }
            elseif(Auth::user()->username == $request->input('username') && Auth::user()->email == $request->input('email'))
            {
                $this->validator($request->except(['username','email']))->validate();
            }
            elseif(Auth::user()->email == $request->input('email') && $request->input('password') == null)
            {
                $this->validator($request->except(['email','password']))->validate();
            }
            elseif(Auth::user()->username == $request->input('username') && $request->input('password') == null)
            {
                $this->validator($request->except(['username','password']))->validate();
            }
            elseif($request->input('password') == null)
            {
                $this->validator($request->except(['password']))->validate();
            }
            else
                $this->validator($request->all())->validate();


           if ($request->input('password') != null)
           {
               $user->update([
                   'username' => $request->input('username'),
                   'email' => $request->input('email'),
                   'password' => Hash::make($request->input('password')),
                   'first_name' => $request->input('first_name'),
                   'last_name' => $request->input('last_name'),
                   'phone_number' => $request->input('phone_number'),
                   'gender' => $request->input('gender')
               ]);
           }
           else
           {
               $user->update([
                   'username' => $request->input('username'),
                   'email' => $request->input('email'),
                   'first_name' => $request->input('first_name'),
                   'last_name' => $request->input('last_name'),
                   'phone_number' => $request->input('phone_number'),
                   'gender' => $request->input('gender')
               ]);
           }

        }



       return redirect()->route('profile',[$request->input('user-id')])
           ->with('message','Profile updated succesfully');
    }
}
