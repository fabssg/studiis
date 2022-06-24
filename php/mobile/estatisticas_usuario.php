<?php
session_start();
include('../conexao.php');

$json = file_get_contents('php://input');

$obj = json_decode($json, true);
$email = $obj['email'];

$query = "SELECT * FROM info_usuarios WHERE email = '{$email}'";
$result = mysqli_query($conexao, $query);

if (mysqli_num_rows($result) != 1) {
    echo json_encode(1);
    exit();
}

$row = mysqli_fetch_row($result);

$pt = array("acertos"=>$row[4 ], "erros"=>$row[5 ]);
$ma = array("acertos"=>$row[6 ], "erros"=>$row[7 ]);
$hi = array("acertos"=>$row[8 ], "erros"=>$row[9 ]);
$ge = array("acertos"=>$row[10], "erros"=>$row[11]);
$fi = array("acertos"=>$row[12], "erros"=>$row[13]);
$qu = array("acertos"=>$row[14], "erros"=>$row[15]);
$bi = array("acertos"=>$row[16], "erros"=>$row[17]);
$in = array("acertos"=>$row[18], "erros"=>$row[19]);

$t = array("portugues"=>$pt, "matematica"=>$ma, "historia"=>$hi, "geografia"=>$ge, "fisica"=>$fi, "quimica"=>$qu, "biologia"=>$bi, "ingles"=>$in);

echo json_encode($t);
exit();
?>