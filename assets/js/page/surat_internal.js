var nomorSurat;
var tipena = $("#tipena").val()

$(document).ready(function () {

	table = $('#list_surat').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/surat/masuk/internal/aksi/data/' + tipena,
			"type": "POST",
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
				"orderable": true
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
	getUpk()
	getSifat()
	nomorSurat()
	getCurJabatan()
	getAdminPersuratan()
})

function getCurJabatan() {
	$.ajax({
		url: `${baseUrl}admin/surat/masuk/internal/aksi/getCurJabatan`,
		dataType: "JSON",
		success: function (result) {
			console.log(result)
			$("#asal_surat").val(`${result.name} - ${result.user}`)
		}
	})
}

function getAdminPersuratan() {
	$.ajax({
		url: `${baseUrl}admin/surat/masuk/internal/aksi/getAdminPersuratan`,
		dataType: "JSON",
		success: function (result) {
			console.log(result)
			$("#tujuan_kirim").val(`${result.id},`)
		}
	})
}

$('#list_surat').on('click', '#delete', function () {
	let id = $(this).data('id');
	confirmSweet("Data akan terhapus secara permanen !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/surat/masuk/internal/aksi/delete/' + id,
					type: "GET",
					success: function (result) {
						response = JSON.parse(result)
						if (response.surat == 'ok') {
							table.ajax.reload(null, false)
							// msgSweetSuccess(response.msg)
							toastSuccess(response.msg)
						} else {
							// msgSweetWarning(response.msg)
							toastWarning(response.msg)
						}
					},
					error: function (error) {
						errorCode(error)
					}
				})
			}
		})
})

function ubahFile(file) {
	$("#nempoFile").attr('src', `${baseUrl}/uploads/surat/${file}`)
}

function ambilDisposisi(id) {
	$("#nempoFile").attr('src', `${baseUrl}/admin/surat/disposisi/kode/${id}`)
}

function ambilDisposisiInternal(id) {
	$("#nempoFile").attr('src', `${baseUrl}/admin/surat/disposisi/kode/internal/${id}`)
}

function ambilPesanBalik(id) {
	$("#nempoFile").attr('src', `${baseUrl}/admin/surat/pesanbalik/kode/${id}`)
}

$('#list_surat').on('click', '#lihat', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/surat/masuk/internal/aksi/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result)
			let lampiran_ = response.lampiran
			let lampiran = lampiran_.split(",")
			let listNa = ""
			let html = ""
			if (lampiran.length > 0) {
				

				if (response.disposisi == 1 || response.disposisi == 2 && response.status_pengiriman == 1 && response.internal == 0) {
					listNa += `<button type="button" onclick="ambilDisposisi('${id}')" class="list-group-item list-group-item-action">Berkas Disposisi</button>`
				}

				if (response.disposisi == 1 || response.disposisi == 2 && response.internal == 1 && response.status_pengiriman == 1) {
					listNa += `<button type="button" onclick="ambilPesanBalik('${id}')" class="list-group-item list-group-item-action">Pesan Balasan</button>`
				}

				if (response.disposisi == 1 || response.disposisi == 2 && response.internal == 1 && response.status_pengiriman == 0) {
					listNa += `<button type="button" onclick="ambilPesanBalik('${id}')" class="list-group-item list-group-item-action">Pesan Balasan</button>`
					listNa += `<button type="button" onclick="ambilDisposisiInternal('${id}')" class="list-group-item list-group-item-action">Berkas Disposisi</button>`
				}


				lampiran.forEach(data => {
					listNa += `<button type="button" onclick="ubahFile('${data}')" class="list-group-item list-group-item-action">${data}</button>`
				})
				html = `
					<div class="col-md-4">
						<div class="list-group">
							${listNa}
						</div>
					</div>
					<div class="col-md-8">
						<embed id="nempoFile" width="100%" height="400" type="">
					</div>
				`
			} 
			$("#lampiranNa").html(html)
			$("#modalLihat").modal('show')
		},
		error: function (error) {
			errorCode(error)
		}
	})
})

