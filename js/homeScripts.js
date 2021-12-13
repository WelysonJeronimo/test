//Script da função de clique no upload de imagens
var btn = document.querySelector('#file-img');
var file = document.querySelector('#post-img');
btn.addEventListener('click', () => {
    file.click();
})

//Script da função de clique no upload de videos
var btn2 = document.querySelector('#file-vid');
var file2 = document.querySelector('#post-vid');
btn2.addEventListener('click', () => {
    file2.click();
})

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

// exibir miniaturas de imagens antes do upload
$(function() {
    
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#post-img').on('change', function() {
        imagesPreview(this, 'div.preview');
    });
});

$(function() {
   
    
    var videosPreview = function (input, placeToInsertVideoPreview) {
        
        if (input.files) {
            var filesAmount = input.files.length;

            for ( j = 0; j < filesAmount; j++) {
                var reader = new FileReader();

                reader.onload = function (event) {
                    $($.parseHTML('<video></video>')).attr('src', event.target.result).appendTo(placeToInsertVideoPreview);
                }
                reader.readAsDataURL(input.files[j]);
            }

        }

    };

    $('#post-vid').on('change', function() {
        videosPreview(this, 'div.preview');
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

//Script da função seguir usuário
$('#profile-edit-button').on('click', '#follow', function () {
    var loggedUser = $('#follow').attr('loggeduser');
    var visitedUser = $('#follow').attr('visiteduser');
    var command = $('#follow').attr('command');
    $.ajax({
        url: 'followUser.php',
        type: 'POST',
        data: { lUser: loggedUser, vUser: visitedUser, command: command },
        success: function (data) {
            $('#profile-edit-button').html(data);
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
$('#profile-edit-button').on('click', '#unfollow', function () {
    var loggedUser = $('#unfollow').attr('loggeduser');
    var visitedUser = $('#unfollow').attr('visiteduser');
    var command = $('#unfollow').attr('command');
    $.ajax({
        url: 'followUser.php',
        type: 'POST',
        data: { lUser: loggedUser, vUser: visitedUser, command: command },
        success: function (data) {
            $('#profile-edit-button').html(data);
        }, error: function () {
            alert('Erro ao tentar operação!');
        }
    });
});