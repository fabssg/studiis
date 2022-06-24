<?php
session_start();
include('../conexao.php');

$json = file_get_contents('php://input');

$obj = json_decode($json, true);
$email = $obj['email'];
$senhaAtual = $obj['senhaAtual'];
$senhaNova = $obj['senhaNova'];

$query = "SELECT * FROM info_usuarios WHERE email = '{$email}' and senha = md5('{$senhaAtual}')";

$result = mysqli_query($conexao, $query);
$row = mysqli_num_rows($result);

if ($row == 1){
    $query = "UPDATE info_usuarios SET senha = md5('{$senhaNova}') WHERE email = '{$email}'";
    $result = mysqli_query($conexao, $query);
    if (mysqli_affected_rows($conexao) > 0) {
        echo json_encode(0);
    } else {
        echo json_encode(1);
    }
} else {
    echo json_encode(2);
}

exit();
?>