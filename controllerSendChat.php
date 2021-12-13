<?php 
    session_start();
    include('connectionDatabase.php');
    date_default_timezone_set('America/Sao_Paulo');

    $idChat = $_POST['id'];
    $loggedUser = $_SESSION['id_usuario'];
    $txt = $_POST['txt'];
    $date = date('Y-m-d H:i:s');

    if($txt != '' or $txt != null) {
        $sql = "INSERT INTO mensagens(mensagem, enviou, recebeu, data_envio) VALUES('$txt','$loggedUser','$idChat','$date')";
        $insert = mysqli_query($connection, $sql) or die('ERROR');
        $date = strtotime($date);
        echo '<div class="right-message">';
            echo '<p>'.$txt.'</p>';
            echo '<span><time>'.date('H:i', $date).'</time></span>';
        echo '</div>';
    } else {
        header('Location: chat.php');
    }

?>