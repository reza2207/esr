<style>
#table-detail tr:hover
{
background: #D7A42B;color:white;
}
#modal_ubah label{color:white;

}
</style>
<div class="row first">
  <!-- <div class="col s12"> -->
  <div class="col push-l3 l9">
    
    <!-- <button id="" class="btn btn-small">[+]Add Data</button> -->
    <table class="table display" id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="thead-dark teal">
        <tr class="rowhead">
          <th class="text-center align-middle">#</th>
          <th class="text-center align-middle">Tgl. Permintaan</th>
          <th class="text-center align-middle">No. Surat Penunjukan</th>
          <th class="text-center align-middle">No. Usulan Pemenang</th>
          <th class="text-center align-middle">Nama Vendor</th>
          <th class="text-center align-middle">Perihal</th>
          <th class="text-center align-middle">Tgl. Pekerjaan Awal</th>
          <th class="text-center align-middle">Tgl. Pekerjaan Akhir</th>
          <th class="text-center align-middle">Status</th>
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
            <input name="no_srt_penunjukan" type="text" class="validate" required>
            <label class="active">No. Surat Penunjukan</label>
          </div>  
          <div class="input-field col s12 l6">
            <input name="tgl_minta" type="text" class="validate datepicker" value="<?= date('Y-m-d');?>" required>
            <label class="active">Tanggal Permintaan</label>
          </div>
          <div class="input-field col s12 l6">
            <input name="no_usulan" type="text" class="validate" required>
            <label class="active">No. Usulan</label>
          </div>  
          <div class="input-field col s12 l6" style="bottom: -14px;" >
            <select name="id_tdr" class="validate" required>
              <?php foreach ($select_tdr as $v){?>

              <option value = "<?= $v->id_vendor;?>"><?= $v->nm_vendor;?></option>

              <?php }?>
            </select>
            <!-- <input name="id_tdr" type="text" class="validate"> -->
            <label class="active" style="top: -14px;">Vendor</label>
          </div>
          <div class="input-field col s12 l12">
            <input name="perihal" type="text" class="validate" required>
            <label class="active">Perihal</label>
          </div>  
          <div class="input-field col s12 l4">
            <input name="tgl_awal" type="text" class="validate datepicker" required>
            <label class="active">Tgl. Awal Pekerjaan</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_akhir" type="text" class="validate datepicker" required>
            <label class="active">Tgl. Akhir Pekerjaan</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="nominal_rp" type="text" class="validate" id="nominal_rp" required>
            <label class="active">Nominal Rp</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="nominal_usd" type="text" class="validate">
            <label class="active">Nominal USD</label>
          </div>
          <div class="input-field col s12 l4 bg">
            <input name="bank_garansi" type="text" class="validate" id="nominal_bg">
            <label id="labelnom">Nominal Bank Garansi</label>
          </div>
        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="save" class="waves-effect waves-green btn-flat">Save</button>
  </div>
</div>
<!-- end modal add-->
<style>
  #table-detail tr td {
     padding-top:0px;padding-bottom:0px;font-size: 12px
  }

  #table-detail td:first-of-type{
    width: 270px;font-weight: bolder
  }
