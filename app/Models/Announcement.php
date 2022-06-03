<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Constants\GlobalConstants;

class Announcement extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public $timestamps = true;

    protected $fillable = ['user_id','product','brand','size','price','city','cover','title','description','status'];

    public static function getAnnouncements($product,$brand,$size){
        $announcements = DB::table('announcements')
            ->join('users', 'announcements.user_id', '=', 'users.id')
            ->select('announcements.*', 'users.username as username')->where('status',1);

        if($product && $product!= GlobalConstants::ALL){
            $announcements = $announcements->where('announcements.product',$product);
        }

        if($brand && $brand != GlobalConstants::ALL){
            $announcements = $announcements->where('announcements.brand',$brand);
        }

        if($size && $size != GlobalConstants::ALL){
            $announcements = $announcements->where('announcements.size',$size);
        }
        return $announcements->paginate(PER_PAGE_LIMIT);
    }

    // announcement belongs to user
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }
    public function images(){
        return $this->hasMany(Image::class);
    }




}
