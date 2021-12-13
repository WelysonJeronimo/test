<?php 
session_start();
include('connectionDatabase.php');

if (isset($_POST['submitIdea'])) {
    $id_idealizador = $_SESSION['id_usuario'];
    $nome = $_SESSION['nome'];
    $area = $_POST['area'];
    $title = $_POST['title'];
    $tipo_user = $_SESSION['tipo_usuario'];
    $status = 'aberto';

    $res = mysqli_query($connection, "INSERT INTO ideias(id_idealizador, nome_idealizador, area, titulo_ideia, tipo_idealizador, status_ideia)
    VALUES('$id_idealizador', '$nome', '$area', '$title', '$tipo_user', '$status')");

    header('Location: ideas.php');

}

?>