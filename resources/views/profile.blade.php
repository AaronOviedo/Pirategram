@extends('layouts.app')

@section('content')

@php
    session_start();
    use Pirategram\myUser;
    use Pirategram\Multimedia;
    use Pirategram\Post;

    $user = myUser::where('id', '=', $_SESSION['userID'])->first();
@endphp
@if(session('userProfile'))
    @php
        if(session('userProfile') == null){
            $user = myUser::where('id', '=', $_SESSION['userID'])->first();
        }else{
            $user = session('userProfile');
        }
    @endphp
@endif
    <div class="container postDiv">
        <span id="spanUserID" data-value="{{$user->id}}"></span>
        <div class="jumbotron coverDiv" style="background-image: url({{$user->cover->strLink}});">
            <div style="display: inline-block; max-width: 200px; max-height: 200px; min-width: 50px; min-height: 50px;">
                <img data-toggle="modal" data-target="#modalImg" src="{{$user->profile->strLink}}"  class="img-circle imgGaleria" style=" max-width: 200px; max-height: 200px; 
                        min-width: 50px; min-height: 50px;">
                @if(session('userProfile'))    
                    <!-- This button is for follow the user -->
                    <button followID="{{$user->id}}" class="btn btn-default follow btnLeftPad" data-action="follow">Follow</button>
                @else
                    <!-- This button is for change Profile Picture (if the profile is ours) -->
                    <input type="file" name="profile" id="profile" class="hideInput">
                    <label for="profile" class="btn btn-default btnLeftPad">Change profile picture</label>

                    <input type="file" name="cover" id="cover" class="hideInput">
                    <label for="cover" class="btn btn-default btnLeftPad">Change cover picture</label>
                @endif
            </div>
        </div>

        <div class="well" style="width: 92.5%; margin: -20px auto; border-top-left-radius: 0px; border-top-right-radius: 0px;
        border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
            <div style="display: inline-block;">
                <h1>{{$user->strName}}</h1>
                <h5>{{$user->strGender}}</h5>
            </div>
        </div>

        <div id='posts' class='postContainer'>
            @php
                $userOnline = Pirategram\myUser::find($_SESSION['userID']);
                $posts = Pirategram\Post::where('intUserID', '=', $user->id)->orderBy('updated_at', 'desc')->get();
            @endphp
            @foreach ($posts as $singlePost)
                <div class="well divPost">
                    <div>
                        <img class="img-circle imgProfile" src="{{$user->profile->strLink}}">
                        <a href="/myUser/{{$user->id}}"><h4 style="display: inline-block; margin-left: 10px;">{{$user->strName}}</h4></a>

                        <button class="btn btn-danger pull-right" style="margin-left: 10px;"  data-postID="{{$singlePost->id}}" data-toggle="modal" data-target="#modalDelete">Delete</button>
                        <button class="btn btn-warning pull-right" data-postID="{{$singlePost->id}}" data-toggle="modal" data-target="#modalEdit">Edit</button>
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
                                <button data-userID="{{$userOnline->id}}" data-postID="{{$singlePost->id}}" class="btn btn-info like" data-liked="true">LIKE</button>                                
                            @else
                                <button data-userID="{{$userOnline->id}}" data-postID="{{$singlePost->id}}" class="btn btn-default like" data-liked="false">LIKE</button>                                
                            @endif
                            <label class="like" id="{{$singlePost->id}}">Likes: <span>{{$singlePost->intLikes}}</span></label>
                            <button id="comments-intPostID" type="button" data-postID="{{$singlePost->id}}" class="btn btn-default comments pull-right" data-toggle="modal" data-target="#modalComments">New comment</button>
                        </div>
                    </div>
                </div>
            @endforeach 
            
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
                                    <input type="hidden" name="modalComentsUserID" id="modalComentsUserID" value="{{$userOnline->id}}">
                                    <input type="hidden" name="modalComentsPostID" id="modalComentsPostID">
                                    <div class="form-group">
                                        <label for="contenidoComentario" style="display: block;">Comment: </label>
                                        <textarea id="contentComment" name="contenidoComentario" placeholder="New comment..." required></textarea>
                                    </div>
                                    <center>
                                        <button type="submit" class="btn btn-primary" align="center" id="publicarComentario">Post comment</button>
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
        </div>
    </div>
@endsection