<?php
session_start();
include('connectionDatabase.php');
date_default_timezone_set('America/Sao_Paulo');

$post = mysqli_real_escape_string($connection, $_POST['id']);
$usuario = $_SESSION['id_usuario'];
$nome = $_SESSION['nome'];


$comprobar = mysqli_query($connection,"SELECT * FROM curtidas WHERE id_curtido = '".$post."' AND id_curtiu = ".$usuario."");
$count = mysqli_num_rows($comprobar);

if ($count == 0) {

	$insert = mysqli_query($connection,"INSERT INTO curtidas(nome_curtiu, id_curtiu, id_curtido, tipo_curtida, data_curtida) VALUES('$nome', '$usuario', '$post', 'publicação', now())");
	$update = mysqli_query($connection,"UPDATE publicacoes SET curtidas = curtidas+1 WHERE id_publicacoes = '".$post."'");
	$query = "SELECT * FROM publicacoes WHERE id_publicacoes={$post}";
	$res = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($res);
	$idUserPubli = $row['id_usuario'];
	$insert2 = mysqli_query($connection, "INSERT INTO notificacoes (usuario1, usuario2, tipo_noti, lido, data_noti, id_item) VALUES ('$usuario', '$idUserPubli', 'curtiu', '0', now(), '$post')");
}

else 

{

	$delete = mysqli_query($connection,"DELETE FROM curtidas WHERE id_curtido = ".$post." AND id_curtiu = ".$usuario."");
	$update = mysqli_query($connection,"UPDATE publicacoes SET curtidas = curtidas-1 WHERE id_publicacoes = '".$post."'");
	$delete2 = mysqli_query($connection,"DELETE FROM notificacoes WHERE id_item = ".$post." AND usuario1 = ".$usuario."");

}

$contar = mysqli_query($connection,"SELECT curtidas FROM publicacoes WHERE id_publicacoes = ".$post."");
$cont = mysqli_fetch_array($contar);
$likes = $cont['curtidas'];

if ($count >= 1) { $curtiu = '<a ><i class="fas fa-heart"></i>Curtir</a>'; $likes = " (".$likes++.") curtiram"; } else { $curtiu = '<a><i class="fas fa-heart" style="color: red;font-size: 15px;"></i>Curtido</a>'; $likes = " (".$likes--.") curtiram"; }

$datos = array('likes' =>$likes,'text' =>$curtiu);

echo json_encode($datos);

?>