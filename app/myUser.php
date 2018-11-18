<?php

namespace Pirategram;

use Illuminate\Database\Eloquent\Model;

class myUser extends Model
{
    protected $fillable = ['strName', 'strEmail', 'strPassword', 'dateBirth', 
                                'strGender', 'strUserDescription', 'intCover', 'intProfile'];

    protected $dates = ['dateBirth'];

    protected $table = 'catUser';
    
    //Relations
    public function cover(){
        return $this->belongsTo('Pirategram\Multimedia', 'intCover');
    }

    public function profile(){
        return $this->belongsTo('Pirategram\Multimedia', 'intProfile');
    }

    public function coment(){
        return $this->hasMany('Pirategram\Coment', 'id');
    }

    public function post(){
        return $this->hasMany('Pirategram\Post', 'id');
    }

    public function messageReceived(){
        return $this->belongsToMany('Pirategram\myUser', 'relPvtMsg', 'intSend', 'intReceive');
    }

    //If maybe some time i'm gonna need the messages sended alone, but now, it's useless
    public function messageSend(){
        return $this->belongsToMany('Pirategram\myUser', 'relPvtMsg', 'intReceive', 'intSend');
    }

    public function userFollows(){
        return $this->belongsToMany('Pirategram\myUser', 'relFollow', 'intFollower', 'intFollowed');
    }

    public function postLiked(){
        return $this->belongsToMany('Pirategram\Post', 'relPostLiked', 'intUserID', 'intPostID');
    }

    //Like functions
    public function like($postID){
        $this->postLiked()->attach($postID);
        return $this;
    }

    public function unlike($postID){
        $this->postLiked()->detach($postID);
        return $this;
    }

    public function isLiking($postID){
        return (boolean) $this->postLiked()->where('intPostID', $postID)->first();
    }

    //Follow functions
    public function follow($userID){
        $this->userFollows()->attach($userID);
        return $this;
    }

    public function unfollow($userID){
        $this->userFollows()->detach($userID);
        return $this;
    }

    public function isFollowing($userID){
        return (boolean) $this->userFollows()->where('intFollowed', $userID)->first();
    }
}
