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
          <th class="center align-center">Item</th>
          <th class="center align-center">Merk</th>
          <th class="center align-center">Type</th>
          <th class="center align-center">Warna</th>
          <th class="center align-center">Jumlah</th>
          <th class="center align-center">Divisi</th>
          <th class="center align-center">Tanggal Masuk</th>
          <th class="center align-center">Diinput Oleh</th>
          <?php if($_SESSION['role'] != 'user'){?>
          <th class="center align-middle"></th>
          <?php }?>
        </tr>
      </thead>
    </table>
  </div>
</div>



<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer" style="max-width:350px">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    
    <?= form_open('',array('id'=>'formtambah'));?>
      <div class="col s12 l12">
        <div class="row">
            <div class="input-field col l12 s6">
                <select class="validate select2" name="id_barang">
                    <?php foreach ($item as $i){?>

                    <option value = "<?= $i->id;?>"><?= $i->item." | ".$i->merk." | ".$i->type." | ".$i->warna;?></option>

                    <?php }?>
                </select>
                <label class="active" style="top: -14px;">Barang</label>
            </div>
            <div class="input-field col s6 l12">
                <input name="jml" type="number" id="a_jml" class="validate" required>
                <label class="active" for="a_jml">Jumlah</label>
            </div>
            <div class="input-field col l12 s6">
                <select class="validate selectnew" name="divisi">
                    <?php foreach ($div as $d){?>

                    <option value = "<?= $d->divisi;?>"><?= $d->divisi;?></option>

                    <?php }?>
                </select>
                <label class="active" for="a_merk" style="top: -14px;">Divisi</label>
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
<div id="modal_edit" class="modal modal-fixed-footer" style="max-width:350px">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    
    <?= form_open('',array('id'=>'formedit'));?>
    <div class="col s12 l12">
        <div class="row">
            <div class="input-field col l12 s6">
                <input name="id" type="text" id="e_id" class="validate" hidden required>
                <select class="validate select2" name="id_barang" id="e_barang">
                    <?php foreach ($item as $i){?>

                    <option value = "<?= $i->id;?>"><?= $i->item." | ".$i->merk." | ".$i->type." | ".$i->warna;?></option>

                    <?php }?>
                </select>
                <label class="active" style="top: -14px;">Barang</label>
            </div>
            <div class="input-field col s6 l12">
                <input name="jml" type="number" id="e_jml" class="validate" required>
                <label class="active" for="a_jml">Jumlah</label>
            </div>
            <div class="input-field col l12 s6">
                <select class="validate selectnew" name="divisi" id="e_divisi">
                    <?php foreach ($div as $d){?>

                    <option value = "<?= $d->divisi;?>"><?= $d->divisi;?></option>

                    <?php }?>
                </select>
                <label class="active" for="e_divisi" style="top: -14px;">Divisi</label>
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

    $(".select2").select2({
      placeholder: 'Select an option',
      //theme: 'material'

    },$('select').css('width','100%'));
    $(".selectnew").select2({
        tags: true
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
        "url": "<?= site_url('barang_in/get_data');?>",
        "type": "POST",

      },
      "columns":[
        {"data": ['no']},
        {"data": ['item']},
        {"data": ['merk']},
        {"data": ['type']},
        {"data": ['warna']},
        {"data": ['jumlah']},
        {"data": ['divisi']},
        {"data": ['tgl_masuk']},
        {"data": ['created_by']},
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
                "targets": [ 0, 1, 2,3,4 ],
                "className": ''
            },
            {
              "targets":[ -1, 0, 1,2,3,4,5,6,7,8 ],"className":"center"
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
        url: '<?= base_url()."barang_in/get_detail";?>',
        data: {id:id,ubah:id},
        dataType: 'JSON',
        success: function(data){
          $("#modal_edit label").addClass('active');
          $('#e_id').val(data.id);
          $('#e_barang').select2().val(data.id_barang).trigger('change.select2');
          $('#e_divisi').select2({
        tags: true}).val(data.divisi).trigger('change.select2');
          $('#e_jml').val(data.jumlah);
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
          url: '<?= base_url()."barang_in/update";?>',
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
          url: '<?= base_url()."barang/delete";?>',
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
          url : '<?= base_url()."barang_in/add_data";?>',
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