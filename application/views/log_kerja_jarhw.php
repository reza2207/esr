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
  <div class="col s12 offset-l3 l9">
   
    
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
<div id="modal_tambah" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    <?php $attrf = array('id'=>'formtambah');?>
    <?= form_open('',$attrf);?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l6 s12">
            <input name="tanggal" type="text" class="validate datepicker" value="<?= date('d-m-Y');?>" required>
            <label class="active">Tanggal</label>
          </div>  
          <div class="input-field col s12 l6">
            <input name="nama" type="text" class="validate" required>
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
            <input name="keterangan" type="text" class="validate" required nama="keterangan">
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
        "url": "<?= site_url('log_kerja_jhw/get_data');?>",
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
        url: '<?= base_url()."pks/update_pks";?>',
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
      $('#formtambah input').val('');
      
    })
    $('#form_reminder').on('submit', function(e){
      e.preventDefault();
      let id = $(this).attr('data-id');
      let form = $(this);
      swal({
        type: 'question',
        text: 'Are you sure to submit this data?',
        showCancelButton: 'TRUE',
        }).then(function(e){
        $.ajax({
          type : 'POST',
          url  : '<?= base_url()."Pks/submit_reminder";?>',
          data : form.serialize(),
          dataType: 'JSON',
          success: function(data){
            swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
            }).then(function(){
              detail_pks(id);
              $('#idpks').val(id);
            })
          }
        })
      })
    })
    $('#save').on('click', function(){
      
      swal({
        type: 'question',
        text: 'Are you sure to submit this data?',
        showCancelButton: 'TRUE',
        }).then(function(e){
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."Log_kerja_jhw/add_data";?>',
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
    function proses_pks(response, id){

      $('#pdraft_dr_legal, #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks, #pperihal, #ps_penunjukan').val('').attr('readonly', false);
      $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #ptgl_pks').datepicker({
        container: 'body',
        format: 'dd-mm-yyyy',
        autoClose: true,
        disableWeekends:true,
        firstDay:1
      }).datepicker("setDate", new Date());
       $('#pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().show();
      
        let data = response.pks;
          $('#formproses label').addClass('active');
          $('#pid_pks').val(id);
          $('#ps_penunjukan').val(data.no_srt_pelaksana).attr('readonly', true);
          $('#pperihal').val(data.perihal).attr('readonly', true);
          let tgl1 = data.tgl_ke_legal;
          let tgl2 =  data.tgl_draft_ke_user;
          let tgl3 = data.tgl_draft_ke_vendor;
          let tgl4 = data.tgl_review_send_to_legal;
          let tgl5 = data.tgl_ke_vendor;
          let tgl6 = data.tgl_blk_dr_vendor_ke_legal;
          let tgl7 = data.tgl_ke_vendor_kedua;
          let tgl8 = data.tgl_pks;
          let nopks = data.no_pks;

          if(tgl1 == '0000-00-00'){

            $('#pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().hide();
            
          }else if(tgl2 == '0000-00-00' || tgl3 == '0000-00-00'){
            
            $('#pdraft_dr_legal').datepicker('destroy');
            $('#pdraft_dr_legal').val(tanggal(tgl1)).attr('readonly', true);
            $('#pdraft_ke_user').val(tanggal(tgl2)).attr('readonly',false);
            $('#pdraft_ke_vendor').val(tanggal(tgl3)).attr('readonly',false);
            $('#pdraft_ke_user, #pdraft_ke_vendor').parent().show();
            
            $('#preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().hide();
            
          }else if(tgl4 == '0000-00-00'){
            
            $('#pdraft_dr_legal ').datepicker({
              container: 'body',
              format: 'dd-mm-yyyy',
              autoClose: true,
              disableWeekends:true,
              firstDay:1
            }).datepicker("setDate", new Date());
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor ').datepicker('destroy');

            $('#pdraft_dr_legal').val(tanggal(tgl1)).attr('readonly', true);
            $('#pdraft_ke_user').val(tanggal(tgl2)).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tanggal(tgl3)).attr('readonly', true);

            $('#preview_ke_legal').parent().show();
            
            $('#pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().hide();

          }else if(tgl5 == '0000-00-00'){
            
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor ').datepicker({
              container: 'body',
              format: 'dd-mm-yyyy',
              autoClose: true,
              disableWeekends:true,
              firstDay:1
            }).datepicker("setDate", new Date());
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal').datepicker('destroy');
            $('#pdraft_dr_legal').val(tanggal(tgl1)).attr('readonly', true);
            $('#pdraft_ke_user').val(tanggal(tgl2)).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tanggal(tgl3)).attr('readonly', true);
            $('#preview_ke_legal').val(tanggal(tgl4)).attr('readonly', true);

            $('#pttd_ke_vendor').parent().show();

            $('#pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().hide();

          }else if(tgl6 == '0000-00-00'){
            
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal').datepicker({
              container: 'body',
              format: 'dd-mm-yyyy',
              autoClose: true,
              disableWeekends:true,
              firstDay:1
            }).datepicker("setDate", new Date());
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor').datepicker('destroy');

            $('#pdraft_dr_legal').val(tanggal(tgl1)).attr('readonly', true);
            $('#pdraft_ke_user').val(tanggal(tgl2)).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tanggal(tgl3)).attr('readonly', true);
            $('#preview_ke_legal').val(tanggal(tgl4)).attr('readonly', true);
            $('#pttd_ke_vendor').val(tanggal(tgl5)).attr('readonly', true);

            $('#pttd_ke_pemimpin').parent().show();

            $('#p_serahterima, #pno_pks, #ptgl_pks').parent().css('display','none');

          }else if(tgl7 == '0000-00-00'){
            
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor').datepicker({
              container: 'body',
              format: 'dd-mm-yyyy',
              autoClose: true,
              disableWeekends:true,
              firstDay:1
            }).datepicker("setDate", new Date());
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin').datepicker('destroy');

            $('#pdraft_dr_legal').val((tgl1)).attr('readonly', true);
            $('#pdraft_ke_user').val(tanggal(tgl2)).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tanggal(tgl3)).attr('readonly', true);
            $('#preview_ke_legal').val(tanggal(tgl4)).attr('readonly', true);
            $('#pttd_ke_vendor').val(tanggal(tgl5)).attr('readonly', true);
            $('#pttd_ke_pemimpin').val(tanggal(tgl6)).attr('readonly', true);
            
            if(nopks != ''){
              $('#pno_pks').val(nopks).attr('readonly', true);
              
             
            }else{
              $('#pno_pks').val('').attr('readonly', false);
            }
            if(tgl8 != '0000-00-00'){
              $('#ptgl_pks').datepicker('destroy');
             $('#ptgl_pks').val(tanggal(tgl8)).attr('readonly', true);
            }else{
              $('#ptgl_pks').datepicker({
                container: 'body',
                format: 'dd-mm-yyyy',
                autoClose: true,
                disableWeekends:true,
                firstDay:1
              }).datepicker("setDate", new Date());
              $('#ptgl_pks').val('').attr('readonly', false);
            }
            $('#p_serahterima,#pno_pks, #ptgl_pks').parent().show();
          
          }else if((tgl7 != '0000-00-00') && (tgl8 == '0000-00-00')){
            
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima').datepicker({
              container: 'body',
              format: 'dd-mm-yyyy',
              autoClose: true,
              disableWeekends:true,
              firstDay:1
            }).datepicker("setDate", new Date());

            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima').datepicker('destroy');

            $('#pdraft_dr_legal').val(tanggal(tgl1)).attr('readonly', true);
            $('#pdraft_ke_user').val(tanggal(tgl2)).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tanggal(tgl3)).attr('readonly', true);
            $('#preview_ke_legal').val(tanggal(tgl4)).attr('readonly', true);
            $('#pttd_ke_vendor').val(tanggal(tgl5)).attr('readonly', true);
            $('#pttd_ke_pemimpin').val(tanggal(tgl6)).attr('readonly', true);
            $('#p_serahterima').val(tanggal(tgl7)).attr('readonly', true);

          }else{
            
             $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #ptgl_pks').datepicker({
                container: 'body',
                format: 'dd-mm-yyyy',
                autoClose: true,
                disableWeekends:true,
                firstDay:1
              }).datepicker("setDate", new Date());
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #ptgl_pks').datepicker('destroy');

            $('#pdraft_dr_legal').val(tanggal(tgl1)).attr('readonly', true);
            $('#pdraft_ke_user').val(tanggal(tgl2)).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tanggal(tgl3)).attr('readonly', true);
            $('#preview_ke_legal').val(tanggal(tgl4)).attr('readonly', true);
            $('#pttd_ke_vendor').val(tanggal(tgl5)).attr('readonly', true);
            $('#pttd_ke_pemimpin').val(tanggal(tgl6)).attr('readonly', true);
            $('#p_serahterima').val(tanggal(tgl7)).attr('readonly', true);
            $('#ptgl_pks').val(tanggal(tgl8)).attr('readonly', true);
            $('#pno_pks').val(nopks).attr('readonly', true);

            $('#btncancel').text('CLOSE');

            $('#prosespks').hide();
          }
    }

    function detail_pks(id)
    {
      $.ajax({
        type:'POST',
        url: '<?= base_url()."pks/get_detail";?>',
        data: {id:id},
        dataType: 'JSON',
        success: function(data){
          
          let pks = data.pks;
          let html = "";
          
          $('#d_srt_pen').text(pks.no_srt_pelaksana);
          $('#d_vendor').text(pks.nm_vendor);
          $('#d_perihal').text(pks.perihal);
          $('#d_pekerjaan').text(tanggal_indo(pks.tgl_krj_awal)+' s/d '+tanggal_indo(pks.tgl_krj_akhir));
          $('#d_nominalrp').text(formatNumber(pks.nominal_rp));
          if(pks.bg_rp == 0){
            $('#d_bgrp').parent().hide();
          }else{
            $('#d_bgrp').text(formatNumber(pks.bg_rp));
          }
          $('#d_usulanp').text(pks.no_notin);
          $('#d_minta').text(tanggal_indo(pks.tgl_minta));
          if(tanggal_indo(pks.tgl_ke_legal) == '-'){
            $('#d_tdraft_ke_legal').parent().hide()
          }else{
            $('#d_tdraft_ke_legal').parent().show()
            $('#d_tdraft_ke_legal').text(tanggal_indo(pks.tgl_ke_legal));
          }
          if(tanggal_indo(pks.tgl_draft_ke_user) == '-'){
            $('#d_tdraft_ke_user').parent().hide();
          }else{
            $('#d_tdraft_ke_user').parent().show();
            $('#d_tdraft_ke_user').text(tanggal_indo(pks.tgl_draft_ke_user));
          }
          if(tanggal_indo(pks.tgl_draft_ke_vendor) == '-'){
            $('#d_tdraft_ke_vendor').parent().hide();
          }else{
            $('#d_tdraft_ke_vendor').parent().show();
            $('#d_tdraft_ke_vendor').text(tanggal_indo(pks.tgl_draft_ke_vendor));
          }
          if(tanggal_indo(pks.tgl_review_send_to_legal) == '-'){
            $('#d_thasil').parent().hide();
          }else{
            $('#d_thasil').parent().show();
            $('#d_thasil').text(tanggal_indo(pks.tgl_review_send_to_legal));
          }
          if(tanggal_indo(pks.tgl_ke_vendor) =='-'){
            $('#d_ttd_ke_vendor').parent().hide();
          }else{
            $('#d_ttd_ke_vendor').parent().show();
            $('#d_ttd_ke_vendor').text(tanggal_indo(pks.tgl_ke_vendor));
          }
          if(tanggal_indo(pks.tgl_blk_dr_vendor_ke_legal) =='-'){
            $('#d_ttd_ke_pem').parent().hide();
          }else{
            $('#d_ttd_ke_pem').parent().show();
            $('#d_ttd_ke_pem').text(tanggal_indo(pks.tgl_blk_dr_vendor_ke_legal));
          }
          if(tanggal_indo(pks.tgl_ke_vendor_kedua) =='-'){
            $('#d_tserahterima').parent().hide();
          }else{
            $('#d_tserahterima').parent().show();
            $('#d_tserahterima').text(tanggal_indo(pks.tgl_ke_vendor_kedua));
          }
          if(pks.no_pks == ''){
            $('#d_nopks').parent().hide();
          }else{
            $('#d_nopks').parent().show();
            $('#d_nopks').text(pks.no_pks);
          }
          if(tanggal_indo(pks.tgl_pks) == '-'){
            $('#d_tglpks').parent().hide();
          }else{
            $('#d_tglpks').parent().show();
            $('#d_tglpks').text(tanggal_indo(pks.tgl_pks));
          }
          let segera = pks.segera == "" ? "" : "<span style='color:red;font-weight:bolder;font-style:italic;'> ("+pks.segera+")</span>";
          let status = "<span style='font-weight:bolder;color:green;font-style:italic;'>"+pks.status+"</span>"+segera;
          $('#d_status').html(status);
          
          if(pks.status == 'Done' || pks.status == 'On Process'){
            $('#proses, #btn-hapus').hide();
          }else{
            $('#proses, #btn-hapus').show();
          }
          
          if(pks.file != ''){
            let file = "<a href='pks/get_pdf/"+pks.id_pks+"' target='_blank'>"+pks.file+"</a>";            
            $('#d_file').parent().show();
            $('#d_file').html(file);
          }else{
            $('#d_file').parent().hide();
            $('#d_file').html('');

          }
          let tp = 'No. Surat: '+pks.no_surat+' | Perihal: '+pks.prhl;

          let tglr = "<span aria-label='"+tp+"' data-balloon-pos='up'>"+tanggal_indo(pks.tgl_surat)+"</span>";
          $('#d_reminder').html(tglr);
          let comment = data.comment;
          
          if(comment.length > 0){
            for(i = 0;i < comment.length;i++){
              if(i == 0){
                html += '<a class="collection-item green white-text"><span class="new badge" data-badge-caption="'+comment[i].comment_date+'">'+comment[i].nama+' on </span>'+comment[i].comment+'</a>';
              }else{
                html += '<a class="collection-item"><span class="new badge" data-badge-caption="'+comment[i].comment_date+'">'+comment[i].nama+' on </span>'+comment[i].comment+'</a>';
              }
            
            }
            $('#comment').html(html);
          }else{
            $('#comment').html('');
          }
          $('#tbody-reminder').html('');
          let rem = data.reminder;
          let trem = '';
          if(rem.length > 0){
            let i = 0;
            let no = 0;
            for(i;i<rem.length;i++){
              no++;
              trem += "<tr>"+
                        "<td>"+no+"</td>"+
                        "<td>"+rem[i].no_surat+"</td>"+
                        "<td>"+tanggal_indo(rem[i].tgl_surat)+"</td>"+
                        "<td>"+rem[i].perihal+"</td>"+
                        "<td>"+strip(rem[i].file)+"</td>"+
                      "</tr>";
            }
          }else{
            trem = "<tr><td colspan='5'>Tidak ada data</td></tr>";
          }
          $('#tbody-reminder').html(trem);
        }
      })
    }//end function detail table

    function get_comment(id)
    {
      $.ajax({
        type:'POST',
        url: '<?= base_url()."pks/get_comm";?>',
        data: {id:id},
        dataType: 'JSON',
        success: function(comment){
          let html = '';
          if(comment.length > 0){
            for(i = 0;i < comment.length;i++){
              if(i == 0){
                html += '<a class="collection-item green white-text"><span class="new badge" data-badge-caption="'+comment[i].comment_date+'">'+comment[i].nama+' on </span>'+comment[i].comment+'</a>';
              }else{
                html += '<a class="collection-item"><span class="new badge" data-badge-caption="'+comment[i].comment_date+'">'+comment[i].nama+' on </span>'+comment[i].comment+'</a>';
              }
            
            }
            $('#comment').html(html);
          }else{
            $('#comment').html('');
          }
        }
      })
    }
    

  })
</script>