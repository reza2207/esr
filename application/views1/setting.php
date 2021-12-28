
  <!-- Page Layout here -->
    <div class="row first">
      <div class="col s12 offset-l3 l9">
        <div class="row">
          <div class="col s12">
            <ul class="tabs" style="overflow-x: hidden">
              <li class="tab col s3"><a href="#menu1"><i class="fa fa-pencil-square-o"></i>Change Password</a></li>
              <li class="tab col s3"><a class="" href="#menu2"><i class="fa fa-photo"></i>Change Picture</a></li>
              <!-- <li class="tab col s3"><a href="#menu3"><i class="fa fa-calendar"></i>Tanggal Libur</a></li> -->
              <li class="tab col s3"><a href="#menu4"><i class="fa fa-database"></i>Master Setting</a></li>
            </ul>
          </div>
          <div id="menu1" class="col s12" style="padding-top: 50px">
            <?= form_open('', array('id'=>'form_cp'));?>
              <div class="row">
                <div class="input-field col s6">
                  <label>New Password:</label>
                  <input type="password" id="newpassword" class="validate" name="newpassword">
                </div>
                <div class="input-field col s6">
                  <input type="password" id="confpass" class="default" name="confpassword">
                  <label>Confirm New Password :</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <button class="btn teal">Submit</button>
                </div>
              </div>
            <?= form_close();?>
          </div>
          <div id="menu4" class="col s12" style="padding-top: 50px">
            <table class="table display" id="table_setting" width="100%">
              <thead class="teal white-text">
                <tr>
                  <th class="center">No.</th>
                  <th>Nama</th>
                  <th>Value</th>
                </tr>
              </thead>
            </table>
          </div>
          <div id="menu2" class="col s12" style="padding-top: 50px">
            <?= form_open_multipart('', array('id'=>'form_pict'));?>
              <div class="row">
                <div class="input-field col s5 center-align" id="image-old">
                  <img class="circle" src="<?= base_url().$this->Setting_model->dir_foto()->row('defaultnya').$this->User_model->get_user($_SESSION['username'])->profil_pict;?>"><br>
                  <label>Old Photo</label>
                </div>
                <div class="input-field col s5 center-align">
                  <div id="image-preview">
                  
                    <label for="image-upload" id="image-label"><i class='fa fa-camera'></i><span>Upload New</span></label>
                    <input type="file" id="image-upload" name="image" >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col push-s5 s4 center-align">
                  
                  <button class="btn teal hide" type="submit" id="btn-upload"><i class="fa fa-upload"></i> Upload</button>
                </div>
              </div>
            <?= form_close();?>
          </div>
          <!-- <div id="menu3" class="col s12" style="padding-top: 50px;">
            <table class="table display" id="table" width="100%">
              <thead class="teal white-text">
                <tr>
                  <th class="center">No.</th>
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>

          </div> -->
        </div>
      </div>

    </div>

    <div id="modal_add" class="modal modal-fixed-footer">
      <div class="modal-content">
           
        <div class="col s12 l12">
          <?= form_open('', array('id'=>'form_tanggal'));?>
          <div class="row">
            <div class="input-field col s12 l2">
              <input type="text" name="no" placeholder="nomor surat">
              <input type="text" name="idpks" id="idpks" class="hide">
            </div>
            <div class="input-field col s12 l2">
              <input type="text" name="tgl" class="datepicker" placeholder="tgl. Surat">
            </div>
            <div class="input-field col s12 l4">
              <input type="text" name="perihal" placeholder="perihal">
            </div>
            <div class="input-field col s12 l2">
              <input type="text" name="file" placeholder="file scan">
            </div>
            <div class="input-field col s12 l2">
              <button type="submit" class="waves-effect waves-green white-text btn-flat green">Save</button>
            </div>
          </div>
          <?= form_close();?>
        </div>
      
      </div>
      <div class="modal-footer">
        <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
        
      </div>
    </div>
