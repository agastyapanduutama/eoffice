var nomorSurat;

$(document).ready(function () {
	tampilData()
	getJenis()
	getAksi()
	getSifat()
	nomorSurat()
	getJabatan()
	getCurUpk()
	masukinTag("#tembusanNa", "getJabatan")

})

function tampilData() {
	var statusPengiriman = $("#statusPengiriman").val();
	try {
		table.destroy()
	} catch (error) {
		
	}
	table = $('#list_surat').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/surat/internal/keluar/aksi/data',
			"type": "POST",
			"data": {
				'tipeKirim': 0,
				'statusPengiriman': statusPengiriman
			},
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
}

$("#statusPengiriman").on('change', function(){
	tampilData();
})

$('#list_surat').on('click', '#edit', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/surat/internal/keluar/aksi/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result) 
			let nomorUrut = response.no_surat.split('/');
			$("#nomorUrutSurat").val(nomorUrut[0])
			$("#idData").val(response.id_suratkeluar)
			$("#RevisiDari").html(response.nama_user)
			$("#catatan1").html(response.catatan_revisi)
			$("#no_surat1").val(response.no_surat)
			$("#tanggal_dibuat1").val(response.tanggal_dibuat)
			$("#id_jenis1").val(`${response.kode_jenis}-${response.jenis_surat}`).change()
			$("#id_sifat1").val(response.sifat_surat).change()
			$("#perihal1").val(response.perihal)
			$("#persetujuan1").val(response.persetujuan)
			$("#asalSurat").val(response.id_upk)
			$("#userBuat").val(response.id_user)
			// $("#isi_surat1").text(response.isi_surat)
			$('#isi_surat1').summernote("code", response.isi_surat);
			$("#modalEdit").modal('show')
		},
		error: function (error) {
			errorCode(error)
		}
	})
})

