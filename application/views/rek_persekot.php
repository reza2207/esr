<style>
#table-detail tr:hover
{
background: #D7A42B;color:white;
}
#table-detail tr td {
     padding-top:0px;padding-bottom:0px;font-size: 12px
  }

#table-detail td:first-of-type{
  width: 270px;font-weight: bolder;
}
#table-detail tr:first-of-type{
  background-color: #D7A42B;color:white;
}
#modal_ubah label{
  color:white;
}

.hapus, .edit{
   cursor:pointer;
}
</style>

<div class="row first">
  
  <!-- <div class="col s12"> -->
  <div class="col s12 offset-l2 l10">
   
    
    <!-- <button id="" class="btn btn-small">[+]Add Data</button> -->
    <table class="table display"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th class="center align-middle">No.</th>
          <th class="center align-center">No. Rekening Persekot</th>
          <th class="center align-center">Nama Rekening Persekot</th>
          <?php if($_SESSION['role'] != 'user'){?>
          <th class="center align-middle"></th>
          <?php }?>
        </tr>
      </thead>
    </table>
  </div>
</div>



<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    
    <?= form_open('',array('id'=>'formtambah'));?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l12 s12">
            <input name="no_rek" id="a_no" type="text" class="validate" required>
            <label class="active" for="a_no">No. Rekening</label>
          </div>  
          
        </div>
        <div class="row">
          <div class="input-field col s12 l12">
            <input name="nama_rek" type="text" id="a_nama" class="validate" required>
            <label class="active" for="a_nama">Nama Rekening</label>
          </div>
        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="save" class="btn-flat white-text waves-effect waves-green teal" :disabled="perihal.length < 2"><i class='fa fa-save'></i> Save</button>
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
    }).datepicker("setDate", new Date());
    $('.modal').modal();
    $('.bg').hide();
    let table = $('#table').DataTable({
      "lengthMenu": [[5,10,25, 50, -1],[5,10,25,50, "All"]],
      "stateSave": false,
      "processing" : true,
      "serverSide": true,
      "orderClasses": false,
      "order": [],
      "ajax":{
        "url": "<?= site_url('rek_persekot/get_data');?>",
        "type": "POST",

      },
      "columns":[
        {"data": ['no']},
        {"data": ['no_rek']},
        {"data": ['nama_rek']},
        <?php if($_SESSION['role'] != 'user'){?>        
        {"data": function(data){
            return '<a data-id="'+data["id"]+'" class="edit"><i class="fa fa-pencil"></i></a> | <a data-id="'+data["id"]+'" class="hapus"><i class="fa fa-trash"></i></a>';
        }},
        <?php }?>
      ],
      "dom": 'Bflrtip',
             buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload'}},
            <?php if($_SESSION['role'] != 'user'){?>
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data'} },
            <?php }?>
            { extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>'},
            { extend: 'excel', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-file-excel-o"><i>'},

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
              "targets":[ -1, 0, 1 ],"className":"center"
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
          url: '<?= base_url()."rek_persekot/delete";?>',
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
   
    $('#save').on('click', function(){
      
      swal({
        type: 'question',
        text: 'Are you sure to submit this data?',
        showCancelButton: 'TRUE',
        }).then(function(e){
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."rek_persekot/add_data";?>',
          data: $('#formtambah').serialize(),
          dataType: 'JSON',
          success: function(data){
           
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
        })
      })
    })
    
    socket.on('reload_table', function(data){
      $('#table').DataTable().ajax.reload();
      
    });
  })
</script>