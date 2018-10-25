@extends('layouts.app')

@section('content')

@php
    session_start();
    use Pirategram\myUser;
    use Pirategram\Multimedia;
    use Pirategram\Post;

    if($userID == )
    $user = myUser::where('id', '=', $_SESSION['userID'])->first();
    //dd($user);
    
    /*
    $userProfile = Multimedia::where('id', '=', $user->intProfile)->first();
    $userCover = Multimedia::where('id', '=', $user->intCover)->first();
    $allPost = Post::where('intUserID', '=', $user->id)->get();
    */
@endphp
    <div class="container">
        <div class="jumbotron" style=" padding-left: 10px;  width: 92.5%; margin: 20px auto;
        background-image: url({{$user->cover->strLink}}); background-repeat: no-repeat;
        background-size: 100% 100%; border-top-left-radius: 5px; border-top-right-radius: 5px;">
            <div style="display: inline-block; max-width: 200px; max-height: 200px; min-width: 50px; min-height: 50px;">
                <img data-toggle="modal" data-target="#modalImg" src="{{$user->profile->strLink}}"  class="img-circle imgGaleria" style=" max-width: 200px; max-height: 200px; 
                        min-width: 50px; min-height: 50px;">
                <!-- This button is for change Profile Picture (if the profile is ours) -->
                <button style="margin-left: 18px; margin-top: 5px;" class="btn btn-primary">Change profile picture</button>
                <!-- This button is for change Profile Picture (if the profile is ours) -->
                <button style="margin-left: 18px; margin-top: 5px;" 
                        data-idusuarioperfil="intUserID" 
                        class="btn btn-default follow" data-action="unfollow">Follow</button>
            </div>
        </div>

        <div class="well" style="width: 92.5%; margin: -20px auto; border-top-left-radius: 0px; border-top-right-radius: 0px;
        border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
            <div style="display: inline-block;">
                <h3>{{$user->strName}}</h3>
                <h5>{{$user->strGender}}</h5>
            </div>
        </div>
        <div style="margin: 30px auto; width: 50%;">
            <button id="btnPosts" class="btn btn-primary" style="margin-top:10px;">Posts</button>
            <button id="btnGallery" class="btn btn-primary" style="margin-top:10px;">Galery</button>
            <button id="btnUsersFollowers" class="btn btn-primary" style="margin-top:10px;">Users who he follow</button>
        </div>

        <div id='posts' class='postContainer'>
            @foreach ($user->post as $singlePost)
                <div class="well" style="width: 70%; margin: 40px auto; background-color:lightblue; " >
                    <div>
                        <img  class="img-circle" style="width: 50px; height: 50px; display: inline-block;" 
                            src="{{$user->profile->strLink}}">
                        <a href="/myUser/{ {{$user->id}} }"><h4 style="display: inline-block; margin-left: 10px;">{{$user->strName}}</h4></a>
                    </div>
                    <div>
                        <h3>{{$singlePost->strTitle}}</h3>
                        <h4>{{$singlePost->strDescription}}</h4>
                        <div style="width: 90%; margin: auto;">
                            <img data-toggle="modal" data-target="#modalImg" class="imgGaleria" style="width: 100%; height: 200px; display: inline;" 
                            src="{{$singlePost->multimedia->strLink}}">
                        </div>
                        <div>
                            <button data-idusuario="{{$user->id}}" data-idpublicacion="{{$singlePost->id}}" 
                                    style="margin-top: 10px; display: inline-block;"
                                    class="btn btn-primary like" data-liked="true" >
                                    LIKE
                            </button>
                            <p style="display: inline-block; color: #337ab7; vertical-align: bottom; margin-left: 15px; " id="{{$singlePost->id}}">Likes {{$singlePost->intLikes}}</p>
                            <button id="comments-intPostID" style="margin-top: 10px; display: inline-block; margin-left: 15px;" type="button" data-idpublicacion="{{$singlePost->id}}" class="btn btn-default comments" data-toggle="modal" data-target="#modalComments">New comment</button>
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
                                        <input type="hidden" name="idUsuario" value="intUserID">
                                        <input type="hidden" name="idPublicacion" id="idPublicacionHidden">
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
        </div>
    </div>
@endsection