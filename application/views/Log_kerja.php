
<div class="row first">
  
  <!-- <div class="col s12"> -->
  <div class="col s12 offset-l2 l10">
   
    
    <!-- <button id="" class="btn btn-small">[+]Add Data</button> -->
    <table class="table display"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th class="center align-middle">No.</th>
          <th class="center align-middle">Tanggal</th>
          <th class="center align-middle">Nama</th>
          <th class="center align-middle">Kelompok</th>
          <th class="center align-middle">Keterangan</th>
          <th class="center align-middle">PIC</th>
          <th class="center align-middle">Status</th>
          <th class="center align-middle">Tgl. Done</th>
          <th class="center align-middle">Jam Input</th>
          <th class="center align-middle"></th>
        </tr>
      </thead>
    </table>
  </div>
</div>



<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer" style="max-width:400px">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    <?php $attrf = array('id'=>'formtambah');?>
    <?= form_open('',$attrf);?>
        <div class="col s12 l12">
            <div class="row">
                <div class="input-field col l12 s12">
                    <input name="tanggal" type="text" class="validate datepicker" value="<?= date('d-m-Y');?>" required>
                    <label class="active">Tanggal</label>
                </div>
                <div class="input-field col s12 l12">
                    <input name="nama" type="text" class="validate" id="nama" required>
                    <label class="active" for="nama">Nama</label>
                </div>
            
                <div class="input-field col s12 l12" style="bottom: -14px;" >
                    <select name="kelompok" class="validate" required>
                    <?php foreach ($kelompok as $v){?>

                        <option value = "<?= $v->nama_kel;?>"><?= $v->nama_kel;?></option>

                    <?php }?>
                        <option value="newvalue">Lainnya</option>
                    </select>
                    <label class="active" style="top: -14px;">Kelompok</label>
                </div>
                <div class="input-field col s12 l12">
                    <input name="keterangan" type="text" class="validate" required id="keterangan">
                    <label class="active" for="keterangan">Keterangan</label>
                </div>  
                <div class="input-field col s12 l12" style="bottom: -14px;" >
                    <select name="status" id="status_n" class="validate" required>
                        <option value="">--pilih--</option>
                        <option value="Done">Done</option>
                        <option value="On Process">On Process</option>
                    </select>
                    <label class="active" style="top: -14px;">Status</label>
                </div>
                <div class="input-field col l12 s12" id="tgl_done_row">
                    <input name="tanggal" type="text" class="validate datepicker" value="<?= date('d-m-Y');?>" id="tgl_done_n" required>
                    <label class="active">Tanggal Done</label>
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
    <?php $attrf = array('id'=>'formproses');?>
    <?= form_open('',$attrf);?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l6 s12">
            <input name="tanggal" type="text" class="validate datepicker" id="tgl_e">
            <label class="active">Tanggal</label>
          </div>  
          <div class="input-field col s12 l6">
            <input name="nama" type="text" class="validate" id="nama_e">
            <label class="active">Nama</label>
          </div>
          
          <div class="input-field col s12 l6" style="bottom: -14px;" >
            <select name="kelompok" class="validate" required>
                <?php foreach ($kelompok as $v){?>

                <option value = "<?= $v->nama_kel;?>"><?= $v->nama_kel;?></option>

                <?php }?>
                
            </select>
            <label class="active" style="top: -14px;">Kelompok</label>
          </div>
          <div class="input-field col s12 l12">
            <input name="keterangan" type="text" class="validate" required v-model="perihal">
            <label class="active">Keterangan</label>
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

<!-- end modal detail-->
<!-- Modal Structure my log-->
<div id="modal_mylog" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    <?php $attrf = array('id'=>'formproses');?>
    <?= form_open('',$attrf);?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l6 s12">
            <input name="tanggal" type="text" class="validate datepicker" id="tgl_e">
            <label class="active">Tanggal</label>
          </div>  
          <div class="input-field col s12 l6">
            <input name="nama" type="text" class="validate" id="nama_e">
            <label class="active">Nama</label>
          </div>
          
          <div class="input-field col s12 l6" style="bottom: -14px;" >
            <select name="kelompok" class="validate" required>
                <?php foreach ($kelompok as $v){?>

                <option value = "<?= $v->nama_kel;?>"><?= $v->nama_kel;?></option>

                <?php }?>
                
            </select>
            <label class="active" style="top: -14px;">Kelompok</label>
          </div>
          <div class="input-field col s12 l12">
            <input name="keterangan" type="text" class="validate" required v-model="perihal">
            <label class="active">Keterangan</label>
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

