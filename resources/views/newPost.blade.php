@extends('layouts.app')

@section('content')
    @php
        session_start();
        $user = Pirategram\myUser::where('id', '=', $_SESSION['userID'])->first();
    @endphp
    <div class="container">
            <div class="well"><h1>NEW POST</h1></div>
        
            <div class="well" style="max-width: 500px; margin: 20px auto 10px; background-color: #e3e7fd;" id="loginForm">
                <form id="formNewPost" method="post" action="/newPost" enctype="multipart/form-data">
                    <input type="hidden" name="idUsuario" value="{{$user->id}}">
                        <div class="form-group">
                            <label for="tituloPublicacion" >Post title</label>
                            <input id="postTitleID" name="postTitle" type="text" class="form-control" placeholder="Título" required>
                        </div>
                <div class="form-group">
                    <label for="contenidoPublicacion" style="display: block;">Post content</label>
                    <p>(if you gonna use '#', take a space between them)</p>
                    <textarea style="width: 100%; height: 100px; border-radius: 5px;" id="postContentID" name="postContent" placeholder="Content..." required></textarea>
                </div>
                <div class="form-group">
                    <label for="imagenPublicacion">Image</label>
                    <input type="file" id="postImageID" name="postImage" class="form-control">
                </div>
                <center>
                    <button type="submit" class="btn btn-primary" style="margin-top:10px;">Post</button>
                </center>
                </form>
        </div>
    </div>
@endsection