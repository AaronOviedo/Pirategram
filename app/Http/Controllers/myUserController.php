<?php

namespace Pirategram\Http\Controllers;

use Illuminate\Http\Request;
use Pirategram\myUser;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

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
        /*$json = json_decode($request->varJSON);

        $gender = $json["gender"];
        $name = $json["name"];
        $email = $json["email"];
        $password = $json["password"];
        $date = $json["date"];

        if($gender == 1){
            $gen = 'male';
        }else if($gender == 2){
            $gen = 'female';
        }else{
            $gen = 'other';
        }

        $myUser = myUser::create([
            'strName'               =>  $name,
            'strEmail'              =>  $email,
            'strPassword'           =>  $password,
            'dateBirth'             =>  $date,
            'strGender'             =>  $gen,
            'intProfile'            =>  1,
            'intCover'              =>  0
        ]);*/

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

        //dd($myUser);
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

    // Function to logout
    public function logout(){
        session_start();
        session_destroy();

        return redirect('/');
    }
}