<!-- end modal mylog-->

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
    }).datepicker("setDate", new Date());;
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
        "url": "<?= site_url('log_kerja/get_data');?>",
        "type": "POST",

      },
      "columns":[
        {"data": ['no']},
        {"data": ['tanggal']},
        {"data": ['nama']},
        {"data": ['kelompok']},
        {"data": ['keterangan']},
        {"data": ['pic']},
        {"data": ['status']},
        {"data": ['tgl_done']},
        {"data": ['jam']},
        {"data": function(data){
            return '<a data-id="'+data["id"]+'" class="edit"><i class="fa fa-pencil"></i></a> | <a data-id="'+data["id"]+'" class="hapus"><i class="fa fa-trash"></i></a>';
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
            { className: 'btn btn-small light-blue darken-4', text: 'My Log', attr: {id: 'btn_mylog'}},
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
              "targets":[ -1, 0, 1, 2, 3, 5, 6, 7,8 ],"className":"center"
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

    $('#btn_mylog').on('click', function(e){
        let selected = "<?= $user ;?>";
        window.open("<?=base_url().'log_kerja/my_log/';?>"+selected,target='_blank','width=800,height=1500,scrollbars=yes, location=no, resizable=yes');
    })
    $('tbody').on('click','.edit', function(e){
      let id = $(this).attr('data-id');
      $('.modal').modal({
        dismissible : false
      });
      $('#modal_proses').modal('open');
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."pks/get_detail";?>',
        data: {id:id,ubah:id},
        dataType: 'JSON',
        success: function(response){
          let data = response.pks;
          $('#eid_tdr').select2().val(data.id_vendor).trigger('change.select2')
          $('#eid_pks').val(id);
          $("#modal_ubah label").addClass('active');
          $('#eno_penunjukan').val(data.no_srt_pelaksana);
          $('#etgl_minta').val(tanggal(data.tgl_minta));
          $('#eno_usulan').val(data.no_notin);
          $('#eperihal').val(data.perihal);
          $('#etgl_awal').val(tanggal(data.tgl_krj_awal));
          $('#etgl_akhir').val(tanggal(data.tgl_krj_akhir));
          $('#enominal_rp').val(data.nominal_rp);
          $('#enominal_usd').val(data.nominal_usd);
          $('#enominal_bg').val(data.bg_rp);
          $('#edraft_dr_legal').val(tanggal(data.tgl_ke_legal));
          $('#edraft_ke_user').val(tanggal(data.tgl_draft_ke_user));
          $('#edraft_ke_vendor').val(tanggal(data.tgl_draft_ke_vendor));
          $('#ereview_ke_legal').val(tanggal(data.tgl_review_send_to_legal));
          $('#ettd_ke_vendor').val(tanggal(data.tgl_ke_vendor));
          $('#ettd_ke_pemimpin').val(tanggal(data.tgl_blk_dr_vendor_ke_legal));
          $('#e_serahterima').val(tanggal(data.tgl_ke_vendor_kedua));
          $('#eno_pks').val(data.no_pks);
          $('#etgl_pks').val(tanggal(data.tgl_pks));
          $('#efile').val(data.file);
          if($('#enominal_rp').val() > 100000000){
            $('.ebg').show();
          }else{
            $('.ebg').hide();
          }
          $('#enominal_rp').on('change', function(){
            let nom = this.value;
            if(nom > 100000000){
              let bg = Math.ceil(nom / 100*5);
              $('.ebg').show();
              $('#enominal_bg').val(bg);
              
            } else {
              $('.ebg').hide()
              $('#enominal_bg').val('');
            }
          })          
        }
      })
    }) //end tbody row click

    $('#proses').on('click', function(){ //proses 
      $('#modal_proses').modal('open');
      let id = $('#proses').attr('data-id');
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."pks/get_detail";?>',
        data: {id:id,ubah:id},
        dataType: 'JSON',
        success: function(response){
          proses_pks(response, id);
          socket.emit('reload_table');
        //ini
        }
      })
    })

    $('#input-comment').hide();
    $('#btn-comment').on('click', function(){
      $('#input-comment').toggle('slow')
    })
    $('#input-comment').keypress(function(event) {
      if(event.key == "Enter"){/* Act on the event */
        let komen = this.value;
        let id = $('#btn-comment').attr('data-id');

        $.ajax({
          type : 'POST',
          url : '<?= base_url()."pks/add_comment";?>',
          data: {id:id, comment:komen},
          dataType: 'JSON',
          success: function(data){
            $('#input-comment').val('');
            if(data.type == 'success'){
              $('#input-comment').val('');
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
              }).then(function(){
                get_comment(id)
              })//ini
            }else{
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
              })
            }
          }
        })
      }
    });
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
          url: '<?= base_url()."log_kerja_jhw/delete";?>',
          data: {id:id},
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

    //end btn 
    $('#update').on('click', function(){
      let id = $(this).attr('data-id');
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."log_kerja/update";?>',
        data: $('#formedit').serialize(),
        success: function(response){
          let data = JSON.parse(response);
          swal({
              type: data.type,
              text: data.message,
              showConfirmButton: true,
          }).then(function(){
            $('#modal_ubah').modal('close');
            detail_pks(id)
            socket.emit('reload_table');
          })
        }
      })
    })
    
    $("#add_data").on('click', function(){
      $('#modal_tambah').modal('open');
      $('#formtambah input, #tgl_done_n input').val('');
      $('#tgl_done_row').addClass('hide');
      
    })
   $('#status_n').on('change', function(e){
       let val = this.value;
       if(val == "Done"){
            $('#tgl_done_row').removeClass('hide');
       }else{
        $('#tgl_done_row').addClass('hide');
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
          url : '<?= base_url()."Log_kerja/add_data";?>',
          data: $('#formtambah').serialize(),
          success: function(response){
           
           let data = JSON.parse(response);
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
        })
      })
    })
    
    socket.on('reload_table', function(data){
      $('#table').DataTable().ajax.reload();
    })
    

   
   
    

  })
</script>