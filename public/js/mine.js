/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.Pusher = require('pusher-js');
import Echo from "laravel-echo";

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'a305fbfddb8548e2b325',
    cluster: 'us2',
    encrypted: true
});

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

    //Listening to the broadcast Chat
    Echo.private('Chat').listen('sendPrivateMessage', (message) => {
        var id = $('meta[name="userID"]').attr('content');
        var divMessages = $('.chatMessages');
        var msg;
        if(message.intSend == id){
            msg = '<div class="messageSend">'
        }else if(message.intReceive == id){
            msg = '<div class="messageReceived">'
        }
        var finalMsg = msg + message.strMessage + '</div>';
        divMessages.append(finalMsg);
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

    $('.divChat').ready(function(){
        $.ajax({
            method: 'post',
            url: 'usersChat',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id : $('meta[name="userID"]').attr('content')},
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                //console.log(message);
                for(var user in data){
                    if(!data.hasOwnProperty(user)) continue;
                    console.log(data[user]);
                    $('.divChat').append('<div class="divChatContainer"><img class="img-circle imgProfile" src="'+data[user].userProfile+'"><a href="pvtMsg/'+data[user].userID+'"><h4 style="display: inline-block; margin-left: 10px;">'+data[user].userName+'</h4></a></div>');
                }
                $('.divChat').prepend('<center><label for="divChat">Chat</label></center>');
            },
            error: function(){
                console.log('Error');
            }
        });
    });

    $('.chatWriteMessage form').submit(function (e){
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
                console.log(data);
            },
            error: function(){
                console.log('Error');
            }
        });
    });

    //AJAX for like


    //AJAX for follow
    
});