</style>
<!-- Modal Structure detail-->
<div id="modal_detail" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    
    <div class="col s12 l12">
      <div class="row">
        <table id="table-detail">
          <tr>
            <td>Surat Penunjukan</td>
            <td>:</td>
            <td id="d_srt_pen"></td>
          </tr>
          <tr>
            <td>Vendor</td>
            <td>:</td>
            <td id="d_vendor"></td>
          </tr>
          <tr>
            <td>Perihal</td>
            <td>:</td>
            <td id="d_perihal"></td>
          </tr>
          <tr>
            <td>Tgl. Pekerjaan</td>
            <td>:</td>
            <td id="d_pekerjaan"></td>
          </tr>
          <tr>
            <td>Nominal (Rp)</td>
            <td>:</td>
            <td id="d_nominalrp"></td>
          </tr>
          <tr>
            <td>Bank Garansi (Rp)</td>
            <td>:</td>
            <td id="d_bgrp"></td>
          </tr>
          <tr>
            <td>No. Usulan Pemenang</td>
            <td>:</td>
            <td id="d_usulanp"></td>
          </tr>
          <tr>
            <td>Tgl. Permintaan PKS</td>
            <td>:</td>
            <td id="d_minta"></td>
          </tr>
          <tr>
            <td>Tgl. Draft Dari Legal</td>
            <td>:</td>
            <td id="d_tdraft_ke_legal"></td>
          </tr>
          <tr>
            <td>Tgl. Draft PKS Dari Legal Ke User</td>
            <td>:</td>
            <td id="d_tdraft_ke_user"></td>
          </tr>
          <tr>
            <td>Tgl. Draft PKS Dari Legal Ke Vendor</td>
            <td>:</td>
            <td id="d_tdraft_ke_vendor"></td>
          </tr>
          <tr>
            <td>Tgl. Hasil Review Send ke Legal</td>
            <td>:</td>
            <td id="d_thasil"></td>
          </tr>
          <tr>
            <td>Tgl. Penandatanganan PKS ke Vendor</td>
            <td>:</td>
            <td id="d_ttd_ke_vendor"></td>
          </tr>
          <tr>
            <td>Tgl. Penandatanganan PKS ke Pemimpin </td>
            <td>:</td>
            <td id="d_ttd_ke_pem"></td>
          </tr>
          <tr>
            <td>Tgl. Serah Terima PKS Ke Vendor</td>
            <td>:</td>
            <td id="d_tserahterima"></td>
          </tr>
          <tr>
            <td>No. PKS</td>
            <td>:</td>
            <td id="d_nopks"></td>
          </tr>
          <tr>
            <td>Status</td>
            <td>:</td>
            <td id="d_status"></td>
          </tr>
        </table>
        <input placeholder="input comment" id="input-comment">
        <div class="collection">
        </div>
      </div>
    </div>
  
  </div>
  <div class="modal-footer">
    <button class="waves-blue btn-flat left teal" id="btn-comment"><i class='fa fa-plus-square-o'></i> Comment</button>
    
    <?php 
    if(isset($_SESSION['role'])){
      if($_SESSION['role'] == "superuser"){?>
        <button class="waves-effect yellow waves-green btn-flat" id="btn-ubah"><i class="fa fa-pencil"></i></button>
        <button class="waves-effect red waves-yellow btn-flat" id="btn-hapus"><i class="fa fa-trash"></i></button>
    <?php }}?>
    <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
    <button id="proses" class="waves-effect blue waves-green btn-flat">PROSES</button>
  </div>
