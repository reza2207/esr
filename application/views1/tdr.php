<div class="row first">
  <!-- <div class="col s12"> -->
  
  <div class="col s12 offset-l3 l9">
    <ul class="collection with-header"  id="reminder">
      <li class="collection-item red accent-4 white-text"><marquee id="marquee"><?= $tdr;?> TDR yang akan berakhir</marquee>
      </li>
    </ul>
    
    <table class="table display"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th class='center'>#</th>
          <th class='center'>No. TDR</th>
          <th class='center'>Nama Vendor</th>      
          <th class='center'>Alamat</th>
          <th class='center'>Sub Bidang Usaha</th>
          <th class='center'>Kualifikasi</th>
          <th class='center'>Tanggal Berlaku</th>
          <th class='center'>Tanggal Berakhir</th>
          <th class='center'>Status</th>
          <th class='center'>Action</th>
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
          <div class="input-field col s12 l6">
            <input type="text" name="no_vendor" class="validate">
            <label>No. Surat Vendor</label>
          </div>  
          <div class="input-field col s12 l6">
            <input type="text" class="validate" name="nm_vendor">
            <label>Nama Vendor</label>
          </div>
          <div class="input-field col s12 l12">
            <input type="text" class="validate" name="alamat">
            <label>Alamat</label>
          </div>  
          <div class="input-field col s12 l12">
            <input type="text" class="validate" name="bidang">
            <label>Sub Bidang Usaha</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" class="validate datepicker" name="tgl_berlaku">
            <label>Tgl. Berlaku</label>
          </div>  
          <div class="input-field col s12 l4">
            <input type="text" class="validate datepicker" name="tgl_berakhir">
            <label>Tgl. Berakhir</label>
          </div>
          <div class="input-field col s12 l4">
            <input type="text" class="validate" name="kualifikasi">
            <label>Kualifikasi</label>
          </div>
          <div class="input-field col s12 l12">
            <input type="text" class="validate" name="file_tdr">
            <label>File TDR</label>
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
    <?php if($_SESSION['role'] != 'user'):?>
    <button id="edit-button" class="orange white-text waves-effect waves-green btn-flat">EDIT</button>
    <?php endif;?>
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
        "url": "<?= site_url('Tdr/get_data_tdr');?>",
        "type": "POST",
        "data": function ( data ) {
                //data.divisi = $('#divisi-select').val();
                //data.tahun = $('#year-select').val();
                //data.my_task = $('#my_task').val();
        }

      },
      "columns":[
        {"data": ['no']},
        {"data": ['no_srt_vendor']},
        {"data": ['nm_vendor']},
        {"data": ['alamat']},
        {"data": ['sub_bdg_usaha']},
        {"data": ['kualifikasi']},
        {"data": ['tgl_mulai']},
        {"data": ['tgl_akhir']},
        {"data": function(data){
          if(data['status'] == 'Expired'){
            return '<span class="deep-orange-text text-accent-4" style="font-weight:bolder;font-style:italic">'+data['status']+'</span>';
          }else if(data['status'] =='Expired Soon'){
            return '<span class="orange-text white" style="font-weight:bolder;font-style:italic">'+data['status']+'</span>';
          }else if(data['status'] == null){
            return null;
          }

          else{
            return '<span class="green-text text-accent-4" style="font-weight:bolder;font-style:italic">'+data['status']+'</span>';
          }
        }},//['status']
        {"data": function(data){
          let id = data['id_vendor'];
          if(data['stat_pdf'] == null){
            return "<button class='edit btn-small' data-id='"+id+"'>Edit</button>";
          } else { 
            <?php if($_SESSION['role'] != 'user'){?>
            return "<button class='pdf btn-small' data-id='"+id+"'><i class='fa fa-eye '></i></button><button class='edit btn-small' data-id='"+id+"'>Edit</button>"
            <?php }else{?>
            return "<button class='pdf btn-small' data-id='"+id+"'><i class='fa fa-eye '></i></button>";
            <?php }?>
          }
        }},
      ],
      "dom": 'Bflrtip',
              buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
            <?php if($_SESSION['role'] != 'user'){?>
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
            <?php }?>
            { extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>', attr: {'aria-label':'Copy Data','data-balloon-pos':'up'}},
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
                "targets": [ 0, 1, 5,6,7,8,-1 ],
                "className": 'center'
            },
            
        ],
      "createdRow" : function(row, data, index){
        $(row).addClass('row');
        $(row).attr('data-id',data['id_vendor']);
     
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

    $('#table').on('click','.pdf', function(e){
      let id = $(this).attr('data-id');
      window.open("<?= base_url().'Tdr/get_pdf/?id=';?>"+id, '_blank');
    })
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
        url : '<?= base_url()."tdr/add_tdr";?>',
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
              $('#form_tambah input').val('');
              $('#table').DataTable().ajax.reload();  
            })
          }  
        }
      })
    })


  });
  
</script>