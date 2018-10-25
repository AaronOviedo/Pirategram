<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mine.js"></script>

    <!-- Styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/myStyles.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-light" style="background-color: #e3e7fd;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                @php
                    $user = Pirategram\myUser::where('id', '=', $_SESSION['userID'])->first();
                    //$photo = Pirategram\Multimedia::where('id', '=', $user->intProfile)->first();
                    //dd($userPhoto->intProfile);
                @endphp

                <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed moveDown" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <img src="{{$user->profile->strLink}}" class="PP moveDown">
                    </div>
    
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="{{url('/profile')}}">{{$user->strName}}<span class="sr-only">(current)</span></a></li>
                            <li class="active"><a href="#newPostModal" data-toggle="modal" data-target="#newPostModal">New Post</a></li>
                        </ul>
                        <form class="navbar-form navbar-left" role="search" action="search" method="get">
                            <div class="form-group">
                                <input type="text" class="form-control" name="textoBusqueda" placeholder="Search" required title='This field is required'>
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav pull-right">
                    <center>
                        <button class="btn btn-secondary moveDown">Logout </button>
                    </center>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="modal fade" id="newPostModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="well morado" id="newPostForm">
                        <center>
                            <h1>New Post</h1>
                        </center>
                        <form id="formNewPost" method="post" action="/newPost">
                            {{ csrf_field() }}
                            <input id="userID" type="hidden" name="userID" value="{{$user->id}}">
                                <div class="form-group">
                                    <label for="tituloPublicacion" >Post title</label>
                                    <input id="postTitleID" name="postTitle" type="text" class="form-control" placeholder="Título" required>
                                </div>
                        <div class="form-group">
                            <label for="contenidoPublicacion" style="display: block;">Post content</label>
                            <p>(if you gonna use '#', take a space between them)</p>
                            <textarea id="postContentID" name="postContent" placeholder="Content..." required></textarea>
                        </div>
                        <!--
                        <div class="form-group">
                            <label for="imagenPublicacion">Image</label>
                            <input type="file" id="postImageID" name="postImage" class="form-control">
                        </div>
                        -->
                        <center>
                            <button type="submit" class="btn btn-primary moveDown">Post</button>
                        </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
