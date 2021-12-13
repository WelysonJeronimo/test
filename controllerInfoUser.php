<?php 
session_start();
include('connectionDatabase.php');

if (isset($_POST['submitEditProfile'])) {
    $sql = "SELECT * FROM info_usuarios WHERE id_usuario={$_SESSION['id_usuario']}";
    $res = mysqli_query($connection,$sql);
    if (mysqli_num_rows($res)>=1) {
        $nome = $_POST['name'];
        $arroba = $_POST['arroba'];
        $bday = $_POST['bday'];
        $description = $_POST['description'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $curso = $_POST['curso'];
        $institution = $_POST['institution'];
        $areas = $_POST['areas'];
        $vagas = $_POST['vagas'];
        $id = $_SESSION['id_usuario'];

        $alter = mysqli_query($connection, "UPDATE usuarios SET arroba_usuario = {$arroba} WHERE id_usuario = '".$id."'");
        $alter2 = mysqli_query($connection, "UPDATE usuarios SET nome = {$nome} WHERE id_usuario = '".$id."'");
        $alter3 = mysqli_query($connection, "UPDATE info_usuarios SET aniversario = {$bday} WHERE id_usuario = '".$id."'");
        $alter4 = mysqli_query($connection, "UPDATE info_usuarios SET descricao = {$description} WHERE id_usuario = '".$id."'");
        $alter5 = mysqli_query($connection, "UPDATE info_usuarios SET estado = {$estado} WHERE id_usuario = '".$id."'");
        $alter6 = mysqli_query($connection, "UPDATE info_usuarios SET cidade = {$cidade} WHERE id_usuario = '".$id."'");
        $alter7 = mysqli_query($connection, "UPDATE info_usuarios SET curso_formacao = {$curso} WHERE id_usuario = '".$id."'");
        $alter8 = mysqli_query($connection, "UPDATE info_usuarios SET instituição = {$institution} WHERE id_usuario = '".$id."'");
        $alter9 = mysqli_query($connection, "UPDATE info_usuarios SET areas = {$areas} WHERE id_usuario = '".$id."'");
        $alter10 = mysqli_query($connection, "UPDATE info_usuarios SET vagas_orientacao = {$vagas} WHERE id_usuario = '".$id."'");
        header('Location: profile.php');
    } else {
        if (isset($_POST['vagas'])) {
            $nome = $_POST['name'];
            $arroba = $_POST['arroba'];
            $bday = $_POST['bday'];
            $description = $_POST['description'];
            $estado = $_POST['estado'];
            $cidade = $_POST['cidade'];
            $curso = $_POST['curso'];
            $institution = $_POST['institution'];
            $areas = $_POST['areas'];
            $vagas = $_POST['vagas'];
            $id = $_SESSION['id_usuario'];

            $insert = mysqli_query($connection, "INSERT INTO info_usuarios(aniversario, descricao, estado, cidade, curso_formacao, instituição, areas, vagas_orientacao, id_usuario)
            VALUES ('$bday', '$description', '$estado', '$cidade', '$curso', '$institution', '$areas', '$vagas', '$id')");

            $alter = mysqli_query($connection, "UPDATE usuarios SET arroba_usuario = {$arroba} WHERE id_usuario = '".$id."'");
            $alter2 = mysqli_query($connection, "UPDATE usuarios SET nome = {$nome} WHERE id_usuario = '".$id."'");
            header('Location: profile.php');
        } else {
            $nome = $_POST['name'];
            $arroba = $_POST['arroba'];
            $bday = $_POST['bday'];
            $description = $_POST['description'];
            $estado = $_POST['estado'];
            $cidade = $_POST['cidade'];
            $curso = $_POST['curso'];
            $institution = $_POST['institution'];
            $areas = $_POST['areas'];
            $vagas = 0;
            $id = $_SESSION['id_usuario'];

            $insert = mysqli_query($connection, "INSERT INTO info_usuarios(aniversario, descricao, estado, cidade, curso_formacao, instituição, areas, vagas_orientacao, id_usuario)
            VALUES ('$bday', '$description', '$estado', '$cidade', '$curso', '$institution', '$areas', '$vagas', '$id')");

            $alter = mysqli_query($connection, "UPDATE usuarios SET arroba_usuario = {$arroba} WHERE id_usuario = '".$id."'");
            $alter2 = mysqli_query($connection, "UPDATE usuarios SET nome = {$nome} WHERE id_usuario = '".$id."'");
            header('Location: profile.php');
        }
    }
}
?>