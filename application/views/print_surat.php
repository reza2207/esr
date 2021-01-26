
<link href="<?= base_url().'assets/font-awesome-4.7.0/css/font-awesome.css';?>" rel="stylesheet">
<link href="<?= base_url().'assets/css/print.css';?>" rel="stylesheet">
<style>
@page {
    margin: 0;
	overflow: hidden;
	position: relative;
	box-sizing: border-box;
	page-break-after: always;
}

@media print{
	
	
	#print, #close{
		display: none;
	}
	#contawal{
		margin-top: 30px;margin-left: 20px;
	}
	
}

.table {
    border-collapse: collapse;
}

.table tr td {
    border: 1px solid black;align-items: center;font-family: Arial, Helvetica, sans-serif;
}

.head-tb{
	text-align: center
}
.table td{
	width: 120px;
}
.isi{
	padding-bottom: 5px;
	min-height: 60px;
	max-height: 80px;
}

.header{
	text-align: center;
	padding-bottom: 10px;
	font-family: Arial, Helvetica, sans-serif;
	padding-top: 10px;
}

.table{
	margin:auto;

}
.container{
	width: 195mm;
    height: 200px;
    border: 1px solid black;


}
.ttd{
	height: 50px;
}
.tdisidb{
	padding-left: 8px;padding-right: 15px;font-family: Arial, Helvetica, sans-serif;
}
.contact{
	z-index: 2;
	position: absolute;
	padding-left:7px;
	margin-top: 0px;
	font-family: Arial, Helvetica, sans-serif;
	padding-top: 10px;
	font-weight: bolder;
}
.btn:hover, .btn:focus {
  text-decoration: none;
}
	.kotak1{
		padding-top: 10px
	}
	.kotak{
		position: relative;
		padding-bottom: 10px;
		padding-left: 30px;
		
	}
	.kotak0{
		padding-bottom: 15px;
	}
.head-tb td{
	font-weight: bolder;
}
.header,.isi,.isidb,.tdisidb,.table,.head-tb,.tgl,.contact{
	font-size: 10px;
}

</style>
<?php 

if($result->num_rows() == 1){?>
	<?php $row = $result->row_array();?>
	<div class="container" id="contawal">
		<div class="header">Lembar <b>TANDA TERIMA</b> Dokumen Pengadaan Barang dan-atau Jasa</div>
		<div class="isi">
			<table>
				<tr class="isidb">
					<td class="tdisidb">No. Surat</td>
					<td>:</td>
					<td><?php echo $row['no_srt'];?></td>
				</tr>
				<tr class="isidb">
					<td class="tdisidb">Perihal</td>
					<td>:</td>
					<td><?php echo $row['perihal'];?></td>
				</tr>
				<tr class="isidb">
					<td class="tdisidb">Dari Kelompok</td>
					<td>:</td>
					<td><?php echo $row['dari_kelompok'];?></td>
				</tr>
			</table>
		</div>
		<table class="table">
			<thead>
				<tr class="head-tb">
					<td>Petugas</td>
					<td>Quality Control</td>
					<td>User</td>
					<td>Legal</td>
					<td>Sekretaris</td>
				</tr>
			</thead>
			<tbody>
				<tr class="ttd">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr class="tgl">
					<td style='padding-left: 5px'>tgl. <?php echo tanggal($row['tgl_petugas_kirim']);?></td>
					<td style='padding-left: 5px'>tgl.</td>
					<td style='padding-left: 5px'>tgl.</td>
					<td style='padding-left: 5px'>tgl.</td>
					<td style='padding-left: 5px'>tgl.</td>
				</tr>
			</tbody>
		</table>
		<div class="contact">
			Nb : Ext. PIC 36117 / 36299 (STL Purchasing)
		</div>
		
	</div>
	<br>
	<div style="border-bottom-style: dashed;border-width: 2px;">
	</div>


	<button class="btn btn-primary"  id="print"><i class="fa fa-print"></i></button>
	<button class="btn btn-warning" onclick='window.close()' id="close"><i class="fa fa-close"></i></button>

	
<?php }elseif($result->num_rows() > 1){?>
	
	<?php $no = 0;
	foreach($result->result_array() AS $row){ $no++;?>

	<div class="kotak kotak<?= $no%5;?>">
		<div class="container">
			<div class="header">Lembar <b>TANDA TERIMA</b> Dokumen Pengadaan Barang dan-atau Jasa</div>
			<div class="isi" style="padding-bottom: 5px">
				<table>
					<tr class="isidb">
						<td class="tdisidb">No. Surat</td>
						<td>:</td>
						<td><?php echo $row['no_srt'];?></td>
					</tr>
					<tr class="isidb">
						<td class="tdisidb">Perihal</td>
						<td>:</td>
						<td><?php echo $row['perihal'];?></td>
					</tr>
					<tr class="isidb">
						<td class="tdisidb">Dari Kelompok</td>
						<td>:</td>
						<td><?php echo $row['dari_kelompok'];?></td>
					</tr>
				</table>
			</div>
			<table class="table">
				<thead>
					<tr class="head-tb">
						<td>Petugas</td>
						<td>Quality Control</td>
						<td>User</td>
						<td>Legal</td>
						<td>Sekretaris</td>
					</tr>
				</thead>
				<tbody>
					<tr class="ttd">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="tgl">
						<td style='padding-left: 5px'>tgl. <?php echo tanggal($row['tgl_petugas_kirim']);?></td>
						<td style='padding-left: 5px'>tgl.</td>
						<td style='padding-left: 5px'>tgl.</td>
						<td style='padding-left: 5px'>tgl.</td>
						<td style='padding-left: 5px'>tgl.</td>
					</tr>
				</tbody>
			</table>
			<div class="contact">
				Nb : Ext. PIC 36117 / 36299 (STL Purchasing)
			</div>
			
		</div>
		<!-- <div style="border-bottom-style: dashed;border-width: 2px; ">
		</div> -->
	</div>

<?php } ?>
		
			<button class="btn btn-primary" id="print" ><i class="fa fa-print"></i></button>
			<button class="btn btn-warning" onclick='window.close()' id="close"><i class="fa fa-close"></i></button>

<?php 

}?>
	<script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
	<script type="text/javascript" >
	$(document).ready(function(){
	  	$('#print').on('click',function(e){
	    window.print()
	
		})
	})
	</script>
