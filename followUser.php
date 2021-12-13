<?php

    session_start();
    include('connectionDatabase.php');

    $seguidor = $_POST['lUser'];
    $seguido = $_POST['vUser'];
    $command = $_POST['command'];

    if ($command === "follow") {
        $date = date('Y/m/d');
        $query = "INSERT INTO seguidores(seguidor, seguido, data_seguiu) VALUES('$seguidor', '$seguido', '$date')";
        $result = mysqli_query($connection, $query);
        echo '<a id="unfollow" command="unfollow" loggeduser="' . $_SESSION['id_usuario'] . '" visiteduser="' . $seguido . '">Seguindo<i class="fas fa-user-check"></i></a>';
        $insert2 = mysqli_query($connection, "INSERT INTO notificacoes (usuario1, usuario2, tipo_noti, lido, data_noti, id_item) VALUES ('$seguidor', '$seguido', 'seguiu', '0', now(), '0')");
    } else if ($command === "unfollow") {
        $query = "DELETE FROM seguidores WHERE seguidor='$seguidor' AND seguido=$seguido";
        $result = mysqli_query($connection, $query);
        echo '<a id="follow" command="follow" loggeduser="' . $_SESSION['id_usuario'] . '" visiteduser="' . $seguido . '">Seguir<i class="fas fa-user-plus"></i></a>';
        $delete = mysqli_query($connection,"DELETE FROM notificacoes WHERE usuario1 = ".$seguidor." AND usuario2 = ".$seguido."");
    } else {
        echo 'ERROR';
    }
    
?>