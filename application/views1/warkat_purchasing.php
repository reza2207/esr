<div class="row first">
  <!-- <div class="col s12"> -->
  
  <div class="col s12 offset-l3 l9">
    <div class="row hide" id="filter">
      <div class="col l2">
      <label class="active">Tahun</label>
        <select class="select-m" id="year-select">
          <?php foreach($year as $y):?>
          <option value="<?= $y->tahun;?>"><?= $y->tahun;?></option>
          <?php endforeach;?>
          <option value="All">All</option>
        </select>
      </div>
    </div>
    <table class="table display" id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th>#</th>
          <th>No. Warkat</th>
          <th>Perihal</th>      
          <th>Pemutus</th>
          <th>Petugas</th>
          <th>Nominal</th>
          <th>Tanggal</th>
          <th>Catatan</th>
          <th>Status</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer"> 
  <?= form_open('',array('id'=>'formtambah'));?>
  <div class="modal-content">
    <div class="col s12 l12">
      <div class="row">
        <div class="input-field col s12 l12">
          <input name="perihal" type="text">
          <label class="active">Perihal</label>
        </div>
        <div class="input-field col l6 s12">
          <label class="active">Pemutus</label>
          <select name="pemutus" class="select-m">
            <option value="">--pilih--</option>
            <?php foreach ($pemutus as $pm) {?>
              <option value="<?= $pm->id_pemutus;?>"><?= $pm->nama_pemutus;?></option>
            <?php }?>
            
          </select>
          
        </div>
        <div class="input-field col s12 l6">
          <label class="active">Petugas</label>
          <select name="petugas" class="select-m">
            <option value="">--pilih--</option>  
            <?php foreach ($petugas as $pt) {?>
              <option value="<?= $pt->username;?>"><?= $pt->nama;?></option>
            <?php }?>
          </select>
        </div>   
        <div class="input-field col s12 l6">
          <input name="nominal" type="number" min="1">
          <label class="active">Nominal</label>
        </div>
        <div class="input-field col s12 l6">
          <input name="tanggal" class="datepicker">
          <label class="active">Tanggal</label>
        </div>
        <div class="input-field col s12 l12">
          <input name="catatan" >
          <label class="active">Catatan</label>
        </div>
       
      </div>
    </div>
  </div>
  <?= form_close();?>
  <div class="modal-footer">
    <button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
    <button id="submit_new" class="waves-effect light-blue accent-4 waves-green btn-flat white-text"><i class="fa fa-save"></i></button>
  </div>
</div>
<!-- end modal add-->
<!-- Modal Structure -->
  <div id="modal_detail" class="modal modal-fixed-footer">
    <?= form_open('',array('id'=>'formedit'));?>
    <div class="modal-content">
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col s12 l6">
            <input name="id_surat" type="text" hidden id="id_srt">
            <input name="no_surat" type="text" id="no_srt">
            <label>No. Surat</label>
          </div>
          <div class="input-field col l6 s12">
            <label>Kepada</label>
            <select name="divisi" class="select-m" id="divisi">
              <option value="">--pilih--</option>  
              <option value="BSK">BSK</option>
              <option value="PDM">PDM</option>
              <option value="EBK">EBK</option>
              <option value="Others">Lain-lain</option>
            </select>
            
          </div>
          <div class="input-field col s12 l12">
            <input name="perihal" type="text" id="perihal">
            <label>Perihal</label>
          </div>   
          <div class="input-field col s12 l4">
            <input name="dari" id="dari" value="STL Purchasing BSK">
            <label>Dari Kelompok</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_kirim" id="tgl_kirim" class="datepicker">
            <label>Tgl. Petugas Kirim</label>
          </div>
          <div class="input-field col s12 l4">
            <input name="tgl_terima" id="tgl_terima" class="datepicker">
            <label>Tgl. Terima Doc</label>
          </div>
        </div>
      </div>
      <div class="col s12 l12">
        <div class="row hide" id="row-input-status">
          <div class="input-field col s12 l12">
            <input name="comment" type="text" id="comment" placeholder="input status">
            <label>Status</label>
          </div>
        </div>
        <div class="collection" id="bodycomment">
        </div>
      </div>
    </div>
    
    <?= form_close();?>

    <div class="modal-footer">
      <?php if($_SESSION['role'] != 'user'){?>
      <button class="left waves-effect waves-yellow btn-flat teal white-text" id="addComment">+ Comment</button>
      <?php }?>
      <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
      <?php if($_SESSION['role'] != 'user'){?>
      <button id="hapus-button" class="waves-effect red white-text waves-green btn-flat">DELETE</button>
      <!-- <button id="edit-button" class="waves-effect orange waves-green btn-flat">EDIT</button> -->
      <button id="proses-button" class="waves-effect white-text green waves-green btn-flat">Proses</button>
      <?php }?>
    </div>
  </div>

