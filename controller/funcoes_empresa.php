<!-- Resultado da Consultar -->
<?php

switch ($link) {
  
  case 'resultado':
    if ($link == "resultado") {

?>

  <div class="col-md-12 mb-3">

    <?php

      // Consulta empresas
      $sql_select = "SELECT * FROM empresas";

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
        <a href="empresas.php?link=novo" style="text-decoration: none;">[+] Adicionar Novo</a>
        <a href="empresapdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Empresa</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefone</th>
            <th scope="col">Segmento</th>
            <th scope="col">Editar</th>
          </tr>
        </thead>
    <?php

        foreach($resultado_query as $res){

          $empresaId          = $res['id'];
          $empresaNome        = $res['empresaNome'];
          $empresaEmail       = $res['empresaEmail'];
          $empresaTel         = $res['empresaTel'];
          $empresaSegmento    = $res['idSegmento'];

          // Consulta segmentos
          $sql_select_segmento = "SELECT * FROM segmento WHERE id = $empresaSegmento";

          try{

            $query_select_segmento = $conecta->prepare($sql_select_segmento);
            $query_select_segmento->execute();

            $resultado_query_segmento = $query_select_segmento->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_segmento) {
            echo 'Erro ao selecionar'.$error_insert_segmento->getMessage();
          }

          foreach($resultado_query_segmento as $res_segmento){

              $segmentoId_segmento     = $res_segmento['id'];
              $segmentoNome_segmento   = $res_segmento['segmentoNome'];


          echo "<tbody> <tr> <th scope='row'>".$empresaId."</th> <td>".$empresaNome."</td> <td>".$empresaEmail."</td> <td>".$empresaTel."</td> <td>".$segmentoNome_segmento."</td> <td> <a href='empresas.php?link=editar&id=".$empresaId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='empresas.php?link=pre_excluir&id=".$empresaId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";

          }
        }
      }
      echo "</tbody> </table>";

    } else {

      //Retorna para a página de consulta
      echo 'Erro ao abrir página.</br></br>';
      echo '<a href="empresas.php?link=resultado">Voltar</a>';

    }

    include_once 'empresa_pdf.php';

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

    include_once'form_empresa.html';

    break;
  }

  //Inicio Salvar
  case 'salvar':
    if ($link == "salvar") {

      if(isset($_GET['empresaNome'])){

        date_default_timezone_set('America/Sao_Paulo');

        $criadoEm       = date ("Y-m-d H:i:s");
        $atualizadoEm   = date ("Y-m-d H:i:s");
        $empresaNome    = $_GET['empresaNome'];
        $empresaTel     = $_GET['empresaTel'];
        $empresaEmail   = $_GET['empresaEmail'];
        $empresaCidade  = $_GET['empresaCidade'];
        $empresaEstado  = $_GET['empresaEstado'];
        $empresaCep     = $_GET['empresaCep'];
        $empresaSeg     = $_GET['empresaSeg'];

        try{

          $sql_insert  = "INSERT INTO empresas (criadoEm, atualizadoEm, empresaNome, empresaTel, empresaEmail, empresaCidade, empresaEstado, empresaCep, idSegmento) "; 
          $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$empresaNome', '$empresaTel', '$empresaEmail', '$empresaCidade', '$empresaEstado', '$empresaCep', '$empresaSeg')";

          $conecta->exec($sql_insert);

          echo '<span> Empresa cadastrada com sucesso!</span></br></br></br>';

          echo '<a href="empresas.php?link=novo">Incluir novo</a>';

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

        $empresaId  = $_GET['id'];

      // Consulta empresas
      $sql_select = "SELECT * FROM empresas WHERE id = $empresaId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $empresaId     = $res['id'];
          $empresaNome   = $res['empresaNome'];
          $empresaTel    = $res['empresaTel'];
          $empresaEmail  = $res['empresaEmail'];
          $empresaCidade = $res['empresaCidade'];
          $empresaEstado = $res['empresaEstado'];
          $empresaCep    = $res['empresaCep'];
          $empresaSeg    = $res['idSegmento'];

          // Consulta segmentos
          $sql_select_segmento = "SELECT * FROM segmento WHERE id = $empresaSeg";

          try{

            $query_select_segmento = $conecta->prepare($sql_select_segmento);
            $query_select_segmento->execute();

            $resultado_query_segmento = $query_select_segmento->fetchAll(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_segmento) {
            echo 'Erro ao selecionar'.$error_insert_segmento->getMessage();
          }

          foreach($resultado_query_segmento as $res_segmento){

              $segmentoId_segmento     = $res_segmento['id'];
              $segmentoNome_segmento   = $res_segmento['segmentoNome'];
          }
          
        }

        include_once'form_empresa_edit.html';
    
    } else {
      echo 'Nada';
    }
    break;
  }
  


  //Inicio Atualizar
  case 'atualizar':
    if ($link == "atualizar") {

      if(isset($_GET['empresaId'])){

        date_default_timezone_set('America/Sao_Paulo');
        $atualizadoEmR  = date ("Y-m-d H:i:s");
        $empresaIdR     = $_GET['empresaId'];
        $empresaNomeR   = $_GET['empresaNome'];
        $empresaTelR    = $_GET['empresaTel'];
        $empresaEmailR  = $_GET['empresaEmail'];
        $empresaCidadeR = $_GET['empresaCidade'];
        $empresaEstadoR = $_GET['empresaEstado'];
        $empresaCepR    = $_GET['empresaCep'];
        $empresaSegR    = $_GET['empresaSeg'];

        try{

          $sql_update  = "UPDATE empresas SET atualizadoEm = '".$atualizadoEmR."', empresaNome = '".$empresaNomeR."', empresaTel = '".$empresaTelR."', empresaEmail = '".$empresaEmailR."', empresaCidade = '".$empresaCidadeR."', empresaEstado = '".$empresaEstadoR."', empresaCep = '".$empresaCepR."', idSegmento = ".$empresaSegR."  WHERE id = ".$empresaIdR." "; 

          $conecta->exec($sql_update);

          echo '<span> Empresa atualizada com sucesso!</span></br></br></br>';

          echo '<a href="empresas.php?link=resultado">Ver todos</a>';

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

        $empresaId  = $_GET['id'];

      // Consulta categoias
      $sql_select = "SELECT * FROM empresas WHERE id = $empresaId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $empresaId     = $res['id'];
          $empresaNome   = $res['empresaNome'];


          echo "
            <div class='col-md-12 mb-3'>
              <h1>Empresa</h1>
              <h4>Tem certeza que deseja excluir este registro?</h4>
            </div>
            <div class='col-md-12 mb-3'>
              <form name='empresa' action='empresas.php' method='GET'>
                <div class='form-row'>
                  <div class='col-md-3 mb-3'>
                    <span class='form-control'>".$empresaNome."</span>
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluir' >
                    <input type='hidden' class='form-control is-valid' id='validationServer03' name='empresaId' value=".$empresaId." >
                  </div>
                  <div class='col-md-4' mb-3>
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                  </div>
                </div>
              </form>
              <form action='empresas.php' method=get >
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

      if(isset($_GET['empresaId'])){

        date_default_timezone_set('America/Sao_Paulo');

        $empresaId = $_GET['empresaId'];

        try{

          $sql_delete  = "DELETE FROM empresas WHERE id = '$empresaId'"; 

          $conecta->exec($sql_delete);

          echo '<span> Registro excluido com sucesso!</span></br></br></br>';

          echo '<a href="empresas.php?link=resultado">Ver todos</a>';

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

?>