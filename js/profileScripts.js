window.onload = function () {
    $.ajax({
        url: 'contents-profile/posts.php',
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
}

$('#posts').on('click', function (e) {
    $.ajax({
        url: 'contents-profile/posts.php',
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
});

$('#media').on('click', function (e) {
    $.ajax({
        url: 'contents-profile/midias.php',
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
});

$('#interaction').on('click', function (e) {
    $.ajax({
        url: 'contents-profile/interaction.php',
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
});

$('#sobre').on('click', function (e) {
    $.ajax({
        url: 'contents-profile/aboutUser.php',
        success: function (result) {
            $('#content-trade').html(result);
        }, error: function () {
            $('#content-trade').html('Error');
        }
    });
});

$(function () {
    //Script da função recortar fotos.
    var resize = $('#upload-demo').croppie({
        enableExif: true,
        enableOrientation: true,
        viewport: {
            width: 250,
            height: 250,
            type: 'circle'
        },
        boundary: {
            width: 400,
            height: 465
        }
    });
    $('#image').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            resize.croppie('bind', {
                url: e.target.result
            }).then(function () {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('.btn-upload-image').on('click', function (ev) {
        resize.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (img) {
            $.ajax({
                url: "controllerCroppie.php",
                type: "POST",
                data: {
                    "image": img,
                    "type": 'profilePic'
                },
                success: function (data) {
                    location.reload();
                    return false;
                }
            });
        });
    });
});

$(function () {
    //Script de recortar imagem para o mural do perfil
    var resize = $('#upload-demo2').croppie({
        showZoomer: false,
        enableOrientation: true,
        viewport: { width: 700, height: 225 },
        boundary: { width: 1000, height: 360 },
    });
    $('#image2').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            resize.croppie('bind', {
                url: e.target.result
            }).then(function () {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('.btn-upload-image2').on('click', function (ev) {
        resize.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (img) {
            $.ajax({
                url: "controllerCroppie.php",
                type: "POST",
                data: {
                    "image": img,
                    "type": 'backgroundPic'
                },
                success: function (data) {
                    location.reload();
                    return false;
                }
            });
        });
    });
});

//Script do compo de escolha de endereço.
$(document).ready(function () {
    carry_json('Estado');
    function carry_json(id, city_id) {
        var html = '';

        $.getJSON('https://gist.githubusercontent.com/letanure/3012978/raw/78474bd9db11e87de65a9d3c9fc4452458dc8a68/estados-cidades.json',
            function (data) {
                html += '<option>Selecionar ' + id + '</option>';
                if (id == 'Estado') {
                    for (var i = 0; i < data.estados.length; i++) {
                        html += '<option value=' + data.estados[i].nome + '>' + data.estados[i].nome + '</option>';
                    }
                } else {

                    for (var i = 0; i < data.estados.length; i++) {
                        if (data.estados[i].sigla == city_id) {
                            for (var j = 0; j < data.estados[i].cidades.length; j++) {
                                html += '<option value=' + data.estados[i].cidades[j] + '>' + data.estados[i].cidades[j] +
                                    '</option>';

                            }
                        }

                    }

                }

                $('#' + id).html(html);
            });

        $(document).on('change', '#Estado', function () {
            var city_id = $(this).val();
            if (city_id != null) {
                carry_json('Cidade', city_id);
            }
        });

    }

});

$(document).ready(function () {
    $(".like").click(function () {
        var id = this.id;

        $.ajax({
            url: 'controllerLikePost.php',
            type: 'POST',
            data: { id: id },
            dataType: 'json',

            success: function (data) {
                var likes = data['likes'];
                var text = data['text'];

                $("#likes_" + id).text(likes);
                $("#" + id).html(text);
            }
        });
    });
});

$(document).ready(function () {

    $(".enviar-btn").keypress(function (event) {

        if (event.which == 13) {

            var getpID = $(this).parent().attr('id').replace('record-', '');

            var usuario = $("input#usuario").val();
            var comentario = $("#comentario-" + getpID).val();
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
                success: function () {
                    $('#new-comment' + getpID).append('<div class="comment"><div class="user-comment"><img src="' + avatar + '"><strong>' + nombre + '</strong></div><div class="txt"><p>' + comentario + '</p><p class="bottom">' + date_show + '</p></div></div>');
                    $("#comentario-" + getpID).val('');
                }
            });
            return false;
        }
    });
});

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