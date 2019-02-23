<?php

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'dbConnect.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
<head>

  <title>Zafiro</title>
  
  <?php include_once 'controller/links_stylesheet.php'; ?>
  
  <style>
    *{
      margin:0;
      padding:0;
    }
    #centralizar{
      top:20%;
      left:20%;
    }
    .margin-top{
      margin-top:20%;
    }
  </style>
  
  
</head>
<body>
<?php if (login_check($mysqli) == true) : ?>

<section id="menu-0">

    <div>
      <?php 
      include_once 'menu/nav_menu_completo.html';
      ?>
    </div>

</section>

<div class="margin-top">

  <div class="container">

    <?php

      $link = $_GET['link'];
      include_once 'controller/funcoes_empresa.php';

    ?>

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