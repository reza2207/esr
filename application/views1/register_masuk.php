<style>
	#table-doc tr > th, #table-doc tr > td{
		height: 10px !important;
		padding-bottom: 0;
		padding-top: 0;
	}
	#table-detail tr > td{
		height: 10px !important;
		padding-top: 0;
		padding-bottom: 0;
	}
	#table-detail tr:hover{
		background-color: yellow;
	}
	#table-detail tr td:first-of-type{
		font-weight: bolder;
	}
	#d_id_register{
		text-decoration-line: underline
	}
	#d_status_data{
		font-style: italic;
		font-weight: bolder
	}
</style>

<div class="waiting hide" id="waiting">
  <div class="warning-alert">
    <div class="loader">
      <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="warning-text">Loading...<i class='fa fa-smile-o'></i></div>
  </div>
</div>

<div class="row first">

	<div class="col s12 offset-l3 l9">
		<div class="row hide" id="filter">
			<div class="col l2">
				<label class="active">Status</label>
				<select class="select-m" id="my_task">
					<option value="All">--Pilih--</option>
					<?php foreach($status as $s){?>
						<option value="<?= $s->id_status;?>"><?= $s->keterangan;?></option>
					<?php };?>
				</select>
			</div>
			<div class="col l2">
				<label class="active">Divisi</label>
				<select class="select-m" id="divisi-select">
					<option value="All">--Pilih--</option>
					<option value="BSK">BSK</option>
					<option value="PDM">PDM</option>
					<option value="EBK">EBK</option>
					<option value="Others">Lain-lain</option>
				</select>
			</div>
			<div class="col l2">
			<label class="active">Tahun</label>
				<select class="select-m" id="year-select">
					<option value="All">--Pilih-- </option>
					<?php foreach($year as $y):?>
					<option value="<?= $y->tahun;?>"><?= $y->tahun;?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		
		<table class="table display" id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
			<thead class="teal white-text">
				<tr>
					<th class="center align-middle">#</th>
					<th class="center align-middle">Tgl. Surat</th>
					<th class="center align-middle">No. Surat</th>
					<th class="center align-middle">Tgl. Terima Surat</th>
					<th class="center align-middle">Perihal</th>
					<th class="center align-middle">Jenis</th>
					<th class="center align-middle">Status</th>
					<th class="center align-middle">Keterangan</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer"> 
	<div class="modal-content">
		<h6 id="title-modal"></h6>
		<?= form_open('',array('id'=>'formtambah'));?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col s12 l4">
						<input name="tgl_terima" type="text" class="datepicker" value="<?= date('d-m-Y');?>">
						<label class="active">Tanggal Terima</label>
					</div>
					<div class="input-field col l4 s12">
						<label class="active">Divisi</label>
						<select name="divisi" class="select-m" id="divisi_f">
							<option value="">--pilih--</option>  
							<option value="BSK">BSK</option>
							<option value="PDM">PDM</option>
							<option value="EBK">EBK</option>
							<option value="Others">Lain-lain</option>
						</select>
						
					</div>  
					<div class="input-field col s12 l4">
						<label class="active">Jenis Surat</label>
						<select name="jenis_surat" class="select-m" id="jenis_surat">
							<option value="">--pilih--</option>
							
							<option value="Permintaan Reguler">Permintaan Reguler</option>
							<option value="Permintaan Urgent">Permintaan Urgent</option>
							<option value="Permintaan Ulang">Permintaan Ulang</option>
							<option value="Email">Email</option>
							<option value="Pemberitahuan">Pemberitahuan</option>
						</select>
					</div>  
					<!-- jika email -->
					<div class="input-field col s12 l6 email hide">
						<input name="email" class="">
						<label class="active">Email</label>
					</div>
					<div class="input-field col s12 l6 email hide">
						<input name="tgl_email" class="datepicker">
						<label class="active">Tgl. Email</label>
					</div>
					<!-- jika surat -->
					<div class="input-field col s12 l4 surat-re hide">
						<input name="id_pengadaan" id="id_p_sbl">
						<label class="active">ID. Pengadaan Sebelumnya</label>
					</div>
					<div class="input-field col s12 l4 surat hide">
						<input name="no_surat" class="">
						<label class="active">No. Surat</label>
					</div>
					<div class="input-field col s12 l4 surat hide">
						<input name="tgl_surat" class="datepicker">
						<label class="active">Tgl. Surat</label>
					</div>
					<div class="input-field col s12 l12">
						<input name="perihal" type="text" class="">
						<label class="active">Perihal</label>
					</div>  
					<div class="input-field col s12 l6">
						<input name="user" type="text" class="">
						<label class="active">USER</label>
					</div>
					<div class="input-field col s12 l6">
						<input name="kelompok" type="text" class="">
						<label class="active">Kelompok</label>
					</div>
					<div class="input-field col s12 l6 beban hide">
						<input name="anggaran" type="number" class="" min="0">
						<label class="active">Anggaran</label>
					</div>
					<div class="input-field col s12 l6 beban hide">
						<input name="beban" type="text" class="">
						<label class="active">Beban Anggaran</label>
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
			<ul class="collapsibles popout" data-collapsible="expandable">
			    <li class="active">
			      	<div class="collapsible-header"><i class="material-icons">list</i><b>Detail</b>
			      	</div>
			      	<div class="collapsible-body">
			      		<table id="table-detail">
							<tr>
								<td>ID Pengadaan</td>
								<td>:</td>
								<td id="d_id_register"></td>
							</tr>
							<tr>
								<td>Nama Pengadaan</td>
								<td>:</td>
								<td id="d_perihal"></td>
							</tr>
							<tr class="row-email hide">
								<td>Email</td>
								<td>:</td>
								<td id="d_email"></td>
							</tr>
							<tr class="row-email hide">
								<td>Tgl. Email</td>
								<td>:</td>
								<td id="d_tgl_email"></td>
							</tr>
							<tr class="row-email hide">
								<td>Tgl. Terima Email</td>
								<td>:</td>
								<td id="d_tgl_t_email"></td>
							</tr>
							<tr class="row-surat hide">
								<td>No. Surat</td>
								<td>:</td>
								<td id="d_no_surat"></td>
							</tr>
							<tr class="row-surat hide">
								<td>Tgl. Surat</td>
								<td>:</td>
								<td id="d_tgl_surat"></td>
							</tr>
							<tr>
								<td>Tgl. Terima Surat</td>
								<td>:</td>
								<td id="d_terima_surat"></td>
							</tr>
							<tr>
								<td>Jenis Surat</td>
								<td>:</td>
								<td id="d_jenis_surat"></td>
							</tr>
							<tr>
								<td>Divisi</td>
								<td>:</td>
								<td id="d_divisi"></td>
							</tr>
							<tr>
								<td>Kelompok</td>
								<td>:</td>
								<td id="d_kelompok"></td>
							<tr>
								<td>User</td>
								<td>:</td>
								<td id="d_user"></td>
							</tr>
							<tr class="ddpimkel">
								<td>Tgl. Disposisi Pimkel</td>
								<td>:</td>
								<td id="d_disposisi_pimkel"></td>
							</tr>
							<tr class="ddmanager hide">
								<td>Tgl. Disposisi Manager</td>
								<td>:</td>
								<td id="d_disposisi_manager"></td>
							</tr>
							<tr class="ddpembuat hide">
								<td>Pembuat Pekerjaan</td>
								<td>:</td>
								<td id="d_pembuat"></td>
							</tr>
							<tr class='d_tempat hide'>
								<td>Tempat Pengadaan</td>
								<td>:</td>
								<td id="d_tempat_pengadaan"></td>
							</tr>
							<tr class="d_metode hide">
								<td>Metode Pengadaan</td>
								<td>:</td>
								<td id="d_jenis_pengadaan"></td>
							</tr>
							<tr class="row-lelang hide">
								<td>No. Surat Pengumuman Lelang</td>
								<td>:</td>
								<td id="d_no_lelang"></td>
							</tr>
							<tr class="row-lelang hide">
								<td>Tgl. Surat Pengumuman Lelang</td>
								<td>:</td>
								<td id="d_tgl_lelang"></td>
							</tr>
							<tr class="row-lelang hide">
								<td>Perihal Surat Pengumuman Lelang</td>
								<td>:</td>
								<td id="d_perihal_lelang"></td>
							</tr>
								<span id="d_unamepembuat" class="hide"></span>
							<tr>
								<td>Status Data</td>
								<td>:</td>
								<td id="d_status_data"></td>
							</tr>
							<tr class="alasan hide">
								<td>Alasan Pengembalian / Pembatalan</td>
								<td>:</td>
								<td id="d_alasan"></td>
							</tr>
						</table>
					</div>
			    </li>
			    <li class="hide active" id="pfa">
			      <div class="collapsible-header"><i class="material-icons">question_answer</i><b>Persuratan Ke PFA</b></div>
			      <div class="collapsible-body">
			      	<div id="tblpfa">
			      	</div>
			      </div>
			    </li>
			    <li class="hide active" id="aanwijzing">
			      <div class="collapsible-header"><i class="material-icons">question_answer</i><b>Aanwijzing</b></div>
			      <div class="collapsible-body">
			      	<div id="tblaanwijzing">
			      	</div>
			      </div>
			    </li>
			    <li id="eauction" class="hide active">
			      	<div class="collapsible-header"><i class="material-icons">people_alt</i><b>E-Auction</b></div>
			      	<div class="collapsible-body">
				      	<div id="tblauction">
						</div>
					</div>
			    </li>
			    <li id="document" class="active">
			      	<div class="collapsible-header"><i class="material-icons">library_books</i><b>Document</b></div>
			      	<div class="collapsible-body">
				      	<div id="detail-surat">
						</div>
					</div>
			    </li>
			    <li id="comment" class="active">
			      	<div class="collapsible-header"><i class="material-icons">comment</i><b>Comments</b></div>
			      	<div class="collapsible-body">
				      	<div id="tblcomments" class="collection">
						</div>
					</div>
			    </li>
			 </ul>
		</div>
	</div>
	<div class="modal-footer">
		<?php if($_SESSION['role'] != "user"){?>
		
		<button class="waves-effect orange waves-green btn-flat left" id="btn-return" aria-label="Pengembalian / Pembatalan Memo/Notin" data-balloon-pos="up-left"><i class="fa fa-rotate-left"></i></button>
		<?php if($_SESSION['role'] == 'superuser'){?>
		<button class="waves-effect red waves-yellow btn-flat white-text hide left" id="btn-hapus" title="Hapus Data" aria-label="Hapus Data" data-balloon-pos="up-left"><i class="fa fa-trash"></i></button>
		<?php }?>
		<!-- <button class="waves-effect yellow waves-green btn-flat left" id="btn-ubah" aria-label="Ubah Data" data-balloon-pos="up-left"><i class="fa fa-pencil"></i></button> -->
		<button class="waves-effect green white-text waves-green btn-flat left" id="btn-comments" aria-label="Comments" data-balloon-pos="up-left"><i class="fa fa-comments"></i></button>
		<button class="waves-blue btn-flat teal white-text" id="update_surat">Update Surat</button>
		<button class="waves-blue btn-flat teal white-text hide" id="btn-disposisi">Disposisi</button>
		<button class="waves-blue btn-flat teal white-text hide" id="btn-jenis">Metode Pengadaan</button>
		<button class="waves-blue btn-flat teal white-text hide" id="btn-lelang">Pengumuman Lelang</button>
		<button class="waves-blue btn-flat teal white-text hide" id="btn-aanwijzing">Aanwijzing</button>
		<button class="waves-blue btn-flat teal white-text hide" id="btn-eauction">E-Auction</button>
		<button class="waves-effect green waves-green btn-flat white-text hide" id="btn-proses" aria-label="Input Berkas Dokumen" data-balloon-pos="up"><i class="fa fa-pencil-square-o"></i></button>

	 	<button class="waves-effect green waves-green btn-flat white-text hide" id="btn-proses-pfa" aria-label="Input Berkas Dokumen" data-balloon-pos="up"><i class="fa fa-pencil-square-o"></i></button>
		<?php }?>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
	</div>
