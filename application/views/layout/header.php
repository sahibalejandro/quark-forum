<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo QUARKPHP_FORUM; ?></title>
  <base href="<?php echo $this->QuarkURL->getBaseURL(); ?>" />
  <?php
  $this->prependCssFiles('bootstrap.min.css', 'quark-forum.css', 'bootstrap-responsive.min.css')->includeCssFiles();
  ?>
</head>
<body>
  <div class="navbar navbar-static-top navbar-inverse">
    <div class="navbar-inner">
      <div class="container">
        <a href="<?php echo $this->QuarkURL->getBaseURL(); ?>" class="brand"><?php echo QUARKPHP_FORUM; ?></a>
        <ul class="nav pull-right">
        <?php if (!$this->userAreSigned()): ?>
          <li>
            <a href="#">
              <i class="icon-user icon-white"></i>
              Iniciar sesión
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo $this->User->getURL(); ?>">
              <i class="icon-user icon-white"></i>
              <?php echo $this->User->name; ?>
            </a>
          </li>
          <li>
            <a href="<?php echo $this->QuarkURL->getURL('logout'); ?>">
              <i class="icon-off icon-white"></i>
              Salir
            </a>
          </li>
        <?php
        endif;
        ?>
        </ul>
      </div>
      <!-- // .container -->
    </div>
    <!-- // .navbar-inner -->
    
    <!-- Area de mensajes -->
    <div id="messages-area" class="container"></div>
    <!-- // Area de mensajes -->

  </div>
  <!-- // .navbar -->
  <div class="container">
