
  <!-- Page Layout here -->
    <div class="row first">
      <div class="col s12 offset-l2 l10">
        <div class="row">
          <div class="input-field col s6">
            <label class="active">Send To:</label>
            <select id="sendto" class="select-m" multiple>
              <option value="all">all</option>
              <?php foreach($sendto as $u):?>
              <option data-icon="<?= 'gambar/profile/'.$u->profil_pict;?>" value="<?= $u->username;?>" class="circle"><?= $u->nama;?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="input-field col s6">
            <label>Message:</label>
            <input type="text" class="validate" id="message" placeholder="press enter to send">
            <input type="text" class="validate" id="nama" hidden="true" value="<?= $_SESSION['nama'];?>">
          </div>
          
        </div>
        <div class="row">
          <div class="col s6">
            <ul class="collection with-header">
              <li class="collection-header blue"><b>To All</b></li>
              <div style="overflow-y: scroll;max-height: 250px;height: 300px" id="list-all">
                <?php foreach($list_all AS $c){?>
                <?php 
                if($_SESSION['username'] == $c->send_by){?>
                <li class="collection-item avatar teal lighten-4">
                  <img src="<?= $c->loc.$c->profil_pict;?>" alt="" class="circle"><div><?= $c->chat;?><br><a style="font-size: 10px">from <?= $c->nama;?> @<?= $c->created_at;?></a></div></li>
                <?php }else{?>
                <li class="collection-item avatar">
                  <img src="<?= $c->loc.$c->profil_pict;?>" alt="" class="circle"><div><?= $c->chat;?><br><a style="font-size: 10px">from <?= $c->nama;?> @<?= $c->created_at;?></a></div></li>
                <?php }};?>
              </div>
            </ul>
          </div>
          <div class="col s6">
            <ul class="collection with-header">
              <li class="collection-header green"><b>Private</b></li>
              <div style="overflow-y: scroll;max-height: 250px;height: 180px" id="list">
                <?php foreach($list AS $d){?>
                <?php 
                if($_SESSION['username'] == $d->send_by){?>
                <li class="collection-item avatar teal lighten-4">
                  <img src="<?= $d->loc.$d->profil_pict;?>" alt="" class="circle"><div><?= $d->chat;?><br><a style="font-size: 10px">to <?= $d->nm;?> @<?= $d->created_at;?></a></div></li>
                <?php }else{?>
                <li class="collection-item avatar">
                  <img src="<?= $d->loc.$d->profil_pict;?>" alt="" class="circle"><div><?= $d->chat;?><br><a style="font-size: 10px">from <?= $d->nama;?> @<?= $d->created_at;?></a></div></li>
                <?php }};?>
              </div>
            </ul>
          </div>
        </div>
          
      </div>

    </div>

<script src="<?= base_url().'assets/js/jquery.uploadPreview.min.js';?>"></script>
<script>
  $(document).ready(function(){
    
    $('.select-m').formSelect();
    let chatHistorys = document.getElementById("list-all");
        chatHistorys.scrollTop = chatHistorys.scrollHeight;
    let chatHistory = document.getElementById("list");
        chatHistory.scrollTop = chatHistory.scrollHeight;
    $('#message').on('keydown', function(e){
      
      if(e.which == 13){
        let msg = $('#message').val();
        let nama = $('#nama').val();
        let sendto = $('#sendto').val();
        let i = 0;
        for(i;i < sendto.length;i++){

        }
        let gambar = "<?= $this->Setting_model->dir_foto()->row('defaultnya').$this->User_model->get_user($_SESSION['username'])->profil_pict;?>";

        let data = { nama: nama, msg: msg, sendto: sendto, gambar: gambar};
        
        
        if(msg.length > 0 && sendto !== null){
          
          $('#message').val('');
          $.ajax({
            type: 'POST',
            url : '<?= base_url()."broadcast/send_broadcast";?>',
            data: data,
            dataType: 'JSON',
            success : function(data){
              
              if(data.status == 'success'){
                socket.emit('broadcast', data);

              }
            },
          })
            
        }else if(msg.length > 0 && sendto === null){
          let toastHTML = 'please select receiver at least one';
          M.toast({
            html: toastHTML
          });
        }
      }
    })
    
    

  });
</script>