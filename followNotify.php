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
    <title>Notificações</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link defer rel="stylesheet" href="css/style.css">
    <script src="js\jquery-3.6.0.min.js"></script>
    <script src="js/generalScripts.js" defer></script>
    <script src="https://kit.fontawesome.com/fa59a635cb.js" crossorigin="anonymous"></script>
    <style type="text/css">
        .content {
            width: auto;
            display: flex;
            flex-direction: column;
            margin-top: 10vh;
            justify-content: center;
            align-items: center;
        }

        .container-not {
            width: 550px;
            height: auto;
            margin-top: 20px;
        }

        .list-not {
            list-style: none;
            margin: 0;
        }

        .container-left {
            font-size: 2.5rem;
        }

        .notification {
            width: 100%;
            height: 120px;
            background-color: #DFF9FB;
            border: 1px solid #1BA39C;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-bottom: 5px;
        }

        .notification a {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: black;
            text-decoration: none;
            font-size: 2rem;
        }

        .notification a>p {
            color: #bcbdbe;
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
                        <button type="button"><a href="#follosNotifications.php"><i class="fas fa-user-friends"></i></a></button>
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
                <div class="container-left">
                    <Strong>Novos Seguidores</Strong>
                </div>
                <div class="container-not">
                    <ul class="list-not">
                        <?php
                        $id = $_SESSION['id_usuario'];

                        $query = "SELECT * FROM notificacoes WHERE usuario2 = {$id} ORDER BY data_noti DESC";
                        $result = mysqli_query($connection, $query);

                        while ($noti = mysqli_fetch_array($result)) {
                            $user = "SELECT nome FROM usuarios WHERE id_usuario={$noti['usuario1']}";
                            $res = mysqli_query($connection, $user);
                            $row = mysqli_fetch_assoc($res);
                            $date = $noti['data_noti'];
                            $date = strtotime($date);
                            if ($noti['tipo_noti'] == 'seguiu') {
                                if ($noti['lido'] == 0) {
                                    echo '<li class="notification" style="background-color:#bae3e1 !important;">
                                            <strong>' . $row['nome'] . ' ' . $noti['tipo_noti'] . ' você</strong>
                                            <p>' . date('d-m-Y H:i', $date) . '</p>
                                    </li>';
                                } else {
                                    echo '<li class="notification">
                                            <strong>' . $row['nome'] . ' ' . $noti['tipo_noti'] . ' você</strong>
                                            <p>' . date('d-m-Y H:i', $date) . '</p>
                                    </li>';
                                }
                            }
                        }


                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</body>

</html>