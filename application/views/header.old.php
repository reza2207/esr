
  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="<?= base_url().'assets/font-awesome-4.7.0/css/font-awesome.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/sweetalert2.min.css';?>" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="<?= base_url().'assets/materialize/css/materialize.min.css';?>" media="screen,projection"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url().'assets/datatables/DataTables-1.10.13/css/jquery.dataTables.min.css';?>"/>
      <link href="<?= base_url().'assets/css/select2.min.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/balloon.css';?>" rel="stylesheet">
      
      <link href="<?= base_url().'assets/css/reza.css';?>" rel="stylesheet">
      <!-- Include Editor style. -->
      <link href="<?= base_url().'assets/materialSummernote-master/css/materialSummernote.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/materialSummernote-master/css/codeMirror/codemirror.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/materialSummernote-master/css/codeMirror/monokai.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/materializefont.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/animate.min.css';?>" rel="stylesheet">
      
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <!-- <link rel="icon" href="<?= base_url().'gambar/logo_purch.png';?>"> -->
    </head>
    <title><?= $title == "" ? "ESR" : $title;?></title>
    
    <body class="">
    
      <div class="navbar-fixed">
        <div class="navbar" style="width: calc(100%-50%);left:300px;">
          <nav class="nav-wrapper grey darken-4 header">
            <div id="menu-bars" style="">
              <button class="waves-effect waves-blue btn-flat white-text show-on-large hide-on-med-and-down" id="button-side" style="top: 15px;"><i class="fa fa-bars" style="height: 0;"></i></button>
            </div>  
            <a href="#" id="brand-logo-mobile" class="brand-logo show-on-small hide-on-large-only" data-target="slide-out" style="font-size: 19px;">ESR</a>
            <a href="<?= base_url();?>" id="brand-logo" class="show-on-large hide-on-med-and-down brand-logo center" for='dekstop'>ESR</a>
            
            <a href="#" data-target="slide-out" class="sidenav-trigger show-on-small hide-on-up" style="font-size: 2em"><i class='fa fa-bars'></i></a>

            <ul class="right hide-on-med-and-down">
              <?php if ($_SESSION['role'] != "user" ){?>
              

              <ul id="dropdown2" class="dropdown-content">
                <li><a href="<?= base_url().'add_user';?>"><i class="fa fa-user-plus"></i> User</a></li>
                <li><a href="<?= base_url('setting');?>"><i class="fa fa-wrench"></i> Setting</a></li>
                
              </ul>
              <li class="<?= current_active($page, 'Broadcast');?>"><a href="<?= base_url().'broadcast';?>"><i class="fa fa-envelope-o"></i> Broadcast</a></li>
              <li><a class="dropdown-trigger" data-target="dropdown2"><i class="fa fa-cog"></i></a></li>
            
              <?php }?>
              <li><a class="logout"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </nav>
        </div>
      </div>
      <ul id="slide-out" class="sidenav sidenav-fixed brown darken-4">
      <!-- <ul id="slide-out" class="sidenav sidenav-fixed brown darken-4" style=";overflow-y: hidden;"> -->
        <!-- <ul id="slide-out" class="sidenav sidenav-fixed indigo lighten-5"> -->
        <li>
          <div class="user-view">
            <div class="background"> 
              <img src="<?= base_url().'gambar/background.jpg';?>" width="100%" height="100%">
            </div>
            <img id="img-user" class="circle responsive-img tooltip-red" src="">
            
            <span class="name" id="sayhi"><b><?= $_SESSION['nama'];?>!</b></span>
            
          </div>

        </li>

        <div id="header-side">
          <ul class="collapsible">

            <li class="<?= current_active($title, 'Persekot');?> collapsible-head">
              <div class="collapsible-header waves-effect" style="padding-left: 0px !important;color: white"><i class="fa fa-caret-down right <?= caretup($page, 'Persekot');?>"></i>Persekot<?= $this->Persekot_model->get_exp()->num_rows() > 0 ? '<span class="new badge red" data-badge-caption="">'.$this->Persekot_model->get_exp()->num_rows().'</span>':'';?>
              </div>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Persekot');?>">
                  <a href="<?= base_url().'persekot';?>">Persekot</a>
                </li>
                <li class="<?= current_active($title, 'Persekot');?>">
                  <a href="<?= base_url().'rek_persekot';?>">Rekening Persekot</a>
                </li>
              </ul>
            </li>
            <hr>
            <li class="<?= current_active($title, 'Persekot');?> collapsible-head">
              <div class="collapsible-header waves-effect" style="padding-left: 0px !important;color: white"><i class="fa fa-caret-down right <?= caretup($page, 'log kerja');?>"></i>Bag. Umum
              </div>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja Bag. Umum');?>">
                  <a href="<?= base_url().'pks';?>">Stock Opname</a>
                </li>
              </ul>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja Bag. Umum');?>">
                  <a href="<?= base_url().'pks';?>">Serah Terima Barang</a>
                </li>
              </ul>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja Bag. Umum');?>">
                  <a href="<?= base_url().'pks';?>">Log Kerja<span class="new badge red" data-badge-caption="">2</span></a>
                </li>
              </ul>
              
            </li>
            <hr>
            <li class="<?= current_active($title, 'Persekot');?> collapsible-head">
              <div class="collapsible-header waves-effect" style="padding-left: 0px !important;color: white"><i class="fa fa-caret-down right <?= caretup($page, 'log kerja');?>"></i>Jar HW
              </div>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja Bag. Umum');?>">
                  <a href="<?= base_url().'pks';?>">Inventory PC<span class="new badge red" data-badge-caption="">2</span></a>
                </li>
              </ul>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja Bag. Umum');?>">
                  <a href="<?= base_url().'pks';?>">Form Monitoring<span class="new badge red" data-badge-caption="">2</span></a>
                </li>
              </ul>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja Bag. Umum');?>">
                  <a href="<?= base_url().'pks';?>">Stock Opname<span class="new badge red" data-badge-caption="">2</span></a>
                </li>
              </ul>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja Bag. Umum');?>">
                  <a href="<?= base_url().'pks';?>">Serah Terima Barang<span class="new badge red" data-badge-caption="">2</span></a>
                </li>
              </ul>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja JarHW');?>">
                  <a href="<?= base_url().'log_kerja_jhw';?>">Log Kerja</a>
                </li>
              </ul>
              <ul class="collapsible-body">
                <li class="<?= current_active($title, 'Log Kerja Bag. Umum');?>">
                  <a href="<?= base_url().'pks';?>">Monitoring Server</a>
                </li>
              </ul>
            </li>
          </ul>
          <?php if ($_SESSION['role'] != "user" ){?>
          <div class="divider show-on-small hide-on-large-only"></div>
          <li class="bold show-on-small hide-on-large-only"><a href="<?= base_url().'add_user';?>">Add User</a></li>
          <li class="bold show-on-small hide-on-large-only"><a href="<?= base_url('setting');?>">Setting</a></li>

          <?php }?>
          <div class="divider show-on-small hide-on-large-only"></div>
          <li class="bold show-on-small hide-on-large-only"><a href="<?= base_url('user/logout');?>" class="logout">Logout</a></li>
          <div style="margin-top: 150px" id="jam"></div>
        </div>
        
      </ul>
    </div>
      <!-- Page Layout here -->
    

  <!-- end page Layout-->
