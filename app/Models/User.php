<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'gender',
        'email',
        'password',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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
    ];

//    public function setPasswordAttribute($password)
//    {
//        $this->attributes['password'] = Hash::make($password);
//    }


    public function announcements(){
        return $this->hasMany(Announcement::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasAnyRole(string $role){
        return null !== $this->roles()->where('name',$role)->first();
    }

    public function hasAnyRoles(array $role){
        return null !== $this->roles()->whereIn('name',$role)->first();
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function reservations(){
        return $this->hasMany(Order::class);
    }

    public static function getUsers($search_keyword) {
        $users = DB::table('users');


        if($search_keyword && !empty($search_keyword)) {
            $users->where(function($q) use ($search_keyword) {
                $q->where('users.username', 'like', "%{$search_keyword}%");
            });
        }
        return $users->paginate(PER_PAGE_LIMIT);
    }
}
