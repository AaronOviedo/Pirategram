@extends('layouts.app')

@section('content')
@php
    session_start();
    if (isset($_SESSION['userID'])) {
        $user = Pirategram\myUser::where('id', '=', $_SESSION['userID'])->first();
    } else {
        $user = false;
    }
    //$allUsers = Pirategram\myUser::all();
@endphp
<div class="container postDiv">
    @if ($user != false)
    @php
        //dd($singleUser->post);
        //dd(Pirategram\Post::all());
        $posts = Pirategram\Post::orderBy('updated_at')->get();
        //$posts = Pirategram\Post::where('intUserID', '=', $singleUser->id)->orderBy('updated_at', 'desc')->get();
    @endphp
        @foreach ($posts->reverse() as $singlePost)
            <div class="well" style="width: 70%; margin: 40px auto; background-color:lightblue; " >
                <div>
                    <img  class="img-circle" style="width: 50px; height: 50px; display: inline-block;" 
                    src="{{$singlePost->user->profile->strLink}}">
                    <a href="/myUser/{{$singlePost->user->id}}"><h4 style="display: inline-block; margin-left: 10px;">{{$singlePost->user->strName}}</h4></a>

                </div>
                <div class="postContainer">
                    <h3>{{$singlePost->strTitle}}</h3>
                    <h4>{{$singlePost->strDescription}}</h4>
                    <div style="width: 90%; margin: auto;">
                        <img data-toggle="modal" data-target="#modalImg" class="imgGaleria" style="width: 100%; height: 200px; display: inline;" 
                        src="{{$singlePost->multimedia->strLink}}">
                    </div>
                    <div>
                        <button data-idusuario="{{$singlePost->user->id}}" data-idpublicacion="{{$singlePost->id}}" 
                                class="btn btn-default like" data-liked="true" >
                                LIKE
                        </button>
                        <p style="display: inline-block; color: #337ab7; vertical-align: bottom; margin-left: 15px; " id="intPostID">Likes: {{$singlePost->intLikes}}</p>
                        <button id="comments-intPostID" style="margin-top: 10px; display: inline-block; margin-left: 15px;" type="button" data-idpublicacion="intPostID" class="btn btn-default comments" data-toggle="modal" data-target="#modalComments">New comment</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalComments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Comments</h4>
                            <div class="modal-body">
                                <form method="post" action="comment" >                
                                    <input type="hidden" name="idUsuario" value="{{$singlePost->user->id}}">
                                    <input type="hidden" name="idPublicacion" id="idPublicacionHidden">
                                    <div class="form-group">
                                        <label for="contenidoComentario" style="display: block;">Comment: </label>
                                        <textarea style="width: 100%; height: 50px; border-radius: 5px;" id="contentComment" name="contenidoComentario" placeholder="New comment..." required></textarea>
                                    </div>
                                    <center>
                                        <button type="submit" class="btn btn-primary" style="margin-top:0px;" align="center">Post comment</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                        <div class="modal-body" id="contenedorComentarios">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Galery</h4>
                        </div>
                            <div class="modal-body">
                                <img id="imgModalGallery" style="width: 100%; height: 500px;">
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach 
    @else
        <script>window.location = "/";</script>
    @endif
</div>
@endsection
