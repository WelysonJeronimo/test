<?php

    if (isset($_POST['submitRegister'])) {
        include('connectionDatabase.php');
        date_default_timezone_set('America/Sao_Paulo');
        //Salvando os dados em variáveis
        $name = ucwords($_POST['name']);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $typeAccount = $_POST['typeAccount'];
        /*Verificando o número de usuários totais da
        tabela usuarios e gerando o @ do usuário*/
        $sql = "SELECT * FROM usuarios";
        $res = $connection->query($sql);
        $idUser = '@usuario0001';
        if (mysqli_num_rows($res) >= 1) {
            $count = mysqli_num_rows($res);
            $idUser = '@usuario000'.$count+'1';
        }
        //Evitando emails repetidos
        $sql2 = "SELECT * FROM usuarios WHERE usuarios.email = '$email'";
        $res2 = $connection->query($sql2);
        if (mysqli_num_rows($res2) === 0 && preg_match('/^[^W][a-z0-9_]+(.[a-z0-9]+)@[a-z0-9]+(.[a-z0-9]+).[a-z]{2,4}$/',$email)) {
            $date = date('Y/m/d');
            $result = mysqli_query($connection, "INSERT INTO monography.usuarios(nome, email, senha, arroba_Usuario, tipo_Usuario, data_registro)
            VALUES ('$name', '$email', md5('$password'), '$idUser', '$typeAccount', '$date')");
            header("Location: access.php");
        } else {
            echo "ERRO";
        }
    }

?>