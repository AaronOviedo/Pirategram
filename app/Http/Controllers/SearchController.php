<?php

namespace Pirategram\Http\Controllers;

use Illuminate\Http\Request;
use Pirategram\myUser;
use Pirategram\Post;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        // $searchInput = $request->searchID;

        // $users = myUser::where('strName', 'like', '%'.$searchInput.'%')
        //                 ->orWhere('strEmail', 'like', '%'.$searchInput.'%');

        // $posts = Post::where('strTitle', 'like', '%'.$searchInput.'%')
        //                 ->orWhere('strDescription', 'like', '%'.$searchInput.'%');

        // return redirect('search')->with([
        //     'allUsers' => $users,
        //     'allPost' => $posts
        //     ]);
        //return redirect('search')->with('allUsers', $users)->with('allPost', $posts);
        return redirect('search');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $searchInput = $request->searchID;

        $users = myUser::where('strName', 'like', '%'.$searchInput.'%')
                        ->orWhere('strEmail', 'like', '%'.$searchInput.'%');

        $posts = Post::where('strTitle', 'like', '%'.$searchInput.'%')
                        ->orWhere('strDescription', 'like', '%'.$searchInput.'%');

        return redirect('search')->with([
            'allUsers' => $users,
            'allPost' => $posts
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
