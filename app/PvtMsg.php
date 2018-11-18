<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;

class PvtMsg extends Model
{
    protected $table = 'relPvtMsg';

    protected $fillable = ['intReceive', 'intSend','strMessage'];
}
