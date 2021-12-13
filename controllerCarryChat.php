<?php
session_start();
include('connectionDatabase.php');
include('validateLogin.php');
$loggedUser = $_SESSION['id_usuario'];

$query = "SELECT * FROM mensagens WHERE enviou={$loggedUser} OR recebeu={$loggedUser} ORDER BY id_mensagens DESC";
$result = mysqli_query($connection, $query);

$query2 = "SELECT * FROM usuarios";
$result2 = mysqli_query($connection, $query2);

if (mysqli_num_rows($result) >= 1) {
    while ($dados = mysqli_fetch_array($result)) {
        while ($dados3 = mysqli_fetch_array($result2)) {
            $query3 = "SELECT caminho FROM fotos_usuario WHERE id_usuario={$dados3['id_usuario']} and tipo_foto='perfil'";
            $result3 = mysqli_query($connection, $query3);
            $pathPic = mysqli_fetch_assoc($result3);
            if ($dados['recebeu'] == $dados3['id_usuario'] && $dados3['id_usuario'] != $loggedUser) {
                echo '<div class="chatting" idUserChat="' . $dados3['id_usuario'] . '" userName="' . $dados3['nome'] . '"
                style="cursor:pointer;display:flex;flex-direction:row;align-items: center;justify-content: flex-start;width: 100%;height: 80px;background-color:#bae3e1;margin-bottom:10px;">';
                if ($pathPic == null) {
                    echo '<a style="border-radius: 50%;width: 50px;height: 50px;background-color:white;margin-left: 15px;display: flex;align-items: center;
                    justify-content: center;"><i class="fas fa-user" style="font-size:25px;color:#1BA39C;"></i></a>';
                } else {
                    echo '<a style="border-radius: 50%;width: 50px;height: 50px;background-color:white;margin-left:15px;"><img id="user-img" src="' . $pathPic['caminho'] . '" ></a>';
                }
                echo '<strong style="font-size:2rem;margin-left:15px;">' . $dados3['nome'] . '</strong>';
                echo '</div>';
                break;
            } elseif ($dados['enviou'] == $dados3['id_usuario'] && $dados3['id_usuario'] != $loggedUser) {
                echo '<div class="chatting" idUserChat="' . $dados3['id_usuario'] . '" userName="' . $dados3['nome'] . '"
                style="cursor:pointer;display:flex;flex-direction:row;align-items: center;justify-content: flex-start;width: 100%;height: 80px;background-color:#bae3e1;margin-bottom:10px;">';
                if ($pathPic == null) {
                    echo '<a style="border-radius: 50%;width: 50px;height: 50px;background-color:white;margin-left: 15px;display: flex;align-items: center;
                    justify-content: center;"><i class="fas fa-user" style="font-size:25px;color:#1BA39C;"></i></a>';
                } else {
                    echo '<a style="border-radius: 50%;width: 50px;height: 50px;background-color:white;margin-left:15px;"><img id="user-img" src="' . $pathPic['caminho'] . '" ></a>';

                }
                echo '<strong style="font-size:2rem;margin-left:15px;">' . $dados3['nome'] . '</strong>';
                echo '</div>';
                break;
            }
        }
    }
} else {
    echo '<p style="font-size: 2rem;color:#1BA39C;">Você ainda não tem conversas</p>';
}
?>