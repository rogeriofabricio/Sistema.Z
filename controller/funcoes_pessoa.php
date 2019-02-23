<!-- Resultado da Consultar -->
<?php

switch ($link) {
  
  case 'resultado':
    if ($link == "resultado") {

?>

  <div class="col-md-12 mb-3">

    <?php

      // Consulta pessoas
      $sql_select = "SELECT * FROM pessoas";

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
        <a href="pessoas.php?link=novo" style="text-decoration: none;">[+] Adicionar Novo</a>
        <a href="pessoapdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">E-mail</th>
            <th scope="col">Data Nasc.</th>
            <th scope="col">Profissão</th>
            <th scope="col">Empresa</th>
            <th scope="col">Editar</th>
          </tr>
        </thead>
    <?php

        foreach($resultado_query as $res){

          $pessoaId          = $res['id'];
          $pessoaNome        = $res['pessoaNome'];
          $pessoaTel         = $res['pessoaTel'];
          $pessoaEmail       = $res['pessoaEmail'];
          $pessoaCPF         = $res['pessoaCpf'];
          $pessoaNasc        = $res['pessoaNasc'];
          $pessoaProfissao   = $res['idCategoria'];
          $pessoaEmpresa     = $res['idEmpresa'];
          

          // Consulta empresa
          $sql_select_empresa = "SELECT * FROM empresas WHERE id = $pessoaEmpresa";

          try{

            $query_select_empresa = $conecta->prepare($sql_select_empresa);
            $query_select_empresa->execute();

            $resultado_query_empresa = $query_select_empresa->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_empresa) {
            echo 'Erro ao selecionar'.$error_select_empresa->getMessage();
          }

          foreach($resultado_query_empresa as $res_empresa){

              $empresaId_empresa     = $res_empresa['id'];
              $empresaNome_empresa   = $res_empresa['empresaNome'];

          }

          // Consulta Profissão
          $sql_select_categoria = "SELECT * FROM categoria WHERE id = $pessoaProfissao";

          try{

            $query_select_categoria = $conecta->prepare($sql_select_categoria);
            $query_select_categoria->execute();

            $resultado_query_categoria = $query_select_categoria->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_categoria) {
            echo 'Erro ao selecionar'.$error_select_categoria->getMessage();
          }

          foreach($resultado_query_categoria as $res_categoria){

              $categoriaId_categoria     = $res_categoria['id'];
              $categoriaNome_categoria   = $res_categoria['categoriaNome'];

          }

          echo "<tbody> <tr> <th scope='row'>".$pessoaId."</th> <td>".$pessoaNome."</td> <td>".$pessoaTel."</td> <td>".$pessoaEmail."</td> <td>".inverteData($pessoaNasc)."</td> <td>".$categoriaNome_categoria."</td> <td>".$empresaNome_empresa."</td> <td> <a href='pessoas.php?link=editar&id=".$pessoaId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='pessoas.php?link=pre_excluir&id=".$pessoaId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
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


  //Inicio Aguardando
  case 'aguardando':
    if ($link == "aguardando") {

    // Consulta pessoas
      $sql_select = "SELECT * FROM pessoas WHERE pessoaStatus = 'aguardando' ";

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
        <a href="pessoas.php?link=novo" style="text-decoration: none;">[+] Adicionar Novo</a>
        <a href="pessoapdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">E-mail</th>
            <th scope="col">Data Nasc.</th>
            <th scope="col">Profissão</th>
            <th scope="col">Empresa</th>
            <th scope="col">Ativar</th>
          </tr>
        </thead>
    <?php

        foreach($resultado_query as $res){

          $pessoaId          = $res['id'];
          $pessoaNome        = $res['pessoaNome'];
          $pessoaTel         = $res['pessoaTel'];
          $pessoaEmail       = $res['pessoaEmail'];
          $pessoaCPF         = $res['pessoaCpf'];
          $pessoaNasc        = $res['pessoaNasc'];
          $pessoaProfissao   = $res['idCategoria'];
          $pessoaEmpresa     = $res['idEmpresa'];
          

          // Consulta empresa
          $sql_select_empresa = "SELECT * FROM empresas WHERE id = $pessoaEmpresa";

          try{

            $query_select_empresa = $conecta->prepare($sql_select_empresa);
            $query_select_empresa->execute();

            $resultado_query_empresa = $query_select_empresa->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_empresa) {
            echo 'Erro ao selecionar'.$error_select_empresa->getMessage();
          }

          foreach($resultado_query_empresa as $res_empresa){

              $empresaId_empresa     = $res_empresa['id'];
              $empresaNome_empresa   = $res_empresa['empresaNome'];

          }

          // Consulta Profissão
          $sql_select_categoria = "SELECT * FROM categoria WHERE id = $pessoaProfissao";

          try{

            $query_select_categoria = $conecta->prepare($sql_select_categoria);
            $query_select_categoria->execute();

            $resultado_query_categoria = $query_select_categoria->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_categoria) {
            echo 'Erro ao selecionar'.$error_select_categoria->getMessage();
          }

          foreach($resultado_query_categoria as $res_categoria){

              $categoriaId_categoria     = $res_categoria['id'];
              $categoriaNome_categoria   = $res_categoria['categoriaNome'];

          }

          echo "<tbody> 
                  <tr> 
                    <th scope='row'>".$pessoaId."</th> 
                    <td>".$pessoaNome."</td> 
                    <td>".$pessoaTel."</td> 
                    <td>".$pessoaEmail."</td> 
                    <td>".inverteData($pessoaNasc)."</td> 
                    <td>".$categoriaNome_categoria."</td> 
                    <td>".$empresaNome_empresa."</td> 
                    <td> 
                      <a href='pessoas.php?link=ativar&id=".$pessoaId."'> <span class='material-icons' style='color: #000;'>check</span> </a> &nbsp&nbsp
                      <a href='pessoas.php?link=pre_excluir&id=".$pessoaId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> 
                    </td> 
                  </tr>";
        }
      }
      echo "</tbody> </table>";

    } else {

      //Retorna para a página de consulta
      echo 'Erro ao abrir página.</br></br>';
      echo '<a href="pessoas.php?link=resultado">Voltar</a>';

    }

    break;
  
  //Inicio Ativar
  case 'ativar':
    if ($link == "ativar") {

    if(isset($_GET['id'])){

        date_default_timezone_set('America/Sao_Paulo');
        $atualizadoEm = date ("Y-m-d H:i:s");
        $pessoaId     = $_GET['id'];
        $pessoaStatus = "ativo";

        try{

          $sql_update  = "UPDATE pessoas SET atualizadoEm = '".$atualizadoEm."', pessoaStatus = '".$pessoaStatus."'  WHERE id = ".$pessoaId." "; 

          $conecta->exec($sql_update);

          echo '<span> Cadastro ativado com sucesso!</span></br></br></br>';

          echo '<a href="pessoas.php?link=resultado">Ver todos</a>';

        } catch(PDOexception $error_update) {
          echo 'Erro ao atualizar'.$error_update->getMessage();
        } 
      }
    }
    break;
  
  
  
  //Inicio Novo
  case 'novo':
    if ($link == "novo") {

    include_once'form_pessoa.html';

    break;
  }

  //Inicio Salvar
  case 'salvar':
    if ($link == "salvar") {

      if(isset($_GET['pessoaNome'])){

        date_default_timezone_set('America/Sao_Paulo');

        $criadoEm     = date ("Y-m-d H:i:s");
        $atualizadoEm = date ("Y-m-d H:i:s");
        $pessoaNome   = $_GET['pessoaNome'];
        $pessoaEmail  = $_GET['pessoaEmail'];
        $pessoaTel    = $_GET['pessoaTel'];
        $pessoaCPF    = $_GET['pessoaCpf'];
        $pessoaNasc   = $_GET['pessoaNasc'];
        $pessoaProfissao   = $_GET['pessoaProfissao'];
        $pessoaEmpresa     = $_GET['pessoaEmpresa'];
        $dataInvertida = inverteData($pessoaNasc);

        try{

          $sql_insert  = "INSERT INTO pessoas (criadoEm, atualizadoEm, pessoaNome, pessoaEmail, pessoaTel, pessoaCpf, pessoaNasc, idCategoria, idEmpresa) "; 
          $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$pessoaNome', '$pessoaEmail', '$pessoaTel', '$pessoaCPF', '$dataInvertida', '$pessoaProfissao', '$pessoaEmpresa')";

          $conecta->exec($sql_insert);

          echo '<span> Pessoa cadastrada com sucesso!</span></br></br></br>';

          echo '<a href="pessoas.php?link=novo">Incluir novo</a>';

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