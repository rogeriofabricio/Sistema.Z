  <!-- Resultado da Consultar -->
  <?php

  switch ($link) {
    
    case 'orcamentos':
      if ($link == "orcamentos") {

      include_once'menu/nav_sub_menu_orcamento.html';


      // Consulta produto
        $sql_select = "SELECT * FROM orc_fechado ORDER BY orc_controle DESC LIMIT 5";

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
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col" style='text-align: center;'>#</th>
                <th scope="col" style='text-align: center;'>Data</th>
                <th scope="col">Cliente</th>
                <th scope="col"></th>
              </tr>
            </thead>
      <?php

          foreach($resultado_query as $res){

            $orcCestaId   = $res['id'];
            $idCliente    = $res['id_cliente'];
            $orcControle  = $res['orc_controle'];
            $criadoEm     = $res['criadoEm'];


            //Inicio da seleção da produto
            $sql_select_cliente = "SELECT * FROM cliente WHERE id = $idCliente";

            try{

              $query_select_cliente = $conecta->prepare($sql_select_cliente);
              $query_select_cliente->execute();

              $resultado_query_cliente = $query_select_cliente->fetchAll(PDO::FETCH_ASSOC);

            } catch(PDOexception $error_select_cliente) {
              echo 'Erro ao selecionar'.$error_insert_cliente->getMessage();
            }

            foreach($resultado_query_cliente as $res_cliente){

              $idCliente    = $res_cliente['id'];
              $clienteNome  = $res_cliente['cliente_nome'];

            }
            //Fim seleção produto

            echo "<tbody> <tr> <td style='text-align: center;'>".$orcControle."</td> <td style='text-align: center;'>".$criadoEm."</td> <td>".$clienteNome."</td> <td> <a href='orcamento.php?link=editarOrcamento&controle=".$orcControle."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='orcamento.php?link=pre_excluirOrcamento&controle=".$orcControle."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </tr>";
            
          }
        }
      } 
    break;


    //Iniciio cadastroOrcamento
    //Selecionar cliente
    case 'cadastroOrcamento':

      date_default_timezone_set('America/Sao_Paulo');
      //Um número para controle do Orçamento
      $controle = date ("YmdHis");
      
      include_once'controller/form_orcamento_cadastrar_01.html';

      break;
      //Fim cadastroOrcamento


    //Inicio SelecionarCliente
    case 'selecionarCliente':

      if(isset($_GET['idCliente'])){

        $idCliente  = $_GET['idCliente'];
        $controle  = $_GET['controle'];

        //Seleciona o nome do cliente
        $sql_select = "SELECT cliente_nome FROM cliente WHERE id = $idCliente";

        try{

          $query_select = $conecta->prepare($sql_select);
          $query_select->execute();

          $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
          $count = $query_select->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select) {
          echo 'Erro ao selecionar'.$error_insert->getMessage();
        }

        foreach($resultado_query as $res){

          $clienteNome   = $res['cliente_nome'];   
        }
      }

      if ($clienteNome != null) {
      
        include_once'controller/form_orcamento_cadastrar_02.html';

      } else {
        echo 'Erro ao selecionar o cliente.';
      }

      break;



    case 'adicionarProduto':

      $controle     = $_GET['controle'];
      $idCliente    = $_GET['idCliente'];

      if ($idCliente != null && $controle != null) {

        $clienteNome  = $_GET['clienteNome'];
        $idProduto    = $_GET['idProduto'];
        $controle     = $_GET['controle'];
        // echo $controle. '</br>';
        // echo $idCliente. '</br>';
        // echo $idProduto. '</br>';
      
        include_once'controller/form_orcamento_cadastrar_02.html';

        if ($idProduto != null) {

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm       = date ("Y-m-d H:i:s");
          $atualizadoEm   = date ("Y-m-d H:i:s");
          $controle       = $_GET['controle'];
          $idCliente      = $_GET['idCliente'];
          $idProduto      = $_GET['idProduto'];
          $quantProduto   = $_GET['quantProduto'];
          $idSolucao      = $_GET['idSolucao'];

          try{

            $sql_insert  = "INSERT INTO orc_cesta (criadoEm, atualizadoEm, orc_controle, id_cliente, id_produto, orc_quant, id_solucao) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$controle', '$idCliente', '$idProduto', '$quantProduto', '$idSolucao')";

            $conecta->exec($sql_insert);

            include_once'controller/form_orcamento_lista_cesta.html';

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
        

      } else {
        echo 'Erro ao listar os produtos.';
      }
      break;
      //Fim Selecionar Cliente


    //Inicio Salvar orçamento
    case 'orcamentoFechar':
      if ($link == "orcamentoFechar") {

        if(isset($_GET['controle'])){

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm       = date ("Y-m-d H:i:s");
          $atualizadoEm   = date ("Y-m-d H:i:s");
          $controle       = $_GET['controle'];
          $idCliente      = $_GET['idCliente'];

          try{

            $sql_insert  = "INSERT INTO orc_fechado (criadoEm, atualizadoEm, orc_controle, id_cliente) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$controle', '$idCliente')";

            $conecta->exec($sql_insert);

            include_once'menu/nav_sub_menu_estoque.html';

            echo "<span style='color: black; margin-left: 60px;'> Orçamento fechado com sucesso!</span></br></br></br>";

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
      }
    break;


    //Inicio Editar
    //Editar orcamento
    case 'editarOrcamento':
      if ($link == "editarOrcamento") {

        if(isset($_GET['controle'])){

          $controle  = $_GET['controle'];

          // Consulta produto
          $sql_select = "SELECT * FROM orc_cesta WHERE orc_controle = $controle";

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
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Modelo</th>
                  <th scope="col">Descrição</th>
                  <th scope="col">Sub-Categoria</th>
                  <th scope="col">Fabricante</th>
                  <th scope="col" style='text-align: center;'>Quant.</th>
                  <th></th>
                </tr>
              </thead>
        <?php

            foreach($resultado_query as $res){

              $orcCestaId   = $res['id'];
              $idCliente    = $res['id_cliente'];
              $orcControle  = $res['orc_controle'];
              $idProduto    = $res['id_produto'];
              $orcQuant     = $res['orc_quant'];


                //Inicio da seleção cliente
                $sql_select_cliente = "SELECT * FROM cliente WHERE id = $idCliente";

                try{

                  $query_select_cliente = $conecta->prepare($sql_select_cliente);
                  $query_select_cliente->execute();

                  $resultado_query_cliente = $query_select_cliente->fetchAll(PDO::FETCH_ASSOC);

                } catch(PDOexception $error_select_cliente) {
                  echo 'Erro ao selecionar'.$error_insert_cliente->getMessage();
                }

                foreach($resultado_query_cliente as $res_cliente){

                    $clienteNome   = $res_cliente['cliente_nome'];;

                }
                //Fim seleção cliente


              //Inicio da seleção da produto
              $sql_select_prod = "SELECT * FROM produtos WHERE id = $idProduto";

              try{

                $query_select_prod = $conecta->prepare($sql_select_prod);
                $query_select_prod->execute();

                $resultado_query_prod = $query_select_prod->fetchAll(PDO::FETCH_ASSOC);

              } catch(PDOexception $error_select_prod) {
                echo 'Erro ao selecionar'.$error_insert_prod->getMessage();
              }

              foreach($resultado_query_prod as $res_prod){

                $produtoId            = $res_prod['id'];
                $produtoModelo        = $res_prod['prod_modelo'];
                $produtoDescricao     = $res_prod['prod_descricao'];
                $produtoSubCategoria  = $res_prod['id_subcategoria'];
                $produtoFabricante    = $res_prod['id_fabricante'];

                //Inicio da seleção da SubCategoria
                $sql_select_subcat = "SELECT * FROM prod_sub_categoria WHERE id = $produtoSubCategoria";

                try{

                  $query_select_subcat = $conecta->prepare($sql_select_subcat);
                  $query_select_subcat->execute();

                  $resultado_query_subcat = $query_select_subcat->fetchAll(PDO::FETCH_ASSOC);

                } catch(PDOexception $error_select_subcat) {
                  echo 'Erro ao selecionar'.$error_insert_subcato->getMessage();
                }

                foreach($resultado_query_subcat as $res_subcat){

                    $subcatNome = $res_subcat['sub_categoria_nome'];

                }
                //Fim seleção subCategoria


                //Inicio da seleção da fabricante
                $sql_select_fabr = "SELECT * FROM prod_fabricante WHERE id = $produtoFabricante";

                try{

                  $query_select_fabr = $conecta->prepare($sql_select_fabr);
                  $query_select_fabr->execute();

                  $resultado_query_fabr = $query_select_fabr->fetchAll(PDO::FETCH_ASSOC);

                } catch(PDOexception $error_select_fabr) {
                  echo 'Erro ao selecionar'.$error_insert_fabr->getMessage();
                }

                foreach($resultado_query_fabr as $res_fabr){

                    $fabrNome   = $res_fabr['fabricante_nome'];

                }
                //Fim seleção fabricante


              }
              //Fim seleção produto

              echo "<tbody> <tr> <td>".$produtoModelo."</td> <td>".$produtoDescricao."</td> <td>".$subcatNome."</td> <td>".$fabrNome."</td> <td style='text-align: center;'>".$orcQuant."</td> <td> <a href='orcamento.php?link=editarOrcItem&orcCestaId=".$orcCestaId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='orcamento.php?link=pre_excluirItemCesta&orcCestaId=".$orcCestaId."&controle=".$orcControle."&produtoModelo=".$produtoModelo."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </tr>";
              
            }
          }
        echo"
          <form action='orcamento.php' method=get >
            <input type='hidden' class='form-control is-valid' id='validationServer01' name='link' value='adicionarItemCesta' >
            <input type='hidden' class='form-control is-valid' id='validationServer02' name='idCliente' value=' ".$idCliente." ' >
            <input type='hidden' class='form-control is-valid' id='validationServer03' name='clienteNome' value=' ".$clienteNome." ' >
            <input type='hidden' class='form-control is-valid' id='validationServer04' name='controle' value=' ".$controle." ' >
            <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Adicionar Item</button>
          </form>
        ";
        }
      }

      break;


    //Editar Cesta
    case 'editarOrcItem':
      if ($link == "editarOrcItem") {

        if(isset($_GET['orcCestaId'])){

          $orcCestaId = $_GET['orcCestaId'];

          // Consulta empresas
          $sql_select = "SELECT * FROM orc_cesta WHERE id = $orcCestaId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

            $orcCestaId     = $res['id'];
            $orcControle    = $res['orc_controle'];
            $idProduto      = $res['id_produto'];
            $orcQuantidade  = $res['orc_quant'];
            $idSolucao      = $res['id_solucao'];


            //Inicio da seleção da produto
            $sql_select_prod = "SELECT * FROM produtos WHERE id = $idProduto";

            try{

              $query_select_prod = $conecta->prepare($sql_select_prod);
              $query_select_prod->execute();

              $resultado_query_prod = $query_select_prod->fetchAll(PDO::FETCH_ASSOC);

            } catch(PDOexception $error_select_prod) {
              echo 'Erro ao selecionar'.$error_insert_prod->getMessage();
            }

            foreach($resultado_query_prod as $res_prod){

                $produtoModelo   = $res_prod['prod_modelo'];

            }
            //Fim seleção produto

            //Inicio da seleção da solução
            $sql_select_sol = "SELECT * FROM orc_solucao WHERE id = $idSolucao";

            try{

              $query_select_sol = $conecta->prepare($sql_select_sol);
              $query_select_sol->execute();

              $resultado_query_sol = $query_select_sol->fetchAll(PDO::FETCH_ASSOC);

            } catch(PDOexception $error_select_sol) {
              echo 'Erro ao selecionar'.$error_insert_sol->getMessage();
            }

            foreach($resultado_query_sol as $res_sol){

                $solucaoNome   = $res_sol['solucao_nome'];

            }
            //Fim seleção produto

          }

          include_once'form_edit_orc_cesta.html';
      
        } else {
          echo 'Nada';
        }
      }
      break;



    //Atualizar Cesta Item
    case 'atualizarOrcCestaItem':
      if ($link == "atualizarOrcCestaItem") {

        if(isset($_GET['orcCestaId'])){

          date_default_timezone_set('America/Sao_Paulo');
          $atualizadoEmR    = date ("Y-m-d H:i:s");
          $orcCestaIdR      = $_GET['orcCestaId'];
          $orcControleR     = $_GET['orcControle'];
          $idProdutoR       = $_GET['idProduto'];
          $idSolucaoR       = $_GET['idSolucao'];
          $orcQuantidadeR   = $_GET['orcQuantidade'];

          try{

            $sql_update  = "UPDATE orc_cesta SET atualizadoEm = '".$atualizadoEmR."', id_produto = '".$idProdutoR."', orc_quant = '".$orcQuantidadeR."', orc_quant = '".$orcQuantidadeR."', id_solucao = '".$idSolucaoR."' WHERE id = ".$orcCestaIdR." "; 

            $conecta->exec($sql_update);

            echo '<span> Atualizado com sucesso!</span></br></br></br>';

            echo '<a href="orcamento.php?link=editarOrcamento&controle='.$orcControleR.'">Ver todos itens</a>';

          } catch(PDOexception $error_update) {
            echo 'Erro ao atualizar'.$error_update->getMessage();
          }

        }  else {
          echo 'Nada';
        }
      }
      break;


    //Inicio pre-excluirProduto
    case 'pre_excluirItemCesta':
      if ($link == "pre_excluirItemCesta") {

        if(isset($_GET['orcCestaId'])){

          $orcCestaId     = $_GET['orcCestaId'];
          $produtoModelo  = $_GET['produtoModelo'];
          $controle       = $_GET['controle'];

          // Consulta categoias
          $sql_select = "SELECT * FROM orc_cesta WHERE id = $orcCestaId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

              $orcCestaId     = $res['id'];

              echo "
                <div class='col-md-12 mb-3'>
                  <h1>Item</h1>
                  <h4>Tem certeza que deseja excluir este item?</h4>
                </div>
                <div class='col-md-12 mb-3'>
                  <form name='item' action='orcamento.php' method='GET'>
                    <div class='form-row'>
                      <div class='col-md-3 mb-3'>
                        <span class='form-control'>".$produtoModelo."</span>
                      </div>
                      <div class='col-md-3 mb-3'>
                        <input type='hidden' class='form-control is-valid' id='validationServer01' name='link' value='excluirOrcItemCesta' >
                        <input type='hidden' class='form-control is-valid' id='validationServer02' name='controle' value='".$controle."' >
                        <input type='hidden' class='form-control is-valid' id='validationServer03' name='orcCestaId' value=".$orcCestaId." >
                      </div>
                      <div class='col-md-2' mb-3>
                        <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                      </div>
                    </div>
                  </form>
                  <form action='orcamento.php' method=get >
                    <input type='hidden' class='form-control is-valid' id='validationServer04' name='controle' value='".$controle."' >
                    <input type='hidden' class='form-control is-valid' id='validationServer05' name='orcCestaId' value='".$orcCestaId."' >
                    <input type='hidden' class='form-control is-valid' id='validationServer06' name='link' value='editarOrcamento' >
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
                  </form>
                </div>";
          }
      
        } else {
          echo 'Nada';
        }
      
      }
    break;
    //Fim pre-excluir



    //Inicio Excluir
    //Inicio excluirOrcItemCesta
    case 'excluirOrcItemCesta':
      if ($link == "excluirOrcItemCesta") {

        if(isset($_GET['orcCestaId'])){

          date_default_timezone_set('America/Sao_Paulo');

          $orcCestaId = $_GET['orcCestaId'];
          $controle   = $_GET['controle'];

          try{

            $sql_delete  = "DELETE FROM orc_cesta WHERE id = '$orcCestaId'"; 

            $conecta->exec($sql_delete);

            echo '<span> Item excluido com sucesso!</span></br></br></br>';

            echo '<a href="orcamento.php?link=editarOrcamento&controle='.$controle.' ">Ver todos</a>';

          } catch(PDOexception $error_delete) {
            echo 'Erro ao excluir'.$error_delete->getMessage();
          }

        }
      }
    break;


    //Inicio SelecionarCliente
    case 'adicionarItemCesta':

      if(isset($_GET['idCliente'])){

        $idCliente  = $_GET['idCliente'];
        $controle  = $_GET['controle'];

        //Seleciona o nome do cliente
        $sql_select = "SELECT cliente_nome FROM cliente WHERE id = $idCliente";

        try{

          $query_select = $conecta->prepare($sql_select);
          $query_select->execute();

          $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
          $count = $query_select->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select) {
          echo 'Erro ao selecionar'.$error_insert->getMessage();
        }

        foreach($resultado_query as $res){

          $clienteNome   = $res['cliente_nome'];   
        }
      }

      if ($clienteNome != null) {
      
        include_once'controller/form_orcamento_cadastrar_item_cesta_02.html';

      } else {
        echo 'Erro ao selecionar o cliente.';
      }

      break;


    case 'adicionarProdutoItemCesta':

      $controle     = $_GET['controle'];
      $idCliente    = $_GET['idCliente'];

      if ($idCliente != null && $controle != null) {

        $clienteNome  = $_GET['clienteNome'];
        $idProduto    = $_GET['idProduto'];
        $controle     = $_GET['controle'];
        // echo $controle. '</br>';
        // echo $idCliente. '</br>';
        // echo $idProduto. '</br>';
      
        include_once'controller/form_orcamento_cadastrar_item_cesta_02.html';

        if ($idProduto != null) {

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm       = date ("Y-m-d H:i:s");
          $atualizadoEm   = date ("Y-m-d H:i:s");
          $controle       = $_GET['controle'];
          $idCliente      = $_GET['idCliente'];
          $idProduto      = $_GET['idProduto'];
          $quantProduto   = $_GET['quantProduto'];
          $idSolucao      = $_GET['idSolucao'];

          try{

            $sql_insert  = "INSERT INTO orc_cesta (criadoEm, atualizadoEm, orc_controle, id_cliente, id_produto, orc_quant, id_solucao) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$controle', '$idCliente', '$idProduto', '$quantProduto', '$idSolucao')";

            $conecta->exec($sql_insert);

            include_once'controller/form_orcamento_lista_cesta.html';

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
        

      } else {
        echo 'Erro ao listar os produtos.';
      }
      break;
      //Fim Selecionar Cliente


    //Inicio pre-excluirOrcamento
    case 'pre_excluirOrcamento':
      if ($link == "pre_excluirOrcamento") {

        if(isset($_GET['controle'])){

          $controle       = $_GET['controle'];

          echo "
                <div class='col-md-12 mb-3'>
                  <h1>Item</h1>
                  <h4>Tem certeza que deseja excluir este Orçamento?</h4>
                </div>
                <div class='col-md-12 mb-3'>
                  <form name='item' action='orcamento.php' method='GET'>
                    <div class='form-row'>
                      <div class='col-md-3 mb-3'>
                        <input type='hidden' class='form-control is-valid' id='validationServer01' name='link' value='excluirOrcamento' >
                        <input type='text' class='form-control is-valid' id='validationServer02' name='controle' value='".$controle."' >
                      </div>
                      <div class='col-md-2' mb-3>
                        <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                      </div>
                    </div>
                  </form>
                  <form action='orcamento.php' method=get >
                    <input type='hidden' class='form-control is-valid' id='validationServer06' name='link' value='orcamentos' >
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
                  </form>
                </div>";

          }
      
        } else {
          echo 'Nada';
        }
      
      
    break;
    //Fim pre-excluir



    //Inicio Excluir
    //Inicio excluirOrcamento
    case 'excluirOrcamento':
      if ($link == "excluirOrcamento") {

        if(isset($_GET['controle'])){

          date_default_timezone_set('America/Sao_Paulo');

          $controle   = $_GET['controle'];

          try{

            $sql_delete  = "DELETE FROM orc_cesta WHERE orc_controle = '$controle'"; 

            $conecta->exec($sql_delete);

          } catch(PDOexception $error_delete) {
            echo 'Erro ao excluir'.$error_delete->getMessage();
          }

          try{

            $sql_delete  = "DELETE FROM orc_fechado WHERE orc_controle = '$controle'"; 

            $conecta->exec($sql_delete);

            echo '<span> Orçamento excluido com sucesso!</span></br></br></br>';

            echo '<a href="orcamento.php?link=orcamentos">Voltar</a>';

          } catch(PDOexception $error_delete) {
            echo 'Erro ao excluir'.$error_delete->getMessage();
          }

        }
      }
    break;


  //TODO excluir item do orccesta e adicionar item
  //TODO INCLUIR CODIGO FABRICANTE E CODIGO ZAFIRO PARA OS PRODUTOS editarOrcItem




    // case 'selecionarCliente':
      
    //   if ($link == "selecionarCliente") {

    //     if(isset($_GET['idCliente'])){

    //       date_default_timezone_set('America/Sao_Paulo');

    //       $criadoEm       = date ("Y-m-d H:i:s");
    //       $atualizadoEm   = date ("Y-m-d H:i:s");
    //       $idCliente      = $_GET['clienteNome'];
    //       $clienteCelular = $_GET['clienteCelular'];
    //       $clienteEmail   = $_GET['clienteEmail'];
    //       $clienteCPF     = $_GET['clienteCPF'];

    //       try{

    //         $sql_insert  = "INSERT INTO orc_cesta (criadoEm, atualizadoEm, cliente_nome, cliente_celular, cliente_email, cliente_cpf) "; 
    //         $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$clienteNome', '$clienteCelular', '$clienteEmail', '$clienteCPF')";

    //         $conecta->exec($sql_insert);

    //         include_once'menu/nav_sub_menu_estoque.html';

    //         echo "<span style='color: black; margin-left: 60px;'> Cliente cadastrado com sucesso!</span></br></br></br>";

    //       } catch(PDOexception $error_insert) {
    //         echo 'Erro ao cadastrar'.$error_insert->getMessage();
    //       }

    //     }
    //   }




      //break;


    //Inicio Cadastro 
    //Inicio Salvar Cliente
    case 'salvarCliente':
      if ($link == "salvarCliente") {

        if(isset($_GET['clienteNome'])){

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm       = date ("Y-m-d H:i:s");
          $atualizadoEm   = date ("Y-m-d H:i:s");
          $clienteNome    = $_GET['clienteNome'];
          $clienteCelular = $_GET['clienteCelular'];
          $clienteEmail   = $_GET['clienteEmail'];
          $clienteCPF     = $_GET['clienteCPF'];

          try{

            $sql_insert  = "INSERT INTO cliente (criadoEm, atualizadoEm, cliente_nome, cliente_celular, cliente_email, cliente_cpf) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$clienteNome', '$clienteCelular', '$clienteEmail', '$clienteCPF')";

            $conecta->exec($sql_insert);

            include_once'menu/nav_sub_menu_estoque.html';

            echo "<span style='color: black; margin-left: 60px;'> Cliente cadastrado com sucesso!</span></br></br></br>";

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
      }
    break;


    //Inicio Salvar Fabricante
    case 'salvarFabricante':
      if ($link == "salvarFabricante") {

        if(isset($_GET['fabricanteNome'])){

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm       = date ("Y-m-d H:i:s");
          $atualizadoEm   = date ("Y-m-d H:i:s");
          $fabricanteNome = $_GET['fabricanteNome'];

          try{

            $sql_insert  = "INSERT INTO prod_fabricante (criadoEm, atualizadoEm, fabricante_nome) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$fabricanteNome')";

            $conecta->exec($sql_insert);

            include_once'menu/nav_sub_menu_estoque.html';

            echo "<span style='color: black; margin-left: 60px;'> Fabricante cadastrado com sucesso!</span></br></br></br>";

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
      }
    break;

    //Inicio Salvar Fornecedor
    case 'salvarFornecedor':
      if ($link == "salvarFornecedor") {

        if(isset($_GET['fornecedorNome'])){

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm       = date ("Y-m-d H:i:s");
          $atualizadoEm   = date ("Y-m-d H:i:s");
          $fornecedorNome = $_GET['fornecedorNome'];

          try{

            $sql_insert  = "INSERT INTO prod_fornecedor (criadoEm, atualizadoEm, fornecedor_nome) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$fornecedorNome')";

            $conecta->exec($sql_insert);

            include_once'menu/nav_sub_menu_estoque.html';

            echo "<span style='color: black; margin-left: 60px;'> Fornecedor cadastrado com sucesso!</span></br></br></br>";

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
      }
    break;


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


    //Inicio Salvar SubCategoria
    case 'salvarSubcategoria':
      if ($link == "salvarSubcategoria") {

        if(isset($_GET['subcategoriaNome'])){

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm         = date ("Y-m-d H:i:s");
          $atualizadoEm     = date ("Y-m-d H:i:s");
          $subcategoriaNome = $_GET['subcategoriaNome'];
          $idCategoria      = $_GET['idCategoria'];

          try{

            $sql_insert  = "INSERT INTO prod_sub_categoria (criadoEm, atualizadoEm, sub_categoria_nome, id_categoria) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$subcategoriaNome', '$idCategoria')";

            $conecta->exec($sql_insert);

            include_once'menu/nav_sub_menu_estoque.html';

            echo "<span style='color: black; margin-left: 60px;'> Sub-Categoria cadastrada com sucesso!</span></br></br></br>";

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
      }
    break;


    //Inicio Salvar Produto
    case 'salvarProduto':
      if ($link == "salvarProduto") {

        if(isset($_GET['prodModelo'])){

          date_default_timezone_set('America/Sao_Paulo');

          $criadoEm       = date ("Y-m-d H:i:s");
          $atualizadoEm   = date ("Y-m-d H:i:s");
          $idSubcategoria = $_GET['idSubcategoria'];
          $prodModelo     = $_GET['prodModelo'];
          $prodDescricao  = $_GET['prodDescricao'];
          $prodCusto      = $_GET['prodCusto'];
          $idFabricante   = $_GET['idFabricante'];
          $idFornecedor   = $_GET['idFornecedor'];

          try{

            $sql_insert  = "INSERT INTO produtos (criadoEm, atualizadoEm, id_subcategoria, prod_modelo, prod_descricao, prod_custo, id_fabricante, id_fornecedor) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$idSubcategoria', '$prodModelo', '$prodDescricao', '$prodCusto', '$idFabricante', '$idFornecedor')";

            $conecta->exec($sql_insert);

            include_once'menu/nav_sub_menu_estoque.html';

            echo "<span style='color: black; margin-left: 60px;'> Produto cadastrado com sucesso!</span></br></br></br>";

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

        }
      }
    break;
    //Fim Cadastro Salvar


    //Inicio Constultas
    case 'consultas':
      if ($link == "consultas") {

        include_once'menu/nav_sub_menu_estoque_consulta.html';
      
      }
    break;

    
    //Inicio Consulta Cliente
    case 'consultaCliente':
      if ($link == "consultaCliente") {
      
        echo '<div class="col-md-12 mb-3">';

        // Consulta pessoas
        $sql_select = "SELECT * FROM cliente";

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
            <a href="estoque.php?link=cadastroCliente" style="text-decoration: none;">[+] Adicionar Novo</a>
            <a href="clientepdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Celuar</th>
                <th scope="col">E-mail</th>
                <th scope="col">CPF</th>
                <th scope="col"></th>
              </tr>
            </thead>
  <?php

          foreach($resultado_query as $res){

            $clienteId          = $res['id'];
            $clienteNome        = $res['cliente_nome'];
            $clienteCelular     = $res['cliente_celular'];
            $clienteEmail       = $res['cliente_email'];
            $clienteCPF         = $res['cliente_cpf'];


            echo "<tbody> <tr> <th scope='row'>".$clienteId."</th> <td>".$clienteNome."</td> <td>".$clienteCelular."</td> <td>".$clienteEmail."</td> <td>".$clienteCPF."</td> <td> <a href='estoque.php?link=editarCliente&id=".$clienteId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='estoque.php?link=pre_excluirCliente&id=".$clienteId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
          }
        }
          
          include_once 'estoque_cliente_pdf.php';

  ?>
          </div>
          </table>

  <?php
      
      }
    break;


    //Inicio consulta Fabricante
    case 'consultaFabricante':
      if ($link == "consultaFabricante") {
      
        echo '<div class="col-md-12 mb-3">';

        // Consulta pessoas
        $sql_select = "SELECT * FROM prod_fabricante";

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
            <a href="estoque.php?link=cadastroFabricante" style="text-decoration: none;">[+] Adicionar Novo</a>
            <a href="fabricantepdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col"></th>
              </tr>
            </thead>
  <?php

          foreach($resultado_query as $res){

            $fabricanteId     = $res['id'];
            $fabricanteNome   = $res['fabricante_nome'];


            echo "<tbody> <tr> <th scope='row'>".$fabricanteId."</th> <td>".$fabricanteNome."</td> <td> <a href='estoque.php?link=editarFabricante&id=".$fabricanteId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='estoque.php?link=pre_excluirFabricante&id=".$fabricanteId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
          }
        }
          
          include_once 'estoque_fabricante_pdf.php';

  ?>
          </div>
          </table>

  <?php
      
      }
    break;



    //Inicio consulta Fornecedor
    case 'consultaFornecedor':
      if ($link == "consultaFornecedor") {
      
        echo '<div class="col-md-12 mb-3">';

        // Consulta pessoas
        $sql_select = "SELECT * FROM prod_fornecedor";

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
            <a href="estoque.php?link=cadastroFornecedor" style="text-decoration: none;">[+] Adicionar Novo</a>
            <a href="fornecedorpdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col"></th>
              </tr>
            </thead>
  <?php

          foreach($resultado_query as $res){

            $fornecedorId     = $res['id'];
            $fornecedorNome   = $res['fornecedor_nome'];


            echo "<tbody> <tr> <th scope='row'>".$fornecedorId."</th> <td>".$fornecedorNome."</td> <td> <a href='estoque.php?link=editarFornecedor&id=".$fornecedorId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='estoque.php?link=pre_excluirFornecedor&id=".$fornecedorId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
          }
        }
          
          include_once 'estoque_fornecedor_pdf.php';

  ?>
          </div>
          </table>

  <?php
      
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



    //Inicio consulta Sub-Categoria
    case 'consultaSubcategoria':
      if ($link == "consultaSubcategoria") {
      
        echo '<div class="col-md-12 mb-3">';

        // Consulta pessoas
        $sql_select = "SELECT * FROM prod_sub_categoria";

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
            <a href="estoque.php?link=cadastroSubcategoria" style="text-decoration: none;">[+] Adicionar Novo</a>
            <a href="prodsubcategoriapdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
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

            $subcategoriaId     = $res['id'];
            $subcategoriaNome   = $res['sub_categoria_nome'];


            echo "<tbody> <tr> <th scope='row'>".$subcategoriaId."</th> <td>".$subcategoriaNome."</td> <td> <a href='estoque.php?link=editarSubcategoria&id=".$subcategoriaId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='estoque.php?link=pre_excluirSubcategoria&id=".$subcategoriaId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
          }
        }
          
          include_once 'estoque_subcategoria_pdf.php';

  ?>
          </div>
          </table>

  <?php
      
      }
    break;


    //Inicio Consulta Produto
    case 'consultaProduto':
      if ($link == "consultaProduto") {
      
        echo '<div class="col-md-12 mb-3">';

        // Consulta produto
        $sql_select = "SELECT * FROM produtos";

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
            <a href="estoque.php?link=cadastroProduto" style="text-decoration: none;">[+] Adicionar Novo</a>
            <a href="produtopdf.php" style="text-decoration: none;" target="_blank">&nbsp;&nbsp;&nbsp;[-] Imprimir</a>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Modelo</th>
                <th scope="col">Descrição</th>
                <th scope="col">Sub-Categoria</th>
                <th scope="col">Fabricante</th>
                <th scope="col">Custo</th>
                <th scope="col"></th>
              </tr>
            </thead>
  <?php

          foreach($resultado_query as $res){

            $produtoId            = $res['id'];
            $produtoModelo        = $res['prod_modelo'];
            $produtoDescricao     = $res['prod_descricao'];
            $produtoSubCategoria  = $res['id_subcategoria'];
            $produtoFabricante    = $res['id_fabricante'];
            $produtoCusto         = $res['prod_custo'];


            //Inicio da seleção da SubCategoria
            $sql_select_subcat = "SELECT * FROM prod_sub_categoria WHERE id = $produtoSubCategoria";

            try{

              $query_select_subcat = $conecta->prepare($sql_select_subcat);
              $query_select_subcat->execute();

              $resultado_query_subcat = $query_select_subcat->fetchAll(PDO::FETCH_ASSOC);

            } catch(PDOexception $error_select_subcat) {
              echo 'Erro ao selecionar'.$error_insert_subcato->getMessage();
            }

            foreach($resultado_query_subcat as $res_subcat){

                $subcatNome   = $res_subcat['sub_categoria_nome'];

            }
            //Fim seleção subCategoria


            //Inicio da seleção da fabricante
            $sql_select_fabr = "SELECT * FROM prod_fabricante WHERE id = $produtoFabricante";

            try{

              $query_select_fabr = $conecta->prepare($sql_select_fabr);
              $query_select_fabr->execute();

              $resultado_query_fabr = $query_select_fabr->fetchAll(PDO::FETCH_ASSOC);

            } catch(PDOexception $error_select_fabr) {
              echo 'Erro ao selecionar'.$error_insert_fabr->getMessage();
            }

            foreach($resultado_query_fabr as $res_fabr){

                $fabrNome   = $res_fabr['fabricante_nome'];

            }
            //Fim seleção fabricante


            echo "<tbody> <tr> <th scope='row'>".$produtoId."</th> <td>".$produtoModelo."</td> <td>".$produtoDescricao."</td> <td>".$subcatNome."</td> <td>".$fabrNome."</td> <td>".$produtoCusto."</td> <td> <a href='estoque.php?link=editarProduto&id=".$produtoId."'> <span class='material-icons' style='color: #000;'>mode_edit</span> </a> <a href='estoque.php?link=pre_excluirProduto&id=".$produtoId."'> <span class='material-icons' style='color: #000;'>delete</span> </a> </td> </tr>";
            
          }
        }
          
          include_once 'estoque_produto_pdf.php';

  ?>
          </div>
          </table>

  <?php
      
      }
    break;



    //Inicio Editar
    //Editar Cliente
    case 'editarCliente':
      if ($link == "editarCliente") {

        if(isset($_GET['id'])){

          $clienteId  = $_GET['id'];

          // Consulta empresas
          $sql_select = "SELECT * FROM cliente WHERE id = $clienteId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

            $clienteId      = $res['id'];
            $clienteNome    = $res['cliente_nome'];
            $clienteCelular = $res['cliente_celular'];
            $clienteEmail   = $res['cliente_email'];
            $clienteCPF     = $res['cliente_cpf'];
          }

          include_once'form_edit_cliente.html';
      
        } else {
          echo 'Nada';
        }
      }
    break;


    //Editar Fabricante
    case 'editarFabricante':
      if ($link == "editarFabricante") {

        if(isset($_GET['id'])){

          $fabricanteId = $_GET['id'];

          // Consulta empresas
          $sql_select = "SELECT * FROM prod_fabricante WHERE id = $fabricanteId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

            $fabricanteId   = $res['id'];
            $fabricanteNome = $res['fabricante_nome'];

          }

          include_once'form_edit_fabricante.html';
      
        } else {
          echo 'Nada';
        }
      }
    break;


    //Editar Fornecedor
    case 'editarFornecedor':
      if ($link == "editarFornecedor") {

        if(isset($_GET['id'])){

          $fornecedorId = $_GET['id'];

          // Consulta empresas
          $sql_select = "SELECT * FROM prod_fornecedor WHERE id = $fornecedorId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

            $fornecedorId   = $res['id'];
            $fornecedorNome = $res['fornecedor_nome'];

          }

          include_once'form_edit_fornecedor.html';
      
        } else {
          echo 'Nada';
        }
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


    //Editar Sub-Categoria
    case 'editarSubcategoria':
      if ($link == "editarSubcategoria") {

        if(isset($_GET['id'])){

          $subcategoriaId = $_GET['id'];

          // Consulta empresas
          $sql_select = "SELECT * FROM prod_sub_categoria WHERE id = $subcategoriaId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

            $subcategoriaId   = $res['id'];
            $subcategoriaNome = $res['sub_categoria_nome'];
            $categoriaNome    = $res['id_categoria'];

          }

          include_once'form_edit_subcategoria.html';
      
        } else {
          echo 'Nada';
        }
      }
    break;



    //Editar Produto
    case 'editarProduto':
      if ($link == "editarProduto") {

        if(isset($_GET['id'])){

          $produtoId = $_GET['id'];

          // Consulta empresas
          $sql_select = "SELECT * FROM produtos WHERE id = $produtoId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

            $produtoId        = $res['id'];
            $id_subcategoria  = $res['id_subcategoria'];
            $produtoModelo    = $res['prod_modelo'];
            $produtoDescricao = $res['prod_descricao'];
            $produtoCusto     = $res['prod_custo'];
            $id_fabricante    = $res['id_fabricante'];
            $id_fornecedor    = $res['id_fornecedor'];

          }

          include_once'form_edit_produto.html';
      
        } else {
          echo 'Nada';
        }
      }
    break;
    //Fim Editar


    //Inicio Atualizar
    //Atualizar Cliente
    case 'atualizarCliente':
      if ($link == "atualizarCliente") {

        if(isset($_GET['clienteId'])){

          date_default_timezone_set('America/Sao_Paulo');
          $atualizadoEmR  = date ("Y-m-d H:i:s");
          $clienteIdR     = $_GET['clienteId'];
          $clienteNomeR   = $_GET['clienteNome'];
          $clienteCelularR= $_GET['clienteCelular'];
          $clienteEmailR  = $_GET['clienteEmail'];
          $clienteCPFR    = $_GET['clienteCPF'];

          try{

            $sql_update  = "UPDATE cliente SET atualizadoEm = '".$atualizadoEmR."', cliente_nome = '".$clienteNomeR."', cliente_celular = '".$clienteCelularR."', cliente_email = '".$clienteEmailR."', cliente_cpf = '".$clienteCPFR."' WHERE id = ".$clienteIdR." "; 

            $conecta->exec($sql_update);

            echo '<span> Cliente atualizada com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaCliente">Ver todos</a>';

          } catch(PDOexception $error_update) {
            echo 'Erro ao atualizar'.$error_update->getMessage();
          }

        } 
      }
    break;


    //Atualizar Fabricante
    case 'atualizarFabricante':
      if ($link == "atualizarFabricante") {

        if(isset($_GET['fabricanteId'])){

          date_default_timezone_set('America/Sao_Paulo');
          $atualizadoEmR  = date ("Y-m-d H:i:s");
          $fabricanteIdR     = $_GET['fabricanteId'];
          $fabricanteNomeR   = $_GET['fabricanteNome'];

          try{

            $sql_update  = "UPDATE prod_fabricante SET atualizadoEm = '".$atualizadoEmR."', fabricante_nome = '".$fabricanteNomeR."' WHERE id = ".$fabricanteIdR." "; 

            $conecta->exec($sql_update);

            echo '<span> Fabricante atualizada com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaFabricante">Ver todos</a>';

          } catch(PDOexception $error_update) {
            echo 'Erro ao atualizar'.$error_update->getMessage();
          }

        } 
      }
    break;


    //Atualizar Fornecedor
    case 'atualizarFornecedor':
      if ($link == "atualizarFornecedor") {

        if(isset($_GET['fornecedorId'])){

          date_default_timezone_set('America/Sao_Paulo');
          $atualizadoEmR  = date ("Y-m-d H:i:s");
          $fornecedorIdR     = $_GET['fornecedorId'];
          $fornecedorNomeR   = $_GET['fornecedorNome'];

          try{

            $sql_update  = "UPDATE prod_fornecedor SET atualizadoEm = '".$atualizadoEmR."', fornecedor_nome = '".$fornecedorNomeR."' WHERE id = ".$fornecedorIdR." "; 

            $conecta->exec($sql_update);

            echo '<span> Fornecedor atualizada com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaFornecedor">Ver todos</a>';

          } catch(PDOexception $error_update) {
            echo 'Erro ao atualizar'.$error_update->getMessage();
          }

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


    //Atualizar Sub-Categoria
    case 'atualizarSubcategoria':
      if ($link == "atualizarSubcategoria") {

        if(isset($_GET['subcategoriaId'])){

          date_default_timezone_set('America/Sao_Paulo');
          $atualizadoEmR        = date ("Y-m-d H:i:s");
          $subcategoriaIdR      = $_GET['subcategoriaId'];
          $subcategoriaNomeR    = $_GET['subcategoriaNome'];
          $idCategoriaR         = $_GET['idCategoria'];

          try{

            $sql_update  = "UPDATE prod_sub_categoria SET atualizadoEm = '".$atualizadoEmR."', sub_categoria_nome = '".$subcategoriaNomeR."', id_categoria = '".$idCategoriaR."' WHERE id = ".$subcategoriaIdR." "; 

            $conecta->exec($sql_update);

            echo '<span> Sub-Categoria atualizada com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaSubcategoria">Ver todos</a>';

          } catch(PDOexception $error_update) {
            echo 'Erro ao atualizar'.$error_update->getMessage();
          }

        } 
      }
    break;


    //Atualizar Produto
    case 'atualizarProduto':
      if ($link == "atualizarProduto") {

        if(isset($_GET['produtoId'])){

          date_default_timezone_set('America/Sao_Paulo');
          $atualizadoEmR      = date ("Y-m-d H:i:s");
          $produtoIdR         = $_GET['produtoId'];
          $idSubategoriaR     = $_GET['idSubcategoria'];
          $produtoModeloR     = $_GET['produtoModelo'];
          $produtoDescricaoR  = $_GET['produtoDescricao'];
          $produtoCustoR      = $_GET['produtoCusto'];
          $idFabricanteR      = $_GET['idFabricante'];
          $idFornecedorR      = $_GET['idFornecedor'];

          try{

            $sql_update  = "UPDATE produtos SET atualizadoEm = '".$atualizadoEmR."', id_subcategoria = '".$idSubategoriaR."', prod_modelo = '".$produtoModeloR."', prod_descricao = '".$produtoDescricaoR."', prod_custo = '".$produtoCustoR."', id_fabricante = '".$idFabricanteR."', id_fornecedor = '".$idFornecedorR."' WHERE id = ".$produtoIdR." "; 

            $conecta->exec($sql_update);

            echo '<span> Produto atualizada com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaProduto">Ver todos</a>';

          } catch(PDOexception $error_update) {
            echo 'Erro ao atualizar'.$error_update->getMessage();
          }

        } 
      }
    break;
    //Fim Atualizar



    //Inicio pre-excluir
    //Inicio pre-excluirCliente
    case 'pre_excluirCliente':
      if ($link == "pre_excluirCliente") {

        if(isset($_GET['id'])){

          $clienteId  = $_GET['id'];

          // Consulta categoias
          $sql_select = "SELECT * FROM cliente WHERE id = $clienteId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

              $clienteId     = $res['id'];
              $clienteNome   = $res['cliente_nome'];
              $clienteCPF    = $res['cliente_cpf'];


              echo "
                <div class='col-md-12 mb-3'>
                  <h1>Cliente</h1>
                  <h4>Tem certeza que deseja excluir este registro?</h4>
                </div>
                <div class='col-md-12 mb-3'>
                  <form name='cliente' action='estoque.php' method='GET'>
                    <div class='form-row'>
                      <div class='col-md-3 mb-3'>
                        <span class='form-control'>".$clienteNome."</span>
                      </div>
                      <div class='col-md-3 mb-3'>
                        <span class='form-control'>".$clienteCPF."</span>
                        <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluirCliente' >
                        <input type='hidden' class='form-control is-valid' id='validationServer03' name='clienteId' value=".$clienteId." >
                      </div>
                      <div class='col-md-2' mb-3>
                        <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                      </div>
                    </div>
                  </form>
                  <form action='estoque.php' method=get >
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='consultaCliente' >
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
                  </form>
                </div>";
          }
      
        } else {
          echo 'Nada';
        }
      
      }
    break;


    //Inicio pre-excluirFabricante
    case 'pre_excluirFabricante':
      if ($link == "pre_excluirFabricante") {

        if(isset($_GET['id'])){

          $fabricanteId  = $_GET['id'];

          // Consulta categoias
          $sql_select = "SELECT * FROM prod_fabricante WHERE id = $fabricanteId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

              $fabricanteId     = $res['id'];
              $fabricanteNome   = $res['fabricante_nome'];


              echo "
                <div class='col-md-12 mb-3'>
                  <h1>Fabricante</h1>
                  <h4>Tem certeza que deseja excluir este registro?</h4>
                </div>
                <div class='col-md-12 mb-3'>
                  <form name='fabricante' action='estoque.php' method='GET'>
                    <div class='form-row'>
                      <div class='col-md-3 mb-3'>
                        <span class='form-control'>".$fabricanteNome."</span>
                      </div>
                      <div class='col-md-3 mb-3'>
                        <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluirFabricante' >
                        <input type='hidden' class='form-control is-valid' id='validationServer03' name='fabricanteId' value=".$fabricanteId." >
                      </div>
                      <div class='col-md-2' mb-3>
                        <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                      </div>
                    </div>
                  </form>
                  <form action='estoque.php' method=get >
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='consultaFabricante' >
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
                  </form>
                </div>";
          }
      
        } else {
          echo 'Nada';
        }
      
      }
    break;


    //Inicio pre-excluirFornecedor
    case 'pre_excluirFornecedor':
      if ($link == "pre_excluirFornecedor") {

        if(isset($_GET['id'])){

          $fornecedorId  = $_GET['id'];

          // Consulta categoias
          $sql_select = "SELECT * FROM prod_fornecedor WHERE id = $fornecedorId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

              $fornecedorId     = $res['id'];
              $fornecedorNome   = $res['fornecedor_nome'];


              echo "
                <div class='col-md-12 mb-3'>
                  <h1>Fornecedor</h1>
                  <h4>Tem certeza que deseja excluir este registro?</h4>
                </div>
                <div class='col-md-12 mb-3'>
                  <form name='fornecedor' action='estoque.php' method='GET'>
                    <div class='form-row'>
                      <div class='col-md-3 mb-3'>
                        <span class='form-control'>".$fornecedorNome."</span>
                      </div>
                      <div class='col-md-3 mb-3'>
                        <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluirFornecedor' >
                        <input type='hidden' class='form-control is-valid' id='validationServer03' name='fornecedorId' value=".$fornecedorId." >
                      </div>
                      <div class='col-md-2' mb-3>
                        <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                      </div>
                    </div>
                  </form>
                  <form action='estoque.php' method=get >
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='consultaFornecedor' >
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
                  </form>
                </div>";
          }
      
        } else {
          echo 'Nada';
        }
      
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


    //Inicio pre-excluirSubcategoria
    case 'pre_excluirSubcategoria':
      if ($link == "pre_excluirSubcategoria") {

        if(isset($_GET['id'])){

          $subcategoriaId  = $_GET['id'];

          // Consulta categoias
          $sql_select = "SELECT * FROM prod_sub_categoria WHERE id = $subcategoriaId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

              $subcategoriaId     = $res['id'];
              $subcategoriaNome   = $res['sub_categoria_nome'];


              echo "
                <div class='col-md-12 mb-3'>
                  <h1>Sub-Categoria</h1>
                  <h4>Tem certeza que deseja excluir este registro?</h4>
                </div>
                <div class='col-md-12 mb-3'>
                  <form name='subcategoria' action='estoque.php' method='GET'>
                    <div class='form-row'>
                      <div class='col-md-3 mb-3'>
                        <span class='form-control'>".$subcategoriaNome."</span>
                      </div>
                      <div class='col-md-3 mb-3'>
                        <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluirSubcategoria' >
                        <input type='hidden' class='form-control is-valid' id='validationServer03' name='subcategoriaId' value=".$subcategoriaId." >
                      </div>
                      <div class='col-md-2' mb-3>
                        <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                      </div>
                    </div>
                  </form>
                  <form action='estoque.php' method=get >
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='consultaSubcategoria' >
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
                  </form>
                </div>";
          }
      
        } else {
          echo 'Nada';
        }
      
      }
    break;



    //Inicio pre-excluirProduto
    case 'pre_excluirProduto':
      if ($link == "pre_excluirProduto") {

        if(isset($_GET['id'])){

          $produtoId  = $_GET['id'];

          // Consulta categoias
          $sql_select = "SELECT * FROM produtos WHERE id = $produtoId";

          try{

            $query_select = $conecta->prepare($sql_select);
            $query_select->execute();

            $resultado_query = $query_select->fetchAll(PDO::FETCH_ASSOC);
            $count = $query_select->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select) {
            echo 'Erro ao selecionar'.$error_insert->getMessage();
          }

          foreach($resultado_query as $res){

              $produtoId     = $res['id'];
              $produtoModelo = $res['prod_modelo'];


              echo "
                <div class='col-md-12 mb-3'>
                  <h1>Sub-Categoria</h1>
                  <h4>Tem certeza que deseja excluir este registro?</h4>
                </div>
                <div class='col-md-12 mb-3'>
                  <form name='subcategoria' action='estoque.php' method='GET'>
                    <div class='form-row'>
                      <div class='col-md-3 mb-3'>
                        <span class='form-control'>".$produtoModelo."</span>
                      </div>
                      <div class='col-md-3 mb-3'>
                        <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='excluirProduto' >
                        <input type='hidden' class='form-control is-valid' id='validationServer03' name='produtoId' value=".$produtoId." >
                      </div>
                      <div class='col-md-2' mb-3>
                        <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Excluir</button>
                      </div>
                    </div>
                  </form>
                  <form action='estoque.php' method=get >
                    <input type='hidden' class='form-control is-valid' id='validationServer02' name='link' value='consultaProduto' >
                    <button class='btn btn-primary' type='submit' style='padding-top: 15px;'>Não</button>
                  </form>
                </div>";
          }
      
        } else {
          echo 'Nada';
        }
      
      }
    break;
    //Fim pre-excluir



    //Inicio Excluir
    //Inicio ExcluirCliente
    case 'excluirCliente':
      if ($link == "excluirCliente") {

        if(isset($_GET['clienteId'])){

          date_default_timezone_set('America/Sao_Paulo');

          $clienteId = $_GET['clienteId'];

          try{

            $sql_delete  = "DELETE FROM cliente WHERE id = '$clienteId'"; 

            $conecta->exec($sql_delete);

            echo '<span> Registro excluido com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaCliente">Ver todos</a>';

          } catch(PDOexception $error_delete) {
            echo 'Erro ao excluir'.$error_delete->getMessage();
          }

        }
      }
    break;


    //Inicio ExcluirFabricante
    case 'excluirFabricante':
      if ($link == "excluirFabricante") {

        if(isset($_GET['fabricanteId'])){

          date_default_timezone_set('America/Sao_Paulo');

          $fabricanteId = $_GET['fabricanteId'];

          try{

            $sql_delete  = "DELETE FROM prod_fabricante WHERE id = '$fabricanteId'"; 

            $conecta->exec($sql_delete);

            echo '<span> Registro excluido com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaFabricante">Ver todos</a>';

          } catch(PDOexception $error_delete) {
            echo 'Erro ao excluir'.$error_delete->getMessage();
          }

        }
      }
    break;


    //Inicio ExcluirFornecedor
    case 'excluirFornecedor':
      if ($link == "excluirFornecedor") {

        if(isset($_GET['fornecedorId'])){

          date_default_timezone_set('America/Sao_Paulo');

          $fornecedorId = $_GET['fornecedorId'];

          try{

            $sql_delete  = "DELETE FROM prod_fornecedor WHERE id = '$fornecedorId'"; 

            $conecta->exec($sql_delete);

            echo '<span> Registro excluido com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaFornecedor">Ver todos</a>';

          } catch(PDOexception $error_delete) {
            echo 'Erro ao excluir'.$error_delete->getMessage();
          }

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


    //Inicio ExcluirSubcategoria
    case 'excluirSubcategoria':
      if ($link == "excluirSubcategoria") {

        if(isset($_GET['subcategoriaId'])){

          date_default_timezone_set('America/Sao_Paulo');

          $subcategoriaId = $_GET['subcategoriaId'];

          try{

            $sql_delete  = "DELETE FROM prod_sub_categoria WHERE id = '$subcategoriaId'"; 

            $conecta->exec($sql_delete);

            echo '<span> Registro excluido com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaSubcategoria">Ver todos</a>';

          } catch(PDOexception $error_delete) {
            echo 'Erro ao excluir'.$error_delete->getMessage();
          }

        }
      }
    break;


    //Inicio ExcluirProduto
    case 'excluirProduto':
      if ($link == "excluirProduto") {

        if(isset($_GET['produtoId'])){

          date_default_timezone_set('America/Sao_Paulo');

          $produtoId = $_GET['produtoId'];

          try{

            $sql_delete  = "DELETE FROM produtos WHERE id = '$produtoId'"; 

            $conecta->exec($sql_delete);

            echo '<span> Registro excluido com sucesso!</span></br></br></br>';

            echo '<a href="estoque.php?link=consultaProduto">Ver todos</a>';

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