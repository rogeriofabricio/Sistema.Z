  <!-- Resultado da Consultar -->
  <?php

  switch ($link) {

    case 'cadastros':
      if ($link == "cadastros") {

      include_once'menu/nav_sub_menu_estoque.html';
      
      }
    break;

    case 'cadastroCategoria':
      if ($link == "cadastroCategoria") {

      include_once'menu/nav_sub_menu_estoque.html';
      include_once'form_estoque_categoria.html';

      }
    break;
    //Fim Cadastro Menu

    //Inicio Salvar Categoria
    case 'salvarCategoria':
      if ($link == "salvarCategoria") {

        if(isset($_GET['categoriaNome'])){

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm       = date ("Y-m-d H:i:s");
          $atualizadoEm   = date ("Y-m-d H:i:s");
          $categoriaNome = $_GET['categoriaNome'];

          try{

            $sql_insert  = "INSERT INTO prod_categoria (criadoEm, atualizadoEm, categoria_nome) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$categoriaNome')";

            $conecta->exec($sql_insert);

            include_once'menu/nav_sub_menu_estoque.html';

            echo "<span style='color: black; margin-left: 60px;'> Categoria cadastrada com sucesso!</span></br></br></br>";

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
      }
    break;


    //Inicio Constultas
    case 'consultas':
      if ($link == "consultas") {

        include_once'menu/nav_sub_menu_estoque_consulta.html';
      
      }
    break;

    
    //Inicio consulta Categoria
    case 'consultaCategoria':
      if ($link == "consultaCategoria") {
      
        echo '<div class="col-md-12 mb-3">';

        // Consulta pessoas
        $sql_select = "SELECT * FROM prod_categoria";

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

        } else {
  ?>
          <div>
            <a href="estoque.php?link=cadastroCategoria" style="text-decoration: none;">[+] Adicionar Novo</a>
            <a href="prodcategoriapdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Categoria</th>
                <th scope="col"></th>
              </tr>
            </thead>
  <?php

          foreach($resultado_query as $res){

            $categoriaId     = $res['id'];
            $categoriaNome   = $res['categoria_nome'];


            echo "<tbody> <tr> <th scope='row'>".$categoriaId."</th> <td>".$categoriaNome."</td> <td> <a href='estoque.php?link=editarCategoria&id=".$categoriaId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='estoque.php?link=pre_excluirCategoria&id=".$categoriaId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
          }
        }
          
          include_once 'estoque_categoria_pdf.php';

  ?>
          </div>
          </table>

  <?php
      
      }
    break;


    //Inicio Editar
    case 'editar':
      if ($link == "editar") {

        include_once'menu/nav_sub_menu_estoque_editar.html';
      
      }
    break;


    //Editar Categoria
    case 'editarCategoria':
      if ($link == "editarCategoria") {

        if(isset($_GET['id'])){

          $categoriaId = $_GET['id'];

          // Consulta empresas
          $sql_select = "SELECT * FROM prod_categoria WHERE id = $categoriaId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

            $categoriaId   = $res['id'];
            $categoriaNome = $res['categoria_nome'];

          }

          include_once'form_edit_categoria.html';
      
        } else {
          echo 'Nada';
        }
      }
    break;


    //Atualizar Categoria
    case 'atualizarCategoria':
      if ($link == "atualizarCategoria") {

        if(isset($_GET['categoriaId'])){

          date_default_timezone_set('America/Sao_Paulo');
          $atualizadoEmR  = date ("Y-m-d H:i:s");
          $categoriaIdR  = $_GET['categoriaId'];
          $categoriaNomeR = $_GET['categoriaNome'];

          try{

            $sql_update  = "UPDATE prod_categoria SET atualizadoEm = '".$atualizadoEmR."', categoria_nome = '".$categoriaNomeR."' WHERE id = ".$categoriaIdR." "; 

            $conecta->exec($sql_update);

            echo '<span> Categoria atualizada com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaCategoria">Ver todos</a>';

          } catch(PDOexception $error_update) {
            echo 'Erro ao atualizar'.$error_update->getMessage();
          }

        } 
      }
    break;


    //Inicio Constultas
    case 'delete':
      if ($link == "delete") {

        include_once'menu/nav_sub_menu_estoque_delete.html';
      
      }
    break;

    //Inicio pre-excluirCategoria
    case 'pre_excluirCategoria':
      if ($link == "pre_excluirCategoria") {

        if(isset($_GET['id'])){

          $categoriaId  = $_GET['id'];

          // Consulta categoias
          $sql_select = "SELECT * FROM prod_categoria WHERE id = $categoriaId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

              $categoriaId     = $res['id'];
              $categoriaNome   = $res['categoria_nome'];


              echo "
                <div class='col-md-12 mb-3'>
                  <h1>Categoria</h1>
                  <h4>Tem certeza que deseja excluir este registro?</h4>
                </div>
                <div class='col-md-12 mb-3'>
                  <form name='categoria' action='estoque.php' method='GET'>
                    <div class='form-row'>
                      <div class='col-md-3 mb-3'>
                        <span class='form-control'>".$categoriaNome."</span>
                      </div>
                      <div class='col-md-3 mb-3'>
                        <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluirCategoria' >
                        <input type='hidden' class='form-control is-valid' id='validationServer03' name='categoriaId' value=".$categoriaId." >
                      </div>
                      <div class='col-md-2' mb-3>
                        <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                      </div>
                    </div>
                  </form>
                  <form action='estoque.php' method=get >
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='consultaCategoria' >
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
                  </form>
                </div>";
          }
      
        } else {
          echo 'Nada';
        }
      
      }
    break;


    //Inicio ExcluirCategoria
    case 'excluirCategoria':
      if ($link == "excluirCategoria") {

        if(isset($_GET['categoriaId'])){

          date_default_timezone_set('America/Sao_Paulo');

          $categoriaId = $_GET['categoriaId'];

          try{

            $sql_delete  = "DELETE FROM prod_categoria WHERE id = '$categoriaId'"; 

            $conecta->exec($sql_delete);

            echo '<span> Registro excluido com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaCategoria">Ver todos</a>';

          } catch(PDOexception $error_delete) {
            echo 'Erro ao excluir'.$error_delete->getMessage();
          }

        }
      }
    break;

    default:
      # code...
      break;
    }

  ?>