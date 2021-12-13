<?php

    define('HOST','127.0.0.1');
    define('USER','root');
    define('PASSWORD','!91968591eu!');
    define('DB','monography');

    $connection = mysqli_connect(HOST, USER, PASSWORD, DB) or die ('Não foi possível conectar');

?>