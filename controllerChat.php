<?php 

    session_start();
    include('connectionDatabase.php');

    $idChat = $_POST['id'];
    $loggedUser = $_SESSION['id_usuario'];

    $query = "SELECT * FROM mensagens WHERE enviou='$loggedUser' AND recebeu='$idChat' OR enviou='$idChat' AND recebeu='$loggedUser' ORDER BY data_envio";
    $result = mysqli_query($connection, $query);

    while ($dados = mysqli_fetch_array($result)) {
        $date = $dados['data_envio'];
        $date = strtotime($date);
        if ($dados['recebeu'] == $loggedUser) {
            echo '<div class="left-message">';
                echo '<p>'.$dados['mensagem'].'</p>';
                echo '<span><time>'.date('H:i',$date).'</time></span>';
            echo '</div>';
        } else {
            echo '<div class="right-message">';
                echo '<p>'.$dados['mensagem'].'</p>';
                echo '<span><time>'.date('d/m - H:i',$date).'</time></span>';
            echo '</div>';
        }
    }

?>