<?php

session_start();
include('connectionDatabase.php');
date_default_timezone_set('America/Sao_Paulo');

$image = $_POST['image'];
$typePic = $_POST['type'];

if ($typePic == 'profilePic') {
    list($type, $image) = explode(';', $image);
    list(, $image) = explode(',', $image);

    $image = base64_decode($image);
    $image_name = uniqid() . '.png';
    file_put_contents('files/userspics/profilepics/' . $image_name, $image);

    $path = 'files/userspics/profilepics/'.$image_name;
    $date = date('Y/m/d');
    $idUser = $_SESSION['id_usuario'];
    $typePic = 'perfil';
    $result = mysqli_query($connection, "INSERT INTO fotos_usuario(nome, caminho, data_upload, tipo_foto, id_usuario)
        VALUES ('$image_name', '$path', '$date', '$typePic', '$idUser')") or die('ERRO AO SALVAR NO BANCO DE DADOS');
    echo 'Foto salve com sucessso';
} elseif ($typePic == 'backgroundPic') {
    list($type, $image) = explode(';', $image);
    list(, $image) = explode(',', $image);

    $image = base64_decode($image);
    $image_name = uniqid() . '.png';
    file_put_contents('files/userspics/backgroundpics/' . $image_name, $image);

    $path = 'files/userspics/backgroundpics/'.$image_name;
    $date = date('Y-m-d');
    $idUser = $_SESSION['id_usuario'];
    $typePic = 'mural';
    $result = mysqli_query($connection, "INSERT INTO fotos_usuario(nome, caminho, data_upload, tipo_foto, id_usuario)
    VALUES('$image_name', '$path', '$date', '$typePic', '$idUser')") or die('ERRO AO SALVAR NO BANCO DE DADOS');
    echo 'Foto salve com sucessso';
}

?>