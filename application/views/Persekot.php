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
    <ul class="collection">
      <li class="collection-item red accent-4 white-text"><marquee id="marquee" onMouseOver="this.stop()" onMouseOut="this.start()"><span class="badge white" style="float: none;" id="rem1"><?= $reminder;?></span> <a href="#" class="white-text">Persekot yang akan jatuh tempo</a> | <span class="badge white" style="float: none;" id="rem2"><?= $exp;?></span> <a href="#" class="white-text">Persekot yang belum selesai</a></marquee></li>
    </ul>
    
    
    <div class="row">

      <div class="input-field col s12 l2">
        <input id="awal" type="text" class="validate datepicker" required nama="keterangan">
        <label class="active">Tgl. Awal</label>
      </div>
      <div class="input-field col s12 l2">
        <input id="akhir" type="text" class="validate datepicker" required nama="keterangan">
        <label class="active">Tgl. Akhir</label>
      </div>
      <div class="input-field col s12 l2">
        <button id="filter" class="btn-flat white-text waves-effect waves-green teal"><i class='fa fa-filter'></i></button>
      </div>
    </div>
    

    <!-- <button id="" class="btn btn-small">[+]Add Data</button> -->
    <table class="table display"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th class="center align-middle">No.</th>
          <th class="center align-middle">Tgl. Permintaan</th>
          <th class="center align-center">No. Rekening Persekot</th>
          <th class="center align-center">Nama Rekening Persekot</th>
          <th class="center align-middle">Kelompok/Divisi/User</th>
          <th class="center align-middle">Perihal</th>
          <th class="center align-middle">Nominal</th>
          <th class="center align-middle">Tgl. Proses</th>
          <th class="center align-middle">Tgl. Penyelesaian</th>
          <th class="center align-middle">SLI</th>
          <th class="center align-middle">Status</th>
          <th class="center align-middle">Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>



<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    <?php $attrf = array('id'=>'formtambah');?>
    <?= form_open('',$attrf);?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l6 s12">
            <input name="tanggal_minta" type="text" class="validate datepicker" value="<?= date('d-m-Y');?>" required>
            <label class="active">Tanggal Permintaan</label>
          </div>  
          <div class="input-field col s12 l6" style="bottom: -14px;" >
            <select name="rek_persekot" class="validate" required>
                <?php foreach ($rek as $v){?>

                <option value = "<?= $v->no_rek;?>"><?= $v->no_rek. ' | '. $v->nama_rekening;?></option>

                <?php }?>
                div
            </select>
            <label class="active" style="top: -14px;">No Rek Persekot</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 l12">
          <label class="active" for="a_user">Kelompok/Divisi/User</label>
            <input name="user" type="text" id="a_user" class="validate" required>
            
          </div>
          
          
          <div class="input-field col s12 l12">
            <input name="perihal" type="text" class="validate" id="a_ket" required >
            <label class="active" for="a_ket">Perihal</label>
          </div>
          <div class="input-field col s12 l6">
            <input name="nominal" type="number" class="validate" required id="a_nominal">
            <label class="active" for="a_nominal">Nominal</label>
          </div>
          <div class="input-field col s12 l6">
            <input name="tgl_proses" type="text" class="validate datepicker" id="a_tgl" required>
            <label class="active" for="a_tgl">Tgl. Proses</label>
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
<!-- Modal Structure detail-->
<div id="modal_proses" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    
    <?= form_open('',array('id'=>'formproses'));?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l12 s12">
            <input name="tanggal" type="text" class="validate datepicker">
            <input name="id" type="text" class="validate" id="id_p" hidden>
            <label class="active">Tanggal Penyelesaian</label>
          </div>  
          
        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="proses" class="btn-flat white-text waves-effect waves-green teal" ><i class='fa fa-save'></i> Save</button>
  </div>
