<?php
session_start();
include('../conexao.php');

$json = file_get_contents('php://input');

$obj = json_decode($json, true);
$materia = $obj['materia'];

$query = "SELECT ano, pergunta, resposta, arquivo FROM perguntas WHERE materia = '{$materia}' ORDER BY rand() LIMIT 1";
$result = mysqli_query($conexao, $query);

if (mysqli_num_rows($result) != 1) {
    echo json_encode(1);
    exit();
}

$row = mysqli_fetch_row($result);
$t = array("Ano"=>$row[0], "Pergunta"=>$row[1], "Resposta"=>$row[2], "Arquivo"=>$row[3]);

echo json_encode($t);

exit();
?>