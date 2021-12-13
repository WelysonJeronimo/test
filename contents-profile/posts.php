<?php
session_start();
include('../validateLogin.php');
include('../connectionDatabase.php');

$user = $_SESSION['id_usuario'];
$photo = $_SESSION['caminhoImgPerfil'];

$sql = "SELECT * FROM usuarios WHERE id_usuario={$user}";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

$sql2 = "SELECT * FROM info_usuarios WHERE id_usuario={$user}";
$res2 = mysqli_query($connection, $sql2);
$row2 = mysqli_fetch_assoc($res2);

$query = "SELECT * FROM publicacoes WHERE id_usuario={$user} ORDER BY id_publicacoes DESC";
$result = mysqli_query($connection, $query);
echo '<div style="display:flex;flex-direction:column;">
    <div class="card-apresentation">
        <h3>Apresentação</h3>';
        echo '<p>'.$row['tipo_usuario'].'</p>';
if (mysqli_num_rows($res2) >= 1 && mysqli_num_rows($result) >= 1) {
        if ($row2['instituição'] != null) {
            echo '<p>'.$row2['instituição'].'</p>';
        }
        if ($row2['curso_formacao'] != null) {
            echo '<p>'.$row2['curso_formacao'].'</p>';
        }
        if ($row2['cidade'] != null && $row2['estado'] != null) {
            echo '<p id="p2"><i class="fas fa-map-marker-alt"></i> '.$row2['cidade'].', '.$row2['estado'].'</p>';
        }
        if ($row2['vagas_orientacao'] != null) {
            echo '<p>'.$row2['vagas_orientacao'].'</p>';
        }
}
    echo '</div>';
        $contPosts = mysqli_num_rows($result);
        $contMidias = 0;
        while ($a = mysqli_fetch_array($result)) {
            $sql3 = "SELECT * FROM midias WHERE id_publicacao={$a['id_publicacoes']}";
            $res3 = mysqli_query($connection, $sql3);
            if(mysqli_num_rows($res3) >= 1) {
                $contMidias++;
            }
        }

        $contInteracoes = 0;
        $sql4 = "SELECT * FROM notificacoes WHERE usuario1={$user}";
        $res4 = mysqli_query($connection,$sql4);
        $contInteracoes+= mysqli_num_rows($res4);
    echo '<div class="card-stats">
        <h3>Estatisticas do Usuário</h3>
        <p>Número de Publicações do Usuário '.$contPosts.'</p>
        <p>Número de Mídias do Usuário '.$contMidias.'</p>
        <p>Número de interações do Usuário '.$contInteracoes.'</p>';


    echo '</div>
</div>';