$("#formAddSurat").submit(function (e) {
	e.preventDefault();
	$.ajax({
		xhr: function () {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function (evt) {
				if (evt.lengthComputable) {
					var percentComplete = (evt.loaded / evt.total) * 100;
					console.log(percentComplete);
					$("#persenUpload").html(`Uploading ${Math.round(percentComplete)}%`)
					$("#progressNa").attr("style", `width:${Math.round(percentComplete)}%`)
					$("#progressNa").attr("data-width", `${Math.round(percentComplete)}%`)
				}
			}, false);
			return xhr;
		},
		url: baseUrl + "admin/surat/masuk/internal/aksi/insert",
		type: "post",
		data: new FormData(this),
		processData: false,
		contentType: false,
		cache: false,
		beforeSend: function () {
			$("#progressNa").attr("style", `width:0%`)
			$("#progressNa").attr("data-width", `0%`)
			disableButton()
		},
		complete: function () {
			enableButton()
		},
		success: function (result) {
			let response = JSON.parse(result)
			if (response.surat == "fail") {
				msgSweetError(response.msg)
			} else {
				$("#persenUpload").html(`Idle`)
				table.ajax.reload(null, false)
				toastSuccess(response.msg)
				// clearInput($("input"))
				nomorSurat()
				getJenis()
				getAksi()
				getSifat()
				// $("#id_upk").val(upk)
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

$("#formAddTindakan").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/surat/masuk/internal/aksi/disposisi/insert",
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
			if (response.status == "fail") {
				msgSweetError(response.msg)
			} else {
				table.ajax.reload(null, false)
				toastSuccess(response.msg)
				clearInput($("input"))
				$("#id_upk").val(upk)
				$("#modalConfirm").modal('hide')
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
		url: baseUrl + "admin/surat/masuk/aksi/getJenis",
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
	$('#id_aksi').append("<option selected value=''> -- Pilih aksi -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/masuk/aksi/getAksi",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_aksi').append("<option value=" + item.id + ">" + item.aksi + "</option>");
			})
		}
	})
}

function getSifat() {
	$('#id_sifat').find('option').remove().end()
	$('#id_sifat').append("<option value=''> -- Pilih Sifat -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/masuk/aksi/getSifat",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_sifat').append("<option value=" + item.id + ">" + item.sifat + "</option>");
			})
		}
	})
	
}


function getUpk() {
	$('#asal_surat').find('option').remove().end()
	$('#asal_surat').append("<option value=''> -- Silakan Pilih Upk -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/masuk/aksi/getUpk",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#asal_surat').append("<option value='" + item.upk + "'>" + item.upk + "</option>");
			})
		}
	})
	$('#asal_surat').append("<option value=''> Lainnya </option>");
}

$('#asal_surat').change(function(evt){
    let id_upk = $(this).val();
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/masuk/aksi/getUpkSelected",
        data: {'id_upks': id_upk},
        type : 'GET',
        success: function (result) {
            let response = jQuery.parseJSON(JSON.stringify(result));
            $('#dikirim').html('')
            response.forEach(item => {
				$('#dikirim').append("<option value=" + item.id + ">" + item.jabatan + "</option>");
			})
		}
	})

})

$("#id_jenis").on('change', function () {
	nomorSurat()
})

$("#id_jenis").on('change', function () {
	nomorSurat()
})

function nomorSurat() {
	$.ajax({
		dataType: "json",
		url: baseUrl + 'admin/surat/masuk/aksi/getNomorUrut',
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result))
			let kodeJenis = $("#id_jenis").val().split('-')
			let format = {
				"NO_URUT": response.NO_URUT,
				"JENIS_SURAT": kodeJenis[0],
				"UPK": response.UPK,
				"BULAN": response.BULAN,
				"TAHUN": response.TAHUN
			}
			console.log(format);
			var nomorSurat = response.FORMAT
			Object.keys(format).forEach(key => {
				nomorSurat = nomorSurat.replace(new RegExp(`{{${key}}}`, "g"), format[key])
			})
			$("#no_surat").val(`${nomorSurat}/I`)
		}
	})
}


$(".custom-file-input").on("change", function () {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

function asalna() {
	if ($("#asal_surat").val() == '' ) {
		let html = "<label>Asal Surat</label>";
			  html+= "<input type='text' name='asal_surat' id='asalnasurat' class='form-control'>";
		$("#asalnasurat").html(html);

	}
	else{	
		$("#asalnasurat").html('');
	}
}
// Arsipkan surat
$('#list_surat').on('click', '#arsip', function () {
	let id = $(this).data('id');
	confirmSweet("Surat Akan di Arsipkan  !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/surat/masuk/internal/aksi/' + id + "/arsip",
					type: "GET",
					success: function (result) {
						response = JSON.parse(result)
						if (response.status == 'ok') {
							table.ajax.reload(null, false)
							// msgSweetSuccess(response.msg)
							toastSuccess(response.msg)
						} else {
							// msgSweetWarning(response.msg)
							toastWarning(response.msg)
						}
					},
					error: function (error) {
						errorCode(error)
					}
				})
			}
		})
})
