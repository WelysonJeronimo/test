<?php 

    include('connectionDatabase.php');

    $id = $_POST['user'];
    $sql = "SELECT * FROM usuarios";
    $result = mysqli_query($connection, $sql);

    while ($userDados = mysqli_fetch_array($result)) {
        if ($userDados['id_usuario'] == $id) {
            $idVisitedUser = $userDados['id_usuario'];
            $nome = $userDados['nome'];
            $arroba = $userDados['arroba_usuario'];
            $tipoUsuario = $userDados['tipo_usuario'];
            break;
        }
    }

    header('Location: visitProfile.php/');

?>