<!--JavaScript at end of body for optimized loading-->
<script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
<script src="<?= base_url().'assets/js/select2.min.js';?>"></script>

<script src="<?= base_url().'assets/materialize/js/materialize.min.js';?>"></script>
<script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>
<script src="<?= base_url().'assets/js/select2-materialize.js';?>"></script>
<script src="<?= base_url().'assets/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/datatables.buttons.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.html5.min.js';?>"></script>
<script src="<?= base_url().'assets/js/moment.js';?>"></script>
<script src="<?= base_url().'assets/js/vue.js';?>"></script>
<script src="<?= base_url().'assets/js/locale.js';?>"></script>
<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/datatables.buttons.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/jszip.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.html5.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.print.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/buttons.colVis.min.js';?>"></script>
<script src="<?= base_url().'assets/js/reza.js';?>"></script>
<script src="<?= base_url().'assets/js/popper.min.js';?>"></script>
<script src="<?= base_url().'assets/js/tooltip.min.js';?>"></script>
<script src="<?= base_url().'assets/materialSummernote-master/js/zzz_ckMaterializeOverrides.js';?>"></script>
<script src="<?= base_url().'assets/materialSummernote-master/js/codeMirror/codemirror.js';?>"></script>
<script src="<?= base_url().'assets/materialSummernote-master/js/codeMirror/xml.js';?>"></script>
<script src="<?= base_url().'assets/materialSummernote-master/js/materialSummernote.js';?>"></script>
<!-- <script type="text/javascript" src="<?= base_url().'assets/js/chart.min.js';?>"></script> -->
<script type="text/javascript" src="<?= base_url().'assets/js/chartjs.min.js';?>"></script>
<script type="text/javascript" src="<?= base_url().'assets/js/utility.js';?>"></script>
<script type="text/javascript" src="<?= base_url().'assets/socket.io/dist/socket.io.js';?>"></script>
<script type="text/javascript" src="<?= base_url().'assets/js/socket.init.js';?>"></script>
<script>
  
  $(document).ready(function(){
   
    window.setInterval(jam, 1000);
    if (Notification.permission !== "granted"){
        Notification.requestPermission().then(function(getperm){
          console.log('perm granted', getperm);
        });
    }
    M.updateTextFields();
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $(".dropdown-trigger").dropdown({
      constrainWidth: false
    });
    
    $('.collapsible-head').on('click', function(e){
      if($(this).find('i').hasClass('caretup')){
        $(this).find('i').removeClass('caretup');
        $(this).find('i').addClass('caretdown');
        if($(this).siblings('.collapsible-head').find('i').hasClass('caretup')){
          
          $(this).siblings('.collapsible-head').find('i').addClass('caretup');
          $(this).siblings('.collapsible-head').find('i').removeClass('caretdown');
        }
      }else{
        $(this).find('i').addClass('caretup');
        $(this).find('i').removeClass('caretdown');
        if($(this).siblings('.collapsible-head').find('i').hasClass('caretup')){
          
          $(this).siblings('.collapsible-head').find('i').removeClass('caretup');
          $(this).siblings('.collapsible-head').find('i').addClass('caretdown');
        }
      }
    })
    $('#button-side').on('click', function(e){
      $('#slide-out').fadeToggle("slow", "swing");

      if($(this).parent().hasClass('leftside')){
       $(this).parent().removeClass('leftside');
      }else{
        $(this).parent().addClass('leftside');
      }
      if($('.first').children().hasClass('offset-l3 l9')){
        $('.first').children().removeClass('offset-l3 l9').addClass('l12');
        $('#table').DataTable().columns.adjust();
      }else{
        $('.first').children().removeClass('l12').addClass('offset-l3 l9');
        $('#table').DataTable().columns.adjust();
      }

      
    })

  });
    socket.on('reload', function(kata){
        let toastHTML = '<span>'+kata+'</span>';
        M.toast({
          html: toastHTML,
          classes: 'rounded',

        });
        
    });
    socket.on('broadcast', function(data){
      let kata = data.msg;
      let user = data.sendto;
      let nama = data.nama+' ';
      let gambar = data.gambar;
      let time = data.time;
      let type = data.type;
      let username = data.username;//sendby

      if(type != 'all' ){
        let toastHTML = nama+' says : '+kata+'<a href="<?= base_url().'broadcast';?>" class="btn-flat toast-action">Reply</a>';
        
        let html = "";
        if(user == "<?= $_SESSION['username'];?>"){
          html = `<li class="collection-item avatar"><img src="`+gambar+`" alt="" class="circle"><div>`+kata+`<br><a style="font-size: 10px">from `+username+` @`+time+`</a></div></li>`;
          $('#list').append(html);
          let chatHistory = document.getElementById("list");
          chatHistory.scrollTop = chatHistory.scrollHeight;
          M.toast({
            html: toastHTML,
            displayLength: 10000
          });
          notifikasi(kata, nama, gambar)
          //tujuan nya ada yang sedang login
        }else if(user.includes('<?= $_SESSION['username'];?>')){
          html = `<li class="collection-item avatar"><img src="`+gambar+`" alt="" class="circle"><div>`+kata+`<br><a style="font-size: 10px">from `+username+` @`+time+`</a></div></li>`;
          $('#list').append(html);
          let chatHistory = document.getElementById("list");
          chatHistory.scrollTop = chatHistory.scrollHeight;

          M.toast({
            html: toastHTML,
            displayLength: 10000
          });
          notifikasi(kata, nama, gambar)

        }else if(username == '<?= $_SESSION['username'];?>'){
          html = `<li class="collection-item avatar teal lighten-4"><img src="`+gambar+`" alt="" class="circle"><div>`+kata+`<br><a style="font-size: 10px">to `+user+` @`+time+`</a></div></li>`;
          $('#list').append(html);
          let chatHistory = document.getElementById("list");
          chatHistory.scrollTop = chatHistory.scrollHeight;
        }
        
      }else if(type == 'all' && "<?= $_SESSION['role'];?>" != 'user'){
        let loc = data.loc;
        let toastHTML = nama+' says to All: '+kata+'<a href="<?= base_url().'broadcast';?>" class="btn-flat toast-action">Reply</a>';
        

        let html = "";
        if(username == "<?= $_SESSION['username'];?>"){
          html = `<li class="collection-item avatar teal lighten-4"><img src="`+gambar+`" alt="" class="circle"><div>`+kata+`<br><a style="font-size: 10px">from `+nama+` @`+time+`</a></div></li>`;
        
        }else{
          html = `<li class="collection-item avatar"><img src="`+gambar+`" alt="" class="circle"><div>`+kata+`<br><a style="font-size: 10px">from `+nama+` @`+time+`</a></div></li>`;
          M.toast({
            html: toastHTML,
            displayLength: 10000
          });
          notifikasi(kata, nama, gambar)
        }
        $('#list-all').append(html);
        let chatHistory = document.getElementById("list-all");
        chatHistory.scrollTop = chatHistory.scrollHeight;
      }
        
    });
    get_user('<?= $_SESSION['username'];?>');
    function jam(){
      moment.locale('id');
      let jam = "<i class='fa fa-calendar'></i> "+moment().format('Do MMMM YYYY, ')+"<br><i class='fa fa-clock-o'></i> "+moment().format('h:mm:ss a');
      document.getElementById('jam').innerHTML = jam;
    }
    function get_user(user){
      socket.emit('send_user', user);
    }

    $('.logout').on('click', function(e){
      let kata = "<?= $_SESSION['nama'];?>"+ ' is logout';
      socket.emit('logout-user', kata);
      window.location.href="<?= base_url('user/logout');?>";
    })

    
    function myTask(count){
      
        let html, htmli;
        if(count > 0){
          html = `<i class="material-icons right">arrow_drop_down</i>Register<span class="new badge red" data-badge-caption="">`+count+`</span>`;
          htmli = `<a href="<?= base_url().'register/masuk';?>">Surat Masuk <span class="new badge red" data-badge-caption="">`+count+`</span></a>`;
          
        }else{
          html = '<i class="material-icons right">arrow_drop_down</i>Register';
          htmli = `<a href="<?= base_url().'register/masuk';?>">Surat Masuk</a>`;
        }
        

        $('#countMyTask').html(html);
        $('#countMyTaskLi').html(htmli);
      
    }
    function notifikasi(str, nama, gambar = null) {
        if (!Notification) {
            alert('Browsermu tidak mendukung Web Notification.'); 
            return;
        }
        if (Notification.permission !== "granted")
            Notification.requestPermission();
        else {
            var notifikasi = new Notification(nama, {
                icon: gambar,
                body: str,
            });
            notifikasi.onclick = function () {
                window.open("http://goo.gl/dIf4s1");
            };
            setTimeout(function(){
                notifikasi.close();
            }, 5000);
        }
    };
    socket.on('cek_task', () =>{
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."register/get_count_task";?>',
        data: {username: "<?= $_SESSION['username'];?>"},
        dataType: 'JSON',
        success: function(data){
          myTask(data);
        }
      })
      
    })
    
</script>

    </body>
  </html>
