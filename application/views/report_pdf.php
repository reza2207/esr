<style type="text/css">
	table {
	    border-collapse: collapse;
	    margin-top: 10px;
	}

	table, th, td {
	    border: 1px solid black;
	}
</style>

	<?php
	$no = 1;
	$r = $query->result();

	for($i = 0; $i < $query->num_rows();$i++){?>
		<?php if($i >= 0){?>
			<?php if($i == 0){?>

			<?php }elseif($r[$i]->bulan_open != $r[$i-1]->bulan_open && $r[$i]->buku_dua == ''){;?>
			
				<tr>
					<td class='center'><?= $no++;?></td>
					<td class='center'><?= $r[$i]->no_bg;?></td>
					<td class='center'><?= $r[$i]->beneficiary;?></td>
					<td class='center'><?= $r[$i]->applicant;?></td>
					<td class='center'><?= $r[$i]->issuer;?></td>      
					<td class='center'><?= $r[$i]->ccy;?></td>
					<td class='center'><?= $r[$i]->amount;?></td>
					<td class='center'><?= $r[$i]->eqv;?></td>
					<td class='center'><?= $r[$i]->open;?></td>
					<td class='center'><?= $r[$i]->start;?></td>
					<td class='center'><?= $r[$i]->maturity;?></td>
					<td class='center'><?= $r[$i]->gl_acc;?></td>
					<td class='center'><?= $r[$i]->type;?></td>
					<td class='center'><?= $r[$i]->keterangan;?></td>
					<td class='center'><?= $r[$i]->buku_satu;?></td>
					<td class='center'><?= $r[$i]->buku_dua;?></td>
					<td class='center'><?= $r[$i]->jenis_pekerjaan;?></td>
				</tr>
					
			<?php }elseif($r[$i]->bulan_open == $r[$i -1]->bulan_open){?>
				<table>
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
				<tbody>
				<tr>
					<td class='center'><?= $no++;?>s</td>
					<td class='center'><?= $r[$i]->no_bg;?></td>
					<td class='center'><?= $r[$i]->beneficiary;?></td>
					<td class='center'><?= $r[$i]->applicant;?></td>
					<td class='center'><?= $r[$i]->issuer;?></td>      
					<td class='center'><?= $r[$i]->ccy;?></td>
					<td class='center'><?= $r[$i]->amount;?></td>
					<td class='center'><?= $r[$i]->eqv;?></td>
					<td class='center'><?= $r[$i]->open;?></td>
					<td class='center'><?= $r[$i]->start;?></td>
					<td class='center'><?= $r[$i]->maturity;?></td>
					<td class='center'><?= $r[$i]->gl_acc;?></td>
					<td class='center'><?= $r[$i]->type;?></td>
					<td class='center'><?= $r[$i]->keterangan;?></td>
					<td class='center'><?= $r[$i]->buku_satu;?></td>
					<td class='center'><?= $r[$i]->buku_dua;?></td>
					<td class='center'><?= $r[$i]->jenis_pekerjaan;?></td>
				</tr>
			<?php }?>
		<?php }?>


	<?php }?>
	</tbody>
</table>