<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;
use Pirategram\myUser;
use Pirategram\Post;

class Multimedia extends Model
{
    protected $table = 'catMultimedia';

    public function cover(){
        return $this->hasOne('Pirategram\myUser');
    }
    
    public function profile(){
        return $this->hasOne('Pirategram\myUser');
    }

    public function post(){
        return $this->hasMany('Pirategram\Post');
    }
}
