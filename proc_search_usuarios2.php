<?php
//Incluir a conexão com banco de dados
include_once 'connectionDatabase.php';

$search = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result_user = "SELECT * FROM usuarios WHERE nome LIKE '%$search%' OR arroba_usuario LIKE '%$search%' LIMIT 5";
$resultado_user = mysqli_query($connection, $result_user);

if (($resultado_user) and ($resultado_user->num_rows != 0)) {
	while ($row_user = mysqli_fetch_assoc($resultado_user)) {
		$pathPic = null;
		$query = "SELECT caminho FROM fotos_usuario WHERE id_usuario={$row_user['id_usuario']} AND tipo_foto='perfil'";
		$result2 = mysqli_query($connection, $query);
		if (mysqli_num_rows($result2) > 0) {
			$rowPath = mysqli_fetch_assoc($result2);
			$pathPic = $rowPath['caminho'];
		}
		echo '<div class="chatting" idUserChat="' . $row_user['id_usuario'] . '" userName="' . $row_user['nome'] . '"
        style="cursor:pointer;display:flex;flex-direction:row;align-items: center;justify-content: flex-start;width: 25%;height: 80px;background-color:#bae3e1;margin-bottom:10px;position: absolute;
		left: 182px;
		top: 40px;">';
		if ($pathPic == null) {
			echo '<a href="visitProfile.php?id='.$row_user['id_usuario'].'" style="border-radius: 50%;width: 50px;height: 50px;background-color:white;margin-left: 15px;display: flex;align-items: center;
            justify-content: center;"><i class="fas fa-user" style="font-size:25px;color:#1BA39C;"></i></a>';
		} else {
			echo '<a href="visitProfile.php?id='.$row_user['id_usuario'].'" style="border-radius: 50%;width: 50px;height: 50px;background-color:white;margin-left:15px;"><img id="user-img" src="' . $pathPic . '" ></a>';
		}
		echo '<strong style="font-size:2rem;margin-left:15px;">' . $row_user['nome'] . '</strong>';
		echo '</div>';
		break;
	}
} else {
	echo "Nenhum usuário encontrado...";
}
