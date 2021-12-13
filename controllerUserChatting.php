<?php
session_start();
include('validateLogin.php');
include('connectionDatabase.php');

$userChat = $_POST['id'];

$query = "SELECT * FROM usuarios WHERE id_usuario={$userChat}";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$name = $row['nome'];

$query2 = "SELECT * FROM fotos_usuario WHERE id_usuario={$userChat} AND tipo_foto='perfil'";
$result2 = mysqli_query($connection, $query2);

if (mysqli_num_rows($result2) > 0) {
    $row2 = mysqli_fetch_assoc($result2);
    $pathImg = $row2['caminho'];
    echo '<img src="' . $pathImg . '"><br>' . '<strong idUser="'.$userChat.'">' . $name . '</strong>';
} else {
    echo '<a><i class="fas fa-user"></i></a><br>' . '<strong idUser="'.$userChat.'">' . $name . '</strong>';
}