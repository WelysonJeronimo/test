<?php
session_start();
include('validateLogin.php');
include('connectionDatabase.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divulgação de ideias</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link defer rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.6.0.min.js" defer></script>
    <script src="js/ideasScript.js" defer></script>
    <script src="https://kit.fontawesome.com/fa59a635cb.js" crossorigin="anonymous"></script>
    <style type="text/css">
        .content {
            display: grid !important;
            justify-content: space-evenly !important;
        }

        #top {
            width: 500px;
            height: 140px;
            background-color: #DFF9FB;
            border: 1px solid #1BA39C;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
        }

        #top strong {
            font-size: 3rem;
        }

        #bottom {
            width: 500px;
            height: auto;
            max-height: 50vh;
            overflow: auto;
            margin-top: 5px;
            background-color: #DFF9FB;
            border: 1px solid #1BA39C;
            padding: 15px;
        }

        .idea {
            height: auto;
            max-height: 240px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            background-color: #bae3e1;
            padding: 10px;
            margin-bottom: 10px;
        }

        .icon {
            width: 100px;
            height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .icon i {
            font-size: 35px;
            display: block;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content-infos {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            margin-right: 10px;
        }

        .form {
            width: 500px;
            height: 240px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            background-color: #DFF9FB;
        }

        #form-idea .content-infos {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        #form-idea .content-infos input {
            border: 1px solid #1BA39C;
            resize: none;
            width: 340px;
            height: 30px;
            padding: 5px;
        }

        #form-idea .content-infos button {
            width: 100px;
            height: 40px;
            margin-top: 20px;
            margin-left: 125px;
        }

        #btn-post-idea {
            background-color: #1BA39C;
            color: #FFF;
        }

        #form-idea .icon {
            margin-right: 10px;
        }

        #form-idea .idea {
            background: none;
        }

        #name {
            font-size: 2rem;
        }

        .strong {
            font-size: 1.5rem;
            width: 100%;
            max-width: 305px;
        }

        #form-pesquisa {
            width: 100%;
        }

        #form-pesquisa input {
            width: 100%;
            height: 30px;
            padding: 5px;
        }

        #loadComments {
            width: 100px;
            height: 40px;
            position: absolute;
            bottom: 30px;
            margin-left: 200px;
            background-color: #1BA39C;
            color: white;
        }

        #spinner {
            display: none;
            text-align: center;
            margin-top: 25px;
        }

        #ideias button {
            background: none;
        }

        #interesse {
            font-size: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            background-color: #1BA39C;
            border-radius: 50%;
        }
    </style>
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
                    <p>Curso/Formação</p>
                </div><!-- Fim da div de informações e foto do usuário-->

                <div class="menu">
                    <div class="menu-options">
                        <button type="button"><a href="profile.php?id=<?php echo $_SESSION['id_usuario'] ?>">Perfil</a></button>
                        <button type="button"><a href="suggest.php">Sugestões</a></button>
                        <button type="button"><a href="about.php">Sobre</a></button>
                    </div>
                </div><!-- Fim da div do menu lateral esquerdo -->

            </div><!-- Fim do conteúdo lateral esquerdo -->
            <div class="content-ideas">
                <div id="top">
                    <strong>Encontre Ideias</strong>
                    <form method="POST" id="form-pesquisa" action="">
                        <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquise por titulo, idealizador ou area da ideia">
                    </form>
                </div>
                <div id="bottom">
                    <div class="ideias" id="ideias">
                        
                    </div>
                    <div class="spinner" id="spinner">
                        <img src="img/spinner.gif" />
                    </div>
                    <div class="btn">
                        <button id="loadComments">Carregar Mais</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-write">
            <button type="button" onclick="show('post')"><a href="#"><i class="fas fa-scroll"></i></a></button>
        </div>

        <div class="blurry" id="post">
            <button type="button" onclick="show('post')" id="btn-close"><i class="fas fa-times"></i></button>
            <div class="form">
                <form id="form-idea" action="controllerSaveIdea.php" method="POST">
                    <div class="ideias">
                        <div class="idea">
                            <div class="icon"><i class="fas fa-bullhorn"></i></div>
                            <div class="content-infos">
                                <label for="title">Titulo:</label>
                                <input maxlength="100" type="text" name="title" id="title" placeholder="Digite o titulo de sua ideia!">
                                <label for="title">Área:</label>
                                <input maxlength="60" type="text" name="area" id="area" placeholder="Digite a área de sua ideia!">
                                <button type="submit" name="submitIdea" id="btn-post-idea" onclick="show('post')">Publicar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>