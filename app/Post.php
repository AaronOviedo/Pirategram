<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;
use Pirategram\Multimedia;

class Post extends Model
{
    protected $table = 'catPost';

    public function multimedia(){
        return $this->belongsTo('Pirategram\Multimedia');
    }

    public function coment(){
        return $this->belongsTo('Pirategram\Coment');
    }

    public function user(){
        return $this->belongsTo('Pirategram\myUser');
    }
}