<script src="<?= base_url().'assets/js/jquery.uploadPreview.min.js';?>"></script>
<script>
  $(document).ready(function(){
    
    $('.tabs').tabs();
    
     $.uploadPreview({
      input_field: "#image-upload",   // Default: .image-upload
      preview_box: "#image-preview",  // Default: .image-preview
      label_field: "#image-label",    // Default: .image-label
      label_default: "Choose File",   // Default: Choose File
      label_selected: "Change File",  // Default: Change File
      no_label: false,                // Default: false
      success_callback: function() {
        $('#btn-upload').removeClass('hide');
      }
    });
    
    $('#form_cp').on('submit', function(e){
      let form = $(this);
      e.preventDefault();
      let newpassword = $('#newpassword').val();
      let confpass = $('#confpass').val();
      if(newpassword != confpass){
        swal({
          type: 'error',
          text: 'Password didn\'t match',
          showConfirmButton: true,
          allowOutsideClick: false,
        })
      }else{
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."";?>',
          data: $(this).serialize(),
          success: function(result){
            let data = JSON.parse(response);
            if(data.type == 'success'){
            swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
                allowOutsideClick: false,
                showCancelButton:true
              }).then(function(){
                $(form)[0].reset();
                $('.tabs').tabs('select','menu1');
              })
            }else{
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
                allowOutsideClick: false,
                showCancelButton:true
              })
            }
          }
        })
      }
      
    })

    $('#form_pict').submit(function(e){
      let form = this;
      e.preventDefault();
      swal({
        type: 'question',
        text: 'Are you sure to change your profile picture?',
        showConfirmButton: true,
        allowOutsideClick: false,
        showCancelButton:true
      }).then(function(){

        $.ajax({
          url: '<?= base_url()."setting/update_photo_profile";?>',
          type: 'POST',
          data: new FormData(form),
          contentType: false,
          processData: false,
          dataType: 'JSON',
          success: function(data){
            if(data.type == 'success'){
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
                allowOutsideClick: false,
                showCancelButton:true
              }).then(function(){
                window.location.href="<?=base_url().'setting';?>";
                $('.tabs').tabs('select','menu2');
              })
            }else{
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
                allowOutsideClick: false,
                showCancelButton:true
              })
            }
          }
        })
      }, function(isConfirm){
        if(isConfirm == 'cancel'){
          swal({
            type: 'warning',
            text: 'Okay',
            showConfirmButton: true,
          })
        }
      })
    })
    //table 
    $('.select-m').formSelect();
    var table = $('#table').DataTable({
      "lengthMenu": [[5,10,25, 50, -1],[5,10,25,50, "All"]],
      "stateSave": false,
      "processing" : true,
      "serverSide": true,
      "orderClasses": false,
      "autoWidth":false,
      "order": [],
      "ajax":{
        "url": "<?= site_url('Setting/get_data_libur');?>",
        "type": "POST",
        "data": function ( data ) {
                /*data.divisi = $('#divisi-select').val();
                data.tahun = $('#year-select').val();
                data.my_task = $('#my_task').val();*/
        }

      },
      "columns":[
        {"data": ['no']},
        {"data": ['tgl']},
        {"data": ['keterangan']},
        {"data": function(data){
          return "<button class='btn btn-small orange darken-3 edit' data-id='"+data.id_tgl+"'>Edit</button>";
        }},
      ],
      "dom": 'Bflrtip',
              buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
            
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-filter"><i>', attr: {id: 'btn-filter'}}
            ],
      "processing": true,
      "language":{
        "processing": "<div class='warning-alert'><i class='fa fa-circle-o-notch fa-spin'></i> Please wait........",
        "buttons": {
          "copyTitle": "<div class='row'><div class='col push-l3 l9' style='font-size:15px'>Copy to clipboard</div></div>",
          "copyKeys":"Press <i>ctrl</i> or <i>\u2318</i> + <i>C</i> to copy the table data<br>to your system clipboard.<br>To cancel, click this message or press escape.",
          "copySuccess":{
            "_": "%d line tercopy",
            "1": "1 line tercopy"
          }
        }
      },
      "columnDefs": [
            {
              "targets": [ 0, 1,  -1 ],
              "className": 'center'
            },
        ],
      "createdRow" : function(row, data, index){
        $(row).addClass('row');
        $(row).attr('data-id',data['id_tgl']);
        
      }
    
    })
    

    $('#table_setting').DataTable({
      "lengthMenu": [[5,10,25, 50, -1],[5,10,25,50, "All"]],
      "stateSave": false,
      "processing" : true,
      "serverSide": true,
      "orderClasses": false,
      "autoWidth":false,
      "order": [],
      "ajax":{
        "url": "<?= site_url('Setting/get_data_setting');?>",
        "type": "POST",
        "data": function ( data ) {
                /*data.divisi = $('#divisi-select').val();
                data.tahun = $('#year-select').val();
                data.my_task = $('#my_task').val();*/
        }

      },
      "columns":[
        {"data": ['no']},
        {"data": ['nama_setting']},
        {"data": function(data){
          return "<span contenteditable='true' data-id='"+data.id_tgl+"'>"+data.defaultnya+"</span>";
        }},
      ],
      "dom": 'Bflrtip',
              buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
            
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-filter"><i>', attr: {id: 'btn-filter'}}
            ],
      "processing": true,
      "language":{
        "processing": "<div class='warning-alert'><i class='fa fa-circle-o-notch fa-spin'></i> Please wait........",
        "buttons": {
          "copyTitle": "<div class='row'><div class='col push-l3 l9' style='font-size:15px'>Copy to clipboard</div></div>",
          "copyKeys":"Press <i>ctrl</i> or <i>\u2318</i> + <i>C</i> to copy the table data<br>to your system clipboard.<br>To cancel, click this message or press escape.",
          "copySuccess":{
            "_": "%d line tercopy",
            "1": "1 line tercopy"
          }
        }
      },
      "columnDefs": [
            {
              "targets": [ 0, 1,  -1 ],
              "className": 'center'
            },
        ],
      "createdRow" : function(row, data, index){
        $(row).addClass('row');
        $(row).attr('data-id',data['id_tgl']);
        
      }
    
    })


    $('#message').on('keydown', function(e){
      
      if(e.which == 13){
        let msg = $('#message').val();
        let nama = $('#nama').val();
        let sendto = $('#sendto').val();
        let gambar = "<?= $this->Setting_model->dir_foto()->row('defaultnya').$this->User_model->get_user($_SESSION['username'])->profil_pict;?>";
        let data = { nama: nama, msg: msg, sendto: sendto, gambar: gambar };

        
        if(msg.length > 0 && sendto !== null){
          
          $('#message').val('');
          $.ajax({
            type: 'POST',
            url : '<?= base_url()."setting/send_broadcast";?>',
            data: data,
            dataType: 'JSON',
            success : function(data){
              if(data.status == 'success'){
                socket.emit('broadcast', data);

              }
            }
          })
          
        }else if(msg.length > 0 && sendto === null){
          let toastHTML = 'please select receiver at least one';
          M.toast({
            html: toastHTML
          });
        }
      }
    })
    //$('#table_filter label').hide();
     $('#table_filter input ').attr('placeholder', 'Search here...');
      //$('#table_filter label').hide();
      let tagsearch = "<div class='input-field'><label class='active'>Search</label>"+
      "<input type='text' class='validate' id='searchnew' style='margin-left: 0;'>"+
      "</div>";
      $('#table_filter label').html(tagsearch);
    
    $('#btn-filter').on('click', function(e){
      $('#filter').toggleClass('hide');
    })
    $('#searchnew').on('keyup change', function(){
        table
          .search(this.value)
          .draw();
    })
    $('#reload').on('click', function(){ //reload
      $('#table').DataTable().ajax.reload();
    })
    $('.modal').modal();
    $('#add_data').on('click', function(e){
      $('#modal_add').modal('open');
    })
    $("[name='table_length']").formSelect();

  });
</script>