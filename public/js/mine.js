/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
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

    $("#formNewPost").submit(function(e){
        e.preventDefault();
        var formAction = $(this).attr("action");
         
        $.ajax({
            method: 'post',
            url: formAction,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                if(data.message){
                    alert(data.message);
                    $('#newPostModal').modal('toggle');
                }else{
                    console.log(data);
                    $('#newPostModal').modal('toggle');
                    $('.postContainer').prepend('<div class="well divPost"><div><img  class="img-circle imgProfile" src="' + data.strUserProfile +'"><a href="/myUser/{ {{'+ data.intUserID +'}} }"><h4 style="display: inline-block; margin-left: 10px;">'+ data.strUserName +'</h4></a></div><div><h3>'+ data.strTitle +'</h3><h4>'+ data.strDescription +'</h4><div><img data-toggle="modal" data-target="#modalImg" class="imgGaleria imgWidth" src="'+ data.strPostLink +'"></div><div><button data-idusuario="'+ data.intUserID +'" data-idpublicacion="'+ data.id +'"class="btn btn-default like" data-liked="true" >LIKE</button><p class="like" id="'+ data.id +'">Likes '+ data.intLikes +'</p><button id="comments-intPostID" type="button" data-idpublicacion="'+ data.id +'" class="btn btn-default comments pull-right" data-toggle="modal" data-target="#modalComments">New comment</button></div></div></div>');
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

    $('#profile').change(function(){
        var formData = new FormData();
        var image = $(this)[0].files[0];
        formData.append('newProfile', image);
        formData.append('userID', $('#spanUserID').attr('data-value'));

        $.ajax({
            method: 'post',
            url: 'newProfile',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                if(data.message){
                    alert(data.message);
                }else{
                    console.log(data);
                    location.reload();
                }
            },
            error: function(){
                console.log('Error');
            }
        });
    });
    
    $('#cover').change(function(){
        var formData = new FormData();
        var image = $(this)[0].files[0];
        formData.append('newCover', image);
        formData.append('userID', $('#spanUserID').attr('data-value'));

        $.ajax({
            method: 'post',
            url: 'newCover',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                if(data.message){
                    alert(data.message);
                }else{
                    console.log(data);
                    location.reload();
                }
            },
            error: function(){
                console.log('Error');
            }
        });
    });
});