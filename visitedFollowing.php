<?php
session_start();
include('validateLogin.php');
$id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguindo</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js\jquery-3.6.0.min.js" defer></script>
    <script src="https://kit.fontawesome.com/fa59a635cb.js" crossorigin="anonymous"></script>
    <style type="text/css">
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .followers {
            height: 100vh;
            width: 50%;
            background-color: #DFF9FB;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            flex-direction: column;
            overflow: auto;
            border-left: 1px solid #1BA39C;
            border-right: 1px solid #1BA39C;
            padding-top: 50px;
        }

        .card {
            width: 400px;
            height: 80px;
            background-color: #bae3e1;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 5px;
            border: 1px solid #1BA39C;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .img img {
            width: 60px;
        }

        .img i {
            color:#bcbdbe;
            font-size: 20px;
        }

        .dados {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            width: 65%;
            flex-direction: column;
            margin-left: 10px;
        }

        .dados strong {
            margin: 0;
            margin-top: 15px;
        }

        .dados .arroba {
            font-size: 1.2rem;
            color: #bcbdbe;
        }

        .card button {
            padding: 5px;
            color: white;
            background-color: #1BA39C;

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

                <div class="search">
                    <input type="search" placeholder="Pesquisar...">
                    <button type="button"><i class="fas fa-search"></i></button>
                </div><!-- Fim do código da barra de pesquisa -->

                <nav>
                    <span>
                        <button type="button"><a href="homepage.php"><i class="fas fa-home"></i></a></button>
                    </span>
                    <span>
                        <button type="button"><a href="#"><i class="fas fa-user-friends"></i></a></button>
                    </span>
                    <span>
                        <button type="button"><a href="chat.php"><i class="fas fa-envelope"></i></a></button>
                    </span>
                    <span>
                        <button type="button"><a href="#"><i class="fas fa-bell"></i></a></button>
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
            <div class="followers">
                <?php
                include('connectionDatabase.php');

                $query3 = "SELECT * FROM seguidores WHERE seguidor={$id}";
                $result3 = mysqli_query($connection, $query3);

                while ($a = mysqli_fetch_array($result3)) {
                    $query = "SELECT * FROM usuarios WHERE id_usuario={$a['seguido']}";
                    $query2 = "SELECT * FROM fotos_usuario WHERE id_usuario={$a['seguido']}";
                    $result = mysqli_query($connection, $query);
                    $result2 = mysqli_query($connection, $query2);
                    $caminho = null;
                    echo '<div class="card">
                        <a href="visitProfile.php?id='.$a['seguido'].'" style="display: flex;width: 100%;height:100%;justify-content: center;align-items: center;font-size: 15px;text-decoration: none;">
                            <div class="img">';
                            while ($c = mysqli_fetch_array($result2)) {
                                if ($a['seguido'] == $c['id_usuario'] && $c['tipo_foto'] == 'perfil') {
                                    $caminho = $c['caminho'];
                                }
                            }
                            if ($caminho != null) {
                                echo '<img src="' . $caminho . '">';
                            } else {
                                echo '<i class="fas fa-user"></i>';
                            }
                            echo '</div>';
                            while ($b = mysqli_fetch_array($result)) {
                                if ($a['seguido'] == $b['id_usuario']) {
                                    $nome = $b['nome'];
                                    $arroba = $b['arroba_usuario'];
                                    $tipo = $b['tipo_usuario'];
                                }
                            }
                            echo '<div class="dados">
                                <Strong>' . $nome . '</Strong>
                                <p class="arroba">' . $arroba . '</p>
                                <p>' . $tipo . '</p>
                            </div></a>';
                    echo '</div>';
                }

                ?>
            </div>
        </div>
    </section>
</body>

</html>