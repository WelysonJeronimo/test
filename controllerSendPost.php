<?php 
session_start();
include('connectionDatabase.php');
date_default_timezone_set('America/Sao_Paulo');
$loggedUser = $_SESSION['id_usuario'];
$name = $_SESSION['nome'];
$tipo = $_SESSION['tipo_usuario'];
$date = date('Y/m/d H:i:s');

if (isset($_POST['submitPost'])) {
    $txt = $_POST['textPost'];
    $result = mysqli_query($connection, "INSERT INTO publicacoes(nome_usuario, tipo_usuario, txt, data_publi, curtidas, id_usuario)
        VALUES ('$name', '$tipo', '$txt', '$date', '0', '$loggedUser')");

    $query = "SELECT * FROM publicacoes WHERE id_usuario={$loggedUser} ORDER BY data_publi DESC LIMIT 1";
    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($result);
    $idPubli = $row['id_publicacoes'];

    $allowedExtensions = array("png", "jpeg", "jpg", "gif", "mp4", "wmv", "mov");
    
    if ($_FILES['post-img']['name'] != null) {
        $countFiles = count($_FILES['post-img']['name']);
        $count = 0;

        while ($count < $countFiles) {
            //var_dump($_FILES['post-img']);
            $ext = pathinfo($_FILES['post-img']['name'][$count], PATHINFO_EXTENSION);

            if (in_array($ext, $allowedExtensions)) {
                $folder = "files/medias/";
                $temp = $_FILES['post-img']['tmp_name'][$count];
                $newName = uniqid() . ".$ext";
                if (move_uploaded_file($temp, $folder.$newName)) {
                    $path = $folder.$newName;
                    $result = mysqli_query($connection, "INSERT INTO midias(nome, caminho, tipo_arquivo, id_publicacao)
                    VALUES ('$newName', '$path', 'foto', '$idPubli')");
                }
            }
            $count++;
        }
    }
    
    if ($_FILES['post-vid']['name'] != null) {
        $countFiles = count($_FILES['post-vid']['name']);
        $count = 0;

        while ($count < $countFiles) {
            $ext = pathinfo($_FILES['post-vid']['name'][$count], PATHINFO_EXTENSION);

            if (in_array($ext, $allowedExtensions)) {
                $folder = "files/medias/";
                $temp = $_FILES['post-vid']['tmp_name'][$count];
                $newName = uniqid() . ".$ext";
                if (move_uploaded_file($temp, $folder.$newName)) {
                    $path = $folder.$newName;
                    $result = mysqli_query($connection, "INSERT INTO midias(nome, caminho, tipo_arquivo, id_publicacao)
                    VALUES ('$newName', '$path', 'video', '$idPubli')");
                }
            }
            $count++;
        }
    }
    header('Location: homepage.php');
}