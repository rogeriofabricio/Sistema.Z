<?php
include_once 'dbConnect.php';
$conecta = new mysqli(HOST, USER, PASS, DB); // CONECTA
if ($conecta->connect_error) {
trigger_error("ERRO NA CONEXÃO: "  . $conecta->connect_error, E_USER_ERROR);
}
// PODE SER SEPARADO O TRECHO ACIMA PARA SER CHAMADO POR INCLUDE
//$sql = "SELECT id, empresaNome, empresaTel, empresaEmail, empresaCidade, empresaEstado, empresaCep, idSegmento FROM empresas"; // CONSULTA

$sql2 = "SELECT id, fornecedor_nome
FROM prod_fornecedor
ORDER BY fornecedor_nome ASC";

$query = $conecta->query($sql2); // RODA A CONSULTA

$abrir  = fopen( "fornecedor.txt" , "w+" );

$linhas = $query->num_rows;
if($linhas >= 1) { // SE HÁ LINHAS

while($colunas = $query->fetch_row()) {
	$limpar = fputs( $abrir , implode( ";" , $colunas ) . "\r\n" );
}
$query->free(); // LIBERANDO OS DADOS DA CONSULTA
} else {
echo "Não há resultados"; // SEM RESULTADOS
}
$conecta->close(); // FECHANDO A CONEXÃO
?>