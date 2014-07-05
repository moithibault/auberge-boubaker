<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BackOffice</title>

    <!-- Bootstrap -->
    <link href="<?= base_url() ?>/assets/bootstrap-3.2.0-dist/css/bootstrap.min.css" rel="stylesheet">
    <?php
    //chargement des JS en plus (def dans app/librairies/Template)
    if(isset($css)){
      echo $css;
    }
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
 
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-th-list"></span> BO Résidence-Boubaker </a>
        </div>
         <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          <li>
              <?= anchor('backoffice', '<span class="glyphicon glyphicon-home"></span>  Accueil'); ?>
          </li>
          <li>
              <?= anchor('frontoffice', '<span class="glyphicon glyphicon-star"></span>  Frontoffice'); ?>
          </li>
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-file"></span> 
            Sections <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><?= anchor('backoffice/addSection', '<span class="glyphicon glyphicon-plus"></span> Nouvelle'); ?></li>
            <li><?= anchor('backoffice/viewSections', '<span class="glyphicon glyphicon-th-list"></span> Toutes'); ?></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               <span class="glyphicon glyphicon-camera"></span> 
               Photos <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><?= anchor('backoffice/addPhoto', '<span class="glyphicon glyphicon-plus"></span>  Nouvelle'); ?></li>
            <li class="divider"></li>
             <li><?= anchor('backoffice/viewPhotos', 'Toutes'); ?></li>
          </ul>
        </li>


          </ul>
          <p class="navbar-text navbar-right"><?= anchor('login/logout', '<span class="glyphicon glyphicon-user"></span> <strong>'.$this->session->userdata("username").'</strong>'); ?></p>
        </div><!--/.nav-collapse -->

      </div>
    </div>
	 <div class="container" style="margin-top: 60px">
    <?= $contents ?>
    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/holder.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= base_url() ?>/assets/bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
    <?php
    if(isset($js)){
      echo $js;
    }
    ?>
  </body>
</html>