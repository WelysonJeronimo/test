<?php

session_start();
include('../validateLogin.php');
include('../connectionDatabase.php');

$user = $_SESSION['id_usuario'];
$photo = $_SESSION['caminhoImgPerfil'];

$query = "SELECT * FROM publicacoes WHERE id_usuario={$user}";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) >= 1) {
    echo '<ul class="posts">';
        while ($dados = mysqli_fetch_array($result)) {
            $query2 = "SELECT * FROM midias WHERE id_publicacao = {$dados['id_publicacoes']}";
            $result2 = mysqli_query($connection, $query2);
            if (mysqli_num_rows($result2) >= 1) {
                $date = $dados['data_publi'];
                $date = strtotime($date);
                echo '<li class="post" idPost="">';
                    echo '<div class="author-post">';
                        $sql = "SELECT * FROM fotos_usuario WHERE id_usuario='$dados[id_usuario]' AND tipo_foto='perfil'";
                        $res = mysqli_query($connection, $sql);
                        $row10 = mysqli_fetch_assoc($res);
                        if (mysqli_num_rows($res) >= 1) {
                            $photo = $row10['caminho'];
                            echo '<div class="img-user"><img src="'.$photo.'"></div>';
                        } else {
                            echo '<div class="img-user"><img src=""></div>';
                        }
                        echo '<div class="info-user">';
                            echo '<strong>'.$dados['nome_usuario'].'</strong>';
                            echo '<p>'.$dados['tipo_usuario'].'</p>';
                            echo '<p>'.date('d/m H:i', $date).'</p>';
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="btn-option"><button type="button"><i class="fas fa-angle-down"></i></button></div>';
                    echo '<p>'.$dados['txt'].'</p>';
                    echo '<div class="midias">';
                        while ($b = mysqli_fetch_array($result2)) {
                            if ($b['id_publicacao'] == $dados['id_publicacoes'] && $b['tipo_arquivo'] == 'video') {
                                echo '<video src="'.$b['caminho'].'" style="width:100%;" controls/>';
                            } else {
                                echo '<img src="'.$b['caminho'].'" style="width:100%;" />';
                            }
                        }
                    echo '</div>';
                    $sql = "SELECT * FROM curtidas WHERE id_curtido={$dados['id_publicacoes']} AND id_curtiu='$user'";
                    $like = mysqli_query($connection, $sql);
                    $row = mysqli_query($connection, "SELECT * FROM comentarios WHERE id_publicacao = '".$dados['id_publicacoes']."'");
                    $numComment = mysqli_num_rows($row);
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
                                $user = "SELECT nome FROM usuarios WHERE id_usuario={$a['id_comentou']}";
                                $res = mysqli_query($connection, $user);
                                $photo = "SELECT caminho FROM fotos_usuario WHERE id_usuario={$a['id_comentou']} AND tipo_foto='perfil'";
                                $res2 = mysqli_query($connection, $photo);
                                $row = mysqli_fetch_assoc($res);
                                echo '<div class="comment">';
                                        echo '<div class="user-comment">';
                                            if(mysqli_num_rows($res2) > 0){
                                                $row2 = mysqli_fetch_assoc($res2);
                                                echo '<img src="'.$row2['caminho'].'">';
                                            } else {
                                                echo '<a><i class="fas fa-user"></i></a><br>';
                                            }
                                            echo '<strong>'.$row['nome'].'</strong>';
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
                            <input type="text" class="enviar-btn form-control input-sm" style="width: 455px;" placeholder="Escribe un comentario" name="comentario" id="comentario-'.$dados['id_publicacoes'].'">
                            <input type="hidden" name="usuario" value="'.$_SESSION['id_usuario'].'" id="usuario">
                            <input type="hidden" name="publicacion" value="'.$dados['id_publicacoes'].'" id="publicacion">
                            <input type="hidden" name="avatar" value="'.$_SESSION['caminhoImgPerfil'].'" id="avatar">
                            <input type="hidden" name="nombre" value="'.$_SESSION['nome'].'" id="nombre">
                            </form>';
                    echo '</div>';
                echo '</li>';
            }
        }
    echo '</ul>';
} else {
    echo 'Publique alguma midia para que apareça algum conteúdo aqui!!';
}