</div>

<!-- end modal detail-->
<div id="modal_disposisi" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?= form_open('',array('id'=>'formdisposisi'));?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col l12 s12 dpim">
						<input name="id_register" type="text" class="idregister" hidden>
						<input name="tgl_d_pimkel" type="text" class="datepicker" id="dtglDisposisiPimkel" value="00-00-0000">
						<label>Tgl. Disposisi Pimkel</label>
					</div>
					<div class="input-field col l12 s12 dman">
						
					</div>
					<div class="input-field col l12 s12" id="dpembuat">
						
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="waves-effect green waves-green btn-flat white-text left hide" id="tmbhrowpembuat">+Pembuat</button>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_disposisi" class="waves-effect green waves-green btn-flat white-text">PROSES</button>

	</div>
</div>

<!-- end modal detail-->
<div id="modal_lelang" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?= form_open('',array('id'=>'formlelang'));?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col l12 s12">
						<input name="id_register" type="text" hidden id="idRegisterL">
						<input name="tgl_surat" type="text" class="datepicker">
						<label>Tgl. Surat</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col l12 s12">
						<input name="no_surat" type="text" class="validate">
						<label>No. Surat</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col l12 s12">
						<input name="perihal" type="text" class="validate">
						<label>Perihal</label>
					</div>
				</div>
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_lelang" class="waves-effect green waves-green btn-flat white-text">PROSES</button>

	</div>
</div>

<!-- end modal detail-->
<div id="modal_prosesSPK" class="modal modal-fixed-footer">
	<div class="modal-content">
		<?= form_open('',array('id'=>'formprosesSPK'));?>
			<div class="col s12 l12">
				<div class="row">
					<input name="id_register" class="idregister" type="hidden">
					<input type="hidden" name="jenis_pengadaan" id="jenis_pengadaans">
					<div id="dspk">
					</div>
					<div id="ddetail">
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="grey darken-3 waves-effect waves-yellow btn-flat white-text left" id="btntmbhvendor">+ Row</button>
		<button class="grey darken-3 waves-effect waves-yellow btn-flat white-text hide left" id="btntmbhitem">+ item</button>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_spk" class="waves-effect green waves-green btn-flat white-text">PROSES</button>

	</div>
</div>
<!-- modal jenis-->
<div id="modal_jenis" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?= form_open('',array('id'=>'formjenis'));?>
			<div class="col s12 l12">
				<input name="id_register" class="idregister" type="text" hidden>
				<div class="row">
					<div class="input-field col l12 s12">
						<select name="tempat_pengadaan" class="select-m" id="tempat_pengadaan">
							<option value="">--pilih--</option>
							<option value="BSK">BSK</option>
							<option value="PFA">PFA</option>
						</select>
						<label>Tempat Pengadaan</label>
					</div>
				</div> 
				<div class="row" id="row-jenis">
					<div class="input-field col l12 s12">
						<select name="jenis" class="select-m" id="jenis_pengadaan">
							<option value="">--pilih--</option>
							<option value="Pembelian Langsung">Pembelian Langsung</option>
							<option value="Penunjukan Langsung">Penunjukan Langsung</option>
							<option value="Pemilihan Langsung">Pemilihan Langsung</option>
							<option value="Pelelangan">Pelelangan</option>
						</select>
						<label>Metode Pengadaan</label>
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_jenis" class="waves-effect green waves-green btn-flat white-text">PROSES</button>
	</div>
</div>
<!-- end-->

<!-- modal eauction -->
<div id="modal_eauction" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?= form_open('',array('id'=>'form-eauction'));?>
			<div class="col s12 l12" id="eauction-row">
				<div class="row">
					<input name="id_register" type="text" class="idregister" hidden>
					<div class="input-field col s12 l4">
						<input name="tempat" class="validate">
						<label class="active">Tempat Eauction</label>
					</div>
					<div class="input-field col s12 l4">
						<input name="tanggal" class="validate datepicker">
						<label class="active">Tgl. Eauction</label>
					</div>
					<div class="input-field col s12 l4">
						<input name="jam" class="validate timepicker">
						<label class="active">Jam Eauction</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12 l11">
						<label class="active" style="top: -14px;">Vendor</label>
						<select name="vendor[]" class="select2">
							<?php foreach ($select_vendor as $key) {?>
								<option value="<?= $key->id_vendor;?>"><?= $key->nm_vendor;?></option>
							<?php }?>
						</select>
					</div>
					<div class="input-field col s12 l1">
						<button class="btn-flat red btn-small white-text hapus-row">x</button>
					</div>
				</div>

			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button id="tmbh-peserta" class="waves-effect green waves-green btn-flat white-text left">[+] Peserta Vendor</button>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_eauction" class="waves-effect green waves-green btn-flat white-text">Submit</button>
	</div>