$('#list_surat').on('click', '#delete', function () {
	let id = $(this).data('id');
	confirmSweet("Data akan terhapus secara permanen !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/surat/internal/keluar/aksi/delete/' + id,
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

$("#formAddSurat").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/surat/internal/keluar/aksi/insert",
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
			if (response.surat == "fail") {
				msgSweetError(response.msg)
			} else if (response.surat == "warning") {
				msgSweetWarning(response.msg)
				table.ajax.reload(null, false)
				clearInput($("select"))
				getCurUpk()
				$("#modalTambah").modal('hide')
			} else {
				table.ajax.reload(null, false)
				toastSuccess(response.msg)
				clearInput($("select"))
				getCurUpk()
				$("#modalTambah").modal('hide')
				// $("#id_upk").val(upk)
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

$("#formRevisiSurat").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/surat/internal/keluar/aksi/insert/revisi",
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
			if (response.surat == "fail") {
				msgSweetError(response.msg)
			} else {
				table.ajax.reload(null, false)
				toastSuccess(response.msg)
				clearInput($("input"))
				getCurUpk()
				$("#modalEdit").modal('hide')
				// $("#id_upk").val(upk)
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

$('#list_surat').on('click', '#lihat', function () {

	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/verifikasi/aksi/lihat/' + id,
		type: "GET",
		success: function (result) {
			
			let html = ""
			
				html = `
					<div class="col-md-12">
						<embed id="nempoFile" src="${baseUrl}/admin/verifikasi/internal/aksi/lihat/${id}" width="100%" height="400" type="">
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

function getJenis() {
	$('#id_jenis').find('option').remove().end()
	$('#id_jenis').append("<option value=''> -- Pilih Jenis -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/internal/keluar/aksi/getJenis",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_jenis').append(`<option value="${item.kode_jenis}-${item.id}">${item.jenis}</option>`);
			})
		}
	})

	$('#id_jenis1').find('option').remove().end()
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/internal/keluar/aksi/getJenis",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_jenis1').append(`<option value="${item.kode_jenis}-${item.id}">${item.jenis}</option>`);
			})
		}
	})
}

function getAksi() {
	$('#id_aksi').find('option').remove().end()
	$('#id_aksi').append("<option value=''> -- Pilih Aksi -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/internal/keluar/aksi/getAksi",
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
		url: baseUrl + "admin/surat/internal/keluar/aksi/getJabatan",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#ttd_pejabat').append("<option value=" + item.value + ">" + item.jabatan + " - " + item.name +  "</option>");
			})
		}
	})
}

function getSifat() {
	$('#id_sifat').find('option').remove().end()
	$('#id_sifat').append("<option value=''> -- Pilih Sifat -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/internal/keluar/aksi/getSifat",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_sifat').append("<option value=" + item.id + ">" + item.sifat + "</option>");
			})
		}
	})

	$('#id_sifat1').find('option').remove().end()
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/internal/keluar/aksi/getSifat",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_sifat1').append("<option value=" + item.id + ">" + item.sifat + "</option>");
			})
		}
	})

}
$("#id_jenis").on('change', function () {
	nomorSurat()
})

$("#id_jenis1").on('change', function () {
	nomorSurat()
})

$("#ttd_pejabat").on('change', function() {
	let id = $(this).val()
	let html = ''
	let optionNa = ''
	$.ajax({
		dataType: "json",
		url: `${baseUrl}admin/surat/internal/keluar/aksi/getStaff/${id}`,
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
		url: baseUrl + 'admin/surat/internal/keluar/aksi/getAsalNa',
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result))
			$("#upkNa").val(`${result.upk} - ${result.name}`)
		}
	})

	$.ajax({
		dataType: "json",
		url: baseUrl + 'admin/surat/internal/keluar/aksi/getCurUpk',
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result))
			$("#upkNa1").val(response.upk)
		}
	})

	$('#tujuanNa').find('option').remove().end()
	$('#tujuanNa').append("<option value='' selected disabled> -- Silakan Pilih Tujuan -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/surat/internal/keluar/aksi/getUpk",
		success: function (result) {
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#tujuanNa').append("<option value='" + item.upk + "'>" + item.upk + "</option>");
			})
		}
	})
	// $('#tujuanNa').append("<option value=''> Lainnya </option>");
}

function nomorSurat() {
	$.ajax({
		dataType: "json",
		url: baseUrl + 'admin/surat/internal/keluar/aksi/getNomorUrut',
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
			var nomorSurat1 = response.FORMAT
			Object.keys(format).forEach(key => {
				nomorSurat = nomorSurat.replace(new RegExp(`{{${key}}}`, "g"), format[key])
				nomorSurat1 = nomorSurat1.replace(new RegExp(`{{${key}}}`, "g"), format[key])
			})
			let noUrut = $("#nomorUrutSurat").val()
			if (noUrut != '') {
				$("#no_surat1").val(`${noUrut}/${nomorSurat2}I`)
			} else {
				$("#no_surat").val(`${nomorSurat}I`)
				$("#no_surat1").val(`${nomorSurat}I`)
			}

		}
	})
}

// Arsipkan surat
$('#list_surat').on('click', '#arsip', function () {
	let id = $(this).data('id');
	confirmSweet("Surat Akan diArsipkan  !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/surat/internal/keluar/aksi/' + id + "/arsip",
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

function statusLampiran() {
	if ($("#lampiranPilih").val() == '1') {
		let html = "<label>Jenis Lampiran</label>";
		html += "<select class='form-control' id='jenislampiran' name='jenis_lampiran' onchange='namaFile()'><option> -- Silakan Pilih --</option><option value='1'>Hardcopy</option></select>";
		// html += "<select class='form-control' id='jenislampiran' name='jenis_lampiran' onchange='namaFile()'><option> -- Silakan Pilih --</option><option value='1'>Hardcopy</option><option value='2'>Softcopy</option></select>";
		$("#jenisLampiran").html(html);
	} else {
		$("#jenisLampiran").html('');
		$("#fileLampiran").html('');
	}
}

function namaFile() {
	if ($("#jenislampiran").val() == '2') {
		// alert("heloworld")
		let html = "<label>File Lampiran</label>";
		html += "<input type='file' name='lampiran' class='form-control'>";
		$("#fileLampiranNa").html(html);
	} else {
		let html = "<label>Nama Lampiran</label>";
		html += "<input type='text' name='lampiran' class='form-control'><br>Dipisahkan Menggunakan Koma (,)";
		$("#fileLampiranNa").html(html);
	}
}


$(document).delegate('#tembusanNa', 'change', function(){
	// alert("Asdasdasd")
	let dataNa = JSON.parse($('#tembusanNa').val());
	let idNa = ''
	dataNa.forEach(element => {
		idNa += `${element.value},`
	});
	$("input[name='tembusan']").val(idNa)
	// alert($idNa);
})

function masukinTag(input, getNa) {
	(function () {
		var dataNa = [];
		var inputElm = document.querySelector(input);

		function tagTemplate(tagData) {
			return `
                <tag title="${tagData.email}"
                        contenteditable='false'
                        spellcheck='false'
                        tabIndex="-1"
                        class="tagify__tag ${tagData.class ? tagData.class : ""}"
                        ${this.getAttributes(tagData)}>
                    <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                    <div>
                        <div class='tagify__tag__avatar-wrap'>
                            <img src="${baseUrl}/assets/img/icon.png">
                        </div>
                        <span class='tagify__tag-text'>${tagData.name}</span>
                    </div>
                </tag>
            `
		}

		function suggestionItemTemplate(tagData) {
			return `
                <div ${this.getAttributes(tagData)}
                    class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
                    tabindex="0"
                    role="option">
                    ${ baseUrl + `/assets/img/icon.png` ? `
                    <div class='tagify__dropdown__item__avatar-wrap'>
                        <img src="${baseUrl}/assets/img/icon.png">
                    </div>` : ''
				}
                    <strong>${tagData.name}</strong>
                    
                </div>
            `
		}

		$.ajax({
			dataType: "json",
			url: baseUrl + `admin/surat/masuk/aksi/${getNa}`,
			type: 'GET',
			success: function (result) {
				result.forEach(element => {
					dataNa.push({
						'value': element.value,
						'name': element.name
					})
				});
			}
		})

		 // initialize Tagify on the above input node reference
        var tagify = new Tagify(inputElm, {
            enforceWhitelist: true,
            skipInvalid: true, // do not remporarily add invalid tags
            dropdown: {
                closeOnSelect: false,
                enabled: 0,
                classname: 'users-list',
                searchKeys: ['name'] // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate
            },
			whitelist: dataNa
        })



		tagify.on('dropdown:show dropdown:updated', onDropdownShow)
		tagify.on('dropdown:select', onSelectSuggestion)

		var addAllSuggestionsElm;

		function onDropdownShow(e) {
			var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

			if (tagify.suggestedListItems.length > 1) {
				addAllSuggestionsElm = getAddAllSuggestionsElm();

				// insert "addAllSuggestionsElm" as the first element in the suggestions list
				dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild)
			}
		}

		function onSelectSuggestion(e) {
			if (e.detail.elm == addAllSuggestionsElm)
				tagify.dropdown.selectAll.call(tagify);
		}

		// create a "add all" custom suggestion element every time the dropdown changes
		function getAddAllSuggestionsElm() {
			// suggestions items should be based on "dropdownItem" template
			return tagify.parseTemplate('dropdownItem', [{
				class: "addAll",
				name: "Add all",
				email: tagify.settings.whitelist.reduce(function (remainingSuggestions, item) {
					return tagify.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1
				}, 0) + " Members"
			}])
		}
	})()
}