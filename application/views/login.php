
  
      <!-- Page Layout here -->
      <div class="row col l12 s12 " style="padding-top: 70px">
        <?= form_open('', 'style="", class="card-panel col s10 push-s1 l4 push-l4 animate__animated animate__fadeInDown" id="form-login"');?>
          <div class="row center-align" style="margin-bottom: 0rem;padding-top: 20px">
            <div class="input-field col s12 l6 push-l3">
              <input id="username" type="text" class="validate">
              <label for="username">Username</label>
            </div>
          </div>
          <div class="row">
             <div class="input-field col s12 l6 push-l3">
              <input id="password" type="password" class="validate">
              <label for="password">Password</label>
            </div>
          </div>
          <div class="row">
            <div class="col l9 push-l3">
              
              <button class="waves-effect waves-light deep-orange darken-1 btn" type="reset">Reset</button>
              <button class="waves-effect waves-light btn" type="submit" id="login">Login</button>
            </div>
            <div class="col l9 push-l3">
              <a href="#" aria-label="untuk login dan password guest, gunakan username: guest | password: guest123" data-balloon-pos='up'><u>info</u></a> | 
              <a href="<?= base_url().'forgot_password';?>">Lupa Password</a> | 
              <a href="<?= base_url().'daftar_baru';?>">Daftar</a>
            </div>
          </div>
          <div class="row">
            <div class="col l12 center">
              <marquee><b>BNI - Divisi Bisnis Kartu &copy 2020</b></marquee>
            </div>
          </div>
        <?= form_close();?>
      </div>
      <div class="row col l12 s12">
        <div class="col s10 push-s1 l4 push-l4 white-text" id="jamlogin"></div>
      </div>
      <div class="row col l12 s12">
        <div class="col s10 push-s1 l4 push-l4 center white-text" style="font-family: comfortaa;color:blue">@2020 <a href="mailto:muhamad.reza@bni.co.id" style="color:white">Muhamad Reza</a> &reg </div>


      </div>
    </body>
      <!--JavaScript at end of body for optimized loading-->
      <script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
      <script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>
      <script src="<?= base_url().'assets/js/moment.js';?>"></script>
      <script src="<?= base_url().'assets/js/locale.js';?>"></script>
      <script type="text/javascript" src="<?= base_url().'assets/materialize/js/materialize.min.js';?>"></script>
      <script type="text/javascript" src="<?= base_url().'assets/socket.io/dist/socket.io.js';?>"></script>
      <script type="text/javascript" src="<?= base_url().'assets/js/socket.init.js';?>"></script>
      <script>


  $(document).ready(function(){
    $('.sidenav').sidenav();
    $('#form-login').hover(function(){
      $(this).css('top', '20%');
    })
    
    window.setInterval(jam, 1000);

    function jam(){
      moment.locale('id');
      let jam = moment().format('Do MMMM YYYY, h:mm:ss a');
      document.getElementById('jamlogin').innerHTML = jam;
    }

    let ipAddress = "<?= $_SERVER['HTTP_HOST']; ?>";
 
    if (ipAddress == "::1") {
        ipAddress = "localhost"
    }

    const port = "3000";
    const socketIoAddress = `http://${ipAddress}:${port}`;
    const socket = io(socketIoAddress);

    $('#login').on('click', function(e){
      e.preventDefault();
      let username = $('#username').val();
      let password = $('#password').val();

      $.ajax({
        type: 'POST',
        url : "<?= base_url().'user/login';?>",
        data : {username: username, password: password},
        dataType: 'JSON',
        success: function(data){
          
          if(data.status == 'success'){
            //socket.emit('reload-user', data.kata);
            swal({
              type: data.status,
              text: data.pesan,
              allowOutsideClick: false
            }).then(function(){
                window.location.href="<?=base_url().'welcome';?>"; 
            })
          }else{
            swal({
              type: data.status,
              text: data.pesan,
              })
          }
        }, error: function(){
          console.log('Occured error!')
        }
      })
    })

  });

   
</script>
