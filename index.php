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

      <div class="row align-items-center">
        <div class="col">
          <!-- texto -->
        </div>
        <div class="col" style="margin-top: 10%; margin-bottom: 25%;">
          <?php 
            include_once 'controller/tela_login.php';
          ?>
        </div>
        <div class="col">
          <!-- texto -->
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