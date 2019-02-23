<?php

if (isset($_GET['link'])) {
  $link = $_GET['link'];
} else {
  $link = "nulo";
}

//$link = $_GET['link'];

switch ($link) {

  case 'nulo':
  
    echo "<div class='col-12 col-md-12 text-center'>
    Cadastro realizado com sucesso, ir para página de <a href='index.php'> login.</a>
    </div>";
  
    break;
  
  case 'novo':
    if ($link == "novo") {

?>
  <!-- style="background-color: rgba(000,000,000,0.4); border: 1px solid #FFF; border-radius: 10px; height: 400px; padding-top: 30px;" -->
    <div class="col-12 col-md-12 text-center" >

      <h1 class="display-3 text-center text-white">Você é?</h1>
        <div class="col-12 col-md-12" style="margin-top: 30px;"></div>

        <!--div class="col-5 col-md-12" style="background-color: rgba(255,255,255,0.1); border: 1px #000 solid; padding: 100px 0 100px 0; border-radius: 10px;"-->
        <div class="col-5 col-md-12">
          <!--span class="col-12 col-md-12 text-white">Cliente</span>
          <a href="registro.php?link=pessoaFisica" class="btn btn-info btn-lg" role="button" aria-disabled="true" style="font-size: 12px;">Pessoa Física</a>
          <a href="registro.php?link=pessoaJuridica" class="btn btn-secondary btn-lg" role="button" aria-disabled="true" style="font-size: 12px;">Pessoa Jurídica</a>
        
          <span class="col-12 col-md-12 text-white">Profissional</span-->
          <a href="registro.php?link=parceiroPL" class="btn btn-info btn-lg col-5" role="button" aria-disabled="true">Profissional Liberal</a>
          <a href="registro.php?link=parceiroPJ" class="btn btn-secondary btn-lg col-5" role="button" aria-disabled="true" style="margin-left: 30px;">Pessoa Jurídica</a>
        </div>
        
    </div>
    
    <?php 
    }
    break;
  
  
  //Inicio Novo
  case 'pessoaFisica':
    if ($link == "pessoaFisica") {

    include_once'form_pessoa_fisica.html';

    break;
  }

  //Inicio Salvar
  case 'salvarClientePF':
    if ($link == "salvarClientePF") {

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
        $pessoaTipo    = "cliente";
        $dataInvertida = inverteData($pessoaNasc);


        // Consulta CPF existente
        $sql_select_cpf = "SELECT pessoaCpf FROM pessoas WHERE pessoaCpf = $pessoaCPF";

        try{

          $query_select_cpf = $conecta->prepare($sql_select_cpf);
          $query_select_cpf->execute();

          $resultado_query_cpf = $query_select_cpf->fetchAll(PDO::FETCH_ASSOC);
          $count_cpf = $query_select_cpf->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_cpf) {
          echo 'Erro ao selecionar'.$error_select_cpf->getMessage();
        }

        //Se CPF existir, mostra o link para página de Login
        if ($count_cpf > 0) {

          echo "Conta existente para esse CPF. Voltar para página de <a href='index.php'>Login</a>.";

        } else {

          try{

            $sql_insert  = "INSERT INTO pessoas (criadoEm, atualizadoEm, pessoaNome, pessoaEmail, pessoaTel, pessoaCpf, pessoaNasc, idCategoria, idEmpresa, pessoaTipo) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$pessoaNome', '$pessoaEmail', '$pessoaTel', '$pessoaCPF', '$dataInvertida', '$pessoaProfissao', '$pessoaEmpresa', '$pessoaTipo')";

            $conecta->exec($sql_insert);

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

          ?>

          <div class="row align-items-center">
            <div class="col">
              <!-- texto -->
            </div>
            <div class="col">
              <?php 
                include_once'controller/form_usuario_senha.html';
              ?>
            </div>
            <div class="col">
              <!-- texto -->
            </div>
          </div>
          <?php
          }

        }
    break;
  }

  case 'pessoaJuridica':
    if ($link == "pessoaJuridica") {

    include_once'form_pessoa_juridica.html';

    break;
  }

  //Inicio SalvarPJ
  case 'salvarClientePJ':
    if ($link == "salvarClientePJ") {

      if(isset($_GET['empresaNome'])){

        date_default_timezone_set('America/Sao_Paulo');

        $criadoEm       = date ("Y-m-d H:i:s");
        $atualizadoEm   = date ("Y-m-d H:i:s");
        $empresaNome    = $_GET['empresaNome'];
        $empresaCNPJ    = $_GET['empresaCnpj'];
        $empresaTel     = $_GET['empresaTel'];
        $empresaContato = $_GET['empresaContato'];
        $empresaEmail   = $_GET['empresaEmail'];
        $empresaCidade  = $_GET['empresaCidade'];
        $empresaEstado  = $_GET['empresaEstado'];
        $empresaCep     = $_GET['empresaCep'];
        $empresaSeg     = $_GET['empresaSeg'];
        $empresaTipo    = "cliente";

        // Consulta CPF existente
        $sql_select_cnpj = "SELECT empresaCnpj FROM empresas WHERE empresaCnpj = $empresaCNPJ";

        try{

          $query_select_cnpj = $conecta->prepare($sql_select_cnpj);
          $query_select_cnpj->execute();

          $resultado_query_cnpj = $query_select_cnpj->fetchAll(PDO::FETCH_ASSOC);
          $count_cnpj = $query_select_cnpj->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_cnpj) {
          echo 'Erro ao selecionar'.$error_select_cnpj->getMessage();
        }

        //Se CNPJ existir, mostra o link para página de Login
        if ($count_cnpj > 0) {

          echo "Conta existente para esse CNPJ. Voltar para página de <a href='index.php'>Login</a>.";

        } else {

          try{

            $sql_insert  = "INSERT INTO empresas (criadoEm, atualizadoEm, empresaNome, empresaCnpj, empresaTel, empresaEmail, empresaCidade, empresaEstado, empresaCep, empresaContato, idSegmento, empresaTipo) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$empresaNome', '$empresaCNPJ', '$empresaTel', '$empresaEmail', '$empresaCidade', '$empresaEstado', '$empresaCep', '$empresaContato', '$empresaSeg', '$empresaTipo')";

            $conecta->exec($sql_insert);

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }
          ?>

          <div class="row align-items-center">
              <div class="col">
                <!-- texto -->
              </div>
              <div class="col">
                <?php 
                $pessoaNome = $empresaNome;
                $pessoaEmail = $empresaEmail;
                  include_once'controller/form_usuario_senha.html';
                ?>
              </div>
              <div class="col">
                <!-- texto -->
              </div>
            </div>
          <?php
        }

      }
    break;
  }

  //Inicio Novo
  case 'parceiroPL':
    if ($link == "parceiroPL") {

    include_once'form_parceiro_pl.html';

    break;
  }

  //Inicio Salvar
  case 'salvarParceiroPL':
    if ($link == "salvarParceiroPL") {

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
        $pessoaTipo    = "parceiro";
        $dataInvertida = inverteData($pessoaNasc);


        // Consulta CPF existente
        $sql_select_cpf = "SELECT pessoaCpf FROM pessoas WHERE pessoaCpf = $pessoaCPF";

        try{

          $query_select_cpf = $conecta->prepare($sql_select_cpf);
          $query_select_cpf->execute();

          $resultado_query_cpf = $query_select_cpf->fetchAll(PDO::FETCH_ASSOC);
          $count_cpf = $query_select_cpf->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_cpf) {
          echo 'Erro ao selecionar'.$error_select_cpf->getMessage();
        }

        //Se CPF existir, mostra o link para página de Login
        if ($count_cpf > 0) {

          echo "Conta existente para esse CPF. Voltar para página de <a href='index.php'>Login</a>.";

        } else {

          try{

            $sql_insert  = "INSERT INTO pessoas (criadoEm, atualizadoEm, pessoaNome, pessoaEmail, pessoaTel, pessoaCpf, pessoaNasc, idCategoria, idEmpresa, pessoaTipo) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$pessoaNome', '$pessoaEmail', '$pessoaTel', '$pessoaCPF', '$dataInvertida', '$pessoaProfissao', '$pessoaEmpresa', '$pessoaTipo')";

            $conecta->exec($sql_insert);

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

          ?>

          <div class="row align-items-center">
            <div class="col">
              <!-- texto -->
            </div>
            <div class="col">
              <?php 
                include_once'controller/form_usuario_senha.html';
              ?>
            </div>
            <div class="col">
              <!-- texto -->
            </div>
          </div>
          <?php
          }

        }
    break;
  }


  //Inicio Novo
  case 'parceiroPJ':
    if ($link == "parceiroPJ") {

    include_once'form_parceiro_pj.html';

    break;
  }

  //Inicio SalvarPJ
  case 'salvarParceiroPJ':
    if ($link == "salvarParceiroPJ") {

      if(isset($_GET['empresaNome'])){

        date_default_timezone_set('America/Sao_Paulo');

        $criadoEm       = date ("Y-m-d H:i:s");
        $atualizadoEm   = date ("Y-m-d H:i:s");
        $empresaNome    = $_GET['empresaNome'];
        $empresaCNPJ    = $_GET['empresaCnpj'];
        $empresaTel     = $_GET['empresaTel'];
        $empresaContato = $_GET['empresaContato'];
        $empresaEmail   = $_GET['empresaEmail'];
        $empresaCidade  = $_GET['empresaCidade'];
        $empresaEstado  = $_GET['empresaEstado'];
        $empresaCep     = $_GET['empresaCep'];
        $empresaSeg     = $_GET['empresaSeg'];
        $empresaTipo    = "parceiro";

        // Consulta CPF existente
        $sql_select_cnpj = "SELECT empresaCnpj FROM empresas WHERE empresaCnpj = '$empresaCNPJ'";

        try{

          $query_select_cnpj = $conecta->prepare($sql_select_cnpj);
          $query_select_cnpj->execute();

          $resultado_query_cnpj = $query_select_cnpj->fetchAll(PDO::FETCH_ASSOC);
          $count_cnpj = $query_select_cnpj->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_cnpj) {
          echo 'Erro ao selecionar'.$error_select_cnpj->getMessage();
        }

        //Se CNPJ existir, mostra o link para página de Login
        if ($count_cnpj > 0) {

          echo "Conta existente para esse CNPJ. Voltar para página de <a href='index.php'>Login</a>.";

        } else {

          try{

            $sql_insert  = "INSERT INTO empresas (criadoEm, atualizadoEm, empresaNome, empresaCnpj, empresaTel, empresaEmail, empresaCidade, empresaEstado, empresaCep, empresaContato, idSegmento, empresaTipo) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$empresaNome', '$empresaCNPJ', '$empresaTel', '$empresaEmail', '$empresaCidade', '$empresaEstado', '$empresaCep', '$empresaContato', '$empresaSeg', '$empresaTipo')";

            $conecta->exec($sql_insert);

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }
          ?>

          <div class="row align-items-center">
              <div class="col">
                <!-- texto -->
              </div>
              <div class="col">
                <?php 
                  include_once'controller/form_usuario_senha.html';
                ?>
              </div>
              <div class="col">
                <!-- texto -->
              </div>
            </div>
          <?php
        }

      }
    break;
  }

  //Inicio emailParceiroPL
  case 'emailParceiroPL':
    if ($link == "emailParceiroPL") {

      //Salvar os dados na tabela Pessoas com Status aguardando
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
        $pessoaTipo    = "parceiro";
        $pessoaStatus  = "aguardando";
        $dataInvertida = inverteData($pessoaNasc);


        // Consulta CPF existente
        $sql_select_cpf = "SELECT pessoaCpf FROM pessoas WHERE pessoaCpf = $pessoaCPF";

        try{

          $query_select_cpf = $conecta->prepare($sql_select_cpf);
          $query_select_cpf->execute();

          $resultado_query_cpf = $query_select_cpf->fetchAll(PDO::FETCH_ASSOC);
          $count_cpf = $query_select_cpf->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_cpf) {
          echo 'Erro ao selecionar'.$error_select_cpf->getMessage();
        }

        //Se CPF existir, mostra o link para página de Login
        if ($count_cpf > 0) {

          echo "Conta existente para esse CPF. Voltar para página de <a href='index.php'>Login</a>.";

        } else {

          try{

            $sql_insert  = "INSERT INTO pessoas (criadoEm, atualizadoEm, pessoaNome, pessoaEmail, pessoaTel, pessoaCpf, pessoaNasc, idCategoria, idEmpresa, pessoaTipo, pessoaStatus) "; 
            $sql_insert .= "VALUES ('$criadoEm', '$atualizadoEm', '$pessoaNome', '$pessoaEmail', '$pessoaTel', '$pessoaCPF', '$dataInvertida', '$pessoaProfissao', '$pessoaEmpresa', '$pessoaTipo', '$pessoaStatus')";

            $conecta->exec($sql_insert);

          } catch(PDOexception $error_insert) {
            echo 'Erro ao cadastrar'.$error_insert->getMessage();
          }

          
        }

      }

      
      $email   = $_GET["pessoaEmail"];
      //echo $email;

      global $email; //função para validar a variável $email no script todo

      $data   = date("d/m/y");           //função para pegar a data de envio do e-mail
      $ip   = $_SERVER['REMOTE_ADDR'];       //função para pegar o ip do usuário
      $navegador = $_SERVER['HTTP_USER_AGENT'];    //função para pegar o navegador do visitante
      $hora   = date("H:i");             //para pegar a hora com a função date
      $assunto = "Teste";
      //aqui envia o e-mail para você
          $envia = mail ("rogeirofabricio@gmail.com",   //email aonde o php vai enviar os dados do form
          "$assunto", //Não altere é o assunto digitado no formulário html
          //Se você adicionou algum campo lá no inicio você deverá colocar logo abaixo também
          //para o script poder enviar corretamente para o seu email
          //Exemplo de como adicionar:  Campo_do_Formulário: $variável\n
          //A variável da sentença acima deve ser a mesma que você colocou para o campo no alto deste script \n é para quebrar a linha para baixo
          // lembre que se for adicionar no inicio da linha abaixo de não excluir as " aspas,
          // Se for no final também " deve ter aspas.
          //"Nome: $nome\nFone: $fone\nemail: $email\nCidade: $cidade\nAssunto: $assunto\nMensagem: $mensagem\n",
          "From: $email\n"
         );

      if ($envia) {
         //Header("location:obrigado.html?categoryid=10"); //essa é a página de obrigado.
         }
      else {
      echo "Problemas no envio, por favor tente novamente";
      echo "<a href='index.php'>Voltar</a>"; /*no lugar de index.htm, coloque
      a página para onde você deseja redirecionar caso o formulário apresente
      algum problema no preenchimento.
      */
      }

      //aqui são as configurações para enviar o e-mail para o visitante
      $site   = "XP Unlimited ThinNetworks";  //o e-mail que aparecerá na caixa postal do visitante
      $titulo = "XP Unlimited";  //titulo da mensagem enviada para o visitante
      $msg  = "Seu email foi recebido por nossos consultores. 

       Obrigado
       
       Atenciosamente,
       ThinNetworks
       www.xpunlimited.com.br";

      //aqui envia o e-mail de auto-resposta para o visitante
      mail("$email",
         "$titulo",
         "$msg",
         "From: $site"
        );

      
      
      
      echo "Voltar para <a href='index.php'>Login</a>.";

    }
    break;

  //Inicio SalvarEmailSenha
  case 'salvarEmaileSenha':
    if ($link == "salvarEmaileSenha") {

      if(isset($_GET['pessoaNome'])){

        date_default_timezone_set('America/Sao_Paulo');

        $pessoaNome   = $_GET['pessoaNome'];
        $pessoaEmail  = $_GET['pessoaEmail'];

        ?>

          <div class="row align-items-center">
            <div class="col">
              
            </div>
            <div class="col">
            <div style="margin: 0 0 70px 0; text-align: center; width: 300px;">
              Bem vindo(a), <?php echo $pessoaNome; ?>
            </div>
              <?php 
                include_once'controller/form_usuario_senha.html';
              ?>
            </div>
            <div class="col">
              <!-- texto -->
            </div>
          </div>
          <?php
          }

        }
    break;
  
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