</div>
<!-- end modal detail-->
<!-- Modal Structure add-->
<div id="modal_edit" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    <?php $attrf = array('id'=>'formedit');?>
    <?= form_open('',$attrf);?>
      <div class="col s12 l12">
      <input name="id" type="text" class="validate" id="e_id" readonly hidden required>
        <div class="row">
          <div class="input-field col l6 s12">
          
            <input name="tanggal_minta" type="text" class="validate datepicker" id="e_tgl_mnt" required>
            <label class="active">Tanggal Permintaan</label>
          </div>  
          <div class="input-field col s12 l6" style="bottom: -14px;" >
            <select name="rek_persekot" class="validate" id="e_rek" required>
                <?php foreach ($rek as $v){?>

                <option value = "<?= $v->no_rek;?>"><?= $v->no_rek .'|'. $v->nama_rekening;?></option>

                <?php }?>
            </select>
            <label class="active" style="top: -14px;">No Rek Persekot</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 l12">
            <input name="user" type="text" class="validate" id="user_e" required>
            <label class="active">Kelompok/Divisi/User</label>
          </div>
          
          <div class="input-field col s12 l12">
            <input name="perihal" type="text" class="validate" required id="perihal_e">
            <label class="active">Perihal</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="nominal" type="number" class="validate" required id="nominal_e">
            <label class="active">Nominal</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_proses" type="text" class="validate datepicker" required id="tgl_proses_e">
            <label class="active">Tgl. Proses</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_selesai" type="text" class="validate datepicker" required id="tgl_selesai_e">
            <label class="active">Tgl. Penyelesaian</label>
          </div>
        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="update" class="btn-flat white-text waves-effect waves-green orange" :disabled="perihal.length < 2"><i class='fa fa-save'></i> EDIT</button>
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
        "url": "<?= site_url('persekot/get_data');?>",
        "type": "POST",
        "data": function ( data ) {
          console.log(data)
					data.tgla = tanggal_r($('#awal').val());
					data.tglb = tanggal_r($('#akhir').val());
				}
      },
      "columns":[
        {"data": ['no']},
        {"data": ['tgl_minta']},
        {"data": ['no_rek']},
        {"data": ['nama_rek']},
        {"data": ['user']},
        {"data": ['perihal']},
        {"data": ['nominal']},
        {"data": ['tgl_proses']},
        {"data": ['tgl_penyelesaian']},
        {"data": function(data){
            return data['sli'];
        }},
        {"data": function(data){
            if(data["tgl_penyelesaian"] == "-"){
                return '<span class="new badge red proses" data-badge-caption="On Process" style="width:70px" data-id="'+data["id"]+'"></span>';
            }else{
                return '<span class="new badge" data-badge-caption="Done"></span>';
            }
        }},
        {"data": function(data){
            return '<a data-id="'+data["id"]+'" class="edit"><i class="fa fa-pencil"></i></a><a data-id="'+data["id"]+'" class="hapus"> | <i class="fa fa-trash"></i></a>';
        }},
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
              "targets":[ -1, 0, 1,2, 3,4,6, 7, 8, 9, 10 ],
              "className":"center"
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
      //$('#table').DataTable().ajax.reload();
      $('#table').dataTable().fnFilter('');
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
        url: '<?= base_url()."persekot/get_detail";?>',
        data: {id:id,ubah:id},
        dataType: 'JSON',
        success: function(data){
          $("#modal_edit label").addClass('active');
          $('#e_rek').select2().val(data.no_rekening_pskt).trigger('change.select2');
          $('#e_id').val(data.id);
          $('#user_e').val(data.user);
          $('#perihal_e').val(data.perihal);
          $('#nominal_e').val(data.nominal);
          
          $('#e_tgl_mnt').val(tanggal(data.tgl_permintaan));
          $('#tgl_proses_e').val(tanggal(data.tgl_proses));
          $('#tgl_selesai_e').val(tanggal(data.tgl_penyelesaian));
        }
      })
    }) //end tbody row click

   

    $('#reminder').on('click', function(e){
      table.search('segera').draw();
      $('#searchnew').val('');
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
          url: '<?= base_url()."persekot/delete";?>',
          data: {id:id},
          dataType: 'JSON',
          success: function(data){
            swal({
              type: data.type,
              text: data.message,
            }).then(function(){
              
              socket.emit('reminder', data);
            })
          }
        }) 
      })
    })
    $('tbody').on('click','.proses', function(e){
      $('#modal_proses').modal('open');
      
      let id = $(this).attr('data-id');
      $('#id_p').val(id);
    })

    $('#proses').on('click', function(){
      let id = $(this).attr('data-id');
      swal({
        type: 'warning',
        text: 'Are you sure?',
        showCancelButton: true,
      }).then(function(){
        
        $.ajax({
          type: 'POST',
          url: '<?= base_url()."persekot/proses";?>',
          data: $('#formproses').serialize(),
          dataType: 'JSON',
          success: function(data){
            swal({
              type: data.type,
              text: data.message,
            }).then(function(){
              
              socket.emit('reload_table');
              $('#table').DataTable().ajax.reload();
            })
          }
        }) 
      })
    })
    $('#marquee').on('click', function(){
      
      let my_table = $('#table').DataTable()
      my_table
      .page.len(-1) // set the length to -1
      .draw();
      my_table.search('on process').draw();
    })
    //end btn 
    $('#update').on('click', function(){
      
      swal({
        type: 'warning',
        text: 'Are you sure to edit this data?',
        showCancelButton: true,
      }).then(function(){

        $.ajax({
          type: 'POST',
          url: '<?= base_url()."persekot/update";?>',
          data: $('#formedit').serialize(),
          dataType: 'JSON',
          success: function(data){
            
            swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
            }).then(function(){
              $('#modal_edit').modal('close');
              socket.emit('reminder', data);
            })
          }
        })
      })
    })

   

    $("#add_data").on('click', function(){
      $('#modal_tambah').modal('open');
      $('#formtambah input').val('');
      
    })
    $('#filter').on('click', function(){
      $('#table').DataTable().ajax.reload();
    })
    $('#save').on('click', function(){
      
      swal({
        type: 'question',
        text: 'Are you sure to submit this data?',
        showCancelButton: 'TRUE',
        }).then(function(e){
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."persekot/add_data";?>',
          data: $('#formtambah').serialize(),
          dataType: 'JSON',
          success: function(data){
            
            if(data.type == 'success'){
              
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
              }).then(function(){
                $('#formtambah input').val('');
                $('#modal_tambah').modal('close');
                socket.emit('reminder', data);
                
                
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
                
                $('#table').DataTable().ajax.reload();
                
              })
            }
          }
        })
      })
    })
    
    socket.on('reload_table', function(data){
      $('#table').DataTable().ajax.reload();
      
    });
    socket.on('reminder', function(data){
      $('#table').DataTable().ajax.reload();
      $('#rem1').text(data.rem1);
      $('#rem2').text(data.rem2);
      $('#rem_per').text(data.rem2);
      
    })
  

  })
</script>