
<div class="row first">
  
  <!-- <div class="col s12"> -->
  <div class="col s12 offset-l2 l10">
   
    
    <!-- <button id="" class="btn btn-small">[+]Add Data</button> -->
    <table class="table display"  id="table" >
      <thead class="teal white-text">
        <tr class="rowhead">
          <th class="center align-middle">No.</th>
          <th class="center align-center">No. Surat</th>
          <th class="center align-center">Tgl. Surat</th>
          <th class="center align-center">Dari</th>
          <th class="center align-center">Kepada</th>
          <th class="center align-middle">Perihal</th>
          <th class="center align-middle" style="width:25px"></th>
        </tr>
      </thead>
    </table>
    
    <?php
    ;?>
</div>
<div>


<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer" style="min-height:600px">
    <div class="modal-content">
        <h6 id="title-modal"></h6>
    
    <?= form_open('',array('id'=>'formtambah'));?>
        <div class="col s12 l12">
          <div class="row">
            <div class="input-field col l4 s12">
              <input name="tgl" id="tgl" type="text" class="datepicker" required>
              <label for="tgl" class="active">Tanggal</label>
            </div>
            <div class="input-field col l4 s12">
              <input name="rubrik" id="rubrik" type="text" class="" required>
              <label for="rubrik" class="active">No. Rubrik</label>
            </div>
            <div class="input-field col l4 s12">
              <input name="nm" id="nm" type="text" class="">
              <label for="nm" class="active">NM/CC</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l12 s12">
              <input name="tujuan" id="tujuan" type="text" class="" required>
              <label for="tujuan" class="active">Tujuan</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l12 s12">
              <label label for="perihal" class="active" >Perihal</label>  
              <input name="perihal" for="perihal_n" type="text" class="" required>
            </div>
          </div>
        </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="save" class="btn-flat white-text waves-effect waves-green teal"><i class='fa fa-save'></i></button>
  </div>
</div>

<!-- end modal add-->

<!-- Modal Structure edit-->
<div id="modal_edit" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    
    <?= form_open('',array('id'=>'formedit'));?>
    <div class="col s12 l12">
        <div class="row">
        <input name="id" type="text" class="validate" id="e_id" readonly hidden required>
          <div class="input-field col l12 s12">
            <input name="no_rek" type="text" id="no_rek_e" class="validate" required>
            <label class="active">No. Rekening</label>
          </div>  
        </div>
        <div class="row">
          <div class="input-field col s12 l12">
            <input name="nama_rek" id="nama_rek_e" type="text" class="validate" required>
            <label class="active">Nama Rekening</label>
          </div>
        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="update" class="btn-flat white-text waves-effect waves-green orange"><i class='fa fa-save'></i> EDIT</button>
  </div>
</div>

