<?php
session_start();
include('validateLogin.php');
include('connectionDatabase.php');

$id = $_GET['id'];

$loggUserId = $_SESSION['id_usuario'];
$sql = "SELECT * FROM usuarios";
$result = mysqli_query($connection, $sql);

while ($userInfo = mysqli_fetch_array($result)) {
    if ($userInfo['id_usuario'] == $id) {
        $idVisitedUser = $userInfo['id_usuario'];
        $nome = $userInfo['nome'];
        $arroba = $userInfo['arroba_usuario'];
        $tipoUsuario = $userInfo['tipo_usuario'];
    }
}

$sql2 = "SELECT * FROM fotos_usuario WHERE id_usuario={$id} AND tipo_foto='mural' OR id_usuario={$id} AND tipo_foto='perfil'";
$result2 = mysqli_query($connection, $sql2);

$backgroundPicPath = null;
$profilePicPath = null;
if (mysqli_num_rows($result2) > 0) {
    while ($photosInfo = mysqli_fetch_array($result2)) {
        if ($photosInfo['tipo_foto'] == 'mural') {
            $backgroundPicPath = $photosInfo['caminho'];
        } else {
            $profilePicPath = $photosInfo['caminho'];
        }
    }
}

$sql3 = "SELECT * FROM info_usuarios WHERE id_usuario={$id}";
$result3 = mysqli_query($connection, $sql3);
if (mysqli_num_rows($result3) >= 1) {
    $infos = mysqli_fetch_assoc($result3);
    $descricao = $infos['descricao'];
    $logra = $infos['cidade'] . ', ' . $infos['estado'];
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-=edge">
    <meta name="veiwport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nome; ?> | Perfil</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js\jquery-3.6.0.min.js" defer></script>
    <script src="js/visitProfileScripts.js" defer></script>
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
                        <button type="button"><a href="homepage.php"><i class="fas fa-home"></i></a></button>
                    </span>
                    <span>
                        <button type="button"><a href="#"><i class="fas fa-user-friends"></i></a></button>
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
                            if ($countNoti > 0) {
                                echo '<span>' . $countNoti . '</span>';
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
                <div class="profile-content">

                    <div class="profile-background-picture" onclick="show('option-bg-img')">
                        <?php
                        if ($backgroundPicPath != null) :
                        ?>
                            <img src="<?php echo $backgroundPicPath; ?>">
                        <?php
                        else :
                        ?>
                            <i class="fas fa-image"></i>
                        <?php endif; ?>
                        <div id="option-bg-img">
                            <ul>
                                <li><a href="#" onclick="show('show-img-bg')">Visualizar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="profile-picture" onclick="show('option-profile-img')">
                        <?php
                        if ($profilePicPath != null) :
                        ?>
                            <img src="<?php echo $profilePicPath; ?>">
                        <?php
                        else :
                        ?>
                            <i class="fas fa-user"></i>
                        <?php endif; ?>

                        <div id="option-profile-img">
                            <ul>
                                <li><a href="#" onclick="show('show-img-profile')">Visualizar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-bio">
                        <div class="top-card">
                            <div class="info-user">
                                <h2 id="name-user"><?php echo $nome; ?></h2>
                                <p id="p1"><?php echo $arroba; ?></p>
                                <p id="p2"><i class="fas fa-map-marker-alt"></i> 
                                <?php 
                                    $sql = "SELECT cidade, estado FROM info_usuarios WHERE id_usuario={$id}";
                                    $res = mysqli_query($connection, $sql);
                                    if (mysqli_num_rows($res)>=1) {
                                        $row = mysqli_fetch_assoc($res);
                                        print_r($row['cidade'].', '.$row['estado']);
                                    } else {
                                        echo '-';
                                    }
                                ?>
                                </p>
                            </div>
                            <span>
                                <button type="button" id="profile-edit-button">
                                    <?php

                                    $sql = "SELECT * FROM seguidores WHERE seguidor='$loggUserId' AND seguido='$idVisitedUser'";
                                    $result = mysqli_query($connection, $sql);

                                    if (mysqli_num_rows($result) < 1) {
                                        echo '<a id="follow" command="follow" loggeduser="' . $_SESSION['id_usuario'] . '" visiteduser="' . $idVisitedUser . '">Seguir<i class="fas fa-user-plus"></i></a>';
                                    } else {
                                        echo '<a id="unfollow" command="unfollow" loggeduser="' . $_SESSION['id_usuario'] . '" visiteduser="' . $idVisitedUser . '">Seguindo<i class="fas fa-user-check"></i></a>';
                                    }

                                    ?>
                                </button>
                            </span>
                        </div>
                        <div class="bottom-card">
                            <p id="bio">
                            <?php 
                                $sql = "SELECT descricao FROM info_usuarios WHERE id_usuario={$id}";
                                $res = mysqli_query($connection, $sql);
                                if (mysqli_num_rows($res)>=1) {
                                    $row = mysqli_fetch_assoc($res);
                                    print_r($row['descricao']);
                                }
                            ?>
                            </p>
                            <div class="f-numbers">
                                <?php
                                $sql = "SELECT seguidor FROM seguidores WHERE seguidor='$id'";
                                $res = mysqli_query($connection, $sql);
                                $countSegui = mysqli_num_rows($res);
                                echo '<a href="visitedFollowing.php?id=' . $id . '" id="following">Seguindo ' . $countSegui . '</a>';
                                $sql2 = "SELECT seguido FROM seguidores WHERE seguido='$id'";
                                $res2 = mysqli_query($connection, $sql2);
                                $countSeguidores = mysqli_num_rows($res2);
                                echo '<a href="visitedFollowers.php?id=' . $id . '" id="followers">Seguidores ' . $countSeguidores . '</a>';
                                ?>


                            </div>
                        </div>

                    </div>

                    <div class="bar-contents">
                        <div class="btn-contents" id="posts" idVisitedUser="<?php echo $idVisitedUser; ?>"><a>Publicações</a></div>
                        <div class="btn-contents" id="media" idVisitedUser="<?php echo $idVisitedUser; ?>"><a>Mídias</a></div>
                        <div class="btn-contents" id="interaction" idVisitedUser="<?php echo $idVisitedUser; ?>"><a>Interações</a></div>
                        <div class="btn-contents" id="sobre" idVisitedUser="<?php echo $idVisitedUser; ?>"><a>Sobre</a></div>
                    </div>

                    <div class="container-initial-content" id="content-trade">


                    </div>

                </div>

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

                                    echo '<button id="profile-edit-button2" type="button"><a loggeduser="' . $_SESSION['id_usuario'] . '" command="follow" visiteduser="'.$dados['seguido'].'" id="follow"><i class="fas fa-user-plus"></i>Seguir</a></button>';
                                    echo '</li>'; //Perfil Sugestionado

                                }
                            }

                        ?>
                    </ul>
                    <div class="btn-more">
                        <a href="suggest.php">MAIS</a>
                    </div>
                </div><!-- Fim do conteúdo lateral direito -->
            </div>

            <div class="edit-group">
                <div class="blurry" id="edit-profile">
                    <button type="button" onclick="show('edit-profile')" id="btn-close"><i class="fas fa-times"></i></button>
                    <div class="edit">
                        <form id="form-edit" action="editProfile.php" method="POST">
                            <h2>Edite ou Adicione informações</h2>
                            <label for="name">Nome: </label>
                            <input type="name" id="name" name="name" placeholder="Digite seu nome e sobrenome..." autocomplete="off">
                            <div class="bday">
                                <label for="bday">Informe a data do seu aniversário:</label>
                                <input type="date" name="bday" id="date">
                            </div>
                            <label for="description">Descrição:</label>
                            <textarea name="description" id="description" rows="2" style="width: 100%;" placeholder="Digite sobre você ou algo que você goste..."></textarea>
                            <div class="address">
                                <label for="address">Escolha sua cidade e estado:</label>
                                <select class="form-control" id="Estado">
                                    <option>Selecionar Estado</option>
                                </select>
                                <select class="form-control" id="Cidade">
                                    <option>Selecionar Cidade</option>
                                </select>
                            </div>
                            <?php
                            if ($_SESSION['tipo_usuario'] == "Estudante") {
                                echo '<label>Curso:</label>';
                                echo '<input type="text" name="curso" id="curso" placeholder="Informe qual seu curso...">';
                                echo '<label for="institution">Instituição:</label>';
                                echo '<input type="text" name="institution" id="institution" placeholder="Em qual instituição você estuda?">';
                                echo '<label for="k-areas">Áreas de conhecimento:</label>';
                                echo '<input type="text" name="k-areas" id="k-areas" placeholder="Qual sua área de conhecimento?">';
                            } else {
                                echo '<label>Formação:</label>';
                                echo '<input type="text" name="formação" id="formação" placeholder="Qual é sua formação?">';
                                echo '<label for="institution">Instituição:</label>';
                                echo '<input type="text" name="institution" id="institution" placeholder="Em qual instituição você trabalha?">';
                                echo '<label for="k-areas">Áreas de orientações:</label>';
                                echo '<input type="text" name="k-areas" id="k-areas" placeholder="Qual sua área de Orientações?">';
                            }
                            ?>
                            <span>
                                <button class="btn btn-save" type="submit" name="submitEditProfile" id="save-form">Salvar</button>
                            </span>
                        </form>
                    </div>
                </div>

                <div class="image-viewer">
                    <div class="blurry" id="show-img-bg">
                        <div class="view-img-bg">
                            <button type="button" onclick="show('show-img-bg')" id="btn-close"><i class="fas fa-times"></i></button>
                            <?php
                            if ($backgroundPicPath != null) :
                            ?>
                                <div>
                                    <img src="<?php echo $backgroundPicPath; ?>">
                                </div>
                            <?php
                            else :
                            ?>
                                <i class="fas fa-image"></i>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="blurry" id="show-img-profile">
                        <div class="view-img-profile">
                            <button type="button" onclick="show('show-img-profile')" id="btn-close"><i class="fas fa-times"></i></button>
                            <?php
                            if ($profilePicPath != null) :
                            ?>
                                <div>
                                    <img src="<?php echo $profilePicPath; ?>">
                                </div>
                            <?php
                            else :
                            ?>
                                <i class="fas fa-user"></i>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="btn-write" onclick="show('post')">
                    <button type="button"><a href="#"><i class="fas fa-pencil-alt"></i></a></button>
                </div>
                <div class="blurry" id="post">
                    <button type="button" onclick="show('post')" id="btn-close"><i class="fas fa-times"></i></button>
                    <div class="form-post form-control">
                        <div class="user-post">
                            <img src="<?php echo $_SESSION['caminhoImgPerfil']; ?>">
                            <p><?php echo $_SESSION['nome']; ?></p>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <textarea name="textPost" id="text-post" cols="90" rows="6" placeholder="Tem algo em mente? Compartilhe com a comunidade!"></textarea>
                            <div class="btn-group-post">
                                <input type="file" id="post-img" name="post-img" accept="image/*">
                                <button type="button" id="file-img"><i class="fas fa-file-image"></i></button>
                                <input type="file" id="post-vid" name="post-img" accept="video/*">
                                <button type="button" id="file-vid"><i class="fas fa-file-video"></i></button>
                                <button type="submit" name="submitPost" id="btn-post" onclick="show('post')">Publicar</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

    </section>

</body>

</html>