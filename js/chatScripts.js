window.onload = function () {
   $.ajax({
       url: 'controllerCarryChat.php',
       success: function (result) {
           $('.users').html(result);
       }, error: function () {
           $('.users').html('Error');
       }
   });
}

//script que devolve as mensagens do chat.
$('.users').on('click', '.chatting', function (e) {
   var idUserChat = $(this).attr('idUserChat');
   $.ajax({
      url: 'controllerChat.php',
      type: 'POST',
      data: { id: idUserChat }
   }).done(function (data) {
      $('#message').html(data);
      var message = document.querySelector('.mid');
      message.scrollTop = message.scrollHeight;
   });
});

//script que pega imagem e nome do usuário e preenche o topo do container das mensagens.
$('.users').on('click', '.chatting', function (e) {
   var idUserChat = $(this).attr('idUserChat');
   $.ajax({
      url: 'controllerUserChatting.php',
      type: 'POST',
      data: { id: idUserChat }
   }).done(function (data) {
      $('.right .top').html(data);
   });
});

//script que envia mensagens.
$('#submitChat').on('click', function () {
   var idUserChat = $('.right .top strong').attr('idUser');
   var txt = $('#in-msg').val();
   $.ajax({
      url: 'controllerSendChat.php',
      type: 'POST',
      data: { txt: txt, id: idUserChat },
      success: function (data) {
         $('#message').load('controllerChat.php');
      }, error: function () {
         alert('Erro ao enviar mensagem!');
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
			$.post('proc_search_usuarios.php', dados, function(retorna){
				//Mostra dentro da ul os resultado obtidos 
				$(".users").html(retorna);
			});
		}
	});
});