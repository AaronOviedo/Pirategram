<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;

class myUser extends Eloquent
{
    protected $fillable = ['strName', 'strEmail', 'strPassword', 'dateBirth', 
                                'strGender', 'strUserDescription', 'intCover', 'intProfile'];

    protected $table = 'catUser';
    
    public function cover(){
        return $this->hasOne('catMultimedia');
    }

    public function profile(){
        return $this->hasOne('catMultimedia');
    }

}
