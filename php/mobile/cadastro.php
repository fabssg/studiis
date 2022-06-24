<?php
session_start();
include("../conexao.php");

$json = file_get_contents('php://input');

$obj = json_decode($json,true);

$nome = trim($obj['nome']);
$email = trim($obj['email']);
$senha = trim($obj['senha']);


$sql = "SELECT count(*) AS total FROM info_usuarios WHERE email = '$email'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] >= 1) {
    echo json_encode(1);
    exit();
}

$sql = "INSERT INTO info_usuarios(email, nome, senha) VALUES('$email', '$nome', md5('$senha'))";

$conexao->query($sql);

echo json_encode(0);

exit();

?>