var btn = document.getElementById('loadComments');
var area = document.getElementById('ideias');
var spinner = document.getElementById('spinner');
var page = 1;

btn.addEventListener('click', function(){
    loadComm();
});

function loadComm() {
    $.ajax({
        url: 'controllerIdeas.php',
        method: 'POST',
        data: {'page':page},
        dataType: 'JSON',
        beforeSend: function() {
            spinner.style.display = 'block';
        }
    }).done(function(res){
        var new_area = area.innerHTML;
        
        if (res.status == 'sucess') {
            for(var i = 0; i <= (res.data.length -1); i++) {
				new_area += '<div class="idea"><div class="icon"><i class="fas fa-bullhorn"></i><p>'+res.data[i].tipo_idealizador+'</p></div><div class="content-infos" style="display: flex;flex-direction: column;"><strong id="name">'+res.data[i].nome_idealizador+'</strong><strong class="strong">'+ res.data[i].area +'</strong><strong class="strong">'+ res.data[i].titulo_ideia+'</strong></div><div class="bottom-idea"><button type="button"><i idIdealizador="'+res.data[i].id_idealizador+'" idIdea="'+res.data[i].id_ideias+'" id="interesse" class="fas fa-hand-sparkles"></i></button></div></div>';
            }
        } else {
            btn.remove();
        }

        page++;

        setTimeout(function(){
            spinner.style.display = 'none';
        }, 300);

        setTimeout(function(){
            area.innerHTML = new_area;
        }, 500);
    });
}

document.onload = loadComm();

$(function(){
	$("#pesquisa").keyup(function(){
		//Recuperar o valor do campo
		var pesquisa = $(this).val();
		
		//Verificar se há algo digitado
		if(pesquisa != ''){
			var dados = {
				palavra : pesquisa
			}
			$.post('proc_search_ideas.php', dados, function(retorna){
				//Mostra dentro da ul os resultado obtidos 
				$(".ideias").html(retorna);
			});
		}
	});
});

//função para exibir e esconder displays
function show(id){
    if (document.getElementById(id).style.display == 'flex') {
        document.getElementById(id).style.display = 'none';
    } else {
        document.getElementById(id).style.display = 'flex';
    }
}

$('#ideias').on('click', '#interesse', function (e) {
    var id_idealizador = $('#interesse').attr('idIdealizador');
    var idIdea = $('#interesse').attr('idIdea');
    $.ajax({
        url: 'controllerNotiIdea.php',
        type: 'POST',
        data:{id_idealizador:id_idealizador, idIdea:idIdea},
        success: function () {
            alert('Você mostrou interesse com sucesso!');
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