</div>
<!-- end modal detail-->
<div id="modal_ubah" class="modal modal-fixed-footer  amber darken-4">
  <div class="modal-content">
    <?php $attrf = array('id'=>'formedit');?>
    <?= form_open('',$attrf);?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l6 s12">
            <input name="no_srt_penunjukan" type="text" class="validate" id="eno_penunjukan" required>
            <label>No. Surat Penunjukan</label>
          </div>  
          <div class="input-field col s12 l6">
            <input name="tgl_minta" type="text" class="validate datepicker" id="etgl_minta" required>
            <label>Tanggal Permintaan</label>
          </div>
          <div class="input-field col s12 l6">
            <input name="no_usulan" type="text" class="validate" id="eno_usulan" required>
            <label>No. Usulan</label>
          </div>  
          <div class="input-field col s12 l6" style="bottom: -14px;" >
            <select name="id_tdr" class="validate" id="eid_tdr"required>
              <?php foreach ($select_tdr as $v){?>
              <option value = "<?= $v->id_vendor;?>"><?= $v->nm_vendor;?></option>
              <?php }?>
            </select>
            <label style="top: -14px;">Vendor</label>
          </div>
          <div class="input-field col s12 l12">
            <input name="perihal" type="text" class="validate" id="eperihal" required>
            <label>Perihal</label>
          </div>  
          <div class="input-field col s12 l4">
            <input name="tgl_awal" type="text" class="validate datepicker" id="etgl_awal" required>
            <label>Tgl. Awal Pekerjaan</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_akhir" type="text" class="validate datepicker" id="etgl_akhir" required>
            <label>Tgl. Akhir Pekerjaan</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="nominal_rp" type="text" class="validate" id="enominal_rp" required>
            <label>Nominal Rp</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="nominal_usd" type="text" class="validate" id="enominal_usd">
            <label>Nominal USD</label>
          </div>
          <div class="input-field col s12 l4 ebg">
            <input name="bank_garansi" type="text" class="validate" id="enominal_bg">
            <label >Nominal Bank Garansi</label>
          </div>

          <!-- start date -->
          <div class="input-field col s12 l4">
            <input name="tgl_draft_dari_legal" type="text" class="validate datepicker" id="edraft_dr_legal">
            <label>Tgl. Draft Dari Legal</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_draft_ke_user" type="text" class="validate datepicker" id="edraft_ke_user">
            <label>Tgl. Draft Ke User</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_draft_ke_vendor" type="text" class="validate datepicker" id="edraft_ke_vendor">
            <label>Tgl. Draft Ke Vendor</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_review_ke_legal" type="text" class="validate datepicker" id="ereview_ke_legal">
            <label>Tgl. Hasil Review Send Ke Legal</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_ttd_ke_vendor" type="text" class="validate datepicker" id="ettd_ke_vendor">
            <label>Tgl. Tanda Tangan ke Vendor</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_ttd_ke_pemimpin" type="text" class="validate datepicker" id="ettd_ke_pemimpin">
            <label>Tgl. Tanda Tangan ke Pemimpin</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_serahterima_pks" type="text" class="validate datepicker" id="e_serahterima">
            <label>Tgl. Serah Terima ke Vendor</label>
          </div>
          <div class="input-field col s12 l6">
            <input name="no_pks" type="text" class="validate" id="eno_pks">
            <label>No. PKS</label>
          </div>
          <div class="input-field col s12 l6">
            <input name="tgl_pks" type="text" class="validate datepicker" id="etgl_pks">
            <label>Tgl. PKS</label>
          </div>
          <!-- end start date-->

        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="update" class="waves-effect waves-green btn-flat">Update</button>
  </div>
</div>

<!-- Modal Structure proses-->
<div id="modal_proses" class="modal modal-fixed-footer">
  <div class="modal-content">
    
    <?php $attrf = array('id'=>'formproses');?>
    <?= form_open('',$attrf);?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l3 s12">
            <input name="no_srt_penunjukan" type="text" class="" id="ps_penunjukan" required>
            <label>No. Surat Penunjukan</label>
          </div>
          <div class="input-field col s12 l9">
            <input name="perihal" type="text" class="" id="pperihal" required>
            <label>Perihal</label>
          </div>
          <!-- start date -->
          <div class="input-field col s12 l4">
            <input name="tgl_draft_dari_legal" class="datepicker" type="text" id="pdraft_dr_legal" readonly>
            <label>Tgl. Draft Dari Legal</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_draft_ke_user" type="text" class="datepicker" id="pdraft_ke_user">
            <label>Tgl. Draft Ke User</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_draft_ke_vendor" type="text" class="datepicker" id="pdraft_ke_vendor">
            <label>Tgl. Draft Ke Vendor</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_review_ke_legal" type="text" class="datepicker" id="preview_ke_legal">
            <label>Tgl. Hasil Review Send Ke Legal</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_ttd_ke_vendor" type="text" class="datepicker" id="pttd_ke_vendor">
            <label>Tgl. Tanda Tangan ke Vendor</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_ttd_ke_pemimpin" type="text" class="datepicker" id="pttd_ke_pemimpin">
            <label>Tgl. Tanda Tangan ke Pemimpin</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_serahterima_pks" type="text" class="datepicker" id="p_serahterima">
            <label>Tgl. Serah Terima ke Vendor</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="no_pks" type="text" id="pno_pks">
            <label>No. PKS</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_pks" type="text" class="datepicker" id="ptgl_pks">
            <label>Tgl. PKS</label>
          </div>
          <!-- end start date-->
        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat" id="btncancel">CANCEL</button>
    <button id="prosespks" class="waves-effect waves-green btn-flat">Save</button>
  </div>
