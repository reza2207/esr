<style>
	#table-detail tr td {
			padding-top:0px;padding-bottom:0px;font-size: 12px
	}

	/*#table-detail td:nth-child(2)::before{
			content: ':';
			padding-right: 15px
		}*/
	
	#table-detail td:first-of-type{
		width: 100px;
		font-weight: bolder
	}
	#table-detail td:nth-child(2), #table-detail td:nth-child(5), #table-detail td:nth-child(8){
		width: 10px;
	}
	#table-detail td:nth-child(3){
		width: 20%;
	}
	#table-detail td:nth-child(6){
		width: 13%;
	}
	#table-detail td:nth-child(4){
		width: 80px;
		font-weight: bolder;
	}
	#table-detail td:nth-child(7){
		width: 105px;
		font-weight: bolder;
	}
	#table-detail tr:hover{
	background: #FFA500;
	color:white;
	}
	#d_perihal{
		background-color: #009CFF;font-family: comfortaa;text-align: center;color:white;
	}
	
</style>
<div class="row first">

	<div class="col s12 offset-l3 l9">
		<div class="row hide" id="filter">
			<div class="col l2">
				<label class="active">My Task</label>
				<select class="select-m" id="my_task">
					<option value="">--Pilih--</option>
					<option value="On Process">On Process</option>
					<option value="Finished">Finished</option>
					<option value="All">All</option>
				</select>
			</div>
		</div>
		
		<table class="table display" id="table" style="width: 100%">
			<thead class="teal white-text">
				<tr class="rowhead">
					<th class="center align-middle">#</th>
					<th class="center align-middle">Tgl.</th>
					<th class="center align-middle">Perihal</th>
					<th class="center align-middle">Due Date</th>
					<th class="center align-middle">Status</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer" style="width: 400px"> 
	<div class="modal-content">
		<h6 id="title-modal"></h6>
		<?php $attrf = array('id'=>'formtambah');?>
		<?= form_open('',$attrf);?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col s12 l12">
						<input name="date" type="text" class="datepicker" value="<?= date('d-m-Y');?>">
						<label class="active">Tanggal</label>
					</div>
					
					<!-- jika email -->
					<div class="input-field col s12 l12">
						<input name="perihal" class="">
						<label class="active">Perihal</label>
					</div>
					<div class="input-field col s12 l12">
						<input name="due_date" class="datepicker">
						<label class="active">Due Date</label>
					</div>
				</div>
			</div>
		<?= form_close();?>
	</div>
	
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="submit_new" class="waves-effect light-blue accent-4 waves-green btn-flat white-text"><i class="fa fa-save"></i></button>
	</div>	
</div>
<!-- end modal add-->

