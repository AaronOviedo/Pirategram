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

    // ALL AJAX FUNCTIONS
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
                    $('.postContainer').prepend(
                        '<div class="well divPost"><div>'+
                        '<img  class="img-circle imgProfile" src="' + data.strUserProfile +'">'+
                        '<a href="/myUser/{ {{'+ data.intUserID +'}} }">'+
                        '<button class="btn btn-danger pull-right" style="margin-left: 10px;"  data-postID="'+ data.id +'" data-toggle="modal" data-target="#modalDelete">Delete</button>' +
                        '<button class="btn btn-warning pull-right" data-postID="'+ data.id +'" data-toggle="modal" data-target="#modalEdit">Edit</button> '+
                        '<h4 style="display: inline-block; margin-left: 10px;">'+ data.strUserName +'</h4></a></div>'+
                        '<div><h3>'+ data.strTitle +'</h3><h4>'+ data.strDescription +'</h4><div>'+
                        '<img data-toggle="modal" data-target="#modalImg" class="imgGaleria imgWidth" src="'+ data.strPostLink +'"></div>'+
                        '<div><button data-idusuario="'+ data.intUserID +'" data-idpublicacion="'+ data.id +'"class="btn btn-default like" data-liked="true" >'+
                        'LIKE</button><label class="like" id="intPostID">Likes <span>'+ data.intLikes +'</span></label>'+
                        '<button id="comments-intPostID" type="button" data-idpublicacion="'+ data.id +'" class="btn btn-default comments pull-right" data-toggle="modal" data-target="#modalComments">New comment</button>'+
                        '</div></div></div>'
                        );
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
                    //location.reload();
                    $('.img-circle').attr('src', data);
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
                    //console.log(data);
                    location.reload();
                    //$('.coverDiv').css('background-image', data);
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
            success: function(data){
                //console.log(message);
                for(var user in data){
                    if(!data.hasOwnProperty(user)) continue;
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
                if(data.hasOwnProperty('message')){
                    $('.chatMessagesSend').append(
                        '<div class="messageSend">' +
                        data.message +
                        '</div>' +
                        '<div class="labelSend">' + data.created_at + '</div>'
                        );
                    
                    $('.chatMessagesReceive').append(
                        '<div class="messageReceive">' +
                        data.message +
                        '</div>'
                        );
                }else{
                    $('.chatMessagesSend').append(
                        '<div class="messageSend">' +
                        data.strMessage +
                        '</div>' +
                        '<div class="labelSend">' + data.created_at + '</div>'
                        );
                    $('.chat input').val('');
                }
            },
            error: function(){
                console.log('Error');
            }
        });
    });

    $('.chatMessages').ready(fetchMessages());
    $('#btnReloadMessages').click(function(){
        fetchMessages();
    });


    function fetchMessages(){
        var divSend = $('.chatMessagesSend');
        var divReceive = $('.chatMessagesReceive');
        $.ajax({
            method: 'post',
            url: 'fetchMessages',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                sendID:     $('#sendID').val(),
                receiveID:  $('#receiverID').val()
            },
            success: function(data){
                console.log(data);
                divSend.empty();
                divReceive.empty();
                var contador = 0;

                if(data.hasOwnProperty('message')){
                    $('.chatMessagesSend').append(
                        '<div class="messageSend">' +
                        data.message +
                        '</div>' +
                        '<div class="labelSend">' + data.created_at + '</div>' +

                        '<div class="messageSend">' +
                        data.message +
                        '</div>' +
                        '<div class="labelSend">' + 'Time created' + '</div>' 
                        );
                    
                    $('.chatMessagesReceive').append(
                        '<div class="messageReceived">' +
                        data.message +
                        '</div>' +
                        '<div class="labelReceived">' + 'Time created' + '</div>' +

                        '<div class="messageReceived">' +
                        data.message +
                        '</div>' +
                        '<div class="labelReceived">' + 'Time created' + '</div>'
                        );
                }else{
                    for(key in data){
                        if(!data.hasOwnProperty(key)) continue;
                        
                        console.log(data[key]);
                        var obj = data[key];
                        if(data.hasOwnProperty('sendMessages') && contador == 0){
                            for(key in obj){
                                $('.chatMessagesSend').append(
                                    '<div class="messageSend">' +
                                        obj[key].strMessage +
                                    '</div>' +
                                    '<div class="labelSend">' + obj[key].created_at + '</div>'
                                );
                            }
                            contador+= 1;
                        }else if(data.hasOwnProperty('receiveMessages') && contador == 1){
                            for(key in obj){
                                $('.chatMessagesReceive').append(
                                    '<div class="messageReceived">' +
                                        obj[key].strMessage +
                                    '</div>' +
                                    '<div class="labelReceived">' + obj[key].created_at + '</div>'
                                );
                            }
                        }
                    }
                }
            },
            error: function(){
                console.log('Error');
            }
        });
    }

    //AJAX for follow
    $('button.follow').click( function(){
        var btnFollow = $(this);
        var id = $('meta[name="userID"]').attr('content');
        if(btnFollow.attr('data-action') == 'follow'){
            $.ajax({
                method: 'get',
                url: 'follow',
                data: {
                    userID:     id,
                    followID:   btnFollow.attr('followID'),
                },
                success: function(e){
                    console.log(e.status);
                    btnFollow.attr('data-action', 'unfollow');
                    btnFollow.removeClass('btn-default');
                    btnFollow.addClass('btn-warning');
                }
            });
        }else if (btnFollow.attr('data-action') == 'unfollow'){
            $.ajax({
                method: 'get',
                url: 'unfollow',
                data: {
                    userID:     id,
                    followID:   btnFollow.attr('followID'),
                },
                success: function(e){
                    console.log(e.status);
                    btnFollow.attr('data-action', 'follow');
                    btnFollow.removeClass('btn-warning');
                    btnFollow.addClass('btn-default');
                }
            });
        }
    });

    //AJAX for like
    $('button.like').click( function(){
        var btnLike = $(this);
        var id = btnLike.attr('data-userID');
        var post = btnLike.attr('data-postID');
        if(btnLike.attr('data-liked') == 'true'){
            $.ajax({
                method: 'get',
                url: 'like',
                data: {
                    userID:     id,
                    postID:     post,
                },
                success: function(e){
                    console.log(e.status);
                    if(e.status == 'failed'){
                        alert('There was an error, please try again');
                    }else{
                        console.log(e);
                        btnLike.attr('data-liked', 'false');
                        btnLike.removeClass('btn-info');
                        btnLike.addClass('btn-default');
                        
                        $('label.like span').empty().append(e.intLikes);
                    }
                }
            });
        }else if (btnLike.attr('data-liked') == 'false'){
            $.ajax({
                method: 'get',
                url: 'unlike',
                data: {
                    userID:     id,
                    postID:     post,
                },
                success: function(e){
                    console.log(e.status);
                    if(e.status == 'failed'){
                        alert('There was an error, please try again');
                    }else{
                        btnLike.attr('data-liked', 'true');
                        btnLike.removeClass('btn-default');
                        btnLike.addClass('btn-info');

                        $('label.like span').empty();
                        $('label.like span').append(e.intLikes);
                    }
                }
            });
        }
    });

    $('button.comments').click(function (){
        var post = $(this).attr('data-postID');
        $('#modalComentsPostID').val(post);
        $.ajax({
            method: 'get',
            url: 'fetchComments',
            data:{
                postID: post
            },
            success: function(e){
                console.log(e);
                $('#contenedorComentarios').empty();
                for(key in e){
                    if(!e.hasOwnProperty(key)) continue;
                    
                    var data = e[key];
                    $('#contenedorComentarios').prepend(
                        '<div class="vistaComentario">' +
                        '<div>' +
                        '<img class="img-circle imgProfile" src="'+ data.userPhoto +'">' +
                        '<a href="/myUser/'+ data.userID +'"><h4 style="display: inline-block; margin-left: 10px;">'+ data.userName +'</h4></a>' +
                        '</div>' +
                        '<div class="vistaComentario">' +
                        data.coment +
                        '</div></div>'
                    );
                }
            }
        });
    });

    $('.postComent').submit(function (e){
        e.preventDefault();
        var formAction = $(this).attr("action");

        $.ajax({
            method: 'post',
            url: formAction,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data){
                $('#contenedorComentarios').prepend(
                    '<div class="vistaComentario">' +
                    '<div>' +
                    '<img class="img-circle imgProfile" src="'+ data.userPhoto +'">' +
                    '<a href="/myUser/'+ data.intUserID +'"><h4 style="display: inline-block; margin-left: 10px;">'+ data.userName +'</h4></a>' +
                    '</div>' +
                    '<div>' +
                    data.strComent +
                    '</div></div>'
                );
            }
        });
    });

    //Delete code
    $('button.btn-danger.pull-right').click(function(){
        var postID = $(this).attr('data-postID');
        $('#modalDeletePostID').val(postID);
    });
    $('#deletePost').click(function(){
        var postid = $('#modalDeletePostID').val();
        $.ajax({
            method: 'post',
            url: 'deletePost',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{
                postID: postid
            },
            success: function(data){
                if(data.message == 'success'){
                    location.reload();
                }else{
                    alert('There was an error, please try again');
                }
            }
        });
    });

    //Edit code
    $('button.btn-warning.pull-right').click(function(){
        var post = $(this).attr('data-postID');
        $('#modalEditPostID').val(post);

        $.ajax({
            method: 'get',
            url: 'editPostValues',
            data: {
                postID: post
            },
            success: function(data){
                if(data.message == 'failure'){
                    alert('There was an error, please try again');
                }else{
                    $('#editPostTitle').val(data.strTitle);
                    $('#editPostContent').val(data.strDescription);
                }
            }
        });
    });
    $('.editPostForm').submit(function(e){
        e.preventDefault();
        var formAction = $(this).attr("action");
        console.log('Hello');

        $.ajax({
            method: 'post',
            url: formAction,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                console.log(data);
                if(data.message == 'failure'){
                    alert('There was an error, please try again');
                }else{
                    location.reload();
                }
            }
        });
    });
});