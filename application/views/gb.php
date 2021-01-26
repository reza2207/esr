<div class="row first">
  <!-- <div class="col s12"> -->
  
  <div class="col s12 offset-l3 l9">
    <div class="row" id="filter">
      <div class="col l2">
        <label class="active">Type</label>
        <select class="select-m" id="type">
          <option value="">--Pilih--</option>
          <option value="Penawaran">Penawaran</option>
          <option value="Pelaksanaan">Pelaksanaan</option>
        </select>
      </div>
      <div class="col l2">
        <label class="active">Divisi</label>
        <select class="select-m" id="divisi-select">
          <option value="">--Pilih--</option>
          <option value="BSK">BSK</option>
          <option value="PDM">PDM</option>
          <option value="EBK">EBK</option>
        </select>
      </div>
      <div class="col l2">
      <label class="active">Tahun</label>
        <select class="select-m" id="year-select">
          <?php foreach($year as $y):?>
          <option value="<?= $y->tahun;?>"><?= $y->tahun;?></option>
          <?php endforeach;?>
          <option value="">All</option>
        </select>
      </div>
      <div class="col l2">
        <label class="active">Bulan</label>
        <select class="select-m" id="month-select">
          <option value="">--Pilih--</option>
          <?php for($i = 1; $i <= 12;$i++):?>
          <option value="<?= $i;?>"><?= bulanindo($i);?></option>
          <?php endfor;?>
          
        </select>
      </div>
      <div class="col l2">
        <label class="active">Jenis</label>
        <select class="select-m" id="jenis">
          <option value="Active">Active</option>
          <option value="Penerimaan">Penerimaan</option>
          <option value="Pencairan">Pencairan</option>
          <option value="Expired">Expired</option>
        </select>
      </div>
    </div>
    <ul class="collection with-header"  id="reminder">
      <li class="collection-item red accent-4 white-text"><marquee id="marquee">Ini jalan loh</marquee>
      </li>
    </ul>
    
    <table class="table display"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 10px;width: 100%">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th class='center'>No.</th>
          <th class='center'>No. BG</th>
          <th class='center'>Beneficiary</th>
          <th class='center'>Applicant</th>
          <th class='center'>Issuing Bank / Issuer</th>      
          <th class='center'>CCY</th>
          <th class='center'>Amount</th>
          <th class='center'>EQV Rupiah</th>
          <th class='center'>Open Date</th>
          <th class='center'>Start Date</th>
          <th class='center'>Maturity Date</th>
          <th class='center'>GL Account</th>
          <th class='center'>GB Type</th>
          <th class='center'>Keterangan</th>
          <th class='center'>Pembukuan I</th>
          <th class='center'>Pembukuan II</th>
          <th class='center'>Jenis Pekerjaan</th>
        </tr>
      </thead>
    </table>
  </div>

</div>

<!-- Modal add -->
<div id="modaladd" class="modal modal-fixed-footer">
  <div class="modal-content">
    <?= form_open('',array('id'=>'form_tambah'));?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col s12 l4">
            <input type="text" name="no_bg" class="validate">
            <label>No. BG</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="beneficiary" value="PT. Bank Negara Indonesia (Persero) Tbk" class="validate">
            <label>Beneficiary</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="applicant" class="validate">
            <label>Applicant</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="issuer" class="validate">
            <label>Issuing Bank / Issuer</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="ccy" value="IDR" class="validate">
            <label>CCY</label>
          </div>  
          <div class="input-field col s12 l4">
            <input type="number" name="amount" class="validate">
            <label>Amount</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="number" name="eqv_rupiah" class="validate">
            <label>Eqv Rupiah</label>
          </div>  
          <div class="input-field col s12 l4">
            <input type="text" name="open_date" class="validate datepicker">
            <label>Open Date</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="start_date" class="validate datepicker">
            <label>Start Date</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="maturity_date" class="validate datepicker">
            <label>Maturity Date</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="gl_account" class="validate" value="SL 621201">
            <label>GL Account</label>
          </div>
          <div class="input-field col s12 l4">
            <select class="select-m" name="gb_type">
              <option>--pilih--</option>
              <option value="Penawaran">Penawaran</option>
              <option value="Pelaksanaan">Pelaksanaan</option>
            </select>
            <label>GB Type</label>
          </div>
          <div class="input-field col s12 l4">
            <select name="divisi" class="validate select-m">
              <option value="">--pilih--</option>
              <option value="BSK">BSK</option>
              <option value="PDM">PDM</option>
              <option value="EBK">EBK</option>
            </select>
            <label>Divisi</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="pembukuan_satu" class="validate">
            <label>Pembukuan I</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" name="keterangan" class="validate">
            <label>Keterangan</label>
          </div>
          <!-- <div class="input-field col s12 l12">
            <input type="text" class="validate" name="file_tdr">
            <label>Pembukuan II</label>
          </div> -->
          <div class="input-field col s12 l12">
            <input type="text" name="jenis_pekerjaan" class="validate">
            <label>Jenis Pekerjaan</label>
          </div>
          
        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="save_button" class="green white-text waves-effect waves-green btn-flat">Submit</button>
  </div>
