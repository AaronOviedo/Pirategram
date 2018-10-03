<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;

class Coment extends Eloquent
{
    protected $table = 'catComent';

    public function post(){
        return $this->belongsTo('Post');
    }

    public function user(){
        return $this->belongsTo('myUser');
    }
}
