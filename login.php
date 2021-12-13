<?php

    session_start();
    include('connectionDatabase.php');
    if (empty($_POST['email']) || empty($_POST['password'])) {
        header('Location: access.php');
        exit();
    }

    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $sql = "SELECT * FROM monography.usuarios where email = '$email' and senha =md5('$password')";
    $res = mysqli_query($connection, $sql);
    $row = mysqli_num_rows($res);

    if ($row == 1) {
        $query = "SELECT * FROM usuarios";
        $result = mysqli_query($connection, $query);
        
        while ($dados = mysqli_fetch_array($result)) {
            if ($dados['email'] == $email) {
                $idUser = $dados['id_usuario'];
                $name = $dados['nome'];
                $email = $dados['email'];
                $user = $dados['arroba_usuario'];
                $typeAccount = $dados['tipo_usuario'];
                $dateRegister = $dados['data_registro'];
            }
        }

        $query2 = "SELECT * FROM fotos_usuario";
        $result2 = mysqli_query($connection, $query2);

        while ($dados2 = mysqli_fetch_array($result2)) {
            if ($dados2['id_usuario'] == $idUser && $dados2['tipo_foto'] == "mural") {
                $pathBackgroundPic = $dados2['caminho'];
            } elseif ($dados2['id_usuario'] == $idUser && $dados2['tipo_foto'] == "perfil") {
                $pathUserPic = $dados2['caminho'];
            }
        }

        $_SESSION['id_usuario'] = $idUser;
        $_SESSION['email'] = $email;
        $_SESSION['nome'] = $name;
        $_SESSION['arroba_usuario'] = $User;
        $_SESSION['tipo_usuario'] = $typeAccount;
        $_SESSION['caminhoImgMural'] = $pathBackgroundPic;
        $_SESSION['caminhoImgPerfil'] = $pathUserPic;
        header('Location: loading.php');
        exit();
    } else {
        $_SESSION['unauthenticated']=true;
        header('Location: access.php');
        exit();
    }

?>