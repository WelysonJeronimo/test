function show(id) {
    if (document.getElementById(id).style.display == 'flex') {
        document.getElementById(id).style.display = 'none';
    } else {
        document.getElementById(id).style.display = 'flex';
    }
}

//Script da função seguir usuário
$('.suggested-profiles').on('click', '#follow', function () {
    var loggedUser = $('#follow').attr('loggeduser');
    var visitedUser = $('#follow').attr('visiteduser');
    var command = $('#follow').attr('command');
    $.ajax({
        url: 'followUser.php',
        type: 'POST',
        data: { lUser: loggedUser, vUser: visitedUser, command: command },
        success: function (data) {
            $('#profile-edit-button2').html(data);
            var unfollow = document.querySelector('#unfollow');

            unfollow.addEventListener('mouseover', function() {
                this.style.backgroundColor = 'red';
                this.style.borderRadius = '25px';
                this.style.transition = '0.2s';
                $('#unfollow').html('Deixar de seguir');
            });

            unfollow.addEventListener('mouseout', function() {
                this.style.backgroundColor = '#1BA39C';
                this.style.borderRadius = '25px';
                $('#unfollow').html('Seguindo<i class="fas fa-user-check"></i>');
            });
        }, error: function () {
            alert('Erro ao tentar operação!');
        }
    });
});

//Script da função deixar de seguir
$('.suggested-profiles').on('click', '#unfollow', function () {
    var loggedUser = $('#unfollow').attr('loggeduser');
    var visitedUser = $('#unfollow').attr('visiteduser');
    var command = $('#unfollow').attr('command');
    $.ajax({
        url: 'followUser.php',
        type: 'POST',
        data: { lUser: loggedUser, vUser: visitedUser, command: command },
        success: function (data) {
            $('#profile-edit-button2').html(data);
        }, error: function () {
            alert('Erro ao tentar operação!');
        }
    });
});

window.onload = function () {
    var id = $('#posts').attr('idVisitedUser');
    $.ajax({
        url: 'contents-profile/visitedProfilePost.php',
        type: 'POST',
        data: {id:id},
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
}

$('#posts').on('click', function (e) {
    var id = $(this).attr('idVisitedUser');
    $.ajax({
        url: 'contents-profile/visitedProfilePost.php',
        type: 'POST',
        data: {id:id},
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
});

$('#media').on('click', function (e) {
    var id = $(this).attr('idVisitedUser');
    $.ajax({
        url: 'contents-profile/visitedMidias.php',
        type: 'POST',
        data: {id:id},
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
});

$('#interaction').on('click', function (e) {
    var id = $(this).attr('idVisitedUser');
    $.ajax({
        url: 'contents-profile/visitedInteraction.php',
        type: 'POST',
        data: {id:id},
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
});

$('#sobre').on('click', function (e) {
    var id = $(this).attr('idVisitedUser');
    $.ajax({
        url: 'contents-profile/visitedAboutUser.php',
        type: 'POST',
        data: {id:id},
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
});

$(document).ready(function(){
	$(".like").click(function(){
		var id = this.id;

		$.ajax({
			url: 'controllerLikePost.php',
			type: 'POST',
			data: {id:id},
			dataType: 'json',

			success:function(data){
				var likes = data['likes'];
				var text = data['text'];

				$("#likes_"+id).text(likes);
				$("#"+id).html(text);
			}
		});
	});
});

$(document).ready(function() {

    $(".enviar-btn").keypress(function(event) {

      if ( event.which == 13 ) {

        var getpID =  $(this).parent().attr('id').replace('record-','');

        var usuario = $("input#usuario").val();
        var comentario = $("#comentario-"+getpID).val();
        var publicacion = getpID;
        var avatar = $("input#avatar").val();
        var nombre = $("input#nombre").val();
        var now = new Date();
        var date_show = now.getDate() + '-' + now.getMonth() + '-' + now.getFullYear() + ' ' + now.getHours() + ':' + + now.getMinutes() + ':' + + now.getSeconds();

        if (comentario == '') {
            alert('Você deve escrever algo!');
            return false;
        }

        var dataString = 'usuario=' + usuario + '&comentario=' + comentario + '&publicacion=' + publicacion;

        $.ajax({
                type: "POST",
                url: "controllerComments.php",
                data: dataString,
                success: function() {
                    $('#new-comment'+getpID).append('<div class="comment"><div class="user-comment"><img src="'+avatar+'"><strong>'+nombre+'</strong></div><div class="txt"><p>'+comentario+'</p><p class="bottom">'+date_show+'</p></div></div>');
                    $("#comentario-"+getpID).val('');
                }
        });
        return false;
      }
    });

});

$(function(){
	$("#pesquisa").keyup(function(){
		//Recuperar o valor do campo
		var pesquisa = $(this).val();
		
		//Verificar se há algo digitado
		if(pesquisa != ''){
			var dados = {
				palavra : pesquisa
			}
			$.post('proc_search_usuarios2.php', dados, function(retorna){
				//Mostra dentro da ul os resultado obtidos 
				$(".users").html(retorna);
			});
		}
	});
});