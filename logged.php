<?php
/**
 * Copyright (C) 2013 peredur.net
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'dbConnect.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="assets/images/dg-logo-318x128-1-318x128.png" type="image/x-icon">
  <meta name="description" content="">
  <title>Zafiro</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&amp;subset=latin">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
  <link rel="stylesheet" href="assets/bootstrap-material-design-font/css/material.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/animate.css/animate.min.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="stylesheet" href="css/style.css">
  
  
</head>
<body>
<?php if (login_check($mysqli) == true) : ?>

<section id="menu-0">

    <div>
      <?php 
        $email = $_GET['email'];

        // Consulta e-mail do usuário
        $sql_select_email = "SELECT pessoaTipo FROM pessoas WHERE pessoaEmail = '$email' ";

        try{

          $query_select_email = $conecta->prepare($sql_select_email);
          $query_select_email->execute();

          $resultado_query_email = $query_select_email->fetchAll(PDO::FETCH_ASSOC);
          $count_email = $query_select_email->rowCount(PDO::FETCH_ASSOC);

        } catch(PDOexception $error_select_email) {
          echo 'Erro ao selecionar'.$error_select_email->getMessage();
        }

        if ($count_email > 0) {

          foreach($resultado_query_email as $res_email){
            $tipo = $res_email['pessoaTipo'];
          }

        } else {

          // Consulta e-mail do usuário
          $sql_select_email = "SELECT empresaTipo FROM empresas WHERE empresaEmail = '$email' ";

          try{

            $query_select_email = $conecta->prepare($sql_select_email);
            $query_select_email->execute();

            $resultado_query_email = $query_select_email->fetchAll(PDO::FETCH_ASSOC);
            $count_email = $query_select_email->rowCount(PDO::FETCH_ASSOC);

          } catch(PDOexception $error_select_email) {
            echo 'Erro ao selecionar'.$error_select_email->getMessage();
          }

          foreach($resultado_query_email as $res_email){
            $tipo = $res_email['empresaTipo'];
          }

        }

        

        switch ($tipo) {
          case 'master':
            include_once 'menu/nav_menu_completo.html';
            break;

          case 'cliente':
            include_once 'menu/nav_menu_cliente.html';
            break;

          case 'parceiro':
            include_once 'menu/nav_menu_parceiro.html';
            break;

          case 'estoque':
            include_once 'menu/nav_menu_estoque_completo.html';
            break;

          case 'vendedor':
            include_once 'menu/nav_menu_estoque_vendedor.html';
            break;
          
          default:
            # code...
            break;
        }
      
      ?>
    </div>

</section>


<div class="mbr-table-cell">

  <div class="container">
    <div class="row">
      <div class="mbr-section col-md-10 col-md-offset-1 text-xs-center">
        
      </div>
    </div>
  </div>
</div>


  <script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smooth-scroll/SmoothScroll.js"></script>
  <script src="assets/dropdown/js/script.min.js"></script>
  <script src="assets/touchSwipe/jquery.touchSwipe.min.js"></script>
  <script src="assets/jarallax/jarallax.js"></script>
  <script src="assets/viewportChecker/jquery.viewportchecker.js"></script>
  <script src="assets/theme/js/script.js"></script>
  
  
  <input name="animation" type="hidden">
  <?php else : ?>
      <p>
        <span class="error">Você não esta autorizado a acessar esta página.</span> Por favor faça o <a href="login_intra.php">login</a>.
      </p>
  <?php endif; ?>
  </body>
</html>