<!-- Modal Structure detail-->
<div id="modal_detail" class="modal modal-fixed-footer">
	<div class="modal-content">
		
		<div class="col s12 l12">
			<div class="row">
				<div id="d_perihal"></div>
				<table id="table-detail">
					
					<tr>
						<td>Jenis Surat</td>
						<td>:</td>
						<td colspan="4" id="d_jenis_surat"></td>
						<td class='d_tempat'>Tempat Pengadaan</td>
						<td class='d_tempat'>:</td>
						<td class='d_tempat' id="d_tempat_pengadaan"></td>
					</tr>
					<tr>
						<td>Divisi</td>
						<td>:</td>
						<td id="d_divisi"></td>
					
						<td style="font-weight: bold">Kelompok</td>
						<td>:</td>
						<td id="d_kelompok"></td>
					
						<td style="font-weight: bold">User</td>
						<td>:</td>
						<td id="d_user"></td>
					</tr>
					<tr class="row-email">
						<td>Email</td>
						<td>:</td>
						<td id="d_email"></td>
						<td style="font-weight: bold">Tgl. Email</td>
						<td>:</td>
						<td id="d_tgl_email"></td>
						<td style="font-weight: bold">Tgl. Terima Email</td>
						<td>:</td>
						<td id="d_tgl_t_email"></td>
					</tr>
					
					<tr class="row-surat">
						<td>No. Surat</td>
						<td>:</td>
						<td id="d_no_surat"></td>
						<td style="font-weight: bold">Tgl. Surat</td>
						<td>:</td>
						<td id="d_tgl_surat"></td>
						<td style="font-weight: bold">Tgl. Terima Surat</td>
						<td>:</td>
						<td id="d_terima_surat"></td>
					</tr>
					
					<tr>
						<td class="ddpimkel">Tgl. Disposisi Pimkel</td>
						<td class="ddpimkel">:</td>
						<td class="ddpimkel"id="d_disposisi_pimkel"></td>
						<td class="ddmanager" style="font-weight: bold">Tgl. Disposisi Manager</td>
						<td class="ddmanager">:</td>
						<td class="ddmanager" id="d_disposisi_manager"></td>
						<td class="ddpembuat" style="font-weight: bold">Pembuat Pekerjaan</td>
						<td class="ddpembuat">:</td>
						<td class="ddpembuat" id="d_pembuat"></td>
					</tr>
					<tr class="hide">
						<td>Username Pembuat</td>
						<td>:</td>
						<td id="d_unamepembuat"></td>
					</tr>
					<tr>
						<td>Metode Pengadaan</td>
						<td>:</td>
						<td id="d_jenis_pengadaan" colspan="7"></td>
					</tr>
					<tr class='spk'>
						<td>Nama Vendor</td>
						<td>:</td>
						<td id="ds_vendor"></td>
						<td>No. SPK</td>
						<td>:</td>
						<td id="d_no_spk"></td>
						<td>Tgl. SPK</td>
						<td>:</td>
						<td id="d_tgl_spk"></td>
						
					</tr>
					<tr>
						<td>Status Data</td>
						<td>:</td>
						<td style="font-style: italic;font-weight: bolder" colspan="7"><div id="d_status_data"></div></td>
					</tr>
				</table>
			</div>
		</div>
	
	</div>
	<div class="modal-footer">
		<?php if($_SESSION['role'] == "admin" && $_SESSION['jabatan'] == 'mgr'){?>
		<button class="waves-blue btn-flat left teal white-text" id="btn-disposisi">Disposisi</button>
		<?php }
		
		elseif($_SESSION['role'] != "user"){?>
		<button class="waves-blue btn-flat left teal white-text" id="update_surat">Update Surat</button>
		<button class="waves-blue btn-flat left teal white-text" id="btn-disposisi">Disposisi</button>
		<button class="waves-blue btn-flat left teal white-text" id="btn-jenis">Metode Pengadaan</button>
		<button class="waves-blue btn-flat left teal white-text" id="btn-aanwijzing">Aanwijzing</button>
		<button class="waves-effect yellow waves-green btn-flat" id="btn-return" aria-label="Return" data-balloon-pos="up"><i class="fa fa-rotate-left"></i></button>
		<button class="waves-effect yellow waves-green btn-flat" id="btn-ubah" aria-label="Edit" data-balloon-pos="up"><i class="fa fa-pencil"></i></button>
		<button class="waves-effect red waves-yellow btn-flat white-text" id="btn-hapus" title="delete" aria-label="Delete" data-balloon-pos="up"><i class="fa fa-trash"></i></button>
		<button class="waves-effect green waves-green btn-flat white-text" id="btn-proses" aria-label="Proses" data-balloon-pos="up"><i class="fa fa-pencil-square-o"></i></button>
		
		<?php 
		}
		?>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
	</div>
</div>

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
				"url": "<?= site_url('Register/get_data_task');?>",
				"type": "POST",
				"data": function ( data ) {
				}

			},
			"columns":[
				{"data": ['no']},
				{"data": ['date']},
				{"data": ['perihal']},
				{"data": ['due_date']},
				{"data": ['status']},
			],
			"dom": 'Bflrtip',
							buttons: [
						{ className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
						{ className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
						{ extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>', attr: {'aria-label':'Copy Data','data-balloon-pos':'up'}},
						
						{ className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-filter"><i>', attr: {id: 'btn-filter'}}
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
							"targets": [ 0, 1, 2, 3, -1 ],
							"className": 'center'
						},
						{
							"targets": [1,3],
							"width": '50px'
						}
				],
			"createdRow" : function(row, data, index){
				$(row).addClass('row');
				$(row).attr('data-id',data['id_task']);
				
			}
		
		})
		
		//$('#table_filter label').hide();
		 $('#table_filter input ').attr('placeholder', 'Search here...');
	    //$('#table_filter label').hide();
	    let tagsearch = "<div class='input-field'><label class='active'>Search</label>"+
	    "<input type='text' class='validate' id='searchnew' style='margin-left: 0;'>"+
	    "</div>";
	    $('#table_filter label').html(tagsearch);
		
		$('#btn-filter').on('click', function(e){
			$('#filter').toggleClass('hide');
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

		
		$('#btn-hapus').on('click', function(e){
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you sure deleting this data?',
				showConfirmButton: true,
				allowOutsideClick: false,
				showCancelButton:true
			}).then(function(){
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."Register/hapus_data";?>',
					data: {id: id},
					success: function(result){
						let data = JSON.parse(result);
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
				})
			})
		})
		$("#add_data").on('click', function(){
			$('#modal_tambah').modal('open');

		})

		$('#submit_new').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url : '<?= base_url()."Register/add_data_masuk";?>',
				data: $('#formtambah').serialize(),
				success: function(response){
					let data = JSON.parse(response);
					if(data.type == 'error'){
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
						})
					}else{
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
						}).then(function(){
							$('#modal_tambah').modal('close');
							$('#formtambah input').val('');
							
						})
						$('#table').DataTable().ajax.reload();
					}
				}
			})
		})

				
	})
	
</script>