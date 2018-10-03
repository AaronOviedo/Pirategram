<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'catPost';

    public function multimedia(){
        return $this->hasMany('Multimedia');
    }

    public function coment(){
        return $this->belongsTo('Coment');
    }

    public function user(){
        return $this->hasMany('User');
    }
}
