<!-- Resultado da Consultar -->
<?php

switch ($link) {
  
  case 'resultado':
    if ($link == "resultado") {

?>

  <div class="col-md-12 mb-3">

    <?php

      // Consulta etapas
      $sql_select = "SELECT * FROM segmento";

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
        <a href="segmentos.php?link=novo" style="text-decoration: none;">[+] Adicionar Novo</a>
        <a href="segmentopdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Segmento</th>
            <th scope="col">Editar</th>
          </tr>
        </thead>
    <?php

        foreach($resultado_query as $res){

          $segmentoId     = $res['id'];
          $segmentoNome   = $res['segmentoNome'];


          echo "<tbody> <tr> <th scope='row'>".$segmentoId."</th> <td>".$segmentoNome."</td> <td> <a href='segmentos.php?link=editar&id=".$segmentoId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='segmentos.php?link=pre_excluir&id=".$segmentoId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";

        }
      }
      echo "</tbody> </table>";

    } else {

      //Retorna para a página de consulta
      echo 'Erro ao abrir página.</br></br>';
      echo '<a href="segmentos.php?link=resultado">Voltar</a>';

    }

    include_once 'segmento_pdf.php';

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

    echo "
    <div class='col-md-3 mb-3'>
      <h1>Segmento</h1>
    </div>
    <div class='col-md-9 mb-3'>
      <form name='segmento' action='segmentos.php' method='GET'>
        <div class='form-row'>
          <div class='col-md-7 mb-3'>
            <input type='text' class='form-control is-valid' id='validationServer01' name='segmentoNome' placeholder='Exemplo: Comercial, Decoração, Arquitetura, etc...' required>
            <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='salvar' >
          </div>
          <div class='col-md-2'>
            <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Salvar</button>
          </div>
        </div>
      </form>
    </div>";
    break;
  }

  //Inicio Salvar
  case 'salvar':
    if ($link == "salvar") {

      if(isset($_GET['segmentoNome'])){

        date_default_timezone_set('America/Sao_Paulo');

        $segmentoNome  = $_GET['segmentoNome'];
        $criadoEm       = date ("Y-m-d H:i:s");
        $atualizadoEm   = date ("Y-m-d H:i:s");

        try{

          $sql_insert  = "INSERT INTO segmento (criadoEm, atualizadoEm, segmentoNome) "; 
          $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$segmentoNome')";

          $conecta->exec($sql_insert);

          echo '<span> Segmento cadastrada com sucesso!</span></br></br></br>';

          echo '<a href="segmentos.php?link=novo">Incluir novo</a>';

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

        $segmentoId  = $_GET['id'];

      // Consulta categoias
      $sql_select = "SELECT * FROM segmento WHERE id = $segmentoId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $segmentoId     = $res['id'];
          $segmentoNome   = $res['segmentoNome'];


          echo "
            <div class='col-md-3 mb-3'>
              <h1>Segmento</h1>
            </div>
            <div class='col-md-9 mb-3'>
              <form name='segmento' action='segmentos.php' method='GET'>
                <div class='form-row'>
                  <div class='col-md-7 mb-3'>
                    <input type='text' class='form-control is-valid' id='validationServer01' name='segmentoNome' value=".$segmentoNome." >
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='atualizar' >
                    <input type='hidden' class='form-control is-valid' id='validationServer03' name='segmentoId' value=".$segmentoId." >
                  </div>
                  <div class='col-md-2'>
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Salvar</button>
                  </div>
                </div>
              </form>
            </div>";
        }
    
  } else {
    echo 'Nada';
  }
    break;
  }
  


  //Inicio Atualizar
  case 'atualizar':
    if ($link == "atualizar") {

      if(isset($_GET['segmentoId'])){

        date_default_timezone_set('America/Sao_Paulo');

        $segmentoId    = $_GET['segmentoId'];
        $atualizadoEm   = date ("Y-m-d H:i:s");
        $segmentoNome  = $_GET['segmentoNome'];

        try{

          $sql_update  = "UPDATE segmento SET segmentoNome = '".$segmentoNome."' WHERE id = ".$segmentoId." "; 

          $conecta->exec($sql_update);

          echo '<span> Segmento atualizada com sucesso!</span></br></br></br>';

          echo '<a href="segmentos.php?link=resultado">Ver todos</a>';

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

        $segmentoId  = $_GET['id'];

      // Consulta categoias
      $sql_select = "SELECT * FROM segmento WHERE id = $segmentoId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $segmentoId     = $res['id'];
          $segmentoNome   = $res['segmentoNome'];


          echo "
            <div class='col-md-12 mb-3'>
              <h1>Segmento</h1>
              <h4>Tem certeza que deseja excluir este registro?</h4>
            </div>
            <div class='col-md-12 mb-3'>
              <form name='segmento' action='segmentos.php' method='GET'>
                <div class='form-row'>
                  <div class='col-md-3 mb-3'>
                    <span class='form-control'>".$segmentoNome."</span>
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluir' >
                    <input type='hidden' class='form-control is-valid' id='validationServer03' name='segmentoId' value=".$segmentoId." >
                  </div>
                  <div class='col-md-4' mb-3>
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                  </div>
                </div>
              </form>
              <form action='segmentos.php' method=get >
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

      if(isset($_GET['segmentoId'])){

        date_default_timezone_set('America/Sao_Paulo');

        $segmentoId = $_GET['segmentoId'];

        try{

          $sql_delete  = "DELETE FROM segmento WHERE id = '$segmentoId'"; 

          $conecta->exec($sql_delete);

          echo '<span> Registro excluido com sucesso!</span></br></br></br>';

          echo '<a href="segmentos.php?link=resultado">Ver todos</a>';

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