</div>
<!-- end modal add-->
<!-- Modal Edit -->
<div id="modaledit" class="modal modal-fixed-footer">
  <div class="modal-content">
    <?= form_open('',array('id'=>'form_edit'));?>
      <div class="col s12 l12">
        <div class="row">
          <div class="input-field col s12 l6">
            <input id="id_vendor" name="id_vendor" type="text" class="hide">
            <input id="no_srt_vendor" type="text" name="no_vendor" class="validate">
            <label>No. Surat Vendor</label>
          </div>  
          <div class="input-field col s12 l6">
            <input id="nm_vendor" type="text" class="validate" name="nm_vendor">
            <label>Nama Vendor</label>
          </div>
          <div class="input-field col s12 l12">
            <input id="alamat" type="text" class="validate" name="alamat">
            <label>Alamat</label>
          </div>  
          <div class="input-field col s12 l12">
            <input id="sub_bdg_usaha" type="text" class="validate" name="bidang">
            <label>Sub Bidang Usaha</label>
          </div>
          <div class="input-field col s12 l4">
            <input id="tgl_mulai" type="text" class="validate datepicker"name="tgl_berlaku">
            <label>Tgl. Berlaku</label>
          </div>  
          <div class="input-field col s12 l4">
            <input id="tgl_akhir" type="text" class="validate datepicker"name="tgl_berakhir">
            <label>Tgl. Berakhir</label>
          </div>
          <div class="input-field col s12 l4">
            <input id="kualifikasi" type="text" class="validate" name="kualifikasi">
            <label>Kualifikasi</label>
          </div>
          <div class="input-field col s12 l12">
            <input id="file_tdr" type="text" class="validate" name="file_tdr">
            <label>File TDR</label>
          </div>
        </div>
      </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
    <button id="edit-button" class="orange white-text waves-effect waves-green btn-flat">EDIT</button>
  </div>
</div>
<!-- end modal edit-->

<script>
  $(document).ready(function(){
    $(".select2").select2({
      placeholder: 'Select an option',
      //theme: 'material'

    },$('select').css('width','100%'));
    
    
    $('.select-m').formSelect();
    //$('.select2-selection__arrow').addClass("fa fa-spin");
    $('.datepicker').datepicker({
      container: 'body',
      format: 'dd-mm-yyyy',
      autoClose: true,
      disableWeekends:true,
      firstDay:1

    });
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
        "url": "<?= site_url('register/get_data_gb');?>",
        "type": "POST",
        "data": function ( data ) {
                data.divisi = $('#divisi-select').val();
                data.tahun = $('#year-select').val();
                data.jenis = $('#jenis').val();
                data.bulan = $('#month-select').val();
                data.type = $('#type').val();
        }

      },
      "columns":[
        {"data": ['no']},
        {"data": /*['no_bg']*/function(data){
          return data.no_bg;
        }},
        {"data": ['beneficiary']},
        {"data": ['applicant']},
        {"data": ['issuer']},
        {"data": ['ccy']},
        {"data": ['amount']},
        {"data": ['eqv']},
        {"data": ['open']},
        {"data": ['start']},
        {"data": ['maturity']},
        {"data": ['gl_acc']},
        {"data": ['type']},
        {"data": ['keterangan']},
        {"data": ['buku_satu']},
        {"data": ['buku_dua']},
        {"data": ['jenis_pekerjaan']},
      ],
      "dom": 'Bflrtip',
              buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
            { extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>', attr: {'aria-label':'Copy Data','data-balloon-pos':'up'}},
            { extend: 'excel', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-file-excel-o"><i>'},
            { className: 'btn btn-small light-blue darken-4', text: 'Report Bulanan', attr: {id: 'report_monthly','aria-label':'Report Excel','data-balloon-pos':'up'}},
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
                "targets": 3,
                "className": 'center',
                "createdCell": function (td, cellData, rowData, row, col) {
                  
                  
                  //$(td).css('color', 'red')
                  
                } 
            },
            
        ],
      "createdRow" : function(row, data, index){
        $(row).addClass('row');
        $(row).attr('data-id',data['id_gb']);
     
      }
    })
     $('#table_filter input ').attr('placeholder', 'Search here...');
    //$('#table_filter label').hide();
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

    $('#add_data').on('click', function(e){
      $('#modaladd').modal('open');
    })
    $('#reload').on('click', function(){ //reload
      $('#table').DataTable().ajax.reload();
    })
    
    $("[name='table_length']").formSelect();

   
    $('#table tbody').on('click','.edit', function(){
      let id = $(this).attr('data-id');
      $('#modaledit').modal('open');
      $('#modaledit label').addClass('active');
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."tdr/detail_tdr";?>/'+id,
        data: {id: id},
        success: function(result){
          let data = JSON.parse(result);

          $('#id_vendor').val(data.id_vendor)
          $('#no_srt_vendor').val(data.no_srt_vendor);
          $('#nm_vendor').val(data.nm_vendor);
          $('#alamat').val(data.alamat);
          $('#sub_bdg_usaha').val(data.sub_bdg_usaha);
          $('#tgl_mulai').val(tanggal(data.tgl_mulai));
          $('#tgl_akhir').val(tanggal(data.tgl_akhir));
          $('#kualifikasi').val(data.kualifikasi);
          $('#file_tdr').val(data.file_tdr);
        }

      });
    })

    $('#table').on( 'click', 'tbody td:not(:first-child)', function (e) {
      console.log($(this).parent().html())   
    });

    $('#report_monthly').on('click', function(){
      let tahun = $('#year-select').val();
      let bulan = $('#month-select').val();
      window.location.href="<?=base_url().'register/report/';?>"+tahun+'/'+bulan; 
    })


    $('#edit-button').on('click', function(e){
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."tdr/edit_tdr";?>',
        data: $('#form_edit').serialize(),
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
              $('#modaledit').modal('close');
              $('#table').DataTable().ajax.reload();  
            })
          } 
        }
      })
    })

    $('#save_button').on('click', function(e){
      //modaladd
      $.ajax({
        type: 'POST',
        url : '<?= base_url()."register/add_gb";?>',
        data : $('#form_tambah').serialize(),
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
              $('#modaladd').modal('close');
              $('#form_tambah').reset();
              $('#table').DataTable().ajax.reload();  
            })
          }  
        }
      })
    })


  });
  
</script>