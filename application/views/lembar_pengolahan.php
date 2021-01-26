<div class="row first">
  <!-- <div class="col s12"> -->
  
  <div class="col s12 offset-l3 l9">
    
    <table class="table display" id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th>#</th>
          <th>No. Surat</th>
          <th>Perihal</th>      
          <th>Dari Kelompok</th>
          <th>Peruntukan</th>
          <th>Tgl. Petugas Kirim</th>
          <th>Tgl. Terima Dokumen</th>
          <th>Status</th>
          <th>Action</th>
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
        <div class="input-field col s12 l6">
          <input name="no_surat" type="text">
          <label class="active">No. Surat</label>
        </div>
        <div class="input-field col l6 s12">
          <label class="active">Kepada</label>
          <select name="divisi" class="select-m">
            <option value="">--pilih--</option>  
            <option value="BSK">BSK</option>
            <option value="PDM">PDM</option>
            <option value="EBK">EBK</option>
            <option value="Others">Lain-lain</option>
          </select>
          
        </div>
        <div class="input-field col s12 l12">
          <input name="perihal" type="text" class="">
          <label class="active">Perihal</label>
        </div>   
        <div class="input-field col s12 l6">
          <input name="dari" value="STL Purchasing BSK">
          <label class="active">Dari Kelompok</label>
        </div>
        <div class="input-field col s12 l6">
          <input name="tgl_kirim" class="datepicker">
          <label class="active">Tgl. Petugas Kirim</label>
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
        "url": "<?= site_url('Register/get_data_pengolahan');?>",
        "type": "POST",
        "data": function ( data ) {
        }

      },
      "columns":[
        {"data": ['no']},
        {"data": ['no_srt']},
        {"data": ['perihal']},
        {"data": ['dari_kelompok']},
        {"data": ['divisi']},
        {"data": ['tgl_petugas_kirim']},
        {"data": ['tgl_terima_doc']},
        {"data": ['status']},
        {"data": ''},
      ],
      "dom": 'Bflrtip',
              buttons: [
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
            { className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
            { extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>', attr: {'aria-label':'Copy Data','data-balloon-pos':'up'}},
            
            { className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-print"><i>', attr: {id: 'btn-print-checklist','aria-label':'Print Checklist','data-balloon-pos':'up'}}
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
                "targets": [ 0, 1, 3,4,5,7,-1 ],
                "className": 'center'
            },
            {
              "targets": [6],
              "className": 'tglterimadoc center'
            },
            {
              "targets":-1,"data":null,"orderable":false,"defaultContent":"</button><button class='detail blue btn-small'><i class='fa fa-eye'></i></button><label><input type='checkbox' class='checkbox' name='check'/><span></span></label>","width":"120px","className":"center"
            }
            
        ],
      "createdRow" : function(row, data, index){
        $(row).addClass('row');
        $(row).attr('data-id',data['id_surat']);
        $(row).children().eq(-1).children().eq(-1).children().attr('data-id',data['id_surat']);
        $(row).children().eq(-1).children().eq(0).attr('data-id',data['id_surat']);
        if(data['status'] == 'Done'){
          $(row).addClass('green accent-1');
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
    // $('#table tbody').on('click', function(e){
    //   alert('s')
    // })

    $("[name='table_length']").formSelect();

    $("#add_data").on('click', function(){
      $('#modal_tambah').modal('open');

    })

    $("#table tbody").on('click','.detail',function(e){
      e.preventDefault();
      $('#modal_detail').modal('open');
      $('#modal_detail label').addClass('active');
      $('#bodycomment').html('');
      $('#comment').val('');
      let id = $(this).attr('data-id');
      $('#hapus-button, #comment').attr('data-id', id);

      $.ajax({
        type: 'POST',
        url : '<?= base_url()."Register/get_data_id_pengolahan";?>',
        data: {id:id, data:'data'},
        success: function(result){
          let data = JSON.parse(result);
          $('#id_srt').val(data.id_surat);
          $('#no_srt').val(data.no_srt);
          $('#divisi').find('option[value="'+data.divisi+'"]').prop('selected', true);
          $('#divisi').formSelect();
          //$('#divisi').val(data.divisi);
          $('#perihal').val(data.perihal);
          $('#dari').val(data.dari_kelompok);
          $('#tgl_kirim').val(tanggal(data.tgl_petugas_kirim));
          if(tanggal(data.tgl_terima_doc) == '-'){          
            $('#proses-button').text('proses');
          }else{
            $('#proses-button').text('edit');
          }
          $('#tgl_terima').val(tanggal(data.tgl_terima_doc));

          get_status(id);

        }
      })
    })
    
    function get_status(id){
      $.ajax({
        type: 'POST',
        url : '<?= base_url()."Register/get_status";?>',
        data: {id:id, data:'status'},
        success: function(result){
          let html = '';
          let data = JSON.parse(result);
          let no = 0;
          
          for(i = 0; i < data.length;i++){
            no++;
            if(i == 0){
              html += '<a class="collection-item green white-text"><span class="new badge" data-badge-caption="'+data[i].tgl_buat+'">'+data[i].nama+' on </span>'+data[i].status+'</a>';
            }else{
              html += '<a class="collection-item"><span class="new badge" data-badge-caption="'+data[i].tgl_buat+'">'+data[i].nama+' on </span>'+data[i].status+'</a>';
            }
          }
          $('#bodycomment').html(html);
        }
      })

    }
    $('#comment').on('keyup', function(e){
      if(e.which == '13'){
        let id = $(this).attr('data-id');
        let value = this.value;
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."register/addstatus";?>',
          data: {id:id, value:value},
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
                get_status(id)
                $('#table').DataTable().ajax.reload();  
              })
            }
          }
        })
      }
    })
    $('#submit_new').on('click', function(e){
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url : '<?= base_url()."Register/add_pengolahan";?>',
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
              $('#formtambah')[0].reset();
              $('#modal_tambah').modal('close');
              $('#table').DataTable().ajax.reload();  
            })
          }
        }
      })
    })
    $('#hapus-button').on('click',function(e){
      let id = $(this).attr('data-id');
      swal({
        type: 'question',
        text: 'Are you sure to delete this data?',
        showConfirmButton: true,
        allowOutsideClick: false,
        showCancelButton: true
      }).then(function(){
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."register/hapus_pengolahan";?>',
          data: {id:id},
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
                $('#modal_detail').modal('close');
                $('#table').DataTable().ajax.reload();  
              })
            }
          }
        })
      }, function(e){
          if(e == 'cancel'){
            swal({
              type: 'success',
              text: 'okay...',
              showConfirmButton: true,
              allowOutsideClick: false,
            })
          }
      })
    })

    $('#proses-button').on('click', function(e){
      e.preventDefault();
      $.ajax({
        type: 'POST',
        data: $('#formedit').serialize(),
        url: '<?= base_url()."register/edit_pengolahan";?>',
        success: function(result){
          let data = JSON.parse(result);
          swal({
            type: data.type,
            text: data.pesan,
            showConfirmButton: true,
            allowOutsideClick: false,
          }).then(function(){
            $('#table').DataTable().ajax.reload();
            $('#modal_detail').modal('close');
          })
        }

      })
    })
    
    $('#btn-print-checklist').on('click', function(e){
      let chkarray = [];
      $('.checkbox:checked').each(function(){
        chkarray.push($(this).attr('data-id'));
      })
      let selected;
      selected = chkarray.join(',');
      if(selected.length > 0){
        window.open("<?=base_url().'register/print_pengolahan';?>?checkid="+selected,target='_blank','width=800,height=500,scrollbars=yes, location=no, resizable=yes');
      }else{
        swal({
          'type':'error',
          'text':'please select at least 1 row'});
      }

    })
      


  });
  
</script>