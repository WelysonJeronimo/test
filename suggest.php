<?php
session_start();
include('validateLogin.php');
include('connectionDatabase.php');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugestões de perfis</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link defer rel="stylesheet" href="css/style.css">
    <script src="js\jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/fa59a635cb.js" crossorigin="anonymous"></script>
    <script src="js/generalScripts.js" defer></script>
    <style type="text/css">
        .container-profiles {
            background: #DFF9FB;
            width: 100%;
            height: 75vh;
            padding: 20px;
            border: 1px solid #1BA39C;
            border-radius: 10px;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            overflow: auto;
            justify-content: space-between;
        }

        .container h2 {
            text-align: center;
            margin-top: 10vh;
        }

        .container-profiles .card {
            width: 200px;
            height: 250px;
            background: #e8f5f5;
            border: 1px solid #1BA39C;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .container-profiles .top {
            width: 100%;
            height: 80px;
            background-color: #bae3e1;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #1BA39C;
            border-radius: 10px;
        }

        .container-profiles .top img {
            width: 75px;
            border-radius: 50%;
            border: 5px solid #1BA39C;
            margin-top: 50px;
        }

        .container-profiles .bottom {
            width: 100%;
            height: 67%;
            display: flex;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .container-profiles .bottom p {
            margin: 0;
            word-wrap: break-word;
        }

        .container-profiles .bottom button {
            height: 30px;
            margin-top: 20px;
            background-color: #1BA39C;
            color: white;
            padding: 5px;
        }

        .container-profiles .bottom button:hover {
            transition: 0.5s;
            background-color: #2f4f4f;

        }

        .container-profiles .top img:hover {
            transition: 0.5s;
            width: 85px;
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
            <h2>Segestões de perfis</h2>
            <div class="container-profiles">
                <?php

                $sql = "SELECT seguido,
                        COUNT(seguido) AS quantidade
                        FROM seguidores
                        GROUP BY seguido
                        ORDER BY quantidade DESC";
                $result = mysqli_query($connection, $sql);

                while ($a = mysqli_fetch_array($result)) {
                    $query = "SELECT * FROM seguidores WHERE seguidor={$_SESSION['id_usuario']} AND seguido={$a['seguido']}";
                    $res = mysqli_query($connection, $query);
                    if (mysqli_num_rows($res) < 1 && $a['seguido'] != $_SESSION['id_usuario']) {
                        echo '<div class="card">';
                            echo '<div class="top">';
                            $sql2 = "SELECT caminho FROM fotos_usuario WHERE id_usuario={$a['seguido']} AND tipo_foto='perfil'";
                            $res2 = mysqli_query($connection, $sql2);
                            $row = mysqli_fetch_assoc($res2);
                            if (mysqli_num_rows($res2) >= 1) {
                                echo '<img src="' . $row['caminho'] . '">';
                            } else {
                                echo '<div class="user-pic" style="display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            width: 75px;
                                            height: 75px;
                                            background-color: white;
                                            border-radius: 50%;
                                            margin-top: 50px;
                                            border: 5px solid #1BA39C;"><i class="fas fa-user"></i></div>';
                            }
                            echo '</div>';
                            $sql3 = "SELECT * FROM usuarios WHERE id_usuario={$a['seguido']}";
                            $res3 = mysqli_query($connection, $sql3);
                            $row2 = mysqli_fetch_assoc($res3);
                            echo '<div class="bottom">';
                            echo '<strong>' . $row2['nome'] . '</strong>';
                            echo '<p>' . $row2['tipo_usuario'] . '</p>';
                            $sql4 = "SELECT * FROM info_usuarios WHERE id_usuario={$a['seguido']}";
                            $res4 = mysqli_query($connection, $sql4);
                            $row3 = mysqli_fetch_assoc($res4);
                            if (mysqli_num_rows($res4) >= 1) {
                                echo '<p>' . $row3['instituição'] . '</p>';
                            }
                            echo '<button><a href="visitProfile.php?id=' . $a['seguido'] . '" style="font-size: 15px;
                                        color: white;
                                        display: block;
                                        width: 100%;
                                        height: 100%;
                                        text-decoration: none;">Visitar Perfil</a></button>';
                            echo '</div>
                        </div>';
                    }
                }

                ?>
            </div>
        </div>
    </section>
</body>

</html>