<?php
require('connectionDatabase.php');

$usuario = mysqli_real_escape_string($connection, $_POST['usuario']);
$comentario = mysqli_real_escape_string($connection, $_POST['comentario']);
$publicacion = mysqli_real_escape_string($connection, $_POST['publicacion']);

$insert = mysqli_query($connection, "INSERT INTO comentarios (comentario, id_comentou, id_publicacao, data_comentou) VALUES ('$comentario', '$usuario', '$publicacion', now())");


$chamado = mysqli_query($connection, "SELECT * FROM publicacoes WHERE id_publicacoes = '".$publicacion."'");
$ch = mysqli_fetch_array($chamado);

$usuario2 = mysqli_real_escape_string($connection, $ch['id_usuario']);

$insert2 = mysqli_query($connection, "INSERT INTO notificacoes (usuario1, usuario2, tipo_noti, lido, data_noti, id_item) VALUES ('$usuario', '$usuario2', 'comentou', '0', now(), '$publicacion')");


?>