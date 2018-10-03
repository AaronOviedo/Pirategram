<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    protected $fillable = ['strLink'];
    protected $table = 'catMultimedia';

    public function cover(){
        return $this->belongsTo('catUser');
    }
    
    public function profile(){
        return $this->belongsTo('catUser');
    }
}
