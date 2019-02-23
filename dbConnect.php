<?php
define('HOST','localhost');
define('DB','zafiro');
define('USER','root');
define('PASS','root');


$conexao = 'mysql:host='.HOST.';dbname='.DB;

try{
	
	$conecta = new PDO($conexao,USER,PASS);
	$conecta->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	//echo 'Conexão efetuada com sucesso!';
	
}catch(PDOexception $error_conecta){
	echo 'Erro ao conectar '.$error_conecta->getMessage();
} 
?>