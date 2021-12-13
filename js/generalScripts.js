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

function show(id) {
    if (document.getElementById(id).style.display == 'flex') {
        document.getElementById(id).style.display = 'none';
    } else {
        document.getElementById(id).style.display = 'flex';
    }
}