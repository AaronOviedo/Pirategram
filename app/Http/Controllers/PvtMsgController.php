<?php

namespace Pirategram\Http\Controllers;

use Pirategram\PvtMsg;
use Pirategram\myUser;
use Pirategram\Multimedia;
use Illuminate\Http\Request;

class PvtMsgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('pvtMsg');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('Hola');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Pirategram\PvtMsg  $pvtMsg
     * @return \Illuminate\Http\Response
     */
    public function show($pvtMsg)
    {
        $userReceiver = myUser::find($pvtMsg);

        return redirect('pvtMsg')->with('receiver', $userReceiver);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Pirategram\PvtMsg  $pvtMsg
     * @return \Illuminate\Http\Response
     */
    public function edit(PvtMsg $pvtMsg)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Pirategram\PvtMsg  $pvtMsg
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PvtMsg $pvtMsg)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Pirategram\PvtMsg  $pvtMsg
     * @return \Illuminate\Http\Response
     */
    public function destroy(PvtMsg $pvtMsg)
    {
        //
    }
}