</div>
<!-- end modal eauction-->


<!-- modal return -->
<div id="modal_return" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<div class="row">
			<div class="input-field">
				<select id="tipe" name="" class="select-m">
					<option value="Pengembalian">Pengembalian</option>
					<option value="Pembatalan">Pembatalan</option>
				</select>
				<label>Tipe</label>
			</div>
		</div>
		<?= form_open('',array('id'=>'form-return'));?>
			<div class="col s12 l12">
				
				<div class="row">
					<input name="id_register" type="text" class="idregister" hidden>
					<div class="input-field col s12 l4">
						<input name="tgl_kembali" class=" datepicker">
						<label class="active">Tgl. Pengembalian</label>
					</div>
					<div class="input-field col s12 l4">
						<input name="no_surat" class="validate">
						<label class="active">No. Surat Pengembalian*</label>
					</div>
					<div class="input-field col s12 l4">
						<input name="tgl_surat" class="validate datepicker">
						<label class="active">Tgl. Surat Pengembalian*</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12 l12">
						<input name="alasan" class="validate">
						<label class="active">Alasan Pengembalian</label>
					</div>
				</div>

			</div>
		<?= form_close();?>
		<?= form_open('',array('id'=>'form-batal', 'class'=>'hide'));?>
			<div class="col s12 l12">
				
				<div class="row">
					<input name="id_register" type="text" class="idregister" hidden>
					<div class="input-field col s12 l4">
						<input name="tgl_batal" class=" datepicker">
						<label class="active">Tgl. Pembatalan</label>
					</div>
					<div class="input-field col s12 l4">
						<input name="no_surat" class="validate">
						<label class="active">No. Surat Pembatalan</label>
					</div>
					<div class="input-field col s12 l4">
						<input name="tgl_surat" class="validate datepicker">
						<label class="active">Tgl. Surat </label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12 l12">
						<input name="alasan" class="validate">
						<label class="active">Alasan</label>
					</div>
				</div>

			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
			
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_return" class="waves-effect green waves-green btn-flat white-text" data-tipe="pengembalian">Submit</button>
	</div>
</div>
<!-- end modal return-->
<!-- modal comments -->
<div id="modal_comment" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?= form_open('',array('id'=>'form-comment'));?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col s12 l12">
						<input type="text" name="id_register" class="idregister" hidden>
						<input name="comment" type="text" class="validate">
						<label class="active">Comments</label>
					</div>
				</div>
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_comment" class="waves-effect green waves-green btn-flat white-text">Submit</button>
	</div>
</div>
<!-- end modal comments-->
<!-- modal update-->
<div id="modal_update_surat" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?= form_open('',array('id'=>'formsurat'));?>
			<div class="col s12 l12">
				<div class="row">
					<input name="id_register" type="text" class="idregister" hidden>
					<div class="input-field col s12 l6">
						<label class="active">Jenis Surat</label>
						<select name="jenis_surat" class="validate select-m" id="jenis_surat">
							<option value="">--pilih--</option>
							<option value="Permintaan Urgent">Permintaan Urgent</option>
							<option value="Permintaan Reguler">Permintaan Reguler</option>
						</select>
					</div>
					<div class="input-field col s12 l6">
						<input name="no_surat" class="validate">
						<label class="active">No. Surat</label>
					</div>
					<div class="input-field col s12 l6">
						<input name="tgl_surat" class="validate datepicker">
						<label class="active">Tgl. Surat</label>
					</div>
					<div class="input-field col s12 l6">
						<input name="tgl_terima_surat" class="validate datepicker">
						<label class="active">Tgl. Terima Surat</label>
					</div>
					<div class="input-field col s12 l12">
						<input name="perihal" type="text" class="validate">
						<label class="active">Perihal</label>
					</div> 
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_surat" class="waves-effect green waves-green btn-flat white-text">PROSES</button>
	</div>
</div>
<!-- end modal update-->

<!-- modal aanwijzing-->
<div id="modal_aanwijzing" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?= form_open('',array('id'=>'formanwijzing'));?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col l12 s12">
						<input name="id_register" type="text" class="idregister" hidden>
						<input name="tgl" type="text" class="datepicker">
						<label>Tgl. Aanwijzing</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="jam" type="text" class="timepicker">
						<label>Jam Aanwizjing</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="tempat" type="text">
						<label>Tempat</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="perihal" type="text">
						<label>Perihal</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="peserta" type="text">
						<label>Peserta</label>
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_aanwijzing" class="waves-effect green waves-green btn-flat white-text">PROSES</button>
	</div>
</div>
<!-- end modal aanwijzing-->


<!-- modal pfa-->
<div id="modal_pfa" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?= form_open('',array('id'=>'form_pfa'));?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col l4 s12">
						<input name="tglkirim" type="text" class="datepicker">
						<label>Tgl. Kirim Memo Ke PFA</label>
					</div>
					<div class="input-field col l4 s12">
						<input name="no" type="text">
						<label>No. Memo</label>
					</div>
					<div class="input-field col l4 s12">
						<input name="id_register" type="text" class="idregister" hidden>
						<input name="tgl" type="text" class="datepicker">
						<label>Tgl. Memo</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="perihal" type="text">
						<label>Perihal</label>
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_pfa" class="waves-effect green waves-green btn-flat white-text">PROSES</button>
	</div>
</div>
<!-- end modal pfa-->

