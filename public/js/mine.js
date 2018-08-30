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
    
    $("#nombreUsuarioRegistro").blur(function(){
        var textBox = $(this);
        var nombreUsuario = textBox.val();
        $.ajax({
			url : 'check',
			data : {
                            nombreUsuario : nombreUsuario,
                            action : "checkUserName"
			},
			success : function(responseText) {
				if(responseText == "<p>1</p>"){
                                    textBox.css("border-color", "#ff0000");
                                    alert("Lo sentimos, ese nombre de usuario ya está en uso")
                                }else{
                                    textBox.css("border-color", "#00ff00");
                                }
			}
		});
    });
    
    $("#correoElectronicoRegistro").blur(function(){
        var textBox = $(this);
        var correoElectronico = textBox.val();
        $.ajax({
			url : 'check',
			data : {
                            correoElectronico : correoElectronico,
                            action : "checkEmail"
			},
			success : function(responseText) {
				if(responseText == "<p>1</p>"){
                                    textBox.css("border-color", "#ff0000");
                                    alert("Lo sentimos, ese correo ya está en uso")
                                }else{
                                    textBox.css("border-color", "#00ff00");
                                }
			}
		});
    });
    
});