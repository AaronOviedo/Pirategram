/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

    function ajaxPost(url, varJSON, sync){
        var xhttp;
        xhttp = new XMLHttpRequest();

        var metas = document.getElementsByTagName('meta'); 

        xhttp.open("POST", url, sync);
        xhttp.setRequestHeader("Content-Type", "application/json");
        for (i=0; i<metas.length; i++) { 
            if (metas[i].getAttribute("name") == "csrf-token") {  
                xhttp.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
            } 
        }
        xhttp.send(varJSON);
    }

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

    /*$("#formRegister").submit(function(event){
        event.preventDefault();

        var formAction = $(this).attr("action");

        var vName = $("#nameID").val();
        var vEmail = $("#emailID").val();
        var vPassword = $("#passwordID").val();
        var vDate = $("#dateID").val();
        var vGender = $("#genderID").val();

        var varJSON = JSON.stringify({name:vName, email:vEmail, password:vPassword, date:vDate, gender:vGender});

        console.log(varJSON);

        ajaxPost(formAction, varJSON, false);
    });*/
});