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
<div class="container postDiv postContainer">
    @if ($user != false)
    @php
        //dd($singleUser->post);
        //dd(Pirategram\Post::all());
        $posts = Pirategram\Post::orderBy('updated_at')->get();
        //$posts = Pirategram\Post::where('intUserID', '=', $singleUser->id)->orderBy('updated_at', 'desc')->get();
    @endphp
        @if($posts)
            @foreach ($posts->reverse() as $singlePost)
                <div class="well divPost">
                    <div>
                        <img class="img-circle imgProfile" src="{{$singlePost->user->profile->strLink}}">
                        <a href="/myUser/{{$singlePost->user->id}}"><h4 style="display: inline-block; margin-left: 10px;">{{$singlePost->user->strName}}</h4></a>
                        @if ($user->id == $singlePost->user->id)
                            <button class="btn btn-danger pull-right" style="margin-left: 10px;"  data-postID="{{$singlePost->id}}" data-toggle="modal" data-target="#modalDelete">Delete</button>
                            <button class="btn btn-warning pull-right" data-postID="{{$singlePost->id}}" data-toggle="modal" data-target="#modalEdit">Edit</button>
                        @endif
                    </div>
                    <div>
                        <h3>{{$singlePost->strTitle}}</h3>
                        <h4>{{$singlePost->strDescription}}</h4>
                        <div>
                            <img data-toggle="modal" data-target="#modalImg" class="imgGaleria imgWidth"
                            src="{{$singlePost->multimedia->strLink}}">
                        </div>
                        <div>
                            @if (!$user->isLiking($singlePost->id))
                                <button data-userID="{{$user->id}}" data-postID="{{$singlePost->id}}" class="btn btn-info like" data-liked="true">LIKE</button>                                
                            @else
                                <button data-userID="{{$user->id}}" data-postID="{{$singlePost->id}}" class="btn btn-default like" data-liked="false">LIKE</button>                                
                            @endif
                            <label class="like" id="intPostID">Likes: <span data-spanPostID="{{$singlePost->id}}">{{$singlePost->intLikes}} </span></label>
                            <button type="button" data-postID="{{$singlePost->id}}" class="btn btn-default comments pull-right" data-toggle="modal" data-target="#modalComments">New comment</button>
                        </div>
                    </div>
                </div>
            @endforeach 
        @endif

        <div class="modal fade" id="modalComments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Comments</h4>
                        <div class="modal-body">
                            <form method="post" action="storeComment" class="postComent">
                                {{ csrf_field() }}       
                                <input type="hidden" name="modalComentsUserID" id="modalComentsUserID" value="{{$user->id}}">
                                <input type="hidden" name="modalComentsPostID" id="modalComentsPostID">
                                <div class="form-group">
                                    <label for="contenidoComentario" style="display: block;">Comment: </label>
                                    <textarea id="contentComment" name="contentComment" placeholder="New comment..." required></textarea>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-primary" style="margin-top:0px;" align="center">Post comment</button>
                                </center>
                            </form>
                        </div>
                    </div>
                    <div class="modal-body" id="contenedorComentarios">
                        <!-- This is where all comments go -->
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
                            <img class="imgModalGallery">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Delete post</h4>
                    </div>
                        <div class="modal-body">
                            Are you sure you want to delete this post?
                            <input type="hidden" name="modalDeletePostID" id="modalDeletePostID">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="deletePost" data-dismiss="modal">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Edit post</h4>
                        <div class="modal-body">
                            <form method="post" action="editPost" class="editPostForm">    
                                {{ csrf_field() }}                
                                <input type="hidden" name="modalEditPostID" id="modalEditPostID">
                                <div class="form-group">
                                    <label for="tituloPublicacion" >Post title</label>
                                    <input id="editPostTitle" name="editPostTitle" type="text" class="form-control" placeholder="Título" required>
                                </div>
                                <div class="form-group">
                                    <label for="contenidoPublicacion" style="display: block;">Post content</label>
                                    <textarea id="editPostContent" name="editPostContent" placeholder="Content..." required></textarea>
                                </div>
                                <!--
                                <div class="form-group">
                                    <input type="file" id="editPostMultimedia" name="editPostMultimedia" class="form-control hideInput" required>
                                    <label for="editPostMultimedia" class="btn btn-default btnLeftPad">Multimedia</label>
                                </div>
                                -->
                                <center>
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </center>
                            </form>
                        </div>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
    @else
        <script>window.location = "/";</script>
    @endif
</div>
@endsection
