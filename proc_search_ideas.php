<?php
//Incluir a conexão com banco de dados
include_once 'connectionDatabase.php';

$search = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT * FROM ideias WHERE nome_idealizador LIKE '%$search%' OR area LIKE '%$search%' OR titulo_ideia LIKE '%$search%' LIMIT 10";
$resultado_user = mysqli_query($connection, $result_user);

if(($resultado_user) AND ($resultado_user->num_rows != 0 )){
	while($row_user = mysqli_fetch_assoc($resultado_user)){
		echo '<div class="idea">
			<div class="icon"><i class="fas fa-bullhorn"></i></div>
			<div class="content-infos" style="display: flex;flex-direction: column;">
				<strong id="name">'.$row_user['nome_idealizador'].'</strong>
				<strong class="strong">'.$row_user['area'].'</strong>
				<strong class="strong">'.$row_user['titulo_ideia'].'</strong>
			</div>
			<button type="button"><i id="interesse" class="fas fa-angle-right"></i></button>
		</div>';
	}
}else{
	echo "Nada foi encontrado...";
}