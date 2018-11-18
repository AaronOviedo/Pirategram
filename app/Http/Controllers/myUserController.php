<?php

namespace Pirategram\Http\Controllers;

use Illuminate\Http\Request;
use Pirategram\myUser;
use Pirategram\Multimedia;
use Pirategram\Post;
use Illuminate\Support\Facades\Input;
use Storage;
use Validator;
use Pirategram\Events\sendPrivateMessage;
use Pirategram\PvtMsg;
use Pirategram\Events\Msg;

class myUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $strEmail = Input::get('email');
        $strPassword = Input::get('password');
        
        $loginUser = myUser::where('strEmail', '=', $strEmail)->where('strPassword', '=', $strPassword)->first();

        if($loginUser != null){
            session_start();

            $userID = $loginUser->id;
            $_SESSION["userID"] = $userID;
    
            return redirect('/home');
        }else{
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->gender == 1){
            $gen = 'male';
        }else if($request->gender == 2){
            $gen = 'female';
        }else{
            $request->gen = 'other';
        }

        $myUser = myUser::create([
            'strName'               =>  $request->name,
            'strEmail'              =>  $request->email,
            'strPassword'           =>  $request->password,
            'dateBirth'             =>  $request->date,
            'strGender'             =>  $gen,
            'intProfile'            =>  2,
            'intCover'              =>  1
        ]);

        session_start();
        $_SESSION["userID"] = $myUser->id;

        return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $myUser = myUser::find($id);

        dd($myUser);
        return redirect('profile')->with('userProfile', $myUser);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // PERSONAL FUNCTIONS TO WORK WITH AJAX

    // Function to logout
    public function logout(){
        session_start();
        session_destroy();

        return redirect('/');
    }

    public function newProfile(Request $request){
        $user = myUser::find($request->userID);
        $Validator = Validator::make($request->all(), [
            'newProfile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if($Validator->passes()){
            $newProfile = $request->file('newProfile');
            $n =  rand() . '.' . $newProfile->getClientOriginalExtension();
            $newPath = $newProfile->storeAs('multimedia', $n, 'files');
            //$newPath = Storage::disk('public')->put('multimedia', $request->postMultimedia);

            $newMultimedia = Multimedia::create([
                'strLink'   =>  'files/' . $newPath
            ]);

            Storage::disk('public')->delete($user->profile->strLink);

            $user->intProfile = $newMultimedia->id;
            $user->save();
            return 'reload';
        }else{
            return response()->json([
                'message'       =>  $Validator->errors()->all()
            ]);
        }
    }

    public function newCover(Request $request){
        $user = myUser::find($request->userID);
        $Validator = Validator::make($request->all(), [
            'newCover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if($Validator->passes()){
            $newCover = $request->file('newCover');
            $n =  rand() . '.' . $newCover->getClientOriginalExtension();
            $newPath = $newCover->storeAs('multimedia', $n, 'files');

            $newMultimedia = Multimedia::create([
                'strLink'   =>  'files/' . $newPath
            ]);

            Storage::disk('files')->delete($user->cover->strLink);

            $user->intCover = $newMultimedia->id;
            $user->save();
            return 'reload';
        }else{
            return response()->json([
                'message'       =>  $Validator->errors()->all()
            ]);
        }
    }

    public function usersChat(Request $request){
        $allUsers = myUser::all();
        $array = array();
        foreach($allUsers as $singleUser){
            if($singleUser != $request->id){
                $tempArray = array();
                $tempArray['userID'] = $singleUser->id;
                $tempArray['userName'] = $singleUser->strName;
                $tempArray['userProfile'] = $singleUser->profile->strLink;
                array_push($array, $tempArray);
            }
        }
        return $array;
    }

    public function follow(Request $request){
        $user = myUser::find($request->userID);
        $followedID = $request->followID;  
        if(!$user->isFollowing($followedID)){
            $user->follow($followedID);
            $user->save();
            return['status' => 'updated'];
        }else{
            return['status' => 'failed'];
        }
    }
    public function unfollow(Request $request){
        $user = myUser::find($request->userID);
        $followedID = $request->followID;  
        if($user->isFollowing($followedID)){
            $user->unfollow($followedID);
            $user->save();
            return['status' => 'updated'];
        }else{
            return['status' => 'failed'];
        }
    }
    public function like(Request $request){

        $user = myUser::find($request->userID);
        $postLikedID = $request->postID;
        if(!$user->isLiking($postLikedID)){
            $user->like($postLikedID);
            $user->save();

            $post = Post::find($postLikedID);
            $post->intLikes++;
            $post->save();
            return [
                'status'    => 'uptaded',
                'intLikes'  => $post->intLikes,
            ];
        }else{
            return['status' => 'failed'];
        }
    }
    public function unlike(Request $request){

        $user = myUser::find($request->userID);
        $postLikedID = $request->postID;
        if($user->isLiking($postLikedID)){
            $user->unlike($postLikedID);
            $user->save();

            $post = Post::find($postLikedID);
            $post->intLikes--;
            $post->save();
            return [
                'status'    => 'uptaded',
                'intLikes'  => $post->intLikes,
            ];
        }else{
            return['status' => 'failed'];
        }
    }

    public function sendMessage(Request $request){
        //$user = myUser::find($request->sendID);
        $message = PvtMsg::create([ 
            'intReceive'        => $request->receiverID,
            'intSend'           => $request->sendID,
            'strMessage'        => $request->chatMsg
        ]);

        event(new Msg('This is a new message'));

        return ['status' => 'Message sent'];
        //return $message;
    }
}
