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
</style>

<div class="row first">
  
  <!-- <div class="col s12"> -->
  <div class="col s12 offset-l3 l9">
    <!-- <div>
        {{ message }}
        <div v-if="count === 1">
          Green
        </div>
        <div v-else-if="count === 2">
          
        </div>
        <br>
        Sign Up
        <br>
        <input v-model="email" :class="[email.length < 2 ? 'red' : 'green']">
        <button onclick="alert('ss')" :disabled="email.length < 2">
          Submit
        </button>
    </div>   -->
    <ul class="collection" id="reminder" v-if="pks > 0">
      <li class="collection-item red accent-4 white-text"><marquee id="marquee"><?= $pks->num_rows();?> PKS yang akan berakhir </marquee></li>
    </ul>
    <!-- <button id="" class="btn btn-small">[+]Add Data</button> -->
    <table class="table display"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th class="center align-middle">No.</th>
          <th class="center align-middle">Tgl. Permintaan</th>
          <th class="center align-middle">No. Surat Penunjukan</th>
          <th class="center align-middle">No. Usulan Pemenang</th>
          <th class="center align-middle">Nama Vendor</th>
          <th class="center align-middle">Perihal</th>
          <th class="center align-middle">Nominal</th>
          <th class="center align-middle">Tgl. Pekerjaan Awal</th>
          <th class="center align-middle">Tgl. Pekerjaan Akhir</th>
          <th class="center align-middle">Status</th>
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
            <input name="tgl_minta" type="text" class="validate datepicker" value="<?= date('d-m-Y');?>" required>
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
            <input name="perihal" type="text" class="validate" required v-model="perihal">
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
    <button id="save" class="btn-flat white-text waves-effect waves-green teal" :disabled="perihal.length < 2"><i class='fa fa-save'></i> Save</button>
  </div>
</div>
<!-- end modal add-->
<!-- Modal Structure detail-->
<div id="modal_detail" class="modal modal-fixed-footer">
  <div class="modal-content">
       
    <div class="col s12 l12">
      <div class="row">
        <table id="table-detail">
          <tr>
            <td>Perihal</td>
            <td>:</td>
            <td id="d_perihal" style="font-weight: bolder"></td>
          </tr>
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
            <td>Tgl. PKS</td>
            <td>:</td>
            <td id="d_tglpks"></td>
          </tr>
          <tr>
            <td>Status</td>
            <td>:</td>
            <td id="d_status"></td>
          </tr>
          <tr>
            <td>File</td>
            <td>:</td>
            <td id="d_file" style="font-style: italic;font-weight: bolder"></td>
          </tr>
          <tr>
            <td>Reminder Terakhir</td>
            <td>:</td>
            <td id="d_reminder" style="font-weight: bolder">-</td>
          </tr>
        </table>
        <input placeholder="input comment" id="input-comment">
        <div class="collection" id="comment">
        </div>
      </div>
    </div>
  
  </div>
  <div class="modal-footer">
    <?php 
    if($_SESSION['role'] != "user"){?>
    <button class="waves-blue btn-flat left teal white-text" id="btn-comment" aria-label="Tambah Comment" data-balloon-pos="right" title="comment"><i class='fa fa-comment'></i></button>
    <button class="waves-blue btn-flat left orange white-text" id="btn-reminder" aria-label="Reminder Jatuh Tempo PKS" data-balloon-pos="right"><i class='fa fa-mail-forward'></i></button>
    <?php }?>
    
    <?php 
    if(isset($_SESSION['role'])){
      if($_SESSION['role'] == "superuser"){?>
        <button class="waves-effect yellow waves-green btn-flat" id="btn-ubah" aria-label="Edit Data" data-balloon-pos="up"><i class="fa fa-pencil"></i></button>
        <button class="waves-effect red waves-yellow btn-flat white-text" id="btn-hapus" aria-label="Hapus Data" data-balloon-pos="up"><i class="fa fa-trash"></i></button>
    <?php }}?>
    <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
    <?php if($_SESSION['role'] != 'user'){?>
    <button id="proses" class="waves-effect blue waves-green btn-flat white-text">PROSES</button>
    <?php }?>
  </div>
</div>
<!-- end modal detail-->

