<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Auth;
use App\Models\Like;



class Blogs extends Model
{
    use HasFactory;

    protected $table = "blogs";

    protected $fillable = ['user_id','title','description','image','status'];
    public function bloger()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function MyLike()
    {
        $user_id = (Auth()->user())?Auth()->user()->id:"";
        return $this->hasOne(Like::class,'blog_id','id')->where('user_id', $user_id);
    }

    public function AllLikes()
    {
        return $this->hasMany(Like::class,'blog_id','id')->where('like', 1);
    }

}
