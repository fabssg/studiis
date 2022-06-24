<?php
session_start();
include('../conexao.php');

$json = file_get_contents('php://input');

$obj = json_decode($json, true);

$num_questoes = $obj['num_questoes'];
$materias = $obj['materias'];
$num_materias = count($materias);

// garante que as matérias com mais perguntas não serão sempre as mesmas
shuffle($materias);

// numero de questões por matéria
$x = floor($num_questoes / $num_materias);

// resto de questões; quais materias terão mais questões que outras?
$y = $num_questoes % $num_materias;

$num_questoes_por_materia = array($x, $x, $x, $x, $x, $x, $x, $x);

for ($i = 0; $i < $y; $i++) {
    $num_questoes_por_materia[$i]++;
}

// questões que estarão no simulado. as questões tiradas randomicamente do banco de dados serão
// guardadas aqui, a fim de mais tarde serem enviadas ao cliente do celular.
$questoes_simulado = array();
foreach ($materias as $indice=>$materia) {
    // consulta no banco de dados por matéria retornando questões aleatórias do banco de uma determinada matéria
    $query = "SELECT ano, pergunta, resposta, arquivo FROM perguntas WHERE materia = '{$materia}' ORDER BY rand() LIMIT {$num_questoes_por_materia[$indice]}";
    
    $result = mysqli_query($conexao, $query);
    while ($row = mysqli_fetch_row($result)) {
        $t = array("Ano"=>$row[0], "Pergunta"=>$row[1], "Resposta"=>$row[2], "Arquivo"=>$row[3], "Materia"=>$materia);
        array_push($questoes_simulado, $t);
    }
}

// garante que as perguntas não seguirão uma ordem especifica de matéria, por ex: matematica => portugues => biologia => matematica => portugues => ...
shuffle($questoes_simulado);
echo json_encode($questoes_simulado);

exit();
?>