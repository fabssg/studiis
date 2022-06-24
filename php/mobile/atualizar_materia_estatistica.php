<?php
session_start();
include('../conexao.php');

$json = file_get_contents('php://input');

$obj = json_decode($json,true);

$email = $obj['email'];
$stat = $obj['stat'];
$incremento = $obj['incremento'];

$query = "UPDATE info_usuarios SET {$stat} = {$stat} + {$incremento} WHERE email = '{$email}'";

$result = mysqli_query($conexao, $query);

if (mysqli_affected_rows($conexao) == 1) {
    echo json_encode(0);
} else {
    echo json_encode(1);
}

exit();
?>