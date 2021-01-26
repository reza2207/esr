
<link href="<?= base_url().'assets/css/reza.css';?>" rel="stylesheet">
<link href="<?= base_url().'assets/font-awesome-4.7.0/css/font-awesome.css';?>" rel="stylesheet">
<!DOCTYPE html>
<html>
<head>
  <link type="text/css" rel="stylesheet" href="<?= base_url().'assets/materialize/css/materialize.min.css';?>"  media="screen,projection"/>
  <title><?= !isset($profile) ? 'Profile' : $profile;?></title>
</head>
<body>
  <div class="row">
    <div class="col s2 blue lighten-5" style="height: 100%">
    </div>
    <div class="col s8">
      <div class="row">
        <div class="col s12 center">
          <h1 style="font-family: caviar;text-decoration: underline;color:#1b5e20">Welcome to The Jungle</h1>
        </div>
      </div>
      <div class="row">
        <div class="col s4">
          <div class="profile center">
            <div class="gambar">
              <img class="profile-pict" src="<?= base_url().'gambar/profile/c308b09cbdeb9d2118c6c3b1fd306012.jpg';?>">
            </div>
            <span class="profile-name">si Buaya</span>
            <span class="anon">Find me on</span>
            <i class='media fa fa-youtube'></i>
            <i class='media fa fa-facebook'></i>
            <i class='media fa fa-twitter'></i>
            <i class='media fa fa-instagram'></i>
          </div>

        </div>
        <div class="col s4">
          <div class="profile center">
            <div class="gambar">
              <img class="profile-pict" src="<?= base_url().'gambar/profile/2717f672f7e01dc6bc183911de750f27.jpg';?>">
            </div>
            <span class="profile-name">si Cungkring</span>
            <span class="anon">Find me on</span>
            <i class='media fa fa-youtube'></i>
            <i class='media fa fa-facebook'></i>
            <i class='media fa fa-twitter'></i>
            <i class='media fa fa-instagram'></i>

          </div>
        </div>
        <div class="col s4">
          <div class="profile center">
            <div class="gambar">
              <img class="profile-pict" src="<?= base_url().'gambar/profile/e8299eb90280b5c5dd8132a3944b7105.jpg';?>">
            </div>
            <span class="profile-name">si Jumbo</span>
            <span class="anon">Find me on</span>
            <i class='media fa fa-youtube'></i>
            <i class='media fa fa-facebook'></i>
            <i class='media fa fa-twitter'></i>
            <i class='media fa fa-instagram'></i>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col s12 center">
          <h1 style="font-family: caviar;text-decoration: underline;color:#1b5e20">About Me</h1>
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <div class="gambar center">
            <img class="pict-about" src="<?= base_url().'gambar/profile/c308b09cbdeb9d2118c6c3b1fd306012.jpg';?>">
          </div>
        </div>
        <div class="col s9 story">
          Hobi nya tidur, makannya banyak banget
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <div class="gambar center">
            <img class="pict-about" src="<?= base_url().'gambar/profile/2717f672f7e01dc6bc183911de750f27.jpg';?>">
          </div>
        </div>
        <div class="col s9 story">
          Hobi nya jualan, Life is money!
        </div>
      </div>
      <div class="row">
        <div class="col s3">
          <div class="gambar center">
            <img class="pict-about" src="<?= base_url().'gambar/profile/e8299eb90280b5c5dd8132a3944b7105.jpg';?>">
          </div>
        </div>
        <div class="col s9 story">
          Hobi nya ngurusin badan, tapi nyatanya bulak balik ke toilet mulu kerjaannya. 
        </div>
      </div>
    </div>
    <div class="col s2 blue lighten-5" style="height: 100%">
      
    </div>
  </div>


</body>
<script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
<script src="<?= base_url().'assets/materialize/js/materialize.min.js';?>"></script>
</html>