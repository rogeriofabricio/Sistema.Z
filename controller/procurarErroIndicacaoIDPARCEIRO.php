<!-- Resultado da Consultar -->
<?php

switch ($link) {
  
  case 'resultado':
    if ($link == "resultado") {

?>

  <div class="col-md-12 mb-3">

    <?php

      $parceiro = htmlentities($_SESSION['username']);

        //Resgata o e-mail do parceiro
        $sql_select_email = "SELECT email FROM members WHERE username = '$parceiro'";

        try{

          $query_select_email = $conecta->prepare($sql_select_email);
          $query_select_email->execute();

          $resultado_query_email = $query_select_email->fetchAll(PDO::FETCH_ASSOC);
          $count_email = $query_select_email->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_email) {
          echo 'Erro ao selecionar'.$error_select_email->getMessage();
        }

        foreach($resultado_query_email as $res_email){

              $email = $res_email['email'];

        }


        //Resgata o id do parceiro Pessoa
        $sql_select_id = "SELECT id FROM pessoas WHERE pessoaEmail = '$email'";

        try{

          $query_select_id = $conecta->prepare($sql_select_id);
          $query_select_id->execute();

          $resultado_query_id = $query_select_id->fetchAll(PDO::FETCH_ASSOC);
          $count_id = $query_select_id->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_id) {
          echo 'Erro ao selecionar'.$error_select_id->getMessage();
        }

        if ($count_id > 0) {

          foreach($resultado_query_id as $res_id){

              $idParceiro = $res_id['id'];

        } else {

          //Resgata o id do parceiro Empresa
          $sql_select_id = "SELECT id FROM empresas WHERE empresaEmail = '$email'";

          try{

            $query_select_id = $conecta->prepare($sql_select_id);
            $query_select_id->execute();

            $resultado_query_id = $query_select_id->fetchAll(PDO::FETCH_ASSOC);
            $count_id = $query_select_id->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_id) {
            echo 'Erro ao selecionar'.$error_select_id->getMessage();
          }

          foreach($resultado_query_id as $res_id){

            $idParceiro = $res_id['id'];

          }
        }
      }

      // Consulta indicacao
      $sql_select = "SELECT * FROM indicacao WHERE idParceiro = $idParceiro"; 

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
    ?>
      <div>
        <a href="indicacao.php?link=novo" style="text-decoration: none;">[+] Adicionar Novo</a>
        <a href="indicacaopdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">E-mail</th>
            <th scope="col">Local</th>
            <th scope="col">Orçamento</th>
            <th scope="col">Perfil</th>
            <th scope="col">Editar</th>
          </tr>
        </thead>
    <?php

        foreach($resultado_query as $res){

          $indicacaoId          = $res['id'];
          $indicacaoNome        = $res['indicacaoNome'];
          $indicacaoTel         = $res['indicacaoTel'];
          $indicacaoEmail       = $res['indicacaoEmail'];
          $indicacaoLocal       = $res['indicacaoLocal'];
          $indicacaoOrcamento   = $res['indicacaoOrcamento'];
          $indicacaoPerfil      = $res['indicacaoPerfil'];


          echo "<tbody> <tr> <th scope='row'>".$indicacaoId."</th> <td>".$indicacaoNome."</td> <td>".$indicacaoTel."</td> <td>".$indicacaoEmail."</td> <td>".$indicacaoLocal."</td> <td>".$indicacaoOrcamento."</td> <td>".$indicacaoPerfil."</td> <td> <a href='indicacao.php?link=editar&id=".$indicacaoId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='indicacao.php?link=pre_excluir&id=".$indicacaoId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
        }
      }
      echo "</tbody> </table>";

    } else {

      //Retorna para a página de consulta
      echo 'Erro ao abrir página.</br></br>';
      echo '<a href="pessoas.php?link=resultado">Voltar</a>';

    }

    include_once 'pessoa_pdf.php';

    ?>
  </div>

  <div class="col-md-12 mb-3">
    <?php echo "<span class='contador' style='font-size: 13px; padding-right: 30px;'>Encontramos: $count Registros</span>"; ?>
  </div>
  
  <?php 
    break;
  
  
  //Inicio Novo
  case 'novo':
    if ($link == "novo") {

    include_once'form_indicacao.html';

    break;
  }

  //Inicio Salvar
  case 'salvar':
    if ($link == "salvar") {

      if(isset($_GET['indicacaoNome'])){

        $parceiro = htmlentities($_SESSION['username']);

        //Resgata o e-mail do usuário
        $sql_select_email = "SELECT email FROM members WHERE username = '$parceiro'";

        try{

          $query_select_email = $conecta->prepare($sql_select_email);
          $query_select_email->execute();

          $resultado_query_email = $query_select_email->fetchAll(PDO::FETCH_ASSOC);
          $count_email = $query_select_email->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_email) {
          echo 'Erro ao selecionar'.$error_select_email->getMessage();
        }

        foreach($resultado_query_email as $res_email){

              $email = $res_email['email'];

        }

        //Regata o id do usuário em Pessoas
        $sql_select_id = "SELECT id FROM pessoas WHERE pessoaEmail = '$email'";

        try{

          $query_select_id = $conecta->prepare($sql_select_id);
          $query_select_id->execute();

          $resultado_query_id = $query_select_id->fetchAll(PDO::FETCH_ASSOC);
          $count_id = $query_select_id->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_id) {
          echo 'Erro ao selecionar'.$error_select_id->getMessage();
        }

        if ($count_id > 0) {
          foreach($resultado_query_id as $res_id){

              $idParceiro = $res_id['id'];

          }

          $parceiroTipo = "pessoas";
          // echo $email . "</br>";
          // echo $idParceiro . "</br>";
        } else {

          //Regata o id do usuário em Empresas
          $sql_select_id = "SELECT id FROM empresas WHERE empresaEmail = '$email'";

          try{

            $query_select_id = $conecta->prepare($sql_select_id);
            $query_select_id->execute();

            $resultado_query_id = $query_select_id->fetchAll(PDO::FETCH_ASSOC);
            $count_id = $query_select_id->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_id) {
            echo 'Erro ao selecionar'.$error_select_id->getMessage();
          }

          foreach($resultado_query_id as $res_id){

            $idParceiro = $res_id['id'];
          }

          $parceiroTipo = "empresas";
          // echo $email . "</br>";
          // echo $idParceiro . "</br>";
        }

        date_default_timezone_set('America/Sao_Paulo');

        $criadoEm           = date ("Y-m-d H:i:s");
        $atualizadoEm       = date ("Y-m-d H:i:s");
        $indicacaoParceiro  = $parceiro;
        $indicacaoNome      = $_GET['indicacaoNome'];
        $indicacaoTel       = $_GET['indicacaoTel'];
        $indicacaoEmail     = $_GET['indicacaoEmail'];
        $indicacaoLocal     = $_GET['indicacaoLocal'];
        $indicacaoOrcamento = $_GET['indicacaoOrcamento'];
        $indicacaoPerfil    = $_GET['indicacaoPerfil'];
        $indicacaoTipo      = $parceiroTipo;

        // echo $indicacaoParceiro . "</br>";
        // echo $indicacaoNome . "</br>"; 
        // echo $indicacaoTel . "</br>";
        // echo $indicacaoEmail . "</br>";
        // echo $indicacaoLocal . "</br>";
        // echo $indicacaoOrcamento . "</br>";
        // echo $indicacaoPerfil;

        try{

          $sql_insert  = "INSERT INTO indicacao (criadoEm, atualizadoEm, idParceiro, indicacaoNome, indicacaoTel, indicacaoEmail, indicacaoLocal, indicacaoOrcamento, indicacaoPerfil, indicacaoTipo) "; 
          $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$idParceiro', '$indicacaoNome', '$indicacaoTel', '$indicacaoEmail', '$indicacaoLocal', '$indicacaoOrcamento', '$indicacaoPerfil', '$indicacaoTipo')";

          $conecta->exec($sql_insert);

          echo '<span> Enviado com sucesso!</span></br></br></br>';

          echo '<a href="indicacao.php?link=novo">Incluir novo</a>';

        } catch(PDOexception $error_insert) {
          echo 'Erro ao cadastrar'.$error_insert->getMessage();
        }

      }
    break;
  }


  //Inicio Editar
  case 'editar':
    if ($link == "editar") {

      if(isset($_GET['id'])){

        $pessoaId  = $_GET['id'];


      // Consulta empresas
      $sql_select = "SELECT * FROM pessoas WHERE id = $pessoaId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $pessoaId         = $res['id'];
          $pessoaNome       = $res['pessoaNome'];
          $pessoaTel        = $res['pessoaTel'];
          $pessoaEmail      = $res['pessoaEmail'];
          $pessoaCPF        = $res['pessoaCpf'];
          $pessoaNasc       = $res['pessoaNasc'];
          $pessoaProfissao  = $res['idCategoria'];
          $pessoaEmpresa    = $res['idEmpresa'];

          // Consulta segmentos
          $sql_select_categoria = "SELECT * FROM categoria WHERE id = $pessoaProfissao";

          try{

            $query_select_categoria = $conecta->prepare($sql_select_categoria);
            $query_select_categoria->execute();

            $resultado_query_categoria = $query_select_categoria->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_categoria) {
            echo 'Erro ao selecionar'.$error_insert_categoria->getMessage();
          }

          foreach($resultado_query_categoria as $res_categoria){

              $categoriaId_categoria     = $res_categoria['id'];
              $categoriaNome_categoria   = $res_categoria['categoriaNome'];
          }

          // Consulta empresas
          $sql_select_empresa = "SELECT * FROM empresas WHERE id = $pessoaEmpresa";

          try{

            $query_select_empresa = $conecta->prepare($sql_select_empresa);
            $query_select_empresa->execute();

            $resultado_query_empresa = $query_select_empresa->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_empresa) {
            echo 'Erro ao selecionar'.$error_insert_empresa->getMessage();
          }

          foreach($resultado_query_empresa as $res_empresa){

              $empresaId_empresa     = $res_empresa['id'];
              $empresaNome_empresa   = $res_empresa['empresaNome'];
          }
          
        }

        include_once'form_pessoa_edit.html';
    
    } else {
      echo 'Nada';
    }
    break;
  }
  


  //Inicio Atualizar
  case 'atualizar':
    if ($link == "atualizar") {

      if(isset($_GET['pessoaId'])){

        date_default_timezone_set('America/Sao_Paulo');
        $atualizadoEmR    = date ("Y-m-d H:i:s");
        $pessoaIdR       = $_GET['pessoaId'];
        $pessoaNomeR      = $_GET['pessoaNome'];
        $pessoaTelR       = $_GET['pessoaTel'];
        $pessoaEmailR     = $_GET['pessoaEmail'];
        $pessoaCPFR       = $_GET['pessoaCpf'];
        $pessoaNasc      = $_GET['pessoaNasc'];
        $pessoaProfissaoR = $_GET['pessoaProfissao'];
        $pessoaEmpresaR   = $_GET['pessoaEmpresa'];
        $dataInvertida = inverteData($pessoaNasc);

        try{

          $sql_update  = "UPDATE pessoas SET atualizadoEm = '".$atualizadoEmR."', pessoaNome = '".$pessoaNomeR."', pessoaTel = '".$pessoaTelR."', pessoaEmail = '".$pessoaEmailR."', pessoaCpf = '".$pessoaCPFR."', pessoaNasc = '".$dataInvertida."', idCategoria = '".$pessoaProfissaoR."', idEmpresa = ".$pessoaEmpresaR."  WHERE id = ".$pessoaIdR." "; 

          $conecta->exec($sql_update);

          echo '<span> Pessoa atualizada com sucesso!</span></br></br></br>';

          echo '<a href="pessoas.php?link=resultado">Ver todos</a>';

        } catch(PDOexception $error_update) {
          echo 'Erro ao atualizar'.$error_update->getMessage();
        }

      }
    break;
  }

  //Inicio Editar
  case 'pre_excluir':
    if ($link == "pre_excluir") {

      if(isset($_GET['id'])){

        $pessoaId  = $_GET['id'];

      // Consulta categoias
      $sql_select = "SELECT * FROM pessoas WHERE id = $pessoaId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $pessoaId     = $res['id'];
          $pessoaNome   = $res['pessoaNome'];


          echo "
            <div class='col-md-12 mb-3'>
              <h1>Pessoa</h1>
              <h4>Tem certeza que deseja excluir este registro?</h4>
            </div>
            <div class='col-md-12 mb-3'>
              <form name='pessoa' action='pessoas.php' method='GET'>
                <div class='form-row'>
                  <div class='col-md-3 mb-3'>
                    <span class='form-control'>".$pessoaNome."</span>
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluir' >
                    <input type='hidden' class='form-control is-valid' id='validationServer03' name='pessoaId' value=".$pessoaId." >
                  </div>
                  <div class='col-md-4' mb-3>
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                  </div>
                </div>
              </form>
              <form action='pessoas.php' method=get >
                <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='resultado' >
                <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
              </form>
            </div>";
        }
    
  } else {
    echo 'Nada';
  }
    break;
  }

  //Inicio Excluir
  case 'excluir':
    if ($link == "excluir") {

      if(isset($_GET['pessoaId'])){

        date_default_timezone_set('America/Sao_Paulo');

        $pessoaId = $_GET['pessoaId'];

        try{

          $sql_delete  = "DELETE FROM pessoas WHERE id = '$pessoaId'"; 

          $conecta->exec($sql_delete);

          echo '<span> Registro excluido com sucesso!</span></br></br></br>';

          echo '<a href="pessoas.php?link=resultado">Ver todos</a>';

        } catch(PDOexception $error_delete) {
          echo 'Erro ao excluir'.$error_delete->getMessage();
        }

      }
    break;
  }

  default:
    # code...
    break;
  }

  function inverteData($pessoaNasc){
    if(count(explode("/",$pessoaNasc)) > 1){
      return implode("-",array_reverse(explode("/",$pessoaNasc)));
    }elseif(count(explode("-",$pessoaNasc)) > 1){
      return implode("/",array_reverse(explode("-",$pessoaNasc)));
    }
  }

?>