<?php
header('Refresh: 2; URL=homepage.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregando...</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'OpenSans-Regular';
            -webkit-font-smoothing: antialiased !important;
            background-color: #e8f5f5;
        }
        img {
            width: 125px;
            box-shadow: 0px 0px 1px 1px #bcbdbe;
            border-radius: 10px;
        }
        .loader {
            width: 100px;
            height: 100px;
            border: 6px solid #bcbdbe;
            border-top-color: #1BA39C;
            border-radius: 50%;
            animation: is-rotating 1s infinite;
            margin-top: 25px;
        }
        @keyframes is-rotating {
            to {
                transform: rotate(1turn);
            }
        }
    </style>
</head>
<body>
    <img id="logo" src="img/Logomarca.png" alt="Monography">
    <div class="loader"></div>
</body>
</html>