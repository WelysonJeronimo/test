<?php

session_start();
include('../validateLogin.php');
include('../connectionDatabase.php');

$id = $_POST['id'];

$query = "SELECT * FROM info_usuarios WHERE id_usuario='$id'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) >= 1) {
    $row = mysqli_fetch_assoc($result);
    $date = $row['aniversario'];
    $date = strtotime($date);

    echo '<div class="infos">
    <label>Curso:</label>
    <p>'.$row['curso_formacao'].'</p>
    <label for="intitute">Instituição:</label>
    <p>'.$row['instituição'].'</p>
    <label for="areas">Áreas de conhecimento:</label>
    <p>'.$row['areas'].'</p>
    <label for="bday">Aniversário:</label>
    <p>'.date('d/m/Y',$date).'</p>
    <label for="address">logradoro:</label>
    <p>'.$row['cidade'].', '.$row['estado'].'.</p>
    </div>';
} else {
    echo 'Usuário ainda não forneceu informações para ativar esta aba...';
}
?>