</div>
<!-- end modal add-->
<script>
  $(document).ready(function(){
    $("select").select2({
      placeholder: 'Select an option',
      //theme: 'material'

    },$('select').css('width','100%'));

    //$('.select2-selection__arrow').addClass("fa fa-spin");
    $('.datepicker').datepicker({
      container: 'body',
      format: 'yyyy-mm-dd',
      autoClose: true,

    });
    $('.modal').modal();
    $('.bg').hide();
    var table = $('#table').DataTable({
      "lengthMenu": [[5,10,25, 50, -1],[5,10,25,50, "All"]],
      "stateSave": false,
      "processing" : true,
      "serverSide": true,
      "order": [],
      "ajax":{
        "url": "<?= site_url('pks/get_data_pks');?>",
        "type": "POST",

      },
      "columns":[
        {"data": ['no']},
        {"data": ['tgl_minta']},
        {"data": ['no_penunjukan']},
        {"data": ['no_usulan']},
        {"data": ['nm_vendor']},
        {"data": ['perihal']},
        {"data": ['tgl_awal']},
        {"data": ['tgl_akhir']},
        {"data": ['status']},
      ],
      "dom": 'Bflrtip',
             buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload'}},
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data'} },
            { extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>'},
            { extend: 'csv', className: 'btn btn-small light-blue darken-4'},
            { extend: 'excel', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-file-excel-o"><i>'},

            ],
      "processing": true,
      "language":{
        "processing": "<div class='warning-alert'><i class='fa fa-circle-o-notch fa-spin'></i> Please wait........",
        "buttons": {
          "copyTitle": "<div class='row'><div class='col push-l3 l9' style='font-size:15px'>Copy to clipboard</div></div>",
          "copyKeys":"Press <i>ctrl</i> or <i>\u2318</i> + <i>C</i> to copy the table data<br>to your system clipboard.<br>To cance, click this message or press escape.",
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
            }
        ],
        "createdRow" : function(row, data, index){
          $(row).addClass('row');
          $(row).attr('data-id',data['no_penunjukan']);
        }
      /*"columnDefs": [
      {
        "targets":-1,"data":null,"orderable":false,"width":"150px","defaultContent":"<button class='edit orange darken-2 btn-smallall'>Edit</button><button class='hapus red darken-2 btn-smallall'>Hapus</button>",
      },
      {
        "targets":0,
        "orderable":false,
        "width":"100px",
      },
      ],*/
    })
    $('#table_filter input ').attr('placeholder', 'Search here...');
    //$('#table_filter label').hide();
    var html = "<div class='input-field'><label class='active'>Search</label>"+
    "<input type='text' class='validate' id='searchnew'>"+
    "</div>";
    $('#table_filter label').html(html)

    
    $('#searchnew').on('keyup change', function(){
        table
          .search(this.value)
          .draw();
    })
    $('#reload').on('click', function(){ //reload
      $('#table').DataTable().ajax.reload();
    })
    
    $("[name='table_length']").formSelect();

    $('tbody').on('click','.row', function(e){

      $('.modal').modal({
        dismissible : false
      });
      $('#modal_detail').modal('open');

      var id = $(this).attr('data-id');//table.row($(this).parents('tr')).data();
      $('#btn-ubah').attr('data-id', id);
      $('#btn-hapus').attr('data-id', id);
      $('#btn-comment').attr('data-id', id);
      $('#proses').attr('data-id', id);
      $.ajax({
        type:'POST',
        url: '<?= base_url()."pks/get_detail";?>',
        data: {id:id},
        success: function(response){
          
          var data = JSON.parse(response);
          var pks = data.pks;
          var comment = data.comment;
          var html = "";
          
          $('#d_srt_pen').text(id);
          $('#d_vendor').text(pks.nm_vendor);
          $('#d_perihal').text(pks.perihal);
          $('#d_pekerjaan').text(pks.tgl_krj_awal+' s/d '+pks.tgl_krj_akhir);
          $('#d_nominalrp').text(formatNumber(pks.nominal_rp));
          $('#d_bgrp').text(formatNumber(pks.bg_rp));
          $('#d_usulanp').text(pks.no_notin);
          $('#d_minta').text(pks.tgl_minta);
          $('#d_tdraft_ke_legal').text(pks.tgl_ke_legal);
          $('#d_tdraft_ke_user').text(pks.tgl_draft_ke_user);
          $('#d_tdraft_ke_vendor').text(pks.tgl_draft_ke_vendor);
          $('#d_thasil').text(pks.tgl_review_send_to_legal);
          $('#d_ttd_ke_vendor').text(pks.tgl_ke_vendor);
          $('#d_ttd_ke_pem').text(pks.tgl_blk_dr_vendor_ke_legal);
          $('#d_tserahterima').text(pks.tgl_ke_vendor_kedua);
          $('#d_nopks').text(pks.no_pks);
          $('#d_status').text(pks.status);
          
          if(comment.length > 0){
            for(i = 0;i < comment.length;i++){
            html += '<a class="collection-item"><span class="new badge" data-badge-caption="'+comment[i].comment_date+'">'+comment[i].nama+' on </span>'+comment[i].comment+'</a>';
            
            }
            $('.collection').html(html);
          }else{
            $('.collection').html('');
          }
          
          //
        }
      })
      
     
     /* 

      }); //end proses*/
      
    }) //end tbody row click

    $('#proses').on('click', function(){ //proses 
      $('#modal_proses').modal('open');
      var id = $('#proses').attr('data-id');
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."pks/get_detail";?>',
        data: {id:id,ubah:id},
        success: function(response){
          var data = JSON.parse(response);
          $('#formproses label').addClass('active');
          $('#ps_penunjukan').val(data.no_srt_pelaksana).attr('readonly', true);
          $('#pperihal').val(data.perihal).attr('readonly', true);
          
          var tgl1 = data.tgl_ke_legal;
          var tgl2 =  data.tgl_draft_ke_user;
          var tgl3 = data.tgl_draft_ke_vendor;
          var tgl4 = data.tgl_review_send_to_legal;
          var tgl5 = data.tgl_ke_vendor;
          var tgl6 = data.tgl_blk_dr_vendor_ke_legal;
          var tgl7 = data.tgl_ke_vendor_kedua;
          var tgl8 = data.tgl_pks;
          var nopks = data.no_pks;

          if(tgl1 == '0000-00-00'){

            $('#pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().hide();
            
          }else if(tgl2 == '0000-00-00' || tgl3 == '0000-00-00'){
            
            $('#pdraft_dr_legal').datepicker('destroy');
            $('#pdraft_dr_legal').val(tgl1).attr('readonly', true);
            $('#pdraft_ke_user, #pdraft_ke_vendor').parent().show();
            
            $('#preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().hide();
            
          }else if(tgl4 == '0000-00-00'){
            
            $('#pdraft_dr_legal ').datepicker({
              container: 'body',
              format: 'yyyy-mm-dd',
              autoClose: true,
            });
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor ').datepicker('destroy');

            $('#pdraft_dr_legal').val(tgl1).attr('readonly', true);
            $('#pdraft_ke_user').val(tgl2).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tgl3).attr('readonly', true);

            $('#preview_ke_legal').parent().show();
            
            $('#pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().hide();

          }else if(tgl5 == '0000-00-00'){
            
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor ').datepicker({
              container: 'body',
              format: 'yyyy-mm-dd',
              autoClose: true,

            });
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal').datepicker('destroy');
            $('#pdraft_dr_legal').val(tgl1).attr('readonly', true);
            $('#pdraft_ke_user').val(tgl2).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tgl3).attr('readonly', true);
            $('#preview_ke_legal').val(tgl4).attr('readonly', true);

            $('#pttd_ke_vendor').parent().show();

            $('#pttd_ke_pemimpin, #p_serahterima, #pno_pks, #ptgl_pks').parent().hide();

          }else if(tgl6 == '0000-00-00'){
            
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal').datepicker({
              container: 'body',
              format: 'yyyy-mm-dd',
              autoClose: true,

            });
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor').datepicker('destroy');

            $('#pdraft_dr_legal').val(tgl1).attr('readonly', true);
            $('#pdraft_ke_user').val(tgl2).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tgl3).attr('readonly', true);
            $('#preview_ke_legal').val(tgl4).attr('readonly', true);
            $('#pttd_ke_vendor').val(tgl5).attr('readonly', true);

            $('#pttd_ke_pemimpin').parent().show();

            $('#p_serahterima, #pno_pks, #ptgl_pks').parent().css('display','none');

          }else if(tgl7 == '0000-00-00'){
            
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor').datepicker({
              container: 'body',
              format: 'yyyy-mm-dd',
              autoClose: true,

            });
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin').datepicker('destroy');

            $('#pdraft_dr_legal').val(tgl1).attr('readonly', true);
            $('#pdraft_ke_user').val(tgl2).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tgl3).attr('readonly', true);
            $('#preview_ke_legal').val(tgl4).attr('readonly', true);
            $('#pttd_ke_vendor').val(tgl5).attr('readonly', true);
            $('#pttd_ke_pemimpin').val(tgl6).attr('readonly', true);

            $('#p_serahterima,#pno_pks, #ptgl_pks').parent().show();
          
          }else if((tgl7 != '0000-00-00') && (tgl8 == '0000-00-00' || nopks == '')){
            
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima').datepicker({
              container: 'body',
              format: 'yyyy-mm-dd',
              autoClose: true,

            });

            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima').datepicker('destroy');

            $('#pdraft_dr_legal').val(tgl1).attr('readonly', true);
            $('#pdraft_ke_user').val(tgl2).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tgl3).attr('readonly', true);
            $('#preview_ke_legal').val(tgl4).attr('readonly', true);
            $('#pttd_ke_vendor').val(tgl5).attr('readonly', true);
            $('#pttd_ke_pemimpin').val(tgl6).attr('readonly', true);
            $('#p_serahterima').val(tgl7).attr('readonly', true);

          }else{
            
             $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin,#p_serahterima,#ptgl_pks').datepicker({
              container: 'body',
              format: 'yyyy-mm-dd',
              autoClose: true,

            });
            $('#pdraft_dr_legal , #pdraft_ke_user, #pdraft_ke_vendor, #preview_ke_legal, #pttd_ke_vendor, #pttd_ke_pemimpin, #p_serahterima, #ptgl_pks').datepicker('destroy');

            $('#pdraft_dr_legal').val(tgl1).attr('readonly', true);
            $('#pdraft_ke_user').val(tgl2).attr('readonly', true);
            $('#pdraft_ke_vendor').val(tgl3).attr('readonly', true);
            $('#preview_ke_legal').val(tgl4).attr('readonly', true);
            $('#pttd_ke_vendor').val(tgl5).attr('readonly', true);
            $('#pttd_ke_pemimpin').val(tgl6).attr('readonly', true);
            $('#p_serahterima').val(tgl7).attr('readonly', true);
            $('#ptgl_pks').val(tgl8).attr('readonly', true);
            $('#pno_pks').val(nopks).attr('readonly', true);

            $('#btncancel').text('CLOSE');
            $('#prosespks').hide();
          }
        }
      })
    })

    $('#input-comment').hide();
    $('#btn-comment').on('click', function(){
      $('#input-comment').toggle('slow')
      $('#input-comment').keypress(function(event) {
        //event.preventDefault();
        if(event.key == "Enter"){/* Act on the event */
          var komen = this.value;
          var id = $('#btn-comment').attr('data-id');
          $.ajax({
            type : 'POST',
            url : '<?= base_url()."pks/add_comment";?>',
            data: {id:id, comment:komen},
            success: function(response){
              var data = JSON.parse(response);
              if(data.type == 'success'){
                swal({
                    type: data.type,
                    text: data.message,
                    showConfirmButton: true,
                }).then(function(){
                  var col = '<a class="collection-item"><span class="new badge" data-badge-caption="'+data.comment_date+'">'+data.name+' on </span>'+data.comment+'</a>';
                  ('.collection').prepend(col);
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
    })

    //start hapus
    $('#btn-hapus').on('click', function(){
      var id =  $('#btn-hapus').attr('data-id');
      swal({
        type: 'warning',
        text: 'Are you sure to delete this data?',
        showCancelButton: true,
      }).then(function(){
        $.ajax({
          type: 'POST',
          url: '<?= base_url()."pks/delete_pks";?>',
          data: {id:id},
          success: function(response){
            var data = JSON.parse(response);
            swal({
              type: data.type,
              text: data.message,
            }).then(function(){
              $('#modal_detail').modal('close');
              $('#table').DataTable().ajax.reload();
            })
          }
        }) 
      })
    })
    //end start hapus
    $('#prosespks').on('click', function(e){
      $.ajax({
        type: 'POST',
        url:'<?= base_url()."pks/proses_pks";?>',
        data: $('#formproses').serialize(),
        success: function(response){
          var data = JSON.parse(response);
          swal({
              type: data.type,
              text: data.message,
              showConfirmButton: true,
          }).then(function(){
              $('#modal_proses').modal('close');
              $('#modal_detail').modal('close');
              $('#table').DataTable().ajax.reload();
          })
        }
      })
    })
    //btn update
    $('#btn-ubah').on('click', function(e){
      $('#modal_ubah').modal('open');
      e.preventDefault();
      var id = $('#btn-ubah').attr('data-id');      
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."pks/get_detail";?>',
        data: {id:id,ubah:id},
        success: function(response){
          console.log(response);
          var data = JSON.parse(response);

          $('#eid_tdr').select2().val(data.id_vendor).trigger('change.select2')
          
          $("#modal_ubah label").addClass('active');
          $('#eno_penunjukan').val(data.no_srt_pelaksana);
          $('#etgl_minta').val(cektgl(data.tgl_minta));
          $('#eno_usulan').val(data.no_notin);
          $('#eperihal').val(data.perihal);
          $('#etgl_awal').val(cektgl(data.tgl_krj_awal));
          $('#etgl_akhir').val(cektgl(data.tgl_krj_akhir));
          $('#enominal_rp').val(data.nominal_rp);
          $('#enominal_usd').val(data.nominal_usd);
          $('#enominal_bg').val(data.bg_rp);
          $('#edraft_dr_legal').val(cektgl(data.tgl_ke_legal));
          $('#edraft_ke_user').val(cektgl(data.tgl_draft_ke_user));
          $('#edraft_ke_vendor').val(cektgl(data.tgl_draft_ke_vendor));
          $('#ereview_ke_legal').val(cektgl(data.tgl_review_send_to_legal));
          $('#ettd_ke_vendor').val(cektgl(data.tgl_ke_vendor));
          $('#ettd_ke_pemimpin').val(cektgl(data.tgl_blk_dr_vendor_ke_legal));
          $('#e_serahterima').val(cektgl(data.tgl_ke_vendor_kedua));
          $('#eno_pks').val(data.no_pks);
          $('#etgl_pks').val(cektgl(data.tgl_pks));

          if($('#enominal_rp').val() > 100000000){
            $('.ebg').show();
          }else{
            $('.ebg').hide();
          }
          $('#enominal_rp').on('change', function(){
            var nom = this.value;
            if(nom > 100000000){
              var bg = Math.ceil(nom / 100*5);
              $('.ebg').show();
              $('#enominal_bg').val(bg);
              
            } else {
              $('.ebg').hide()
              $('#enominal_bg').val('');
            }
          })

          $('#update').on('click', function(){
            $.ajax({
              type: 'POST',
              url: '<?= base_url()."pks/update_pks";?>',
              data: $('#formedit').serialize(),
              success: function(response){
                var data = JSON.parse(response);
                swal({
                    type: data.type,
                    text: data.message,
                    showConfirmButton: true,
                }).then(function(){
                  $('#modal_ubah').modal('close');
                  $('#modal_detail').modal('close');
                  $('#table').DataTable().ajax.reload();
                })
              }
            })          
          })
        }
      })
    }) 
    //end btn 

    $("#add_data").on('click', function(){
      $('#modal_tambah').modal('open');
      $('#nominal_rp').on('change', function(){
        var nom = this.value;
        if(nom >= 100000000){
          var bg = Math.ceil(nom / 100*5);
          $('.bg').show();
          $('#nominal_bg').val(bg);
          $('#labelnom').addClass('active');
        } else {
          $('.bg').hide()
          $('#nominal_bg').val('');
        }
      })
      $('#save').on('click', function(){
        alert('h')
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."pks/add_data";?>',
          data: $('#formtambah').serialize(),
          success: function(response){
            var data = JSON.parse(response);

            swal({
              type: data.type,
              text: data.message,
              showConfirmButton: true,
            }).then(function(){
              $('#modal_tambah').modal('close');
              $('#table').DataTable().ajax.reload();
            })
          }
        })
      })
    })
    

  })
</script>