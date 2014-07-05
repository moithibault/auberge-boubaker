<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?= $title ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?= base_url()?>assets/frontoffice/css/normalize.min.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frontoffice/css/main.css">
    <?php
    if(isset($css)){
      echo $css;
    }?>
        <script src="<?= base_url()?>assets/frontoffice/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body style="background: url('<?= base_url()?>assets/images/skulls.png') repeat;">
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="header-container" style="background: url('<?= base_url()?>assets/images/congruent_pentagon.png') repeat;">
            <header class="wrapper clearfix">
                <h1 class="title"><?= $title ?></h1>
                <nav>
                    <ul>
<?php 
foreach ($sections as $section){
	echo '<li>'.anchor('frontoffice/view/'.$section->id.'/'.$section->menu, $section->menu).'</li>';
}
?>
                    </ul>
                </nav>
            </header>
        </div>

        <div class="main-container">
            <div class="main wrapper clearfix">
            	<?= $contents ?>


            </div> <!-- #main -->
        </div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper">
                <h3>Auberge Boubaker 2014</h3>
            </footer>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?= base_url()?>assets/frontoffice/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

        <script src="<?= base_url()?>assets/frontoffice/js/main.js"></script>
            <?php
            if(isset($js)){
                echo $js;
            }
            ?>
    </body>
</html>
