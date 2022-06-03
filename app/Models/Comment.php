<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'Comment';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['comment','user_id','announcement_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
