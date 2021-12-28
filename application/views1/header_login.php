<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="<?= base_url().'assets/font-awesome-4.7.0/css/font-awesome.css';?>" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="<?= base_url().'assets/materialize/css/materialize.min.css';?>"  media="screen,projection"/>
      <link href="<?= base_url().'assets/css/sweetalert2.min.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/reza.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/balloon.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/animate.min.css';?>" rel="stylesheet">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
    <script src="<?= base_url().'assets/js/select2.min.js';?>"></script>
    <script src="<?= base_url().'assets/materialize/js/materialize.min.js';?>"></script>
<script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>
    <title>ESR</title>
    <style>
    #form-login{
    box-shadow: 10px 10px 5px#888888;
    }
    <?php if(empty($page)){?>
    body{
      background-image: url("<?= base_url().'gambar/background.JPG';?>");
      background-repeat: no-repeat;background-size: 100%;background-position: center;background-size: cover;height:100vh;position: relative;
    }
    <?php }?>

    </style>
    <body>
      <nav>
        <div class="nav-wrapper deep-orange darken-3">
          
          <a href="#" class="brand-logo show-on-small hide-on-large-only" data-target="slide-out" style="font-size: 19px;font-family: ogresse;">ESR</a>
            <a href="<?= base_url();?>" id="brand-logo" class="show-on-large hide-on-med-and-down brand-logo center" for='dekstop'>ESR</a>
        </div>
      </nav>