var nomorSurat;
var tipena = $("#tipena").val()

$(document).ready(function () {
	table = $('#list_verifikasi').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/verifikasi/aksi/data/' + tipena,
			"type": "POST",
			"data": { 'tipeKirim': 0 },
			"error": function (error) {
				errorCode(error)
			}
		},

		"columnDefs": [{
			"sClass": "text-center",
			"targets": [0],
			"orderable": false
		},
		{
			"targets": [1],
			"orderablegetJabatan": true
		},
		{
			"targets": [2],
			"orderable": true
		},
		{
			"sClass": "text-center",
			"targets": [4],
			"orderable": false
		}
		],
	});
	getJenis()
	getAksi()
	getSifat()
	nomorSurat()
	getJabatan()
	getCurUpk()
})


$('#list_verifikasi').on('click', '#confirm', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/verifikasi/aksi/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result)
			console.log(response.no_surat)
			$("#idData").val(response.id)
			$("#no_surat").val(response.no_surat)
			$("#tampilIsi").html(response.isi_surat)
			$("#tanggal_dibuat").val(response.tanggal_dibuat)
			$("#asal_surat").val(response.asal_surat)
			$("#jenis_surat").val(response.jenis_surat)
			$("#sifat_surat").val(response.sifat_surat)
			$("#userBuat").val(response.id_user)
			$("#perihal").val(response.perihal)
			$("#catatan").val(response.isi_surat)
			$("#notif").val(response.notif)
			$("#modalConfirm").modal('show')
		},
		error: function (error) {
			errorCode(error)
		}
	})
})


$('#list_verifikasi').on('click', '#lihat', function () {

	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/verifikasi/aksi/lihat/' + id,
		type: "GET",
		success: function (result) {
			
			let html = ""
			
				html = `
					<div class="col-md-12">
						<embed id="nempoFile" src="${baseUrl}/admin/verifikasi/aksi/lihat/${id}" width="100%" height="400" type="">
					</div>
				`
			
			$("#lampiranNa").html(html)
			$("#modalLihat").modal('show')
			
		},
		error: function (error) {
			errorCode(error)
		}
	})
})


$("#formAddTindakan").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: `${baseUrl}admin/verifikasi/add`,
		type: "post",
		data: new FormData(this),
		processData: false,
		contentType: false,
		cache: false,
		beforeSend: function () {
			// disableButton()
		},
		complete: function () {
			// enableButton()
		},
		success: function (result) {
			let response = JSON.parse(result)
			console.log(response)
			if (response.surat == "fail") {
				msgSweetError(response.msg)
			} else if (response.surat == "warning") {
				msgSweetWarning(response.msg)
				table.ajax.reload(null, false)
				clearInput($("select"))
				getCurUpk()
				$("#modalConfirm").modal('hide')
			} else {
				table.ajax.reload(null, false)
				toastSuccess(response.msg)
				clearInput($("select"))
				getCurUpk()
				$("#modalConfirm").modal('hide')
				// $("#id_upk").val(upk)
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

$("#formEditSurat").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/surat/keluar/aksi/update",
		type: "post",
		data: new FormData(this),
		processData: false,
		contentType: false,
		cache: false,
		beforeSend: function () {
			disableButton()
		},
		complete: function () {
			enableButton()
		},
		success: function (result) {
			let response = JSON.parse(result)
			if (response.surat == "fail") {
				// msgSweetError(response.msg)
				clearInput($("input"))
				$("#modalEdit").modal('hide')
			} else {
				table.ajax.reload(null, false)
				toastSuccess(response.msg)
				clearInput($("input"))
				$("#modalEdit").modal('hide')
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

function getJenis() {
	$('#id_jenis').find('option').remove().end()
	$('#id_jenis').append("<option value=''> -- Pilih Jenis -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/keluar/aksi/getJenis",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_jenis').append(`<option value="${item.kode_jenis}-${item.id}">${item.jenis}</option>`);
			})
		}
	})
}

function getAksi() {
	$('#id_aksi').find('option').remove().end()
	$('#id_aksi').append("<option value=''> -- Pilih Aksi -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/keluar/aksi/getAksi",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_aksi').append("<option value=" + item.id + ">" + item.aksi + "</option>");
			})
		}
	})
}

function getJabatan() {
	$('#ttd_pejabat').find('option').remove().end()
	$('#ttd_pejabat').append("<option value=''> -- Pilih Tanda Tangan -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/keluar/aksi/getJabatan",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#ttd_pejabat').append("<option value=" + item.value + ">" + item.name + "</option>");
			})
		}
	})
}

function getSifat() {
	$('#id_sifat').find('option').remove().end()
	$('#id_sifat').append("<option value=''> -- Pilih Sifat -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/keluar/aksi/getSifat",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_sifat').append("<option value=" + item.id + ">" + item.sifat + "</option>");
			})
		}
	})
}

$("#id_jenis").on('change', function () {
	nomorSurat()
})

$("#ttd_pejabat").on('change', function() {
	let id = $(this).val()
	let html = ''
	let optionNa = ''
	$.ajax({
		dataType: "json",
		url: `${baseUrl}admin/surat/keluar/aksi/getStaff/${id}`,
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				optionNa += `<option value='${item.id}'>${item.name}</option>`
			})
			html = `
				<div class="form-group">
                	<label>Staff</label>
					<select class="form-control" name="">
						${optionNa}
					</select>
                </div>
			`
			$("#pilihStaff").html(html)
		}
	})	
})

function getCurUpk() {
	$.ajax({
		dataType: "json",
		url: baseUrl + 'admin/surat/keluar/aksi/getCurUpk',
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result))
			$("#jabatanNa").val(response.jabatan)
		}
	})
}

function nomorSurat() {
	$.ajax({
		dataType: "json",
		url: baseUrl + 'admin/surat/keluar/aksi/getNomorUrut',
		success: function (result) {
			// let response = jQuery.parseJSON(JSON.stringify(result))
			// $("#no_surat").val(response.nomor)
			let response = jQuery.parseJSON(JSON.stringify(result))
			let kodeJenis = $("#id_jenis").val().split('-')
			let nomorSurat = `${response.nomor}/${kodeJenis[0]}/${response.upk}/${response.bulan}${response.tahun}`;
			$("#no_surat").val(nomorSurat)
		}
	})
}

function statusRevisi() {
	if ($("#status").val() == '0' ) {
		let html = "<label>Apakah Revisi?</label>";
			  html+= "<select class='form-control' id='statusrevisi' name='statusrevisi' onchange='catatanRevisi()'><option value='4'>TIdak</option><option value='2'>Ya</option></select>";
		$("#statusRevisiNa").html(html);
	}
	else{	
		$("#statusRevisiNa").html('');
		$("#catatanRevisiNa").html('');
	} 
}

function catatanRevisi() {
	if ($("#statusrevisi").val() == '2' ) {
		let html = "<label>Catatan Revisi</label>";
			  html+= "<textarea class='form-control' id='catatanrevisi' name='catatanrevisi'></textarea>";
		$("#catatanRevisiNa").html(html);
	}
	else{	
		$("#catatanRevisiNa").html('');
			if ($("#status").val() == '1') {
				$("#catatanRevisiNa").html('');
		}
	}
}

