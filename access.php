<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-=edge">
        <meta name="veiwport" content="width=device-width, initial-scale=1.0">
		<title>Monography | Entre ou Cadastre-se</title>
        <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style-access.css">
	</head>

	<body>
        <header>
            <div class="header-green">

                <div class="text-header">
                    <h1 translate="no">Monography</h1>
                </div>

            </div>
        </header>

        <section>

            <div class="container">

                <div class="content content-left">
                    <figure>
                        <img id="logo" src="img/Logomarca.png" alt="Logotipo">
                    </figure>

                    <div id="text">
                        <h2>Boas Vindas</h2>
                        <p class="description">A Monography é uma rede social criada com a intenção de gerar um ambiente
                            para disseminação de informações sobre TCC com a intenção de deixar os 
                            estudantes mais familiarizados e prontos para enfrentar essa jornada.
                        </p>
                    </div>
                </div>

                <div class="content content-right">

                    <div class="login-content">
                        <h4>Entrar</h4>
                        <form action="login.php" method="POST">
                            <label for="email">E-mail:</label>
                            <input type="email" name="email" placeholder="Digite seu email" autocomplete="off" required>
                            <?php
                            if(isset($_SESSION['unauthenticated'])):
                            ?>
                            <div class="notification is-danger">
                                <p>Usuário ou senha incorreta!</p>
                            </div>
                            <?php endif;
                            unset($_SESSION['unauthenticated']);
                            ?>
                            <label for="password">Senha:</label>
                            <input type="password" name="password" placeholder="Digite sua senha" required>
                            <a href="#" id="forgot-pass">Esqueceu a senha?</a>
                            <input type="submit" name="submitLogin" id="submitLogin" value="entrar">
                        </form>
                        </div>

                    <div class="register-content">
                        <h4>Registre-se</h4>
                        <form action="register.php" method="POST">
                            <label for="name">Nome:</label>
                            <input type="name" name="name" placeholder="Digite seu nome completo" autocomplete="off" minlength="15" required>
                            <label for="email">E-mail:</label>
                            <input type="email" name="email" placeholder="Digite seu email" autocomplete="off" required>
                            <label for="password">Senha:</label>
                            <input type="password" name="password" placeholder="Crie sua senha" minlength="8" required>
                            <div class="radio">
                                <input type="radio" name="typeAccount" id="student" value="Estudante" checked> 
                                <label for="student">Estudante</label>
                                <input type="radio" name="typeAccount" id="teacher" value="Professor(a)">
                                <label for="teacher">Professor(a)</label>
                            </div>
                            <input type="submit" name="submitRegister" id="submitRegister" value="Registrar">
                        </form>
                    </div>

                </div>
            </div>

        </section>
    </body>
</html>