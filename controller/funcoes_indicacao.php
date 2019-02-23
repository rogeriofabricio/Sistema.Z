<!-- Resultado da Consultar -->
<?php

switch ($link) {
  
  case 'resultado':
    if ($link == "resultado") {

?>

  <div class="col-md-12 mb-3">

    <?php

      $parceiro = htmlentities($_SESSION['username']);
      //echo $parceiro;
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
        //echo $email;

        //Resgata o id do parceiro
        $sql_select_id = "SELECT id FROM pessoas WHERE pessoaEmail = '$email'";

        try{

          $query_select_id = $conecta->prepare($sql_select_id);
          $query_select_id->execute();

          $resultado_query_id = $query_select_id->fetchAll(PDO::FETCH_ASSOC);
          $count_email = $query_select_id->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_id) {
          echo 'Erro ao selecionar'.$error_select_id->getMessage();
        }

        foreach($resultado_query_id as $res_id){

              $idParceiro = $res_id['id'];

        }
        
        if ($count_email == 0) {

          //Resgata o id do parceiro
          $sql_select_id = "SELECT id FROM empresas WHERE empresaEmail = '$email'";

          try{

            $query_select_id = $conecta->prepare($sql_select_id);
            $query_select_id->execute();

            $resultado_query_id = $query_select_id->fetchAll(PDO::FETCH_ASSOC);
            $count_email = $query_select_id->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_id) {
            echo 'Erro ao selecionar'.$error_select_id->getMessage();
          }

          foreach($resultado_query_id as $res_id){

                $idParceiro = $res_id['id'];

          }

        } 
        //echo $idParceiro;
        ?>


      <div>
        <a href="indicacao.php?link=novo" style="text-decoration: none;">[+] Adicionar Novo</a>
        <a href="indicacaopdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
      </div>

      <?php
      // Consulta pessoas
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
      <!--div>
        <a href="indicacao.php?link=novo" style="text-decoration: none;">[+] Adicionar Novo</a>
        <a href="indicacaopdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
      </div-->
      <table class="table table-striped">
        <thead>
          <tr>
            <!--th scope="col">ID</th-->
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">E-mail</th>
            <th scope="col">Local</th>
            <!--th scope="col">Orçamento</th-->
            <!--th scope="col">Perfil</th-->
            <th scope="col">Status</th>
            <th scope="col">Editar / Info</th>
          </tr>
        </thead>
    <?php

        foreach($resultado_query as $res){

          $indicacaoId          = $res['id'];
          $indicacaoNome        = $res['indicacaoNome'];
          $indicacaoTel         = $res['indicacaoTel'];
          $indicacaoEmail       = $res['indicacaoEmail'];
          $indicacaoLocal       = $res['indicacaoLocal'];
          $idEtapa              = $res['idEtapa'];
          //$indicacaoOrcamento   = $res['indicacaoOrcamento'];
          //$indicacaoPerfil      = $res['indicacaoPerfil'];

          $sql_select_etapa = "SELECT etapaNome FROM etapa WHERE id = $idEtapa"; 

          try{

            $query_select_etapa = $conecta->prepare($sql_select_etapa);
            $query_select_etapa->execute();

            $resultado_query_etapa = $query_select_etapa->fetchAll(PDO::FETCH_ASSOC);
            $count_etapa = $query_select_etapa->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_etapa) {
            echo 'Erro ao selecionar'.$error_select_etapa->getMessage();
          }

          foreach($resultado_query_etapa as $res_etapa){

            $etapaNome  = $res_etapa['etapaNome'];

          }

          echo "<tbody> 
                  <tr>
                    <td>".$indicacaoNome."</td> 
                    <td>".$indicacaoTel."</td> 
                    <td>".$indicacaoEmail."</td> 
                    <td>".$indicacaoLocal."</td> 
                    <td>".$etapaNome."</td> 
                    <td> 
                      <a href='indicacao.php?link=editar&id=".$indicacaoId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> 
                      <!--a href='indicacao.php?link=pre_excluir&id=".$indicacaoId."'> <span class='material-icons' style='color: #000;'>delete</span> </a-->
                      <a href='indicacao.php?link=info&id=".$indicacaoId."'> <span class='material-icons' style='color: #000;'>info</span> </a> 
                    </td> 
                  </tr>";
        }
      }
      echo "</tbody> </table>";

    } else {

      //Retorna para a página de consulta
      echo 'Erro ao abrir página.</br></br>';
      echo '<a href="indicacao.php?link=resultado">Voltar</a>';

    }

    include_once 'indicacao_pdf.php';

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
        $indicacaoOrcamento = 0;
        $indicacaoPerfil    = $_GET['indicacaoPerfil'];
        $indicacaoTipo      = $parceiroTipo;
        $idEtapa            = 1;

        // echo $indicacaoParceiro . "</br>";
        // echo $indicacaoNome . "</br>"; 
        // echo $indicacaoTel . "</br>";
        // echo $indicacaoEmail . "</br>";
        // echo $indicacaoLocal . "</br>";
        // echo $indicacaoOrcamento . "</br>";
        // echo $indicacaoPerfil;

        try{

          $sql_insert  = "INSERT INTO indicacao (criadoEm, atualizadoEm, idParceiro, indicacaoNome, indicacaoTel, indicacaoEmail, indicacaoLocal, indicacaoOrcamento, indicacaoPerfil, indicacaoTipo) "; 
          $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$idParceiro', '$indicacaoNome', '$indicacaoTel', '$indicacaoEmail', '$indicacaoLocal', '$indicacaoOrcamento', '$indicacaoPerfil', '$indicacaoTipo', '$idEtapa')";

          $conecta->exec($sql_insert);

          echo '<span> Enviado com sucesso!</span></br></br></br>';

          echo '<a href="indicacao.php?link=resultado">Voltar para Lista</a>';

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

        $indicacaoId  = $_GET['id'];


      // Consulta empresas
      $sql_select = "SELECT * FROM indicacao WHERE id = $indicacaoId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $indicacaoId     = $res['id'];
          $indicacaoNome   = $res['indicacaoNome'];
          $indicacaoTel    = $res['indicacaoTel'];
          $indicacaoEmail  = $res['indicacaoEmail'];
          $indicacaoLocal  = $res['indicacaoLocal'];
          $indicacaoPerfil = $res['indicacaoPerfil'];
          
        }

        include_once'form_indicacao_edit.html';
    
    } else {
      echo 'Nada';
    }
    break;
  }
  


  //Inicio Atualizar
  case 'atualizar':
    if ($link == "atualizar") {

      if(isset($_GET['indicacaoId'])){

        date_default_timezone_set('America/Sao_Paulo');
        $atualizadoEmR    = date ("Y-m-d H:i:s");
        $indicacaoIdR     = $_GET['indicacaoId'];
        $indicacaoNomeR   = $_GET['indicacaoNome'];
        $indicacaoTelR    = $_GET['indicacaoTel'];
        $indicacaoEmailR  = $_GET['indicacaoEmail'];
        $indicacaoLocalR  = $_GET['indicacaoLocal'];
        $indicacaoPerfilR = $_GET['indicacaoPerfil'];

        try{

          $sql_update  = "UPDATE indicacao SET atualizadoEm = '".$atualizadoEmR."', indicacaoNome = '".$indicacaoNomeR."', indicacaoTel = '".$indicacaoTelR."', indicacaoEmail = '".$indicacaoEmailR."', indicacaoLocal = '".$indicacaoLocalR."', indicacaoPerfil = '".$indicacaoPerfilR."'  WHERE id = ".$indicacaoIdR." "; 

          $conecta->exec($sql_update);

          echo '<span> Cadastro atualizada com sucesso!</span></br></br></br>';

          echo '<a href="indicacao.php?link=resultado">Voltar para Lista Completa</a>';

        } catch(PDOexception $error_update) {
          echo 'Erro ao atualizar'.$error_update->getMessage();
        }

      }
    break;
  }

  //Inicio Editar
  case 'info':
    if ($link == "info") {

      if(isset($_GET['id'])){

        $indicacaoId  = $_GET['id'];


      // Consulta empresas
      $sql_select = "SELECT * FROM indicacao WHERE id = $indicacaoId";

      try{

        $query_select = $conecta->prepare($sql_select);
        $query_select->execute();

        $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
        $count = $query_select->rowCount(PDO::FETCH_ASSOC);

      } catch(PDOexception $error_select) {
        echo 'Erro ao selecionar'.$error_insert->getMessage();
      }

      foreach($resultado_query as $res){

          $indicacaoId     = $res['id'];
          $criadoEm        = $res['criadoEm'];
          $atualizadoEm    = $res['atualizadoEm'];
          $indicacaoNome   = $res['indicacaoNome'];
          $indicacaoTel    = $res['indicacaoTel'];
          $indicacaoEmail  = $res['indicacaoEmail'];
          $indicacaoLocal  = $res['indicacaoLocal'];
          $indicacaoPerfil = $res['indicacaoPerfil'];
          
        }

        include_once'form_indicacao_info.html';
    
    } else {
      echo 'Nada';
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