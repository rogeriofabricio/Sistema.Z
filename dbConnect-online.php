<?php
define('HOST','localhost');
define('DB','contr761_db_gold');
define('USER','contr761_usuario');
define('PASS','50fdmlpur');


$conexao = 'mysql:host='.HOST.';dbname='.DB;

try{
	
	$conecta = new PDO($conexao,USER,PASS);
	$conecta->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	//echo 'Conexão efetuada com sucesso!';
	
}catch(PDOexception $error_conecta){
	echo 'Erro ao conectar '.$error_conecta->getMessage();
} 
?>