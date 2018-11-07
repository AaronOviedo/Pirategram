<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;
use Pirategram\myUser;
use Pirategram\Post;

class Multimedia extends Model
{
    protected $fillable = ['strLink'];
    protected $table = 'catMultimedia';

    public function cover(){
        return $this->hasOne('Pirategram\myUser', 'id');
    }
    
    public function profile(){
        return $this->hasOne('Pirategram\myUser', 'id');
    }

    public function post(){
        return $this->hasMany('Pirategram\Post', 'id');
    }
}
