<?php
session_start();
include('validateLogin.php');
include('connectionDatabase.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-=edge">
    <meta name="veiwport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['nome']; ?> | Perfil</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js\jquery-3.6.0.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js" defer></script>
    <script src="https://kit.fontawesome.com/fa59a635cb.js" crossorigin="anonymous"></script>
    <script src="js/profileScripts.js" defer></script>
    <script src="js/generalScripts.js" defer></script>
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
                        if (isset($_SESSION['caminhoImgMural']) != null) :
                        ?>
                            <img src="<?php echo $_SESSION['caminhoImgMural']; ?>">
                        <?php
                        else :
                        ?>
                            <i class="fas fa-image"></i>
                        <?php endif; ?>
                        <div id="option-bg-img">
                            <ul>
                                <li><a href="#" onclick="show('show-img-bg')">Visualizar</a></li>
                                <li><a href="#" onclick="show('edit-back-pic')">Selecionar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="profile-picture" onclick="show('option-profile-img')">
                        <?php
                        if (isset($_SESSION['caminhoImgPerfil']) != null) :
                        ?>
                            <img src="<?php echo $_SESSION['caminhoImgPerfil']; ?>">
                        <?php
                        else :
                        ?>
                            <i class="fas fa-user"></i>
                        <?php endif; ?>

                        <div id="option-profile-img">
                            <ul>
                                <li><a href="#" onclick="show('show-img-profile')">Visualizar</a></li>
                                <li><a href="#" onclick="show('edit-user-pic')">Selecionar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-bio">
                        <div class="top-card">
                            <div class="info-user">
                                <h2 id="name-user"><?php echo $_SESSION['nome']; ?></h2>
                                <p id="p1"><?php 
                                    $sql = "SELECT arroba_usuario FROM usuarios WHERE id_usuario={$_SESSION['id_usuario']}";
                                    $res = mysqli_query($connection,$sql);
                                    $row = mysqli_fetch_assoc($res);
                                    echo $row['arroba_usuario'];
                                ?></p>
                                <p id="p2"><i class="fas fa-map-marker-alt"></i>
                                <?php 
                                    $sql = "SELECT cidade, estado FROM info_usuarios WHERE id_usuario={$_SESSION['id_usuario']}";
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
                                <button type="button" id="profile-edit-button" onclick="show('edit-profile')">
                                    <a href="#">Editar Perfil<i class="fas fa-user-edit"></i></a>
                                </button>
                            </span>
                        </div>
                        <div class="bottom-card">
                            <p id="bio"><?php 
                                $sql = "SELECT descricao FROM info_usuarios WHERE id_usuario={$_SESSION['id_usuario']}";
                                $res = mysqli_query($connection, $sql);
                                if (mysqli_num_rows($res)>=1) {
                                    $row = mysqli_fetch_assoc($res);
                                    print_r($row['descricao']);
                                }
                            ?></p>
                            <div class="f-numbers">
                                <?php

                                $query = "SELECT * FROM  seguidores WHERE seguidor={$_SESSION['id_usuario']}";
                                $result = mysqli_query($connection, $query);
                                echo '<a href="following.php" id="following">Seguindo ' . mysqli_num_rows($result) . '</a>';

                                $query = "SELECT * FROM  seguidores WHERE seguido={$_SESSION['id_usuario']}";
                                $result = mysqli_query($connection, $query);
                                echo '<a href="followers.php" id="followers">Seguidores ' . mysqli_num_rows($result) . '</a>';
                                ?>
                            </div>
                        </div>

                    </div>

                    <div class="bar-contents">
                        <div class="btn-contents" id="posts"><a>Publicações</a></div>
                        <div class="btn-contents" id="media"><a>Mídias</a></div>
                        <div class="btn-contents" id="interaction"><a>Interações</a></div>
                        <div class="btn-contents" id="sobre"><a>Sobre</a></div>
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
                        <form id="form-edit" action="controllerInfoUser.php" method="POST">
                            <h2>Edite ou Adicione informações</h2>
                            <label for="name">Nome: </label>
                            <input type="name" id="name" name="name" placeholder="Digite seu nome e sobrenome..." autocomplete="off" value="<?php echo $_SESSION['nome'];?>">
                            <label for="arroba">Arroba:</label>
                            <input type="text" id="arroba" name="arroba" value="<?php 
                                    $sql = "SELECT arroba_usuario FROM usuarios WHERE id_usuario={$_SESSION['id_usuario']}";
                                    $res = mysqli_query($connection,$sql);
                                    $row = mysqli_fetch_assoc($res);
                                    echo $row['arroba_usuario'];
                                ?>">
                            <div class="bday">
                                <label for="bday">Informe a data do seu aniversário:</label>
                                <input type="date" name="bday" id="date">
                            </div>
                            <label for="description">Descrição:</label>
                            <textarea name="description" id="description" rows="2" style="width: 100%;" placeholder="Digite sobre você ou algo que você goste..."></textarea>
                            <div class="address">
                                <label for="address">Escolha sua cidade e estado:</label>
                                <select class="form-control" id="Estado" name="estado">
                                    <option >Selecionar Estado</option>
                                </select>
                                <select class="form-control" id="Cidade" name="cidade">
                                    <option >Selecionar Cidade</option>
                                </select>
                            </div>
                            <?php
                            $sql = "SELECT * FROM info_usuarios WHERE id_usuario={$_SESSION['id_usuario']}";
                            $res = mysqli_query($connection, $sql);
                            if (mysqli_num_rows($res)>=1) {
                                $row = mysqli_fetch_assoc($res);
                                if ($_SESSION['tipo_usuario'] == "Estudante") {
                                    echo '<label>Curso:</label>';
                                    echo '<input type="text" name="curso" id="curso" placeholder="Informe qual seu curso...">';
                                    echo '<label for="institution">Instituição:</label>';
                                    echo '<input type="text" name="institution" id="institution" placeholder="Em qual instituição você estuda?">';
                                    echo '<label for="k-areas">Áreas de conhecimento:</label>';
                                    echo '<textarea rows="2" style="width: 100%;" name="areas" id="areas" placeholder="Quais suas áreas de conhecimento?"></textarea>';
                                } else {
                                    echo '<label>Formação:</label>';
                                    echo '<input type="text" name="curso" id="formação" placeholder="Qual é sua formação?">';
                                    echo '<label for="institution">Instituição:</label>';
                                    echo '<input type="text" name="institution" id="institution" placeholder="Em qual instituição você trabalha?">';
                                    echo '<label for="k-areas">Áreas de orientações:</label>';
                                    echo '<textarea rows="2" style="width: 100%;" name="areas" id="areas" placeholder="Quais suas áreas de Orientações?"></textarea>';
                                    echo '<label for="va">Vagas para orientações:</label>';
                                    echo '<input type="number" name="vagas" id="vagas" max="10" min="0">';
                                }
                            } else {
                                if ($_SESSION['tipo_usuario'] == "Estudante") {
                                    echo '<label>Curso:</label>';
                                    echo '<input type="text" name="curso" id="curso" placeholder="Informe qual seu curso...">';
                                    echo '<label for="institution">Instituição:</label>';
                                    echo '<input type="text" name="institution" id="institution" placeholder="Em qual instituição você estuda?">';
                                    echo '<label for="k-areas">Áreas de conhecimento:</label>';
                                    echo '<textarea rows="2" style="width: 100%;" name="areas" id="areas" placeholder="Quais suas áreas de conhecimento?"></textarea>';
                                } else {
                                    echo '<label>Formação:</label>';
                                    echo '<input type="text" name="formação" id="formação" placeholder="Qual é sua formação?">';
                                    echo '<label for="institution">Instituição:</label>';
                                    echo '<input type="text" name="institution" id="institution" placeholder="Em qual instituição você trabalha?">';
                                    echo '<label for="k-areas">Áreas de orientações:</label>';
                                    echo '<textarea rows="2" style="width: 100%;" name="areas" id="areas" placeholder="Quais suas áreas de Orientações?"></textarea>';
                                    echo '<label for="va">Vagas para orientações:</label>';
                                    echo '<input type="number" name="vagas" id="vagas" max="10" min="0">';
                                }
                            }
                            
                            ?>
                            <span>
                                <button class="btn btn-save" type="submit" name="submitEditProfile" id="save-form">Salvar</button>
                            </span>
                        </form>
                    </div>
                </div>

                <div class="blurry" id="edit-back-pic">
                    <button type="button" onclick="show('edit-back-pic')" id="btn-close"><i class="fas fa-times"></i></button>
                    <div class="image-edit2">
                        <div class="card-body2">
                            <div class="row2">
                                <div class="text-center">
                                    <div id="upload-demo2"></div>
                                </div>
                                <div class="bottom-img-edit2">
                                    <input type="file" id="image2">
                                    <button class="btn btn-success btn-block btn-upload-image2">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blurry" id="edit-user-pic">
                    <button type="button" onclick="show('edit-user-pic')" id="btn-close"><i class="fas fa-times"></i></button>
                    <div class="image-edit">
                        <div class="card-body">
                            <div class="row">
                                <div class="text-center">
                                    <div id="upload-demo"></div>
                                </div>
                                <div class="bottom-img-edit">
                                    <input type="file" id="image">
                                    <button class="btn btn-success btn-block btn-upload-image">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="image-viewer">
                    <div class="blurry" id="show-img-bg">
                        <div class="view-img-bg">
                            <button type="button" onclick="show('show-img-bg')" id="btn-close"><i class="fas fa-times"></i></button>
                            <?php
                            if (isset($_SESSION['caminhoImgMural']) != null) :
                            ?>
                                <div>
                                    <img src="<?php echo $_SESSION['caminhoImgMural']; ?>">
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
                            if (isset($_SESSION['caminhoImgPerfil']) != null) :
                            ?>
                                <div>
                                    <img src="<?php echo $_SESSION['caminhoImgPerfil']; ?>">
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