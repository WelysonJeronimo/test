<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre a Monography</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: 0;
            border: none;
        }
        body {
            font-family: 'OpenSans-Regular';
            -webkit-font-smoothing: antialiased !important;
            background-color: #e8f5f5;
        }
        header {
            width: 100%;
            height: 50px;
            background-color: #1BA39C;
        }
        header .bar-green {
            display: flex;
            justify-content: flex-start;
            padding: 10px;
        }
        header .bar-green a {
            font-size: 2rem;
            text-decoration: none;
            color: #FFF;
            margin-left: 100px;
        }
        section .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50%;
            height: 914px;
        }
        .container div {
            max-width: 700px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: absolute;
            text-align: center;
        }
        .container .top {
            top: 100px;
            margin-bottom: 70px;
        }
        .container .top img {
            box-shadow: 0px 0px 1px 1px #bcbdbe;
            border-radius: 10px;
            width: 100px;
            margin-bottom: 30px;
        }
        .container .top h1 {
            font-size: 4rem;
            margin: 0;
        }
        .container p {
            margin: 0;
            font-size: 2rem;
            color: rgba(0, 0, 0, 0.6);
        }
        .container .middle {
            top: 470px;
        }
        .container .middle h2{
            font-size: 3rem;
            margin: 0;
        }
        .container .bottom {
            top: 670px;
            margin-bottom: 90px;
        }
        .container .bottom h3 {
            font-size: 3rem;
            margin: 0;
        }
        footer {
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #bcbdbe;
        }
        .copy p {
            font-size: 1.8rem;
            margin: 0;
            color: #1BA39C;
        }
    </style>
</head>
<body>
    <header>
        <div class="bar-green">
            <a href="homepage.php" translate="no">Monography</a>
        </div>
    </header>
    <section>
        <div class="container">
            <div class="top">
                <img src="img/Logomarca.png" alt="Monography">
                <h1 translate="no">Monography</h1>
                <p>A Monography é uma rede social criada com a intenção de gerar um ambiente
                    para disseminação de informações sobre TCC com a intenção de deixar os 
                    estudantes mais familiarizados e prontos para enfrentar essa jornada.
                </p>
            </div>
            <div class="middle">
                <h2>Missão</h2>
                <p>Ser um suporte e servir de grande ajuda para alunos e professores.</p>
            </div>
            <div class="bottom">
                <h3>Sobre nós</h3>
                <p>A Monography foi criada como um projeto de TCC do curso de Licenciatura em 
                    Ciência da Computação da Universidade Federal da Paraíba no Campus IV
                    e teve como desenvolvedor o aluno Welyson Jerônimo Santos e como orientador
                    o professor Augusto César Pereira da Silva Montalvão.
                </p>
            </div>
        </div>
    </section>
    <footer>
        <div class="copy">
            <p translate="no">&copy; Monography 2021</p>
        </div>
    </footer>
</body>
</html>