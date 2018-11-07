/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $(".follow").click(function(){
        var button = $(this);
        var action = button.data("action");
        var idUsuarioPerfil = button.data("idusuarioperfil");
        $.ajax({
            url : 'follow',
            data : {
                idUsuarioPerfil : idUsuarioPerfil,
                action : action
            },
            success : function(responseText) {
                
                if(action == "follow"){
                    button.text("Dejar de seguir");
                    button.removeClass("btn-success");
                    button.addClass("btn-default");
                    button.data("action", "unfollow");
                }else{
                    button.text("Seguir");
                    button.removeClass("btn-default");
                    button.addClass("btn-success");
                    button.data("action", "follow");
                }
            }
	});
    });
    
    $(".comments").click(function(){
        var button = $(this);
        var idPublicacion = button.data("idpublicacion");
        var action = "obtenerComentarios";
        $("#idPublicacionHidden").val(idPublicacion);
        $.ajax({
            url : 'comment',
            data : {
                idPublicacion : idPublicacion,
                action : action
            },
            dataType: 'html',
            success : function(responseText) {
                $("#contenedorComentarios").html(responseText);
            }
	});
        
    });
    
    $(".like").click(function(){
        var button = $(this);
        var liked = button.data("liked");
        var idUsuario = button.data("idusuario");
        var idPublicacion = button.data("idpublicacion");
        var action;
        
        if(liked){
            action = "dislike";
            $.ajax({
			url : 'like',
			data : {
				idPublicacion : idPublicacion,
                                idUsuario : idUsuario,
                                action : action
			},
			success : function(responseText) {
				$('#'+idPublicacion).text("Likes("+responseText+")");
                                button.removeClass("btn-primary");
                                button.addClass("btn-default");
                                button.text("Me gusta");
                                button.data("liked", false);
			}
		});
        }else{
            action = "like";
            $.ajax({
			url : 'like',
			data : {
                            idPublicacion : idPublicacion,
                            idUsuario : idUsuario,
                            action : action
			},
			success : function(responseText) {
				$('#'+idPublicacion).text("Likes("+responseText+")");
                                button.removeClass("btn-default");
                                button.addClass("btn-primary");
                                button.text("Ya no me gusta");
                                button.data("liked", true);
			}
		});
        }
    });
    
    $("#btnPosts").click(function(){
        $("#gallery").hide();
        $("#usersFollowers").hide();
        $("#usersFollowing").hide();
        $("#posts").show();
    });
    
    $("#btnGallery").click(function(){
        $("#usersFollowers").hide();
        $("#usersFollowing").hide();
        $("#posts").hide();
        $("#gallery").show();
    });
    
    $("#btnUsersFollowers").click(function(){
        $("#usersFollowing").hide();
        $("#posts").hide();
        $("#gallery").hide();
        $("#usersFollowers").show();
    });
    
    $("#btnUsersFollowing").click(function(){
        $("#posts").hide();
        $("#gallery").hide();
        $("#usersFollowers").hide();
        $("#usersFollowing").show();
    });
    
    $(".imgGaleria").click(function(){
        var img = $(this);
        var src = img.attr("src");
        $("#imgModalGallery").attr("src", src);
    });

    /*
    $("#formNewPost").submit(function(e){
        e.preventDefault();
        var formAction = $(this).attr("action");

        var postTitle = $('#postTitleID').val();
        var postContent = $('#postContentID').val();
        var userID = $('#userID').val();

        var varJSON = JSON.stringify({title:postTitle, content:postContent, id:userID});

        var xhttp;
        xhttp = new XMLHttpRequest();

        var metas = document.getElementsByTagName('meta'); 

        xhttp.onreadystatechange = function(){
            if(this.readyState == 4){
                //$('.postContainer').append('<div class="well" style="width: 70%; margin: 40px auto; background-color:lightblue; "><div><img  class="img-circle" style="width: 50px; height: 50px; display: inline-block;" src="{{ $userProfile->strLink }}"><a href="/myUser/{ {{$user->id}} }"><h4 style="display: inline-block; margin-left: 10px;">{{$user->strName}}</h4></a></div> <div><h3>{{$singlePost->strTitle}}</h3><h4>{{$singlePost->strDescription}}</h4><div style="width: 90%; margin: auto;"><img data-toggle="modal" data-target="#modalImg" class="imgGaleria" style="width: 100%; height: 200px; display: inline;" src="{{$postMultimedia->strLink}}"></div><div><button data-idusuario="{{$user->id}}" data-idpublicacion="{{$singlePost->id}}" style="margin-top: 10px; display: inline-block;"class="btn btn-primary like" data-liked="true" >LIKE</button><p style="display: inline-block; color: #337ab7; vertical-align: bottom; margin-left: 15px; " id="{{$singlePost->id}}">Likes {{$singlePost->intLikes}}</p><button id="comments-intPostID" style="margin-top: 10px; display: inline-block; margin-left: 15px;" type="button" data-idpublicacion="{{$singlePost->id}}" class="btn btn-default comments" data-toggle="modal" data-target="#modalComments">New comment</button></div></div></div>');
            }
        }

        xhttp.open("POST", formAction, true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        for (i=0; i<metas.length; i++) { 
            if (metas[i].getAttribute("name") == "csrf-token") {  
                xhttp.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
            } 
        }
        xhttp.send(varJSON);
    });
    */

    $("#formNewPost").submit(function(e){
        e.preventDefault();
        var formAction = $(this).attr("action");
         
        $.ajax({
            method: 'post',
            url: formAction,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:new FormData(this),
            //dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                if(data.message){
                    alert(data.message);
                }else{
                    console.log(data);
                    $('#newPostModal').modal('toggle');
                    $('.postDiv').prepend('<div class="well" style="width: 70%; margin: 40px auto; background-color:lightblue; "><div><img  class="img-circle" style="width: 50px; height: 50px; display: inline-block;" src="' + data.strUserProfile +'"><a href="/myUser/{ {{'+ data.intUserID +'}} }"><h4 style="display: inline-block; margin-left: 10px;">'+ data.strUserName +'</h4></a></div><div><h3>'+ data.strTitle +'</h3><h4>'+ data.strDescription +'</h4><div style="width: 90%; margin: auto;"><img data-toggle="modal" data-target="#modalImg" class="imgGaleria" style="width: 100%; height: 200px; display: inline;" src="'+ data.strPostLink +'"></div><div><button data-idusuario="'+ data.intUserID +'" data-idpublicacion="'+ data.id +'" style="margin-top: 10px; display: inline-block;"class="btn btn-default like" data-liked="true" >LIKE</button><p style="display: inline-block; color: #337ab7; vertical-align: bottom; margin-left: 15px; " id="'+ data.id +'">Likes '+ data.intLikes +'</p><button id="comments-intPostID" style="margin-top: 10px; display: inline-block; margin-left: 15px;" type="button" data-idpublicacion="'+ data.id +'" class="btn btn-default comments" data-toggle="modal" data-target="#modalComments">New comment</button></div></div></div>');
                }
            },
            error: function(){
                console.log('Error');
            }
        });
    });

    $('img[data-target="#modalImg"]').click(function(){
        var srcImg = $(this).attr('src');
        $('.imgModalGallery').attr('src', srcImg);
    });
});