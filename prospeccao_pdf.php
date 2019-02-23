<?php
include_once 'dbConnect.php';
$conecta = new mysqli(HOST, USER, PASS, DB); // CONECTA
if ($conecta->connect_error) {
trigger_error("ERRO NA CONEXÃO: "  . $conecta->connect_error, E_USER_ERROR);
}
// PODE SER SEPARADO O TRECHO ACIMA PARA SER CHAMADO POR INCLUDE
//$sql = "SELECT indicacaoNome, indicacaoTel, indicacaoEmail, indicacaoLocal, idEtapa, indicacaoPerfil FROM indicacao WHERE idParceiro = $idParceiro"; // CONSULTA

$sql2 = "SELECT indicacao.indicacaoNome, indicacao.indicacaoTel, indicacao.indicacaoEmail, indicacao.indicacaoLocal, etapa.etapaNome, indicacao.indicacaoPerfil
FROM  indicacao
INNER JOIN etapa ON indicacao.idEtapa = etapa.id ";

/**$sql2 = "SELECT pessoas.id, pessoas.pessoaNome, pessoas.pessoaTel, pessoas.pessoaEmail, pessoas.pessoaCpf, date_format(pessoas.pessoaNasc, '%d-%m-%Y') pessoaNasc, empresas.empresaNome, categoria.categoriaNome
FROM ((pessoas
INNER JOIN categoria ON pessoas.idCategoria = categoria.id)
INNER JOIN empresas ON pessoas.idEmpresa = empresas.id)
ORDER BY pessoas.id ASC";**/

$query = $conecta->query($sql2); // RODA A CONSULTA

$abrir  = fopen( "lista_pdf/indicacao.txt" , "w+" );

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