<?php
session_start();
include('connectionDatabase.php');
$idPost = $_GET['id'];

$delete = mysqli_query($connection,"DELETE FROM publicacoes WHERE id_publicacoes={$idPost}");
header('Location: profile.php');
?>