$query = "SELECT * FROM publicacoes WHERE id_usuario={$user} ORDER BY id_publicacoes DESC";
$result = mysqli_query($connection, $query);
echo '<ul class="posts">';
if (mysqli_num_rows($result) >= 1) {
    while ($dados = mysqli_fetch_array($result)) {
        $date = $dados['data_publi'];
        $date = strtotime($date);
        echo '<li class="post" idPost="">';
            echo '<div class="author-post">';
                $sql = "SELECT * FROM fotos_usuario WHERE id_usuario='$dados[id_usuario]' AND tipo_foto='perfil'";
                $res = mysqli_query($connection, $sql);
                $row10 = mysqli_fetch_assoc($res);
                if (mysqli_num_rows($res) >= 1) {
                    $photo = $row10['caminho'];
                    echo '<div class="img-user"><a href="visitProfile.php?id='.$dados['id_usuario'].'"><img src="'.$photo.'"></a></div>';
                } else {
                    echo '<div class="img-user"><a href="visitProfile.php?id='.$dados['id_usuario'].'"><img src=""></a></div>';
                }
                echo '<div class="info-user">';
                    echo '<strong>'.$dados['nome_usuario'].'</strong>';
                    echo '<p>'.$dados['tipo_usuario'].'</p>';
                    echo '<p>'.date('d/m H:i', $date).'</p>';
                echo '</div>';
            echo '</div>';
            echo '<div class="btn-option"><button type="button" ><a href="deletePost.php?id='.$dados['id_publicacoes'].'"><i class="fas fa-times"></i></a></button>
            </div>';
            

            echo '<p>'.$dados['txt'].'</p>';
            $midia = "SELECT * FROM midias WHERE id_publicacao = {$dados['id_publicacoes']}";
            $pathMidia = mysqli_query($connection, $midia);
                if (mysqli_num_rows($pathMidia) >= 1) {
                    echo '<div class="midias">';
                    while ($b = mysqli_fetch_array($pathMidia)) {
                        if ($b['id_publicacao'] == $dados['id_publicacoes'] && $b['tipo_arquivo'] == 'video') {
                            echo '<video src="'.$b['caminho'].'" style="width:100%;" controls/>';
                        } else {
                            echo '<img src="'.$b['caminho'].'" style="width:100%;" />';
                        }
                    }
                    echo '</div>';
                }
            $sql = "SELECT * FROM curtidas WHERE id_curtido={$dados['id_publicacoes']} AND id_curtiu='$user'";
            $like = mysqli_query($connection, $sql);
            $row3 = mysqli_query($connection, "SELECT * FROM comentarios WHERE id_publicacao = '".$dados['id_publicacoes']."'");
            $numComment = mysqli_num_rows($row3);
            echo '<div class="actions-btn-group">';
                echo '<div class="stats">';
                    echo '<p id="likes_'.$dados['id_publicacoes'].'">('.$dados['curtidas'].') curtiram</p>';
                    echo '<p >('.$numComment.') comentarios</p>';
                echo '</div>';
                if (mysqli_num_rows($like) >= 1) {
                    echo '<button class="like" id="'.$dados['id_publicacoes'].'" type="button"><a><i class="fas fa-heart" style="color: red;"></i>Curtido</a></button>';
                } else {
                    echo '<button class="like" id="'.$dados['id_publicacoes'].'" type="button"><a ><i class="fas fa-heart"></i>Curtir</a></button>';
                }
                echo '<button class="comm" type="button"><a ><i class="fas fa-comment"></i> Comentar</a></button>
            </div>';
        
            echo '<div class="comments">';
                    $query3 = "SELECT * FROM comentarios WHERE id_publicacao={$dados['id_publicacoes']}";
                    $result3 = mysqli_query($connection, $query3);
                    while ($a = mysqli_fetch_array($result3)) {
                        $date = $a['data_comentou'];
                        $date = strtotime($date);
                        $user2 = "SELECT nome FROM usuarios WHERE id_usuario={$a['id_comentou']}";
                        $res = mysqli_query($connection, $user2);
                        $photo = "SELECT caminho FROM fotos_usuario WHERE id_usuario={$a['id_comentou']} AND tipo_foto='perfil'";
                        $res2 = mysqli_query($connection, $photo);
                        $row4 = mysqli_fetch_assoc($res);
                        echo '<div class="comment">';
                                echo '<div class="user-comment">';
                                    if(mysqli_num_rows($res2) > 0){
                                        $row3 = mysqli_fetch_assoc($res2);
                                        echo '<img src="'.$row3['caminho'].'">';
                                    } else {
                                        echo '<a><i class="fas fa-user"></i></a><br>';
                                    }
                                    echo '<strong>'.$row4['nome'].'</strong>';
                                echo '</div>';
                                echo '<div class="txt">';
                                    echo '<p>'.$a['comentario'].'</p>
                                    <p class="bottom">'.date('d/m - H:i', $date).'</p>';
                                echo '</div>';
                        echo '</div>';
                    }
                    echo '<div id="new-comment'.$dados['id_publicacoes'].'"></div>';
                    echo '<form method="post" action="">
                    <label id="record-'.$dados['id_publicacoes'].'">
                    <input type="text" class="enviar-btn form-control input-sm" style="width: 455px;" placeholder="Escreva um comentario" name="comentario" id="comentario-'.$dados['id_publicacoes'].'">
                    <input type="hidden" name="usuario" value="'.$_SESSION['id_usuario'].'" id="usuario">
                    <input type="hidden" name="publicacion" value="'.$dados['id_publicacoes'].'" id="publicacion">
                    <input type="hidden" name="avatar" value="'.$_SESSION['caminhoImgPerfil'].'" id="avatar">
                    <input type="hidden" name="nombre" value="'.$_SESSION['nome'].'" id="nombre">
                    </form>';
            echo '</div>';
        echo '</li>';
    }
} else {
    echo 'Você precisa publicar para que suas publicações apareçam aqui...';
}
echo '</ul>';
?>