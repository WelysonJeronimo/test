<?php
session_start();
include('validateLogin.php');
include('connectionDatabase.php');
$id = $_SESSION['id_usuario'];
$query = "SELECT * FROM info_usuarios WHERE id_usuario='$id'";
$result = mysqli_query($connection, $query);
$curso_formacao = '';
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
    $curso_formacao = $row['curso_formacao'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-=edge">
    <meta name="veiwport" content="width=device-width, initial-scale=1.0">
    <title>Monography | Página Inicial</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link defer rel="stylesheet" href="css/style.css">
    <script src="js\jquery-3.6.0.min.js"></script>
    <script src="js/homeScripts.js" defer></script>
    <script src="js/generalScripts.js" defer></script>
    <script src="https://kit.fontawesome.com/fa59a635cb.js" crossorigin="anonymous"></script>
</head>

<body>

    <header>

        <div class="container">
            <div class="green-bar">

                <figure>
                    <a href="homepage.php"><img id="logo" src="img/Logomarca.png" alt="logotipo"></a>
                </figure><!-- Fim do código do logo -->

                <div class="search" id="div-pesquisa">
                    <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar...">
                    <button type="button"><i class="fas fa-search"></i></button>
                    <div class="users"></div>
                </div><!-- Fim do código da barra de pesquisa -->

                <nav>
                    <span>
                        <button type="button"><a href="followNotify.php"><i class="fas fa-user-friends"></i></a></button>
                    </span>
                    <span>
                        <button type="button"><a href="ideas.php"><i class="fas fa-scroll"></i></a></button>
                    </span>
                    <span>
                        <button type="button"><a href="chat.php"><i class="fas fa-envelope"></i></a></button>
                    </span>
                    <span>
                        <button type="button"><a href="notifications.php"><i class="fas fa-bell"></i></a>
                            <?php 
                                $noti = "SELECT * FROM notificacoes WHERE usuario2={$_SESSION['id_usuario']} and lido='0'";
                                $res = mysqli_query($connection, $noti);
                                $countNoti = mysqli_num_rows($res);
                                if ($countNoti>0) {
                                    echo '<span>'.$countNoti.'</span>';
                                }
                            ?>
                        </button>
                        
                    </span>
                    <span>
                        <button type="button" id="caret-down" onclick="show('acc-options')">
                            <i class="fas fa-caret-down"></i>
                        </button>
                        <div id="acc-options">
                            <ul>
                                <li><a href="logout.php">sair</a></li>
                            </ul>
                        </div>
                    </span>
                </nav><!-- Fim do menu do cabeçalho -->

            </div><!-- Fim do código do cabeçalho verde -->
        </div><!-- Fim do container do header -->

    </header>

    <section>

        <div class="container">

            <div class="content">
                <div class="content-left">

                    <div class="profile-user">
                        <div class="img-user">
                            <?php
                            if (isset($_SESSION['caminhoImgPerfil']) != null) :
                            ?>
                                <img style="width: 90px;" src="<?php echo $_SESSION['caminhoImgPerfil']; ?>">
                            <?php
                            else :
                            ?>
                                <i style="font-size: 25px;color: grey;" class="fas fa-user"></i>
                            <?php endif; ?>
                        </div>
                        <Strong><?php echo $_SESSION['nome']; ?></Strong>
                        <p><?php  echo $curso_formacao;?></p>
                    </div><!-- Fim da div de informações e foto do usuário-->

                    <div class="menu">
                        <div class="menu-options">
                            <button type="button"><a href="profile.php?id=<?php echo $_SESSION['id_usuario'] ?>">Perfil</a></button>
                            <button type="button"><a href="suggest.php">Sugestões</a></button>
                            <button type="button"><a href="about.php">Sobre</a></button>
                        </div>
                    </div><!-- Fim da div do menu lateral esquerdo -->

                </div><!-- Fim do conteúdo lateral esquerdo -->

                <div class="content-right">
                    <p>SUGESTÕES RÁPIDAS</p>
                    <ul class="suggested-profiles">
                    <?php
                        $sql = "SELECT seguido,
                        COUNT(seguido) AS quantidade
                        FROM seguidores
                        GROUP BY seguido
                        ORDER BY quantidade DESC LIMIT 3";
                        $result = mysqli_query($connection, $sql);

                        while ($dados = mysqli_fetch_array($result)) {
                            $query = "SELECT * FROM seguidores WHERE seguidor={$_SESSION['id_usuario']} AND seguido={$dados['seguido']}";
                            $res = mysqli_query($connection, $query);
                            if (mysqli_num_rows($res) < 1 && $dados['seguido'] != $_SESSION['id_usuario']) {
                                $query2 = "SELECT nome, id_usuario, arroba_usuario FROM usuarios WHERE id_usuario={$dados['seguido']}";
                                $result2 = mysqli_query($connection, $query2);
                                $row = mysqli_fetch_assoc($result2);
                                $query3 = "SELECT * FROM fotos_usuario WHERE id_usuario={$dados['seguido']} AND tipo_foto='perfil'";
                                $result3 = mysqli_query($connection, $query3);
                                $row2 = mysqli_fetch_assoc($result3);
                                $caminho = '';
                                if (mysqli_num_rows($result3) >= 1) {
                                    $caminho = $row2['caminho'];
                                }
                                echo '<li class="profile">';
                                echo '<div class="img-user"><a href="visitProfile.php?id=' . $dados['seguido'] . '"><img src="' . $caminho . '"></a></div>';
                                echo '<a href="visitProfile.php?id=' . $dados['seguido'] . '">';
                                echo '<strong>' . $row['nome'] . '</strong>';
                                echo '<p>' . $row['arroba_usuario'] . '</p>';
                                echo '</a>';

                                echo '<button id="profile-edit-button" type="button"><a loggeduser="' . $_SESSION['id_usuario'] . '" command="follow" visiteduser="'.$dados['seguido'].'" id="follow"><i class="fas fa-user-plus"></i>Seguir</a></button>';
                                echo '</li>'; //Perfil Sugerido

                            }
                        }

                    ?>
                    </ul><!-- Fim da lista de sugestões -->
                    <div class="btn-more">
                        <a href="suggest.php">MAIS</a>
                    </div>
                </div>

                <ul class="posts">

                    <div class="feed">
                        <div class="line"></div>
                        <p>Feed de notícias</p>
                    </div>

                    <?php
                        $loggedUser = $_SESSION['id_usuario'];

                        $query = "SELECT seguido FROM seguidores WHERE seguidor='$loggedUser'";
                        $result = mysqli_query($connection, $query);
                        $dados2 = mysqli_fetch_assoc($result);

                        $query2 = "SELECT * FROM publicacoes ORDER BY data_publi DESC";
                        $result2 = mysqli_query($connection, $query2);

                        while ($dados = mysqli_fetch_array($result2)) {
                            $date = $dados['data_publi'];
                            $date = strtotime($date);
                            if (in_array($dados['id_usuario'], $dados2)) {
                                echo '<li class="post" idPost="">';
                                    echo '<div class="author-post">';
                                        $sql = "SELECT * FROM fotos_usuario WHERE id_usuario='$dados[id_usuario]' AND tipo_foto='perfil'";
                                        $res = mysqli_query($connection, $sql);
                                        if (mysqli_num_rows($res) >= 1) {
                                            $photo = mysqli_fetch_assoc($res);
                                            echo '<div class="img-user"><a href="visitProfile.php?id='.$dados['id_usuario'].'"><img src="'.$photo['caminho'].'"></a></div>';
                                        } else {
                                            echo '<div class="img-user"><a href="visitProfile.php?id='.$dados['id_usuario'].'"><img src=""></a></div>';
                                        }
                                        echo '<div class="info-user">';
                                            echo '<strong>'.$dados['nome_usuario'].'</strong>';
                                            echo '<p>'.$dados['tipo_usuario'].'</p>';
                                            echo '<p>'.date('d/m H:i', $date).'</p>';
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="btn-option"><button type="button"><i class="fas fa-angle-down"></i></button></div>';
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
                                    $sql = "SELECT * FROM curtidas WHERE id_curtido={$dados['id_publicacoes']} AND id_curtiu='$loggedUser'";
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
                                            <input type="text" class="enviar-btn form-control input-sm" style="width: 455px;" placeholder="Escreva um comentario" name="comentario" id="comentario-'.$dados['id_publicacoes'].'">
                                            <input type="hidden" name="usuario" value="'.$_SESSION['id_usuario'].'" id="usuario">
                                            <input type="hidden" name="publicacion" value="'.$dados['id_publicacoes'].'" id="publicacion">
                                            <input type="hidden" name="avatar" value="'.$_SESSION['caminhoImgPerfil'].'" id="avatar">
                                            <input type="hidden" name="nombre" value="'.$_SESSION['nome'].'" id="nombre">
                                            </form>';
                                    echo '</div>';
                                echo '</li>';
                            }
                        }

                    ?>

                </ul><!-- Fim do código do conteúdo de posts -->

            </div>
            <!--Fim da div de conteudo da página-->

            <div class="btn-write">
                <button type="button" onclick="show('post')"><a href="#"><i class="fas fa-pencil-alt"></i></a></button>
            </div>

            <div class="blurry" id="post">
                <button type="button" onclick="show('post')" id="btn-close"><i class="fas fa-times"></i></button>
                <div class="form-post form-control">
                    <div class="user-post">
                        <img src="<?php echo $_SESSION['caminhoImgPerfil']; ?>">
                        <p><?php echo $_SESSION['nome']; ?></p>
                    </div>
                    <form action="controllerSendPost.php" method="POST" enctype="multipart/form-data">
                        <textarea name="textPost" id="text-post" cols="90" rows="6" placeholder="Tem algo em mente? Compartilhe com a comunidade!"></textarea>
                        <div class="btn-group-post">
                            <input type="file" id="post-img" name="post-img[]" accept="image/*" multiple>
                            <button type="button" id="file-img"><i class="fas fa-file-image"></i></button>
                            <input type="file" id="post-vid" name="post-vid[]" accept="video/*" multiple>
                            <button type="button" id="file-vid"><i class="fas fa-file-video"></i></button>
                            <div class="preview">
                                <!-----As miniaturas dos arquivos escolhidos no post aparecem aqui----->
                            </div>
                            <button type="submit" name="submitPost" id="btn-post" onclick="show('post')">Publicar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </section>
</body>

</html>