<script>
  $(document).ready(function(){
    $(".select2").select2({
      placeholder: 'Select an option',
      //theme: 'material'
    },$('select').css('width','100%'));
    
    $('#addComment').on('click', function(e){
      e.preventDefault();
      $('#row-input-status').toggleClass('hide');
    })

    $('.select-m').formSelect();
    //$('.select2-selection__arrow').addClass("fa fa-spin");
    $('.datepicker').datepicker({
      container: 'body',
      format: 'dd-mm-yyyy',
      autoClose: true,
      disableWeekends:true,
      firstDay:1
    }).datepicker("setDate", new Date());
    function selected(status, stat){
      if(status == stat){
        return 'selected';
      
      }else{
        return '';
      }
    }
    $('.modal').modal();
    $('.bg').hide();
    var table = $('#table').DataTable({
      "lengthMenu": [[5,10,25, 50, -1],[5,10,25,50, "All"]],
      "stateSave": false,
      "processing" : true,
      "serverSide": true,
      "orderClasses": false,
      "order": [],
      "ajax":{
        "url": "<?= site_url('Register/get_data_warkat');?>",
        "type": "POST",
        "data": function ( data ) {
          data.tahun = $('#year-select').val();
        }

      },
      "columns":[
        {"data": ['no']},
        {"data": ['no_warkat']},
        {"data": ['perihal']},
        {"data": ['pemutus']},
        {"data": ['petugas']},
        {"data": ['nominal']},
        {"data": ['tanggal']},
        {"data": ['catatan']},
        {"data": function(data){
            $('.select-m').formSelect();
            /*if(data['status']=='done'){
              return 'Done';
            }else{*/
              let status = data.status;
              if(status == ''){
              return "<select class='browser-default status' data-id='"+data['id_warkat']+"'>"+
                      "<option "+selected(status,'none')+">-pilih-</option>"+
                      "<option value='done' "+selected(status,'done')+">Approve</option>"+
                      "<option value='reject' "+selected(status,'reject')+">Reject</option>"+
                    "</select>";

              }else{
                return status;
              }
           
            //}
          }
        }
      ],
      "dom": 'Bflrtip',
              buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
            { extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>', attr: {'aria-label':'Copy Data','data-balloon-pos':'up'}},
            { extend: 'excel', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-file-excel-o"><i>'},
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
                "targets": [ 0, 1,2,3,4,5,6,7,-1 ],
                "className": 'center'
            },
            
        ],
      "createdRow" : function(row, data, index){
        $(row).addClass('row');
        $(row).attr('data-id',data['id_warkat']);
        $(row).children().eq(-1).children().eq(-1).children().attr('data-id',data['id_warkat']);
        $(row).children().eq(-1).children().eq(0).attr('data-id',data['id_warkat']);
        if(data['status'] == 'Done'){
          $(row).addClass('amber lighten-3');
        }
      }
    })
    
    $('#table_filter input ').attr('placeholder', 'Search here...');
    let tagsearch = "<div class='input-field'><label class='active'>Search</label>"+
    "<input type='text' class='validate' id='searchnew' style='margin-left: 0;'>"+
    "</div>";
    $('#table_filter label').html(tagsearch);
    
    $('#btn-filter').on('click', function(e){
      $('#filter').toggleClass('hide')
    })
    $('#searchnew').on('keyup change', function(){
        table
          .search(this.value)
          .draw();
    })
    $('#reload').on('click', function(){ //reload
      $('#table').DataTable().ajax.reload();
    })

    $("[name='table_length']").formSelect();

    $("#add_data").on('click', function(){
      $('#modal_tambah').modal('open');

    })
    $("#table tbody").on('change','.status', function(e){
      e.preventDefault();
      id = $(this).attr('data-id');
      val = this.value;
      $.ajax({
        type: 'POST',
        url : '<?= base_url()."register/update_warkat";?>',
        data: {id:id, value:val},
        success: function(result){
          $('#table').DataTable().ajax.reload();
        }
      })
    })
       
    $('#submit_new').on('click', function(e){
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url : '<?= base_url()."Register/add_warkat";?>',
        data: $('#formtambah').serialize(),
        success: function(result){
          let data = JSON.parse(result);
          if(data.type == 'error'){
            swal({
              type: data.type,
              text: data.pesan,
              showConfirmButton: true,
              allowOutsideClick: false,
            })
          }else{
            swal({
              type: data.type,
              text: data.pesan,
              showConfirmButton: true,
              allowOutsideClick: false,
            }).then(function(){
              $('#formtambah input').val('');
              $('#modal_tambah').modal('close');
              $('#table').DataTable().ajax.reload();  
            })
          } 
        }
      })
    })
  });
  
</script>