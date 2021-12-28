<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="<?= base_url().'assets/font-awesome-4.7.0/css/font-awesome.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/sweetalert2.min.css';?>" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="<?= base_url().'assets/materialize/css/materialize.min.css';?>" media="screen,projection"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url().'assets/datatables/DataTables-1.10.13/css/jquery.dataTables.min.css';?>"/>
      <link href="<?= base_url().'assets/css/select2.min.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/balloon.css';?>" rel="stylesheet">
      
      <link href="<?= base_url().'assets/css/reza.css';?>" rel="stylesheet">
      <!-- Include Editor style. -->
      <link href="<?= base_url().'assets/materialSummernote-master/css/materialSummernote.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/materialSummernote-master/css/codeMirror/codemirror.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/materialSummernote-master/css/codeMirror/monokai.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/materializefont.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/animate.min.css';?>" rel="stylesheet">
      
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <!-- <link rel="icon" href="<?= base_url().'gambar/logo_purch.png';?>"> -->
    </head>
    <title><?= $title == "" ? "ESR" : $title;?></title>

<div class="row first">
  
  <!-- <div class="col s12"> -->
  <div class="col s12 offset-l2 l10">
    <h1><u>Log Kerja <?= $nama;?></u></h1>
    
    <blockquote style="font-weight: bold">
        Log Kerja yang masih On Process:
    </blockquote>
    
    <table class="table display centered"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 10px;width: 100%">
      <thead class="deep-orange darken-4 white-text">
        <tr>
          <th>No.</th>
          <th>Tanggal</th>
          <th>Nama</th>
          <th>Kelompok</th>
          <th>Keterangan</th>
          <th>PIC</th>
        </tr>
      </thead>
      <tbody>
        <?php $nos = 1;
        if($pending->num_rows()> 1){
          foreach ($pending->result() as $row) {?>
          <tr>
            <td><?= $nos++;?></td>
            <td><?= tgl_indo($row->tanggal);?></td>
            <td><?= $row->nama;?></td>      
            <td><?= $row->kelompok;?></td>
            <td><?= $row->keterangan;?></td>
            <td><?= $row->pic;?></td>
            
          </tr>
        <?php }
        }else{?>
          <tr>
            <td rowspan="6">Tidak ada data</td>
          </tr>
          
        <?php }?>
      </tbody>
    </table>
    
    <blockquote style="font-weight: bold">
        Log Kerja yang sudah Done:
    </blockquote>
  
    <table class="table display centered"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 10px;width: 100%">
      <thead class="deep-orange darken-4 white-text">
        <tr>
          <th>No.</th>
          <th>Tanggal</th>
          <th>Nama</th>
          <th>Kelompok</th>
          <th>Keterangan</th>
          <th>PIC</th>
          <th>Tgl. Done</th>
          <th>SLI</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data->result() as $row) {?>
          <tr>
            <td><?= $no++;?></td>
            <td><?= tgl_indo($row->tanggal);?></td>
            <td><?= $row->nama;?></td>      
            <td><?= $row->kelompok;?></td>
            <td><?= $row->keterangan;?></td>
            <td><?= $row->pic;?></td>
            <td><?= tgl_indo($row->tgl_done);?></td>
            <td><?= $row->sli.' hari';?></td>
            
          </tr>
        <?php }?>
      </tbody>
    </table>
    
    <?php echo $pagination; ?> 
     
  </div>
  
</div>
<hr>
<div style="text-align:center">- ESR Monitoring System @2021- </div>
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
            { extend: 'excel', className: 'btn btn-small light-blue darken-4', text: 'My Log', attr: {id: 'btn_mylog'}},
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