<?php
session_start();
include('../conexao.php');

$json = file_get_contents('php://input');

$obj = json_decode($json,true);

$email = $obj['email'];
$senha = $obj['senha'];

if (empty($email) || empty($senha)) {
	echo json_encode(1);
	exit();
}

$query = "SELECT * FROM info_usuarios where email = '{$email}' and senha = md5('{$senha}')";

$result = mysqli_query($conexao, $query);

if (mysqli_num_rows($result) == 1){
	echo json_encode(0);
	exit();
} else {
	echo json_encode(1);
	exit();
}

?>