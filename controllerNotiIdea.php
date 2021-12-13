<?php
require('connectionDatabase.php');
session_start();

$id_dono = mysqli_real_escape_string($connection, $_POST['id_idealizador']);
$idIdea = mysqli_real_escape_string($connection, $_POST['idIdea']);
$loggedUser = $_SESSION['id_usuario'];

$insert2 = mysqli_query($connection, "INSERT INTO notificacoes (usuario1, usuario2, tipo_noti, lido, data_noti, id_item) VALUES ('$loggedUser', '$id_dono', 'interesse', '0', now(), '$idIdea')");


?>