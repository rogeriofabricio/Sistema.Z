  <?php

  $membersNome = htmlentities($_SESSION['username']);

  // Consulta empresa
  $sql_select_members = "SELECT id, email FROM members WHERE username = '$membersNome' ";

  try{

    $query_select_members = $conecta->prepare($sql_select_members);
    $query_select_members->execute();

    $resultado_query_members = $query_select_members->fetchAll(PDO::FETCH_ASSOC);

  } catch(PDOexception $error_select_members) {
    echo 'Erro ao selecionar'.$error_select_members->getMessage();
  }

  foreach($resultado_query_members as $res_members){

    $memberId     = $res_members['id'];
    $memberEmail  = $res_members['email'];

  }

  

  // Consulta pessoas
  $sql_select = "SELECT id, pessoaTipo FROM pessoas WHERE pessoaEmail = '$memberEmail' ";

  try{

    $query_select = $conecta->prepare($sql_select);
    $query_select->execute();

    $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
    $count = $query_select->rowCount(PDO::FETCH_ASSOC);

  } catch(PDOexception $error_select) {
    echo 'Erro ao selecionar'.$error_insert->getMessage();
  }

  if($count == '0'){

    echo '<br /><br />Nada encontrado.';

  }else{

    foreach($resultado_query as $res){

      $pessoaId   = $res['id'];
      $pessoaTipo = $res['pessoaTipo'];

    }
  }
  
  //echo $pessoaTipo;


?>