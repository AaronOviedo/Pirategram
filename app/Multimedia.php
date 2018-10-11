<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    protected $table = 'catMultimedia';

    public function cover(){
        return $this->hasOne('myUser');
    }
    
    public function profile(){
        return $this->hasOne('myUser');
    }

    public function post(){
        return $this->hasMany('Pirategram\Post');
    }
}
