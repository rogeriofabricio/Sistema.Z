<!-- Resultado da Consultar -->
<?php

switch ($link) {
  
  case 'resultado':
    if ($link == "resultado") {

?>

  <div class="col-md-12 mb-3">

    <?php

      // Consulta pessoas
      $sql_select = "SELECT * FROM projetos";

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
        <a href="projeto.php?link=novo" style="text-decoration: none;">[+] Adicionar Novo</a>
        <a href="projetopdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Cliente</th>
            <th scope="col">Empreendimento</th>
            <th scope="col">Parceiro</th>
            <th scope="col">Automação</th>
            <th scope="col">Centralização</th>
            <th scope="col">Projeção</th>
            <th scope="col"></th>
          </tr>
        </thead>
    <?php

        foreach($resultado_query as $res){

          $id                           = $res['id'];
          $idPessoa                     = $res['idPessoa'];
          $empreendimento               = $res['projetoEmpreendimento'];
          $idParceiro                   = $res['idParceiro'];
          $projetoAutomacao             = $res['projetoAutomacao'];
          $projetoAutomacaoMarca        = $res['projetoAutomacaoMarca'];
          $projetoCentralizacao         = $res['projetoCentralizacao'];
          $projetoCentralizacaoLocal    = $res['projetoCentralizacaoLocal'];
          $projetoProjecao              = $res['projetoProjecao'];
          $projetoProjecaoLocal         = $res['projetoProjecaoLocal'];
          $projetoProjecaoTela          = $res['projetoProjecaoTela'];
          $projetoProjecaoProjetor      = $res['projetoProjecaoProjetor'];
          

          // Consulta pessoa
          $sql_select_pessoa = "SELECT * FROM pessoas WHERE id = $idPessoa";

          try{

            $query_select_pessoa = $conecta->prepare($sql_select_pessoa);
            $query_select_pessoa->execute();

            $resultado_query_pessoa = $query_select_pessoa->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_pessoa) {
            echo 'Erro ao selecionar'.$error_select_pessoa->getMessage();
          }

          foreach($resultado_query_pessoa as $res_pessoa){

              $epessoaId_pessoa     = $res_pessoa['id'];
              $pessoaNome_pessoa   = $res_pessoa['pessoaNome'];

          }


          // Consulta pessoa
          $sql_select_parceiro = "SELECT * FROM pessoas WHERE id = $idParceiro";

          try{

            $query_select_parceiro = $conecta->prepare($sql_select_parceiro);
            $query_select_parceiro->execute();

            $resultado_query_parceiro = $query_select_parceiro->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_parceiro) {
            echo 'Erro ao selecionar'.$error_select_parceiro->getMessage();
          }

          foreach($resultado_query_parceiro as $res_parceiro){

              $epessoaId_parceiro     = $res_parceiro['id'];
              $pessoaNome_parceiro   = $res_parceiro['pessoaNome'];

          }

          echo "<tbody> <tr> <th scope='row'>".$pessoaNome_pessoa."</th> <td>".$empreendimento."</td> <td>".$pessoaNome_parceiro."</td> <td>".$projetoAutomacao."</td> <td>".$projetoCentralizacao."</td> <td>".$projetoProjecao."</td> <td> <a href='projeto.php?link=editar&id=".$id."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='projeto.php?link=pre_excluir&id=".$id."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
        }
      }
      echo "</tbody> </table>";

    } else {

      //Retorna para a página de consulta
      echo 'Erro ao abrir página.</br></br>';
      echo '<a href="projeto.php?link=resultado">Voltar</a>';

    }

    include_once 'projeto_pdf.php';

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

    include_once'form_projeto.html';

    break;
  }

  //Inicio Salvar
  case 'salvar':
    if ($link == "salvar") {

      if(isset($_GET['cliente'])){

        date_default_timezone_set('America/Sao_Paulo');

        $criadoEm                      = date ("Y-m-d H:i:s");
        $atualizadoEm                  = date ("Y-m-d H:i:s");
        $idPessoa                      = $_GET['cliente'];
        $projetoEmpreendimento         = $_GET['projetoEmpreendimento'];
        $idParceiro                    = $_GET['parceiro'];
        $projetoAutomacao              = $_GET['projetoAutomacao'];
        $projetoAutomacaoMarca         = $_GET['projetoAutomacaoMarca'];
        $projetoCentralizacao          = $_GET['projetoCentralizacao'];
        $projetoCentralizacaoLocal     = $_GET['projetoCentralizacaoLocal'];
        $projetoProjecao               = $_GET['projetoProjecao'];
        $projetoProjecaoLocal          = $_GET['projetoProjecaoLocal'];
        $projetoProjecaoTela           = $_GET['projetoProjecaoTela'];
        $projetoProjecaoProjetor       = $_GET['projetoProjecaoProjetor'];

        try{

          $sql_insert  = "INSERT INTO projetos (criadoEm, atualizadoEm, idPessoa, projetoEmpreendimento, idParceiro, projetoAutomacao, projetoAutomacaoMarca, projetoCentralizacao, projetoCentralizacaoLocal, projetoProjecao, projetoProjecaoLocal, projetoProjecaoTela, projetoProjecaoProjetor) "; 
          $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$idPessoa', '$projetoEmpreendimento', '$idParceiro', '$projetoAutomacao', '$projetoAutomacaoMarca', '$projetoCentralizacao', '$projetoCentralizacaoLocal', '$projetoProjecao', '$projetoProjecaoLocal', '$projetoProjecaoTela', '$projetoProjecaoProjetor')";

          $conecta->exec($sql_insert);

          echo '<span> Projeto cadastrado com sucesso!</span></br></br></br>';

          echo '<a href="projeto.php?link=novo">Incluir novo</a>';

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

        $projetoId  = $_GET['id'];


      // Consulta empresas
      $sql_select = "SELECT * FROM projetos WHERE id = $projetoId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $id                           = $res['id'];
          $idPessoa                     = $res['idPessoa'];
          $empreendimento               = $res['projetoEmpreendimento'];
          $idParceiro                   = $res['idParceiro'];
          $projetoAutomacao             = $res['projetoAutomacao'];
          $projetoAutomacaoMarca        = $res['projetoAutomacaoMarca'];
          $projetoCentralizacao         = $res['projetoCentralizacao'];
          $projetoCentralizacaoLocal    = $res['projetoCentralizacaoLocal'];
          $projetoProjecao              = $res['projetoProjecao'];
          $projetoProjecaoLocal         = $res['projetoProjecaoLocal'];
          $projetoProjecaoTela          = $res['projetoProjecaoTela'];
          $projetoProjecaoProjetor      = $res['projetoProjecaoProjetor'];

          // Consulta cliente
          $sql_select_cliente = "SELECT * FROM pessoas WHERE id = $idPessoa";

          try{

            $query_select_cliente = $conecta->prepare($sql_select_cliente);
            $query_select_cliente->execute();

            $resultado_query_cliente = $query_select_cliente->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_cliente) {
            echo 'Erro ao selecionar'.$error_insert_cliente->getMessage();
          }

          foreach($resultado_query_cliente as $res_cliente){

              $pessoaId_cliente     = $res_cliente['id'];
              $pessoaNome_cliente   = $res_cliente['categoriaNome'];
          }


          // Consulta Parceiro
          $sql_select_parceiro = "SELECT * FROM pessoas WHERE id = $idPessoa";

          try{

            $query_select_parceiro = $conecta->prepare($sql_select_parceiro);
            $query_select_parceiro->execute();

            $resultado_query_parceiro = $query_select_parceiro->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_parceiro) {
            echo 'Erro ao selecionar'.$error_insert_parceiro->getMessage();
          }

          foreach($resultado_query_parceiro as $res_parceiro){

              $pessoaId_parceiro     = $res_parceiro['id'];
              $pessoaNome_parceiro   = $res_parceiro['categoriaNome'];
          }
          
        }

        include_once'form_projeto_edit.html';
    
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