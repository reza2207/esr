
    
      <!-- Page Layout here -->
      <div class="row col l12 s12" id="rowFirstStep" >        
        <?= form_open('', 'style="top: 20%;position: absolute;padding-top: 10px;", class="card-panel col s10 push-s1 l4 push-l4" id="formCheck"');?>
          <div class="row center-align" style="margin-bottom: 0rem;">
            <div class="input-field col s12 l6 push-l3">
              <input id="usernameConf" type="text" class="validate" name="username">
              <label for="username">Username</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l8 push-l3">
              <button class="waves-effect waves-light btn" type="submit" id="submitConf">Submit</button>
            </div>
          </div>
          <div class="row">
            <div class="col l12 center">
              <marquee><b>BNI - Divisi Bisnis Kartu &copy 2020</b></marquee>
            </div>
          </div>
        <?= form_close();?>
      </div>

      <!-- submit new pass -->
      <div class="row col l12 s12 hide" id="rowSecondStep">        
        <?= form_open('', 'style="top: 20%;position: absolute;padding-top: 10px;", class="card-panel col s10 push-s1 l4 push-l4" id="formConfQuestion"');?>
          <div class="row center-align" style="margin-bottom: 0rem;">
            <div class="input-field col s12 l6 push-l3">
              <input id="usernameSS" type="text" class="validate" name="username" readonly="true">
              <label>username</label>
            </div>
          </div>
          <div class="row">
             <div class="input-field col s12 l6 push-l3">
              <input id="question" name="question" type="text" readonly="true" class="validate">
              <label>Question</label>
            </div>
          </div>
          <div class="row">
             <div class="input-field col s12 l6 push-l3">
              <input id="answer" name="answer" type="text" class="validate">
              <label>Answer</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l8 push-l3">
              <button class="waves-effect waves-light btn" type="submit">Submit</button>
            </div>
          </div>
          <div class="row">
            <div class="col l12 center">
              <marquee><b>BNI - Divisi Bisnis Kartu &copy 2018</b></marquee>
            </div>
          </div>
        <?= form_close();?>
      </div>

      <!-- third step-->
      <div class="row col l12 s12 hide" id="rowThirdStep">        
        <?= form_open('', 'style="top: 20%;position: absolute;padding-top: 10px;", class="card-panel col s10 push-s1 l4 push-l4" id="formNew"');?>
          <div class="row center-align" style="margin-bottom: 0rem;">
            <div class="input-field col s12 l6 push-l3">
              <input id="usernameTS" name="username" type="text" class="validate" readonly="true">
              <label>username</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 l6 push-l3">
              <input id="password" name="password" type="password" class="validate">
              <label>New Password</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 l6 push-l3">
              <input id="passwordConf" type="password" class="validate">
              <label>Confirm New Password</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l8 push-l4">
              <button class="waves-effect waves-light btn" type="submit">Submit</button>
            </div>
          </div>
          <div class="row">
            <div class="col l12 center">
              <marquee><b>BNI - Divisi Bisnis Kartu &copy 2020</b></marquee>
            </div>
          </div>
        <?= form_close();?>
      </div>
    </body>
  <!--JavaScript at end of body for optimized loading-->
  <script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
  <script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>
  <script type="text/javascript" src="<?= base_url().'assets/materialize/js/materialize.min.js';?>"></script>
  
  <script>


  $(document).ready(function(){           
    $('#formCheck').on('submit', function(e){
      let username = $('#usernameConf').val();
      e.preventDefault();
      $.ajax({
        type: 'POST',
        data: $(this).serialize(),
        url : '<?= base_url()."user/check_user";?>',
        success : function(result){
          let data = JSON.parse(result);

          if(data.type == 'error'){
            swal({
              type: data.type,
              text: data.message,
            })
          }else{
            $('#rowFirstStep').addClass('hide');
            $('#rowSecondStep').removeClass('hide');
            $('#usernameSS').val(username);
            $('#usernameTS').val(username);
            $('#question').val(data.message);
            $('label').addClass('active');
          }
        }
      })
    });

    //second
    $('#formConfQuestion').on('submit', function(e){
      
      e.preventDefault();
      $.ajax({
        type : 'POST',
        data : $(this).serialize(),
        url  : '<?= base_url()."user/submit_answer";?>',
        success: function(result){
          let data = JSON.parse(result);
          if(data.type == 'error'){
            swal({
              type: data.type,
              text: data.message,
            })
          }else{
            //$('#rowFirstStep').addClass('hide');
            $('#rowSecondStep').addClass('hide');
            $('#rowThirdStep').removeClass('hide');
            $('label').addClass('active');
          }
        }
      })
    });

    //third
    $('#formNew').on('submit', function(e){
      
      e.preventDefault();
      let pass = $('#password').val();
      let passC = $('#passwordConf').val();

      if(pass != passC){
        swal({
          type: 'error',
          text: 'Password didn\'t match',
        })
      }else{
        $.ajax({
          type : 'POST',
          data : $(this).serialize(),
          url  : '<?= base_url()."user/submit_new_password";?>',
          success: function(result){
            let data = JSON.parse(result);
            if(data.type == 'error'){
              swal({
                type: data.type,
                text: data.message,
              })
            }else{
              swal({
                type: data.type,
                text: data.message,
              }).then(function(){
                window.location.href="<?=base_url().'';?>"; 
              })
            }
          }
        })
      }
    })

  });
</script>