<div id="modal_reminder" class="modal modal-fixed-footer">
  <div class="modal-content">
       
    <div class="col s12 l12">
      <?= form_open('', array('id'=>'form_reminder'));?>
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
      <div class="row">
        <table id="table-reminder">
          <thead class="center red white-text">
            <tr>
              <th>No.</th>
              <th>No. Surat</th>
              <th>Tgl. Surat</th>
              <th>Perihal</th>
              <th>File</th>
            </th>
          </thead>
          <tbody id="tbody-reminder">
          </tbody>
        </table>        
      </div>
    </div>
  
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
    
  </div>
</div>


<div id="modal_ubah" class="modal modal-fixed-footer  amber darken-4">
  <div class="modal-content">
    <?php $attrf = array('id'=>'formedit');?>
    <?= form_open('',$attrf);?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l6 s12">
            <input name="id_pks" type="text" class="hide" id="eid_pks" required>
            <input name="no_srt_penunjukan" type="text"class="validate" id="eno_penunjukan" required>
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
          <div class="input-field col s12 l12">
            <input name="file" type="text" class="validate" id="efile">
            <label>File PKS</label>
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
    
    <?= form_open('',array('id'=>'formproses'));?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col l3 s12">
            <input type="text" class="hide" name="id" id="pid_pks" required>
            <input type="text" class="" id="ps_penunjukan" name="no_penunjukan" required>
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
  new Vue({
    el: '#modal_tambah',
    data: {
      message: 'You loaded this page on ' + new Date().toLocaleString(),
      count: 0,
      perihal: '',
      pks: '<?= $pks->num_rows();?>'
    }
  })
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
        {"data": ['nominal']},
        {"data": ['tgl_awal']},
        {"data": ['tgl_akhir']},
        {"data": ['status']},
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
              "targets":[ -1, 0, 1, 2, 3, 6, 7,8 ],"className":"center"
            }
        ],
        "createdRow" : function(row, data, index){
          $(row).addClass('row');
          $(row).attr('data-id',data['id_pks']);
          if(data['segera'] == 'Segera'){
            $(row).addClass('orange');
          }
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

    $('tbody').on('click','.row', function(e){
      let id = $(this).attr('data-id');
      $('.modal').modal({
        dismissible : false
      });
      $('#modal_detail').modal('open');
      $('#proses, #btn-reminder, #prosespks, #btn-ubah, #btn-hapus, #update, #btn-comment').attr('data-id', id);
      detail_pks(id);
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
    $('#btn-hapus').on('click', function(){
      let id =  $('#btn-hapus').attr('data-id');
      swal({
        type: 'warning',
        text: 'Are you sure to delete this data?',
        showCancelButton: true,
      }).then(function(){
        $.ajax({
          type: 'POST',
          url: '<?= base_url()."pks/delete_pks";?>',
          data: {id:id},
          dataType: 'JSON',
          success: function(data){
            swal({
              type: data.type,
              text: data.message,
            }).then(function(){
              $('#modal_detail').modal('close');
              socket.emit('reload_table');
            })
          }
        }) 
      })
    })

    $('#btn-reminder').on('click', function(e){
      let id = $(this).attr('data-id');
      $('#idpks').val(id);
      $('#form_reminder').attr('data-id', id);
      $("#modal_reminder").modal('open');
    })
    //end start hapus
    $('#prosespks').on('click', function(e){
      let id = $(this).attr('data-id');
      $.ajax({
        type: 'POST',
        url:'<?= base_url()."pks/proses_pks";?>',
        data: $('#formproses').serialize(),
        dataType: 'JSON',
        success: function(data){
          swal({
            type: data.type,
            text: data.message,
            showConfirmButton: true,
          }).then(function(){
            $('#modal_proses').modal('close');
            //$('#modal_detail').modal('close');
            detail_pks(id);
            $('#table').DataTable().ajax.reload();
            socket.emit('reload_table');
          })
        }
      })
    })
    //btn update
    $('#btn-ubah').on('click', function(e){
      $('#modal_ubah').modal('open');
      e.preventDefault();
      let id = $('#btn-ubah').attr('data-id');      
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
      $('#nominal_rp').on('change', function(){
        let nom = this.value;
        if(nom >= 100000000){
          let bg = Math.ceil(nom / 100*5);
          $('.bg').show();
          $('#nominal_bg').val(bg);
          $('#labelnom').addClass('active');
        } else {
          $('.bg').hide()
          $('#nominal_bg').val('');
        }
      })
      
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
          url : '<?= base_url()."pks/add_data";?>',
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