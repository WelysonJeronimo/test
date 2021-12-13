<?php
session_start();
include('validateLogin.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js\jquery-3.6.0.min.js" defer></script>
    <script src="js\chatScripts.js" defer></script>
    <script src="https://kit.fontawesome.com/fa59a635cb.js" crossorigin="anonymous"></script>
    <style type="text/css">
        #div-pesquisa {
            width: 100%;
            height: 30px;
        }

        #div-pesquisa input {
            width: 100%;
            height: 100%;
            padding: 5px;
        }

        .user {
            width: 100%;
            height: auto;
        }

        .search {
            width: 100%;
            margin-bottom: 15px;
        }

        .users {
            width: 100%;
        }
    </style>
</head>

<body>
    <section>
        <div class="container">
            <div class="content-chat">
                <a href="homepage.php"><img src="img/Logomarca.png" alt="Monography"></a>
                <div class="chat">
                    <div class="left">
                        <div class="top">
                            <?php
                            if (isset($_SESSION['caminhoImgPerfil']) != null) :
                            ?>
                                <img src="<?php echo $_SESSION['caminhoImgPerfil']; ?>">
                            <?php
                            else :
                            ?>
                                <a><i class="fas fa-user"></i></a>
                            <?php endif; ?>
                            <strong><?php echo $_SESSION['nome']; ?></strong>
                        </div>
                        <div class="bottom">
                            <div class="search">
                                <div method="POST" id="div-pesquisa" action="">
                                    <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquise por usuários e inicie uma conversa!">
                                </div>
                            </div>

                            <div class="users">
                                
                            </div>

                        </div>
                    </div>
                    <div class="right">
                        <div class="top"></div>
                        <div class="mid">
                            <div id="message"></div>
                        </div>
                        <div class="footer">
                            <div class="input-msg">
                                <div class="send-chat">
                                    <textarea name="in-msg" id="in-msg" placeholder="inicie uma conversa..."></textarea>
                                    <button type="submit" name="submitChat" id="submitChat"><i class="fas fa-chevron-circle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</body>

</html>