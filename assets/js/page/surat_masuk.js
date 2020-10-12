var nomorSurat;
var tipena = $("#tipena").val()

$(document).ready(function () {

	table = $('#list_surat').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/surat/masuk/aksi/data/' + tipena,
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
	// $("#asalnasurat").hide();
})

$('#list_surat').on('click', '#edit', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/surat/masuk/aksi/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result)
			$("#idData").val(response.id_suratna)
			$("#kode_surat1").val(response.kode_surat)
			$("#surat1").val(response.surat)
			$("#keterangan1").val(response.keterangan)
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
					url: baseUrl + 'admin/surat/masuk/aksi/delete/' + id,
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

$('#list_surat').on('click', '#lihat', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/surat/masuk/aksi/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result)
			let lampiran_ = response.lampiran
			let lampiran = lampiran_.split(",")
			let listNa = ""
			let html = ""
			if (lampiran.length > 1) {
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
			} else {
				html = `
					<div class="col-md-12">
						<embed id="nempoFile" src="${baseUrl}/uploads/surat/${lampiran[0]}" width="100%" height="400" type="">
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
		url: baseUrl + "admin/surat/masuk/aksi/insert",
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
				clearInput($("textarea"))
				nomorSurat()
				getJenis()
				getAksi()
				getSifat()
				$("#modalTambah").modal('hide')
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

$('#list_surat').on('click', '#delete', function () {
	let id = $(this).data('id');
	confirmSweet("Data akan terhapus secara permanen !")
	.then(result => {
		if (result) {
			$.ajax({
					url: baseUrl + 'admin/surat/masuk/aksi/delete/' + id,
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


$("#formEditSurat").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/surat/masuk/aksi/update",
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
	$('#id_jenis').append("<option value='' selected disabled> -- Pilih Jenis -- </option>");
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
	$('#id_aksi').append("<option value='' selected disabled> -- Pilih Aksi -- </option>");
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
	$('#id_sifat').append("<option value='' selected disabled> -- Pilih Sifat -- </option>");
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
	$('#asal_surat').append("<option value='' selected disabled> -- Silakan Pilih Upk -- </option>");
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
			$("#no_surat").val(`${nomorSurat}/E`)
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

$("#disposisi").on('change', function(){
	// alert("hai")
	let input_ = '';
	if ($("#disposisi").val() == 0) {
		$("#alamat-aksi").html('');
		let html = `
		<label>Alamat Tujuan</label>
		<input type="text" name="" id="tujuanNa" required>
		`
		$("#alamat-tujuan").html(html);
		masukinTag('#tujuanNa', 'getUser')
	}
	else {
		$("#alamat-tujuan").html('');
		let html = `
		<label>Alamat Aksi</label>
		<input type='text' name='' id='aksiNa' required>
		`;
		$("#alamat-aksi").html(html);
		masukinTag('#aksiNa', 'getJabatan')
	}
	$("#valAksi").val(', ')
	$("#valTujuan").val(', ')
})

// function getDataTag(get) {
// 	// alert("Asdasd")
// 	// var result = [];
// 	// $.ajax({
// 	// 	dataType: "json",
// 	// 	url: baseUrl + `admin/surat/masuk/aksi/${get}`,
// 	// 	type: 'GET',
// 	// 	success: function (result) {
// 	// 		// result[] = {
// 	// 		// 	'value': result
// 	// 		// }
// 	// 		result.forEach(element => {
// 	// 			// console.log(element);
// 	// 			result.push({
// 	// 				'value': element.value,
// 	// 				'name': element.name
// 	// 			})
// 	// 		});
// 	// 		return result
// 	// 	}
// 	// })
// }

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

$(document).delegate('#tujuanNa', 'change', function(){
	// alert("Asdasdasd")
	let dataNa = JSON.parse($('#tujuanNa').val());
	let idNa = ''
	dataNa.forEach(element => {
		idNa += `${element.value},`
	});
	$("#valTujuan").val(idNa)
	// alert($idNa);
})

$(document).delegate('#aksiNa', 'change', function () {
	// alert("Asdasdasd")
	let dataNa = JSON.parse($("#aksiNa").val());
	let idNa = ''
	dataNa.forEach(element => {
		idNa += `${element.value},`
	});
	$("#valAksi").val(idNa)
})

// Arsipkan surat
$('#list_surat').on('click', '#arsip', function () {
	let id = $(this).data('id');
	confirmSweet("Surat Akan diArsipkan  !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/surat/masuk/aksi/' + id + "/arsip",
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



// $("#tujuanNa").on('change', function () {
// 	alert("ASdasd")
	
// })

// $("#aksiNa").on('change', function () {
// 	alert("ASdasd")
	
// })

// setInterval(() => {
	
// }, 100);
