<?php

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script> 

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

    <title>Zafiro Online</title>

    <style>
    *{
      margin:0;
      padding:0;
    }
    #telaToda{
      position:absolute;
      top:0;
      left:0;
      z-index:11;
      background-color:#000;
      width:100%;
      height:100%;
      opacity: .50;
      filter: alpha(opacity=65);
    }
  </style>

  </head>

  <body>

    <div>
      <?php 
      include_once 'menu/nav_menu.html';
      ?>
    </div>

    <div class="container">
      <div class="row align-items-start">
        <div class="col">
          <!-- texto -->
        </div>
        <div class="col">
          <!-- texto -->
        </div>
        <div class="col">
          <!-- texto -->
        </div>
      </div>

      <div class="col-12 col-md-12 border border-dark rounded mx-auto d-block" style="background:url(imagens/fundo_registro.jpg); margin-top: 5%; margin-bottom: 25%; padding: 0;">   
        <div class="col-12 col-md-12 border border-dark" style="background-color: #FFF; opacity: 0.8; height: 700px;">

          <div class="col-3 col-md-2 border border-secondary" style="background-color: #000; opacity: none; margin-top: 150px; height: 200px;">
            
          </div>

          <div class="col-3 col-md-2 border border-secondary" style="background-color: #000; opacity: none; margin-top: 150px; height: 200px;">
            
          </div>
          
        </div>
      </div>

      <div class="row align-items-end">
        <div class="col">
          <div class="col-12 col-md-12 text-center">
            <?php 
              include_once 'controller/copyright.php';
            ?>
          </div>
        </div>
      </div>

    </div><!-- Fim conteiner -->

  </body>
</html>