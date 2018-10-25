<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;
use Pirategram\Multimedia;
use Pirategram\myUser;
use Pirategram\Coment;

class Post extends Model
{
    protected $fillable = ['strTitle', 'strDescription', 'intLikes', 'intUserID', 'intMultimediaID'];

    protected $table = 'catPost';

    public function multimedia(){
        return $this->belongsTo('Pirategram\Multimedia', 'intMultimediaID');
    }

    public function coment(){
        return $this->hasMany('Pirategram\Coment', 'id');
    }

    public function user(){
        return $this->belongsTo('Pirategram\myUser', 'intUserID');
    }
}