<script>
	$(document).ready(function(){
		$(".select2").select2({
			placeholder: 'Select an option',
		},$('select').css('width','100%'));
		
		var collaps = $('.collapsibles').collapsible({
		    accordion: false, // A setting that changes the collapsible behavior to expandable instead of the default accordion style
		    onOpenStart: function(el) { }, // Callback for Collapsible open
		    onCloseEnd: function(el) { } // Callback for Collapsible close
		});
		$('.select-m').formSelect();
		//$('.select2-selection__arrow').addClass("fa fa-spin");
		$('.datepicker').datepicker({
			container: 'body',
			format: 'dd-mm-yyyy',
			autoClose: true,
			disableWeekends:true,
			firstDay:1
		}).datepicker("setDate", new Date());
		$('.timepicker').timepicker({
			container: 'body',
			twelveHour: false
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
				"url": "<?= base_url('register/get_data_surat');?>",
				"type": "POST",
				"data": function ( data ) {
					data.divisi = $('#divisi-select').val();
					data.tahun = $('#year-select').val();
					data.my_task = $('#my_task').val();
				}

			},
			"columns":[
				{"data": ['id_register']},
				{"data": ['tgl_surat']},
				{"data": ['no_surat']},
				{"data": ['tgl_terima_surat']},
				{"data": ['perihal']},
				{"data": ['jenis_surat']},
				{"data": ['status']},
				{"data": function(data){
					if(data['comment'] != '-' && data['status'] == 'On Process'){
						return "<span aria-label='"+data['created_at']+"' data-balloon-pos='up-right'>"+data['comment']+"</span>";
					}else if(data['status'] == 'Return'){
						return "<span aria-label='R"+data['tgl_srt_pengembalian']+"' data-balloon-pos='up-right'>"+data['alasan']+"</span>";;
					}else{
						return '';
					}
					
				}
				},

			],
			"dom": 'Bflrtip',
							buttons: [
						{ className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
						<?php if($_SESSION['role'] != 'user'){?>
						{ className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
						<?php }?>
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
							"targets": [ 0, 1, 2, 3, 5,6, -1 ],
							"className": 'center'
						}
				],
			"createdRow" : function(row, data, index){
				$(row).addClass('row');
				

				$(row).attr('data-id',data['id_register']);
				if(cek_similar(data['username'], '<?= $_SESSION['username'];?>') && data['status'] == 'On Process')
				{
					$(row).css({'background':'#ce3500','color':'white'});
				}
			}
		})
		
	    let tagsearch = "<div class='input-field'><label class='active'>Search</label>"+
	    "<input type='text' class='validate' id='searchnew' style='margin-left: 0;'>"+
	    "</div>";
	    $('#table_filter label').html(tagsearch);

		$('#searchnew').on('keyup change', function(){
			table
				.search(this.value)
				.draw();
		})
		$('#btn-filter').on('click', function(e){
			$('#filter').toggleClass('hide');
		})
		$('#reload').on('click', function(){ //reload
			$('#table').DataTable().ajax.reload();
		})
		
		$("[name='table_length']").formSelect();

		$('tbody').on('click','.row', function(e){ //klik detail
			$('#modal_detail').modal('open');
			
			let id = $(this).attr('data-id');//table.row($(this).parents('tr')).data();
			update_modal(id)
		}) //end tbody row click

		$('#update_surat').on('click', function(e){
			let id = $(this).attr('data-id');
			$('#modal_update_surat').modal('open')
		})
		$('#btn-lelang').on('click', function(e){
			$('#modal_lelang').modal('open');
			let id = $(this).attr('data-id');
			$('#idRegisterL').val(id);
			$('#proses_lelang').attr('data-id', id);
		})

		$('#proses_lelang').on('click', function(e){
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you sure to submit this data?',
				showCancelButton: 'TRUE',
			}).then(function(e){
				$.ajax({
					type : 'POST',
					data : $('#formlelang').serialize(),
					dataType : 'JSON',
					url : '<?= base_url()."register/add_pengumuman_lelang";?>',
					success: function(data){
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
								$('#modal_lelang').modal('close');
								$('#formlelang input:not(#idRegisterL)').val('');
								update_modal(id);
							})
							$('#table').DataTable().ajax.reload();
						}
					}

				})

			})
		})

		$('#proses_return').on('click', function(e){
			let id = $(this).attr('data-id');
			
			let tipe = $(this).attr('data-tipe');
			if(tipe == 'pengembalian'){
				swal({
					type: 'question',
					text: 'Are you sure to submit this data?',
					showConfirmButton: true,
					allowOutsideClick: false,
					showCancelButton:true
				}).then(function(){
					$.ajax({
						type: 'POST',
						url: '<?= base_url()."register/proses_return";?>',
						data: $('#form-return').serialize(),
						dataType: 'JSON',
						success: function(data){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								update_modal(id);
								$('#modal_return').modal('close');
								$('#table').DataTable().ajax.reload();	
							})
						}
					})
				})
			}else{
				swal({
					type: 'question',
					text: 'Are you sure to submit this data?',
					showConfirmButton: true,
					allowOutsideClick: false,
					showCancelButton:true
				}).then(function(){
					$.ajax({
						type: 'POST',
						url: '<?= base_url()."register/proses_batal";?>',
						data: $('#form-batal').serialize(),
						dataType: 'JSON',
						success: function(data){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								update_modal(id);
								$('#modal_return').modal('close');
								$('#table').DataTable().ajax.reload();	
							})
						}
					})
				})
			}
		})
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
					dataType: 'JSON',
					success: function(data){
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
		$('#add_data').on('click', function(){
			$('#modal_tambah').modal('open');
			
			$('.select-m').find('option[value=""]').prop('selected', true);
			$('.select-m').formSelect();
			check_new(jenis)
		})
		$('#submit_new').on('click', function(e){
			e.preventDefault();
			swal({
				type: 'question',
				text: 'Are you sure to submit this data?',
				showCancelButton: 'TRUE',
			}).then(function(e){
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."Register/add_data_masuk";?>',
					data: $('#formtambah').serialize(),
					dataType : 'JSON',
					success: function(data){
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
								let str = "<?= $_SESSION['nama'];?>"+' menambahkan data register masuk';
								socket.emit('notification', str);
							})
							$('#table').DataTable().ajax.reload();
						}
					}
				})
			})
		})
		$('#formdisposisi').on('click','.hapusrow', function(e){
			e.preventDefault();
			$(this).parent().parent().remove();
		})
		$('#tmbhrowpembuat').on('click', function(e){
			$('#dpembuat').show();
			$.ajax({
				url : "<?= base_url().'Register/get_user';?>",
				dataType: 'JSON',
				success : function(data){
					let pembuat = "";
					pembuat += '<div class="row"><div class="col l11"><select name="pembuat[]" class="select-m s-pembuat"><option value="">--pilih--</option>';
					for(i = 0;i < data.length;i++){
						pembuat += '<option value="'+data[i].username+'">'+data[i].nama+'</option>';
					}
					pembuat += '</select>';
					pembuat += '<label>Pembuat Pekerjaan</label></div><div class="col l1"><button class="btn red hapusrow">x</button></div></div>';
				$('#dpembuat').append(pembuat);
				$('.select-m').formSelect();
				}
			})	
		})

		function check_new(jenis = '')
		{
			if(jenis == 'Email'){
				$('.surat, .beban').addClass('hide');
				$('.email').removeClass('hide');
				$('.surat input, .surat-re').val('');
				$('#id_p_sbl').val('');
				$('.surat-re').addClass('hide');
			}else if(jenis == '' || jenis == 'Pemberitahuan'){
				$('.surat').removeClass('hide');
				$('.email, .beban').addClass('hide');
				$('.email input, .surat input').val('');
				$('.surat-re').val('');
				$('#id_p_sbl').val('');
				$('.surat-re').addClass('hide');
			}else if(jenis == 'Permintaan Ulang'){
				
				$('.surat-re').removeClass('hide');
				$('.surat').removeClass('hide');
				if($('.surat').hasClass('l6')){
					
					$('.surat').removeClass('l6').addClass('l4');
				}else if($('.surat').hasClass('l4')){
					
					//$('.surat').removeClass('l4').addClass('l6');
				}
				$('.surat-re').val('');
			}else{
				$('#id_p_sbl').val('');
				
				$('.beban, .surat').removeClass('hide');
				$('.email, .surat-re').addClass('hide');
				$('.surat-re').val('');
				if($('.surat').hasClass('l4')){
					$('.surat').removeClass('l4').addClass('l6');	
					$('.email input').val('');
				}else if($('.surat').hasClass('l6')){
					//$('.surat').removeClass('l6').addClass('l4');
				}

			}
		}
		$('#jenis_surat').on('change', function(e){
			e.preventDefault();
			jenis = this.value;
			check_new(jenis)
		})
		$('#btn-disposisi').on('click', function(e){
			$('#modal_disposisi').modal('open')
			$('#modal_disposisi label').addClass('active')
			$('#dpembuat').html('');
			let id = $(this).attr('data-id');
			let jenis = $('#d_jenis_surat').text();
			let dpim = tanggal_biasa($('#d_disposisi_pimkel').text());
			let dman = tanggal_biasa($('#d_disposisi_manager').text());
			let kel = $('#d_kelompok').text();

			update_modal(id);
			disposisi(kel, dpim, dman);
		})
		$('#proses_disposisi').on('click', function(e){
			e.preventDefault();
			let id = $(this).attr('data-id');
			$('#s-pembuat').formSelect();

			swal({
				type: 'question',
				text: 'Are you sure to submit this data?',
				showCancelButton: 'TRUE',
			}).then(function(e){
				$.ajax({
					type: 'POST',
					data: $('#formdisposisi').serialize(),
					url: '<?= base_url()."Register/submit_disposisi";?>',
					dataType: 'JSON',
					success: function(data){
						
						if(data.type == 'success'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false, //nihhh
							}).then(function(){
								$('#modal_disposisi').modal('close');
								update_modal(id);
								socket.emit('update_task');
							})
						}else if(data.type == 'error'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								update_modal(id);
							})
						}
					} //end
				})
			})
		})
		$('#btn-eauction').on('click', function(e){
			e.preventDefault();
			$('#modal_eauction').modal('open');
			let id = $(this).attr('data-id');
			$('.idregister').val(id);
			$('#proses_eauction').attr('data-id', id);
		})
		$('#proses_eauction').on('click', function(e){
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you Sure?',
				showConfirmButton: true,
				allowOutsideClick: false,
				showCancelButton: true
			}).then(function(){
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."register/submit_auction";?>',
					data: $('#form-eauction').serialize(),
					dataType: 'JSON',
					success: function(data){
						if(data.type == 'success'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false, //nihhh
							}).then(function(){
								$('#modal_eauction').modal('close');
								update_modal(id);
							})
						}else if(data.type == 'error'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								update_modal(id);
							})
						}
					}
				})

			})
		})
		function disposisi(kel, dpim, dman){
			
			let rdman = '<input name="tgl_d_manager" type="text" class="datepicker" id="dtglDisposisiManager">'+
						'<label>Tgl. Disposisi Manager</label>';

			if(kel == 'STL' || kel == 'stl'){
				if(dman == ''){ //second jika  dp manager kosong
					
					$('.dman').show();
					$('#dpembuat, .dpim').hide();
					$('.dman').html(rdman);
					$('.datepicker').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					}).datepicker("setDate", new Date());
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1

					}).datepicker("setDate", new Date()).attr('readonly', false);
					
					if($('#tmbhrowpembuat').hasClass('hide')){
						$('#tmbhrowpembuat').removeClass('hide');
					}
				}else if(dman !=''){//tri
					$('.dpim').hide();
					
					$('#dpembuat, .dman').show();
					$('.datepicker').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					}).datepicker("setDate", new Date());
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).datepicker('destroy').attr('readonly', true);
					$('.dman').html(rdman);
					
					if($('#tmbhrowpembuat').hasClass('hide')){
						$('#tmbhrowpembuat').removeClass('hide');
					}
					
				}else{
					$('.dpim, #dpembuat').hide();
					$('.datepicker').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					}).datepicker("setDate", new Date());
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).datepicker('destroy').attr('readonly', true);
					$('.dman').html(rdman);
					$('#tmbhrowpembuat').addClass('hide');
					
				}
			}else{
				if(dpim == ''){//awal
					$('.dpim').show();
					$('.dman').children().remove();
					$('#dtglDisposisiPimkel').val('');
					$('#tmbhrowpembuat').addClass('hide');
					$('#dtglDisposisiPimkel').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					}).datepicker("setDate", new Date()).attr('readonly', false);
					
				}else if(dpim != '' && dman == ''){//second
					$('.dpim').show();
					$('.datepicker').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					}).datepicker("setDate", new Date());
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);

					$('.dman').html(rdman);
					$('#dtglDisposisiManager').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					}).datepicker("setDate", new Date()).attr('readonly', false);
					
					$('#tmbhrowpembuat').removeClass('hide');
					
				}else if(dpim != '' && dman !=''){//tri

					$('.dman').html(rdman);
					$('.dpim').show();
					$('.dman label').addClass('active');
					$('.datepicker').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					})
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).datepicker('destroy').attr('readonly', true);
					
					$('#tmbhrowpembuat').removeClass('hide');
				
					
				}else{
					$('.dpim').show();
					$('.dman').html(rdman);
					$('.datepicker').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					}).datepicker("setDate", new Date());
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).datepicker('destroy').attr('readonly', true);
					$('#tmbhrowpembuat').addClass('hide');
					
				}
			}
		}
		$('#proses_surat').on('click', function(e){
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you Sure?',
				showConfirmButton: true,
				allowOutsideClick: false,
				showCancelButton: true
			}).then(function(){
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."register/update_surat";?>',
					data: $('#formsurat').serialize(),
					dataType: 'JSON',
					success: function(data){
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){
							if(data.type=='success'){
								
								$('#modal_update_surat').modal('close');
								$('#table').DataTable().ajax.reload();
								$('#update_surat').hide();
								update_modal(id);
								socket.emit('register_masuk');
							}
						})
					}
				})
			})
		})
		
		$('#btn-jenis').on('click', function(e){
			$('#modal_jenis').modal('open');
			$('#row-jenis').addClass('hide')
			$('#jenis_pengadaan').find('option[value=""]').prop('selected', true)
			$("#tempat_pengadaan").on('change', function(e){
				let value = this.value;
				if(value == 'BSK'){
					$('#row-jenis').removeClass('hide');
				}else if(value == "PFA"){
					$('#jenis_pengadaan').find('option[value=""]').prop('selected', true);
					$('#row-jenis').addClass('hide');
					$("#jenis_pengadaan").formSelect();
				}else{
					$('#jenis_pengadaan').find('option[value=""]').prop('selected', true)
					$('#row-jenis').addClass('hide')
					$("#jenis_pengadaan").formSelect();
				}
			})
		})
		$('#btn-return').on('click', function(e){
			$('#modal_return').modal('open');
		})
		$('#tmbh-peserta').on('click', function(e){
			no++;
			let html = '';
			$.post("<?= base_url()."tdr/get_tdr";?>", function(result){
		        let idoption = '#selectvendora'+no;
		        let options = $(idoption);
		        $.each(JSON.parse(result), function() {
		              options.append($("<option />").val(this.id_vendor).text(this.nm_vendor));
		        });
		        $(".select2").select2({
					placeholder: 'Select an option',
				},$('select').css('width','100%'));
	  	    });
			html = '<div class="row">'+
						'<div class="input-field col s12 l11" id="vendor-eaction">'+
						'<label class="active" style="top: -14px;">Vendor</label>'+
						'<select name="vendor[]" class="select2" id="selectvendora'+no+'">'+
						'</select>'+
						'</div>'+
						'<div class="input-field col s12 l1">'+
							'<button class="btn-flat red btn-small white-text hapus-row">x</button>'+
						'</div>'+
					'</div>';
			$('#eauction-row').append(html);
			$('#modal_eauction .hapus-row').on('click', function(e){
				e.preventDefault();
				$(this).parent().parent().remove();
			})
		})
		$('#proses_jenis').on('click', function(e){
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you sure to submit this data?',
				showCancelButton: true,
				allowOutsideClick: false,
			}).then(function(e){
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."Register/submit_jenis";?>',
					data: $('#formjenis').serialize(),
					dataType: 'JSON',
					success : function(data){
						if(data.type == 'success'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
							}).then(function(){
								$('#modal_jenis').modal('close');
								$('#formjenis input').val('');
								update_modal(id)
							})
						}else{
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
							})
						}
					}
				})
			})
		})
		$('#proses_comment').on('click', function(e){
			e.preventDefault();
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you sure to submit this data?',
				showCancelButton: true,
				allowOutsideClick: false,
			}).then(function(e){
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."register/new_comment_register";?>',
					data: $('#form-comment').serialize(),
					dataType: 'JSON',
					success: function(data){
						if(data.type == 'success'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								$('#modal_comment').modal('close');
								update_modal(id);
								$('#table').DataTable().ajax.reload();
								$('#form-comment input:not(.idregister)').val('');
							})
						}else{
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							})
						}
					}
				})
			})
		})
		$('#btn-proses').on('click', function(e){
			let id = $(this).attr('data-id');
			$('#modal_prosesSPK').modal('open');
			$('#dspk').html('');
			let jenis = $(this).attr('jenis');
			let jenisp = $(this).attr('jenis-pengadaan');
			$('#jenis_pengadaans').val(jenisp);
			
			let html = 	'<div class="row"><div class="input-field col l4 s12 sp">'+
							'<select name="id_vendor[]" id="selectvendor'+no+'" class="select2">'+
							'<option value="">--select--</option>'+
							'</select>'+
							'<label class="active" style="top: -14px;">Nama Vendor</label>'+
						'</div>'+
						'<div class="input-field col l2 s12 sp" style="bottom: 18px;">'+
							'<input class="datepicker" name="tgl_sp[]" type="text"  id="tglspk'+no+'">'+
							'<label>Tgl. Surat</label>'+
						'</div>'+
						'<div class="input-field col l2 s12 sp" style="bottom: 18px;">'+
							'<input name="no_sp[]" type="text">'+
							'<label>No. Surat</label>'+
						'</div>'+
						'<div class="input-field col l3 s12 sp">'+
							'<select name="id_jenis[]" type="text" id="selectjenis'+no+'" class="select2">'+
							'<option value="">--select--</option>'+
							'</select>'+
						'</div>'+
						'<div class="input-field col l1 s12">'+
							'<button class="btn hapus-sk">x</button>'+
						'</div></div>';
			
			if(jenis == 'auction'){
				$.post("<?= base_url()."tdr/get_tdr/";?>"+id, function(result){
			        let idoption = '#selectvendor'+no;
			        let options = $(idoption);
			        $.each(JSON.parse(result), function() {
			              options.append($("<option />").val(this.id_vendor).text(this.nm_vendor));
			        });
			        $(".select2").select2({
						placeholder: 'Select an option',
					},$('select').css('width','100%'));
		  	    });
			}else{
				$.post("<?= base_url()."tdr/get_tdr";?>", function(result){
			        let idoption = '#selectvendor'+no;
			        let options = $(idoption);
			        $.each(JSON.parse(result), function() {
			              options.append($("<option />").val(this.id_vendor).text(this.nm_vendor));
			        });
			        $(".select2").select2({
						placeholder: 'Select an option',
					},$('select').css('width','100%'));
		  	    });
			}
	      	$.post("<?= base_url()."register/get_jenis";?>", function(result){
		        let idoption = '#selectjenis'+no;
		        let options = $(idoption);
		        $.each(JSON.parse(result), function() {
		              options.append($("<option />").val(this.id_surat).text(this.jenis_surat));
		        });
		        $(".select2").select2({
					placeholder: 'Select an option',
				},$('select').css('width','100%'));
	      	});
			$('#dspk').append(html);
			$('.datepicker').datepicker({
				container: 'body',
				format: 'dd-mm-yyyy',
				autoClose: true,
				disableWeekends:true,
				firstDay:1
			})
		})
		$('#proses_spk').on('click', function(e){
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you sure to submit this data?',
				showCancelButton: true,
				allowOutsideClick: false,
			}).then(function(e){
				$.ajax({
					type: 'POST',
					data: $('#formprosesSPK').serialize(),
					dataType: 'JSON',
					url: '<?= base_url()."Register/submit_spk";?>',
					success: function(data){
						if(data.type == 'success'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								$('#modal_prosesSPK').modal('close');
								update_modal(id);
								$('#table').DataTable().ajax.reload();
							})
						}else{
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								$('#table').DataTable().ajax.reload();
							})
						}
					}
				})
			})
		})
		$('#btntmbhitem').on('click', function(e){
			e.preventDefault();
			let html = '<div class="input-field col l4 s12">'+
						 '<input name="no_spk[]" type="text">'+
						 '<label>Item</label>'+
						 '</div>'+
						 '<div class="input-field col l2 s12">'+
					   	 '<input name="no_spk[]" type="text">'+
						 '<label>qty</label>'+
						 '</div>'+
						 '<div class="input-field col l2 s12">'+
						 '<input name="no_spk[]" type="text">'+
						 '<label>hps</label>'+
						 '</div>'+
						 '<div class="input-field col l2 s12">'+
						 '<input name="no_spk[]" type="text">'+
						 '<label>penawaran</label>'+
						 '</div>'+
						 '<div class="input-field col l2 s12">'+
						 '<input name="no_spk[]" type="text">'+
						 '<label>nego</label>'+
						 '</div>';
			$('#ddetail').append(html);
		})
		let no = 0;
		$('#btntmbhvendor').on('click', function(e){
			let id = $(this).attr('data-id');
			let jenis = $(this).attr('jenis');
			if(jenis == 'auction'){
				$.post("<?= base_url()."tdr/get_tdr/";?>"+id, function(result){
			        let idoption = '#selectvendor'+no;
			        let options = $(idoption);
			        $.each(JSON.parse(result), function() {
			              options.append($("<option />").val(this.id_vendor).text(this.nm_vendor));
			        });
			        $(".select2").select2({
						placeholder: 'Select an option',
					},$('select').css('width','100%'));
		  	    });
			}else{
				$.post("<?= base_url()."tdr/get_tdr";?>", function(result){
			        let idoption = '#selectvendor'+no;
			        let options = $(idoption);
			        $.each(JSON.parse(result), function() {
			              options.append($("<option />").val(this.id_vendor).text(this.nm_vendor));
			        });
			        $(".select2").select2({
						placeholder: 'Select an option',
					},$('select').css('width','100%'));
		  	    });
			}
	      	$.post("<?= base_url()."register/get_jenis";?>", function(result){
			        let idoption = '#selectjenis'+no;
			        let options = $(idoption);
			        $.each(JSON.parse(result), function() {
			              options.append($("<option />").val(this.id_surat).text(this.jenis_surat));
			        });
		        $(".select2").select2({
					placeholder: 'Select an option',
				},$('select').css('width','100%'));
	      	});

			no++;
			let html = 	'<div class="row"><div class="input-field col l4 s12 sp">'+'<select name="id_vendor[]" id="selectvendor'+no+'" class="select2">'+
							'<option value="">--select--</option>'+
							'</select>'+
							'<label class="active" style="top: -14px;">Nama Vendor</label>'+
						'</div>'+
						'<div class="input-field col l2 s12 sp" style="bottom: 18px;">'+
							'<input class="datepicker" name="tgl_sp[]" type="text"  id="tglspk'+no+'">'+
							'<label>Tgl. Surat</label>'+
						'</div>'+
						'<div class="input-field col l2 s12 sp" style="bottom: 18px;">'+
							'<input name="no_sp[]" type="text">'+
							'<label>No. Surat</label>'+
						'</div>'+
						'<div class="input-field col l3 s12 sp">'+
							'<select name="id_jenis[]" type="text" id="selectjenis'+no+'" class="select2">'+
							'<option value="">--select--</option>'+
							'</select>'+
						'</div>'+
						'<div class="input-field col l1 s12">'+
							'<button class="btn hapus-sk">x</button>'+
						'</div></div>';
			$('#dspk').append(html);
			$('.datepicker').datepicker({
				container: 'body',
				format: 'dd-mm-yyyy',
				autoClose: true,
				disableWeekends:true,
				firstDay:1
			});
			$('.hapus-sk').on('click', function(e){
				e.preventDefault();
				$(this).parent().parent().remove();
			})
		})
		$('.hapus-sk').on('click', function(e){
			e.preventDefault();
			$(this).parent().parent().remove();
		})

		$('#btn-aanwijzing').on('click', function(e){
			e.preventDefault();
			let id = $(this).attr('data-id');
			$('#modal_aanwijzing').modal('open');
		})

		$('#btn-proses-pfa').on('click', function(e){
			e.preventDefault()
			$('#modal_pfa').modal('open');
		})
		$('#btn-comments').on('click', function(e){
			$('#modal_comment').modal('open');
		
		})

		$('#tipe').on('change', function(e){
			let tipe = this.value;
			console.log(tipe)
			if(tipe == 'Pengembalian'){
				$('#form-batal').addClass('hide');
				$('#form-return').removeClass('hide');
				$('#proses_return').attr('data-tipe', 'pengembalian');
			}else{
				$('#form-batal').removeClass('hide');
				$('#form-return').addClass('hide');
				$('#proses_return').attr('data-tipe', 'batal');
			}
		})

		
		$('#modal_eauction .hapus-row').on('click', function(e){
			e.preventDefault();
			$(this).parent().parent().remove();
		})
		$('#proses_aanwijzing').on('click', function(e){
			let id = $(this).attr('data-id');
			e.preventDefault();
			swal({
				type: 'question',
				text: 'Are you sure to submit this data?',
				showCancelButton: true,
				allowOutsideClick: false,
			}).then(function(e){
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."register/form_aanwijzing";?>',
					data: $('#formanwijzing').serialize(),
					dataType: 'JSON',
					success: function(data){
						if(data.type == 'success'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								$('#modal_aanwijzing').modal('close');
								$('#form_aanwijzing input:not(.idregister)').val('');
								update_modal(id);
							})
						}else{
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							})
						}
					}
				})
			})
			
		})
		socket.on('reload-regist-msk', function(kata){
			$('#table').DataTable().ajax.reload();
		})
		$('#proses_pfa').on('click', function(e){
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you sure to submit this data?',
				showCancelButton: true,
				allowOutsideClick: false,
			}).then(function(e){
				$.ajax({
					type: 'POST',
					url: '<?= base_url()."register/submit_pfa";?>',
					dataType: 'JSON',
					data: $('#form_pfa').serialize(),
					success: function(data){
						if(data.type == 'success'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							}).then(function(){
								$('#modal_pfa').modal('close');
								update_modal(id);
								$('#form_pfa input:not(.idregister)').val('');
							})
						}else{
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
								allowOutsideClick: false,
							})
						}
					}
				})
			})
		})
	})
	function update_modal(id){
		$('#waiting').removeClass('hide');
		$('#d_disposisi_pimkel, #d_disposisi_manager, #d_pembuat, #d_jenis_pengadaan, #d_unamepembuat, #d_jenis_surat, #d_no_surat, #d_tgl_surat, #d_terima_surat,#d_perihal, #d_tempat_pengadaan, ds_vendor_p, .s-pembuat, #dpembuat, #d_alasan, #tblcomments').html('');
		$('.ddpimkel, .spk').hide();
		$('#btn-ubah, #btn-hapus, #proses, #btn-disposisi, #update_surat, #proses_disposisi, #proses_spk, #proses_jenis, #btn-eauction, #btn-proses, #btntmbhvendor, #btn-lelang, #proses_return, #proses_comment, #proses_pfa, #proses_aanwijzing, #proses_surat').attr('data-id', id);
		$('.idregister').val(id);
		$('#btn-eauction, #eauction, #btn-lelang, #btn-jenis, .row-lelang, .d_tempat, .row-surat, .row-email, #btn-aanwijzing, #btn-proses, #aanwijzing, .d_metode, #btn-proses-pfa, #btn-proses, #btn-hapus, #btn-disposisi, .alasan, .ddpembuat, .ddmanager').addClass('hide');
		$('#btn-eauction, #eauction').removeAttr('jenis');


		$.ajax({
			type:'GET',
			url: '<?= base_url()."Register/get_detail_masuk/";?>'+id,
			dataType: 'JSON',
			success: function(result){
				$('#waiting').addClass('hide');
				//$('#pfa, #aanwijzing, #eauction, #document, #comment').open();
				let data = result.register;
				$('#d_divisi').text(strip(data.divisi));
				$('#d_kelompok').text(strip(data.kelompok));
				$('#d_user').text(strip(data.user));
				$('#d_email').text(strip(data.email));
				$('#d_tgl_email').text(tanggal_indo(data.tgl_email));
				$('#d_tgl_t_email').text(tanggal_indo(data.tgl_terima_email));
				$('#d_jenis_surat').html(data.jenis_surat);
				$('#d_no_surat').text(strip(data.no_surat));
				$('#d_perihal').text(strip(data.perihal));
				$('#d_id_register').text(data.id_register)
				$('#d_tgl_surat').text(tanggal_indo(data.tgl_surat));
				$('#d_terima_surat').text(tanggal_indo(data.tgl_terima_surat));
				$('#d_unamepembuat').text(data.username);
				if(data.tempat_pengadaan != null){
					$('#d_tempat_pengadaan').text(strip(data.tempat_pengadaan));
					$('.d_tempat').removeClass('hide');
				}
				if(data.email != '' && data.no_surat == ''){
					$('.row-surat').addClass('hide');
					$('#update_surat').show();
					$('.row-email').removeClass('hide');
				}else if(data.email == '' && data.no_surat != ''){
					$('#update_surat, .row-email').hide();
					$('.row-surat').removeClass('hide');
				}else{
					$('.row-email, .row-surat').addClass('hide');
				}
				if(data.tgl_disposisi_pimkel != '0000-00-00'){
					$('#d_disposisi_pimkel').text(tanggal_indo(data.tgl_disposisi_pimkel));
					$('.ddpimkel').show();

				}
				if(data.tgl_disposisi_manajer != '0000-00-00'){
					$('#d_disposisi_manager').text(tanggal_indo(data.tgl_disposisi_manajer));
					$('.ddmanager').removeClass('hide');
				}

				if(data.jenis_pengadaan !== null && data.jenis_pengadaan != ''){
					$('.d_metode').removeClass('hide')
					$('#d_jenis_pengadaan').text(data.jenis_pengadaan);
				}
				let html = '';
				let i;
				
				if(data.no_kontrak !== null){
					$('#document').removeClass('hide');
					let no = 0;
					let jmldspk = data.no_kontrak.split("&");
					html += '<table id="table-doc">'+
								'<tr>'+
									'<th>#</th>'+
									'<th>Doc</th>'+
									'<th>Nama Vendor</th>'+
									'<th>No. Surat</th>'+
									'<th>Tgl. Surat</th>'+
								'</tr>';
					for(i = 0;i < jmldspk.length;i++){
						no ++;
					let dspk = jmldspk[i].split('|');
						if(i < jmldspk.length){
							html += '<tr class="rowsp"><td>'+no+'</td><td class="d_tgl_spk">'+dspk[2]+'</td>'+
								'<td class="ds_vendor">'+dspk[3]+'</td>'+
								'<td class="d_no_spk">'+dspk[0]+'</td>'+
								'<td class="d_tgl_spk">'+tanggal_indo(dspk[1])+'</td>'+
								'</tr>';
						}else if(i == jmldspk.length){
							html += '<tr class="rowsp"><td>'+no+'</td><td class="d_tgl_spk">'+dspk[2]+'</td>'+
								'<td class="ds_vendor">'+dspk[3]+'</td>'+
								'<td class="d_no_spk">'+dspk[0]+'</td>'+
								'<td class="d_tgl_spk">'+tanggal_indo(dspk[1])+'</td>'+
								'</tr></table>';
						}

					}
					$('#detail-surat').html(html)
					//$('#table-detail tr:eq(5)').after(html);
				}else{
					//$('#detail-surat').html('Tidak ada data');
					$('#document').addClass('hide');
					//$('.rowsp').remove();
				}

				let comment = result.comment;
				let tblc = '';

				if(comment.length > 0)
				{
					$('#comment').removeClass('hide');
					let no = 0;
					
					for(i = 0; i < comment.length ;i++){
						no++;
						 tblc += '<a class="collection-item"><span class="new badge" data-badge-caption="'+comment[i].created_at+'">'+comment[i].nama+' on </span>'+comment[i].comment+'</a>';
					}
					$('#tblcomments').html(tblc);	
				}else{
					$('#comment').addClass('hide');
					//tblc = 'Tidak ada data';
				}
				//$('#tblcomments').html(tblc);
				//aanwijzing
				let aanw = result.aanwijzing;
				let tblaan = "";

				if(aanw.length > 0){
					$('#aanwijzing').removeClass('hide');
					
					let no = 0;
					tblaan += '<table id="table-aan">'+
									'<tr>'+
										'<th>#</th>'+
										'<th>Perihal</th>'+
										'<th>Tempat</th>'+
										'<th>Tgl. Aanwijzing</th>'+
										'<th>Peserta</th>'+
									'</tr>';
					
					for(i = 0; i < aanw.length ;i++){
						no++;
						 tblaan += '<tr>'+
										'<td>'+no+'</td>'+
										'<td>'+aanw[i].perihal+'</td>'+
										'<td>'+aanw[i].tempat+'</td>'+
										'<td>'+tanggal_indo(aanw[i].tgl)+' '+aanw[i].jam+'</td>'+
										'<td>'+aanw[i].peserta+'</td>'+
									'</tr>';
					}
					tblaan += '</table>';
				}else{

					tblaan = 'Tidak ada data';
				}

				$('#tblaanwijzing').html(tblaan);
				let auc = result.auction;
				let tblauc = "";

				if(auc.length > 0){
					$('#eauction').removeClass('hide');
					let no = 0;
					tblauc += '<table id="table-auc">'+
									'<tr>'+
										'<th>#</th>'+
										'<th>Tempat</th>'+
										'<th>Tgl. Auction</th>'+
										'<th>Vendor Peserta</th>'+
									'</tr>';
					
					for(i = 0; i < auc.length ;i++){
						no++;
						 tblauc += '<tr>'+
										'<td>'+no+'</td>'+
										'<td>'+auc[i].tempat+'</td>'+
										'<td>'+tanggal_indo(auc[i].tanggal)+' '+auc[i].jam+'</td>'+
										'<td>'+auc[i].vendor+'</td>'+
									'</tr>';
					}
					tblauc += '</table>';
				}else{
					tblauc = "Tidak ada data.";
				}


				$('#tblauction').html(tblauc);

				if(cek_similar($('#d_unamepembuat').text(), '<?= $_SESSION['username'];?>')){
					//$('#d_no_spk').html(strip(no_spk));
				}else{
					//$('#d_no_spk').html(strip(data.no_spk));
				}
				if(data.nama !== null){
					
					$('.ddpembuat').removeClass('hide');
					$('#d_pembuat').html(data.nama);
				}
				
				
				if(data.tempat_pengadaan == 'PFA'){
					let pfa = result.pfa;
					let tblpfa = "";
					if(pfa.length > 0)
					{
						$('#pfa').removeClass('hide');
						let no = 0;
						tblpfa += '<table id="table-pfa">'+
										'<tr>'+
											'<th>#</th>'+
											'<th>Tgl. Kirim</th>'+
											'<th>Tgl. Surat</th>'+
											'<th>No. Surat</th>'+
											'<th>Perihal</th>'+
										'</tr>';
						
						for(i = 0; i < pfa.length ;i++){
							no++;
							 tblpfa += '<tr>'+
											'<td>'+no+'</td>'+
											'<td>'+tanggal_indo(pfa[i].tgl_kirim)+'</td>'+
											'<td>'+tanggal_indo(pfa[i].tgl_surat)+'</td>'+
											'<td>'+pfa[i].no_surat+'</td>'+
											'<td>'+pfa[i].perihal+'</td>'+
										'</tr>';
						}
						tblpfa += '</table>';
						$('#tblpfa').html(tblpfa);
						$('#btn-proses-pfa').addClass('hide');
						$('#btn-proses').removeClass('hide');
					}else{
						$('#btn-proses-pfa').removeClass('hide');
						$('#btn-proses').addClass('hide');
						$('#pfa').addClass('hide');
						$('#tblpfa').html('');
					}
					
				}else{
					$('#pfa').addClass('hide');
					$('#tblpfa').html('');
				}
				if(data.status_data == 'Done' || '<?= $_SESSION['role'];?>' == 'user'){
					$('#d_status_data').text(strip(data.status_data)).css({'color':'green'});
					$('#btn-ubah, #btn-disposisi, #btn-return').addClass('hide');
					$('#btn-eauction, #btn-aanwijzing, #btn-hapus, #btn-proses, #btn-comments, #btn-proses-pfa').addClass('hide');
					

				}else{ // jika status masih on proses
					$('#btn-ubah, #btn-return').removeClass('hide');
					
					$('#btn-comments, #btn-hapus').removeClass('hide');

					if(data.nama != null){ //jika pembuat ada 
						
						$('#btn-jenis').removeClass('hide');
						
						//$('#btn-disposisi').hide();
						if(cek_similar(data.username, '<?= $_SESSION['username'];?>'))
						{
							if(data.jmlp > 1 ){
								$('#btn-disposisi').addClass('hide');
								
							}else{
								$('#btn-disposisi').removeClass('hide')
							}
							$('#btn-jenis').removeClass('hide');
							$('#btn-ubah, #btn-return').show();

							if(data.tempat_pengadaan !== null){ 
							//jika tempat pengadaan sudah diisi
								$('#btn-jenis').addClass('hide');
								

								if(data.tempat_pengadaan == 'BSK'){
									
									if(data.jenis_pengadaan == 'Pembelian Langsung'){
										$('#btn-proses, #btntmbhvendor').attr('jenis-pengadaan', data.jenis_pengadaan);
										$('#modal_prosesSPK .spk').show();
										$('#btn-proses').removeClass('hide');
										$('#btn-eauction').removeAttr('jenis');

									}else if(data.jenis_pengadaan == 'Penunjukan Langsung'){
										$('#btn-aanwijzing').removeClass('hide');
										$('#btn-proses, #btntmbhvendor').attr('jenis-pengadaan', data.jenis_pengadaan);
										$('#btn-eauction, #eauction').removeAttr('jenis');
										$('#btn-proses').removeClass('hide');
										$('#modal_prosesSPK .spk').hide();
										
									}else if(data.jenis_pengadaan == 'Pemilihan Langsung'){
										
										$('#btn-proses, #btntmbhvendor').attr('jenis', 'auction');
										$('#btn-proses, #btntmbhvendor').attr('jenis-pengadaan', data.jenis_pengadaan);
										$('#btn-aanwijzing, #btn-eauction').removeClass('hide');
										$('#btn-lelang').addClass('hide');
										if(result.auction.length > 0){
											$('#btn-proses').removeClass('hide');
										}else{
											$('#btn-proses').addClass('hide');
										}

									}else if(data.jenis_pengadaan == 'Pelelangan'){
										$('#btn-proses, #btntmbhvendor').attr('jenis-pengadaan', data.jenis_pengadaan);
										if(data.no_srt_llg == null && data.tgl_srt_llg == null){
											$('#btn-proses').addClass('hide');
											$('#btn-lelang').removeClass('hide');//disini
											$('#btn-aanwijzing').removeClass('hide');

										}else{

											$('#d_no_lelang').text(data.no_srt_llg);
											$('#d_tgl_lelang').text(tanggal_indo(data.tgl_srt_llg));
											$('#d_perihal_lelang').text(data.perihal_llg);
											$('#btn-lelang').addClass('hide');
											$('#btn-aanwijzing').removeClass('hide');
											if(auc.length > 0){
												$('#btn-proses').removeClass('hide');
											}
											
											$('#btn-proses, #btntmbhvendor').attr('jenis', 'auction');
											$('#btn-eauction').removeClass('hide');
											$('.row-lelang').removeClass('hide');
											
										}

									}

								}else{ // jika pengadaan nya di pfa
									//tambahin btn memo ke pfa
									$('#btn-eauction').addClass('hide');
									$('#btn-aanwijzing').removeClass('hide');
									
									
								}
							}

						}else{//jika petugasnya orang lain
							$('#btn-aanwijzing, #btn-eauction, #btn-proses, #btn-lelang, #btn-proses-pfa, #btn-jenis').addClass('hide');
							$('#btn-eauction, #eauction').removeAttr('jenis');
						}
						
					}else{

						$('#btn-disposisi').removeClass('hide')
					}

					if(data.alasan != null){
						let tp = 'Tgl. Pengembalian: '+tanggal(data.tgl_kembali)+'|No. Surat Pengembalian: '+data.no_pengembalian+'|Tgl. Surat Pengembalian: '+tanggal(data.tgl_srt_pengembalian);
						let status = "<span aria-label='"+tp+"' data-balloon-pos='up'>"+data.alasan+"</span>";

						$('#d_status_data').text('Memo / Notin Dikembalikan').css({'color':'red'});
						$('.alasan').removeClass('hide');
						$('#d_alasan').html(status);
						$('#btn-return, #btn-eauction, #btn-aanwijzing, #btn-hapus, #btn-proses, #btn-ubah, #btn-comments, #btn-jenis').addClass('hide');
						
					}else if(data.alasan_batal != null){
						let tp = 'Tgl. Pembatalan: '+tanggal(data.tgl_pembatalan)+'|No. Surat Pembatalan: '+data.no_srt_btl+'|Tgl. Surat Pengembalian: '+tanggal(data.tgl_srt_btl);
						let status = "<span aria-label='"+tp+"' data-balloon-pos='up'>"+data.alasan_batal+"</span>";

						$('#d_status_data').text('Dibatalkan').css({'color':'red'});
						$('.alasan').removeClass('hide');
						$('#d_alasan').html(status);
						$('#btn-return, #btn-eauction, #btn-aanwijzing, #btn-hapus, #btn-proses, #btn-ubah, #btn-comments, #btn-proses-pfa, #btn-jenis').addClass('hide');

					}else{
						
						$('#d_status_data').text(strip(data.status_data)).css({'color':'green'});
						/*if(data.tempat_pengadaan == 'BSK'){
							
							$('.alasan').addClass('hide');
							$('#btn-ubah, #btn-return, #btn-aanwijzing, #btn-hapus').removeClass('hide');
						}else{
							$('#btn-ubah, #btn-return, #btn-aanwijzing, #btn-hapus').removeClass('hide');
							$('#btn-eauction').addClass('hide');
						}*/
					}
				}

			}
		})
	}
	

</script>