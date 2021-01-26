$(document).ready(function(){
		$(".select2").select2({
			placeholder: 'Select an option',
		},$('select').css('width','100%'));

		$('.collapsible').collapsible({
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

		});
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
				{"data": ['no']},
				{"data": ['tgl_surat']},
				{"data": ['no_surat']},
				{"data": ['tgl_terima_surat']},
				{"data": ['perihal']},
				{"data": ['jenis_surat']},
				{"data": ['status']},
			],
			"dom": 'Bflrtip',
							buttons: [
						{ className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
						{ className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
						{ extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>', attr: {'aria-label':'Copy Data','data-balloon-pos':'up'}},
						{ extend: 'csv', className: 'btn btn-small light-blue darken-4'},
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
							"targets": [ 0, 1, 2, 3, 5, -1 ],
							"className": 'center'
						}
				],
			"createdRow" : function(row, data, index){
				$(row).addClass('row');
				$(row).attr('data-id',data['id_register']);
				if(data['jenis_surat'] == 'Email'){
					$(row).css({'background':'#65635D','color':'white'});//#140FF0
				}

				if(data['status_data'] == 'Done'){
					$(row).css({'background':'#039be5','color':'white'});
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
		$('#jenis_surat').on('change', function(e){
			e.preventDefault();
			if(this.value == 'Email'){
				$('.surat').addClass('hide');
				$('.email').removeClass('hide');
				$('.surat input').val('');
				$('.beban').addClass('hide');
			}else if(this.value == '' || this.value == 'Pemberitahuan'){
				$('.surat').removeClass('hide');
				$('.email').addClass('hide');
				$('.email input').val('');
				$('.surat input').val('');
				$('.beban').addClass('hide');
			}else{
				$('.beban').removeClass('hide');
				$('.email').addClass('hide');
				$('.surat').removeClass('hide');
				$('.email input').val('');

			}
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
					})
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1

					}).attr('readonly', false);
					
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
					})
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
					})
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
					}).attr('readonly', false);
					
				}else if(dpim != '' && dman == ''){//second
					$('.dpim').show();
					$('.datepicker').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					})
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);

					$('.dman').html(rdman);
					$('#dtglDisposisiManager').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1
					}).attr('readonly', false);
					
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
					})
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).datepicker('destroy').attr('readonly', true);
					$('#tmbhrowpembuat').addClass('hide');
					
				}
			}
		}
		$('#proses_surat').on('click', function(e){
			swal({
				type: 'question',
				text: 'Are you Sure?',
				showConfirmButton: true,
				allowOutsideClick: false,
				showCancelButton: true
			}).then(function(){
				let id = $(this).attr('data-id');
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."register/update_surat";?>',
					data: $('#formsurat').serialize(),
					success: function(result){
						let data = JSON.parse(result);
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
			$.post("<?= base_url().'tdr/get_tdr';?>", function(result){
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
		$('#modal_eauction .hapus-row').on('click', function(e){
			e.preventDefault();
			$(this).parent().parent().remove();
		})
		$('#proses_aanwijzing').on('click', function(e){
			let id = $(this).attr('data-id');
			e.preventDefault();
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
	function update_modal(id){
		
		$('#d_disposisi_pimkel, #d_disposisi_manager, #d_pembuat, #d_jenis_pengadaan, #d_unamepembuat, #d_jenis_surat, #d_no_surat, #d_tgl_surat, #d_terima_surat,#d_perihal, #d_tempat_pengadaan, ds_vendor_p, .s-pembuat, #dpembuat, #d_alasan, #tblcomments').html('');
		
		$('.ddpimkel, .ddmanager, .ddpembuat, .spk, .alasan').hide();
		$('#btn-ubah, #btn-hapus, #proses, #btn-disposisi, #update_surat, #proses_disposisi, #proses_spk, #proses_jenis, #btn-eauction, #btn-proses, #btntmbhvendor, #btn-lelang, #proses_return, #proses_comment').attr('data-id', id);
		$('.idregister').val(id);
		$('#btn-eauction, #eauction, #btn-lelang, #btn-jenis, .row-lelang, .d_tempat, .row-surat, .row-email, #btn-aanwijzing, #btn-proses, #aanwijzing, .d_metode, #btn-proses-pfa, #btn-proses, #btn-hapus, #btn-disposisi').addClass('hide');
		$('#btn-eauction, #eauction').removeAttr('jenis');
		$.ajax({
			type:'GET',
			url: '<?= base_url()."Register/get_detail_masuk/";?>'+id,
			dataType: 'JSON',
			success: function(result){
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
					$('.ddmanager').show();
				}

				if(data.jenis_pengadaan !== null && data.jenis_pengadaan != ''){
					$('.d_metode').removeClass('hide')
					$('#d_jenis_pengadaan').text(data.jenis_pengadaan);
				}
				let html = '';
				let i;
				
				if(data.no_kontrak !== null){
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
					$('#detail-surat').html('Tidak ada data');
					//$('.rowsp').remove();
					
				}

				let comment = result.comment;
				let tblc = '';

				if(comment.length > 0)
				{
					let no = 0;
					
					for(i = 0; i < comment.length ;i++){
						no++;
						 tblc += '<a class="collection-item"><span class="new badge" data-badge-caption="'+comment[i].created_at+'">'+comment[i].nama+' on </span>'+comment[i].comment+'</a>';
					}
					
				}else{

					tblc = 'Tidak ada data';
				}
				$('#tblcomments').html(tblc);
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
										'<td>'+aanw[i].tgl+' '+aanw[i].jam+'</td>'+
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
										'<td>'+auc[i].tanggal+' '+auc[i].jam+'</td>'+
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
				
				$('.ddpembuat').show();
				$('#d_pembuat').html(data.nama);

				if(data.status_data == 'Done' || '<?= $_SESSION['role'];?>' == 'user'){
					$('#d_status_data').text(strip(data.status_data)).css({'color':'green'});
					$('#btn-ubah, #btn-disposisi, #btn-return').hide();
					$('#btn-eauction, #btn-aanwijzing, #btn-hapus, #btn-proses, #btn-comments, .alasan').addClass('hide');
					

				}else{ // jika status masih on proses

					
					$('#btn-comments, #btn-hapus').removeClass('hide');

					if(data.nama != null){ //jika pembuat ada 

						$('#btn-jenis').removeClass('hide');
						
						//$('#btn-disposisi').hide();
						if(cek_similar(data.username, '<?= $_SESSION['username'];?>'))
						{

							$('#btn-jenis').removeClass('hide');
							$('#btn-ubah, #btn-return').show();

							if(data.tempat_pengadaan !== null){ 
							//jika tempat pengadaan sudah diisi
								$('#btn-jenis').addClass('hide');
								$('#btn-aanwijzing').removeClass('hide');
								if(data.tempat_pengadaan == 'BSK'){
									
									if(data.jenis_pengadaan == 'Pembelian Langsung'){
										$('#btn-proses, #btntmbhvendor').attr('jenis-pengadaan', data.jenis_pengadaan);
										$('#modal_prosesSPK .spk').show();
										$('#btn-proses').removeClass('hide');
										$('#btn-eauction').removeAttr('jenis');
									}else if(data.jenis_pengadaan == 'Penunjukan Langsung'){
										$('#btn-aanwijzing').show();
										$('#btn-proses, #btntmbhvendor').attr('jenis-pengadaan', data.jenis_pengadaan);
										$('#btn-eauction, #eauction').removeAttr('jenis');
										$('#btn-proses').removeClass('hide');
										$('#modal_prosesSPK .spk').hide();
										
									}else if(data.jenis_pengadaan == 'Pemilihan Langsung'){
										$('#btn-aanwijzing').show();
										$('#btn-proses, #btntmbhvendor').attr('jenis', 'auction');
										$('#btn-aanwijzing, #btn-eauction').removeClass('hide');
										$('#btn-lelang').addClass('hide');
										if(result.auction.length > 0){
											$('#btn-proses').removeClass('hide');
										}else{
											$('#btn-proses').addClass('hide');
										}

									}else if(data.jenis_pengadaan == 'Pelelangan'){

										if(data.no_srt_llg == null && data.tgl_srt_llg == null){
											$('#btn-proses').addClass('hide');
											$('#btn-lelang').addClass('hide');//disini
											$('#btn-aanwijzing').removeClass('hide');

										}else{

											$('#d_no_lelang').text(data.no_srt_llg);
											$('#d_tgl_lelang').text(tanggal_indo(data.tgl_srt_llg));
											$('#btn-lelang').addClass('hide');
											$('#btn-aanwijzing').show();
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
									$('#btn-proses-pfa').removeClass('hide');
									
									
								}
							}

						}else{//jika petugasnya orang lain
							$('#btn-eauction, #btn-proses, #btn-lelang, #btn-proses-pfa').addClass('hide');
							$('#btn-aanwijzing, #btn-jenis').hide();
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
						$('#btn-return, #btn-eauction, #btn-aanwijzing, #btn-hapus, #btn-proses, #btn-ubah, #btn-comments').addClass('hide');

					}else{
						$('#d_status_data').text(strip(data.status_data)).css({'color':'green'});
						if(data.tempat_pengadaan == 'BSK'){
							
							$('.alasan').addClass('hide');
							$('#btn-ubah, #btn-return, #btn-eauction, #btn-aanwijzing, #btn-hapus').removeClass('hide');
						}else{
							$('#btn-ubah, #btn-return, #btn-aanwijzing, #btn-hapus').removeClass('hide');
							$('#btn-eauction').addClass('hide');
						}
					}
				}

			}
		})
	}