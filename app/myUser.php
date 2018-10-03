<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;

class myUser extends Model
{
    protected $fillable = ['strName', 'strEmail', 'strPassword', 'dateBirth', 
                                'strGender', 'strUserDescription', 'intCover', 'intProfile'];

    protected $dates = ['dateBirth'];

    protected $table = 'catUser';
    
    public function cover(){
        return $this->hasOne('Multimedia');
    }

    public function profile(){
        return $this->hasOne('Multimedia');
    }

    public function coment(){
        return $this->hasMany('Coment');
    }

    public function post(){
        return $this->hasMany('Post');
    }

    public function pvtMsg(){
        return $this->belongsToMany('myUser', 'relPvtMsg', 'intReceiveID', 'intSendID');
    }

    public function follow(){
        return $this->belongsToMany('myUser', 'relFollow', 'intFollowedID', 'intFollowerID');
    }

}