<script>
  
  $(document).ready(function(){
    M.updateTextFields();
    var currentDate = new Date();
    $("select").select2({
      placeholder: 'Select an option',
      //theme: 'material'

    },$('select').css('width','100%'));
    
    //$('.select2-selection__arrow').addClass("fa fa-spin");

    $('.datepicker').datepicker({
      container: 'body',
      format: 'dd-mm-yyyy',
      autoClose: true,
      disableWeekends:true,
      firstDay:1
    }).datepicker("setDate", currentDate);
    $('#tgl').datepicker({
      container: 'body',
      format: 'dd-mm-yyyy',
      autoClose: true,
      disableWeekends:true,
      firstDay:1
    }).datepicker("setDate", currentDate);
    
    $('#tgl').val('12-12-2021');
    $('.modal').modal();
    $('.bg').hide();
    let table = $('#table').DataTable({
      "lengthMenu": [[25, 50, -1],[25,50, "All"]],
      "stateSave": false,
      "processing" : true,
      "serverSide": true,
      "orderClasses": false,
      "order": [],
      "ajax":{
        "url": "<?= site_url('berkas/get_data');?>",
        "type": "POST",

      },
      "columns":[
        {"data": ['no']},
        {"data": ['no_surat']},
        {"data": ['tgl_surat']},
        {"data": ['dari']},
        {"data": ['kepada']},
        {"data": ['perihal']},        
        {"data": function(data){
          return '<i class="fa fa-download" data-id="'+data["id"]+'" ></i>|<i class="fa fa-eye look" data-id="'+data["id"]+'" data-file="'+data["nama_file"]+'"></i><?php if($_SESSION['role'] != 'user'){?>|<i class="fa fa-trash hapus" data-id="'+data["id"]+'" ></i><?php }?>';
        }},
      ],
      "dom": 'Bflrtip',
             buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload'}},
            <?php if($_SESSION['role'] != 'user'){?>
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data'} },
            <?php }?>
            { extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>'},
            

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
                "targets": [ 0, 1, 2 ],
                "className": ''
            },
            {
              "targets":[ -1, 0, 1,2,3,4,5 ],"className":"center"
            }
        ],
        "createdRow" : function(row, data, index){
          $(row).addClass('row');
          $(row).attr('data-id',data['id']);
          
        }
    })
    $('#table_filter input ').attr('placeholder', 'Search here...');
    //$('#table_filter label').hide();
    let tagsearch = "<div class='input-field'><label class='active'>Search</label>"+
    "<input type='text' class='validate' id='searchnew' style='margin-left: 0;'>"+
    "</div>";
    $('#table_filter label').html(tagsearch);

    
    $('#searchnew').on('keyup change', function(){
        table
          .search(this.value)
          .draw();
    })
    $('#reload').on('click', function(){ //reload
      $('#table').DataTable().ajax.reload();
    })
    
    $("[name='table_length']").formSelect();

    $('tbody').on('click','.edit', function(e){
      let id = $(this).attr('data-id');
      $('.modal').modal({
        dismissible : false
      });
      $('#modal_edit').modal('open');
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."rek_persekot/get_detail";?>',
        data: {id:id,ubah:id},
        dataType: 'JSON',
        success: function(data){
          $("#modal_edit label").addClass('active');
          $('#e_id').val(data.id);
          $('#no_rek_e').val(data.no_rek);
          $('#nama_rek_e').val(data.nama_rekening);
        }
      })
    }) //end tbody row click    

    $('#update').on('click', function(){
      
      swal({
        type: 'warning',
        text: 'Are you sure to edit this data?',
        showCancelButton: true,
      }).then(function(){
        
        $.ajax({
          type: 'POST',
          url: '<?= base_url()."rek_persekot/update";?>',
          data: $('#formedit').serialize(),
          dataType: 'JSON',
          success: function(data){
            
            swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
            }).then(function(){
              $('#modal_edit').modal('close');
              socket.emit('reload_table');
            })
          },
          error: function(request, status, error){
            console.log(error)
          }
        })
      })
    })
    //start hapus
    $('tbody').on('click','.hapus', function(e){
      let id = $(this).attr('data-id');
      swal({
        type: 'warning',
        text: 'Are you sure to delete this data?',
        showCancelButton: true,
      }).then(function(){
        
        $.ajax({
          type: 'POST',
          url: '<?= base_url()."berkas/delete";?>',
          data: {id:id},
          dataType: 'JSON',
          success: function(data){
            swal({
              type: data.type,
              text: data.message,
            }).then(function(){
              
              socket.emit('reload_table');
            })
          }
        }) 
      })
    })

    //end btn 
    

    $("#add_data").on('click', function(){
      $('#modal_tambah').modal('open');
      $('#formtambah input').val('');
      
    })

    $('#url').on('change', function(e){
        if(this.value == "newurl"){
          $("#newurl").prop('disabled', false)
        }else{
          $("#newurl").prop('disabled', true)
        }
    })
    $('#save').on('click', function(){
      
      swal({
        type: 'question',
        text: 'Are you sure to submit this data?',
        showCancelButton: 'TRUE',
        }).then(function(e){
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."penomoran_bsk/add_data";?>',
          data: $('#formtambah').serialize(),
          dataType: 'JSON',
          success: function(data){
            if(data.type == 'error'){
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
              })
            }else{
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
              }).then(function(){
                $('#formtambah input').val('');
                $('#modal_tambah').modal('close');
                socket.emit('reload_table');
              })
            }
          }
        })
      })
    })
    $('tbody').on('click','.look', function(e){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-file');
      console.log(id)
      window.open("<?=base_url().'berkas/look';?>/"+id+'/'+nama,target='_blank','width=800,height=1000,scrollbars=yes, location=no, resizable=yes')
   
 
    })
    socket.on('reload_table', function(data){
      $('#table').DataTable().ajax.reload();
      
    });
  })
</script>