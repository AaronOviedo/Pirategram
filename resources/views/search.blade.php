@extends('layouts.app')

@section('content')
@php
    session_start();
@endphp
    <div class="container">
        <!-- Users -->
        <div class="well" style="width: 70%; margin: 40px auto;" >
            @if(session('allUsers'))
                @php
                    session('allUsers') = $allUsers;
                @endphp
                <h3>Users found:</h3> <br>
                @foreach ($allUsers as $user)
                    <div class="jumbotron coverDiv" style="background-image: url({{$user->cover->strLink}});">
                        <div style="display: inline-block; max-width: 200px; max-height: 200px; min-width: 50px; min-height: 50px;">
                            <img data-toggle="modal" data-target="#modalImg" src="{{$user->profile->strLink}}"  class="img-circle imgGaleria" style=" max-width: 200px; max-height: 200px; 
                                    min-width: 50px; min-height: 50px;">
                        </div>
                    </div>
                @endforeach      
            @else
                <h3>No users found</h3> <br>
            @endif
        </div>
        
        <!-- Posts -->
        <div class="well" style="width: 70%; margin: 40px auto;" >
            <h3>Post found:</h3> <br>
            @if(session('allPost'))
                @php
                    session('allPost') = $allPost;
                    $userOnline = Pirategram\myUser::find($_SESSION['userID']);
                @endphp
                @foreach ($allPost as $singlePost)
                <div class="well divPost">
                        <div>
                            <img class="img-circle imgProfile" src="{{$user->profile->strLink}}">
                            <a href="/myUser/{{$user->id}}"><h4 style="display: inline-block; margin-left: 10px;">{{$user->strName}}</h4></a>
                        </div>
                        <div>
                            <h3>{{$singlePost->strTitle}}</h3>
                            <h4>{{$singlePost->strDescription}}</h4>
                            <div>
                                <img data-toggle="modal" data-target="#modalImg" class="imgGaleria imgWidth"
                                src="{{$singlePost->multimedia->strLink}}">
                            </div>
                            <div>
                                @if (!$userOnline->isLiking($singlePost->id))
                                    <button data-userID="{{$singlePost->user->id}}" data-postID="{{$singlePost->id}}" class="btn btn-default like" data-liked="true">LIKE</button>                                
                                @else
                                    <button data-userID="{{$singlePost->user->id}}" data-postID="{{$singlePost->id}}" class="btn btn-warning like" data-liked="false">LIKE</button>                                
                                @endif
                                <label class="like" id="{{$singlePost->id}}">Likes: <span>{{$singlePost->intLikes}}</span></label>
                                <button id="comments-intPostID" type="button" data-idpublicacion="{{$singlePost->id}}" class="btn btn-default comments pull-right" data-toggle="modal" data-target="#modalComments">New comment</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3>No post found:</h3>
            @endif
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
                            <form method="post" action="comment">                
                                <input type="hidden" name="idUsuario" value="">
                                <input type="hidden" name="idPublicacion" id="">
                                <input type="hidden" name="action" value="createComment">
                                <input type="hidden" name="place" value="home">
                                <div class="form-group">
                                    <label for="contenidoComentario" style="display: block;">Comment: </label>
                                    <textarea style="width: 100%; height: 50px; border-radius: 5px;" id="contenidoComentario" name="contenidoComentario" placeholder="New comment..." required></textarea>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-primary" style="margin-top:0px;" align="center" id="publicarComentario">Post comment</button>
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
    </div>
@endsection