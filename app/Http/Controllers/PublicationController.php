<?php

namespace Pirategram\Http\Controllers;

use Illuminate\Http\Request;
use Pirategram\Post;
use Pirategram\myUser;
use Pirategram\Multimedia;
use Pirategram\Coment;
use Storage;
use Validator;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('newPost');
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
        $Validator = Validator::make($request->all(), [
            'postMultimedia' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if($Validator->passes()){
            $postMultimedia = $request->file('postMultimedia');
            $n =  rand() . '.' . $postMultimedia->getClientOriginalExtension();
            $newPath = $postMultimedia->storeAs('multimedia', $n, 'files');
            //$newPath = Storage::disk('public')->put('multimedia', $request->postMultimedia);

            $newMultimedia = Multimedia::create([
                //'strLink'   =>  'storage/' . $newPath
                'strLink'   =>  'files/' . $newPath
            ]);
        }else{
            return response()->json([
                'message'       =>  $Validator->errors()->all()
            ]);
        }
        $newPost = Post::create([
            'strTitle'          =>  $request->postTitle,
            'strDescription'    =>  $request->postContent,
            'intLikes'          =>  0,
            'intUserID'         =>  $request->userID,
            'intMultimediaID'   =>  $newMultimedia->id
        ]);

        $newPost['strLink'] = $newPost->multimedia->strLink;
        $newPost['intUserID'] = $newPost->user->id;
        $newPost['strUserProfile'] = $newPost->user->profile->strLink;
        $newPost['strUserName'] = $newPost->user->strName;
        $newPost['strPostLink'] = $newMultimedia->strLink;

        //$user = myUser::find($newPost->intUserID);
        //$multimedia = Multimedia::find($newPost->intMultimediaID);

        return $newPost;
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

    public function fetchComments(Request $request){
        $allComments = Coment::where('intPostID', $request->postID)->get();
        $arrayComents = array();
        foreach($allComments as $singleComent){
            $tempArray = array();
            $tempArray['userID'] = $singleComent->user->id;
            $tempArray['userName'] = $singleComent->user->strName;
            $tempArray['userPhoto'] = $singleComent->user->profile->strLink;
            $tempArray['coment'] = $singleComent->strComent;
            array_push($arrayComents, $tempArray);
        }

        return $arrayComents;
    }

    public function storeComment(Request $request){
        $newComent = Coment::create([
            'strComent'    =>  $request->contentComment,
            'intUserID'     =>  $request->modalComentsUserID,
            'intPostID'     =>  $request->modalComentsPostID
        ]);

        $user = myUser::find($request->modalComentsUserID);
        $newComent['userPhoto'] = $user->profile->strLink;
        $newComent['userName'] = $user->strName;

        return $newComent;
    }

    public function deletePost(Request $request){
        $post = Post::find($request->postID);
        Storage::disk('public')->delete($post->multimedia->strLink);
        $post->delete();
        return['message' => 'success'];
    }

    public function editPost(Request $request){
        $editPost = Post::find($request->modalEditPostID);
        $editPost->strTitle = $request->editPostTitle;
        $editPost->strDescription = $request->editPostContent;
        $editPost->save();

        return['message' => 'success'];
    }

    public function editPostValues(Request $request){
        $postFinded = Post::find($request->postID);
        return $postFinded;
    }
}
