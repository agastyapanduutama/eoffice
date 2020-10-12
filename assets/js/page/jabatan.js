$(document).ready(function () {
	table = $('#list_jabatan').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/jabatan/data',
			"type": "POST",
			"complete": function () {
				cekPilihanNa()
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
	getUpk()
	getJabatan()
	$("#id_upk").val(upk)
})

$('#list_jabatan').on('click', '#edit', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/jabatan/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result)
			$("#idData").val(response.id)
			// $("#kode_jabatan1").val(response.kode_jabatan)
			$("#kode_jabatan1").val(response.kode_jabatan)
			$("#jabatan1").val(response.jabatan)
			$("#parent1").val(response.parent).change()
			$("#level1").val(response.level).change()
			$("#keterangan1").val(response.keterangan)
			$("#modalEdit").modal('show')
			
		},
		error: function (error) {
			errorCode(error)
		}
	})
})

$('#list_jabatan').on('click', '#delete', function () {
	let id = $(this).data('id');
	confirmSweet("Data akan terhapus secara permanen !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/jabatan/delete/' + id,
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

$("#formAddJabatan").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/jabatan/insert",
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
				getJabatan()
				getUpk()
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

$("#formEditJabatan").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/jabatan/update",
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


function getJabatan() {
	$('#parent').find('option').remove().end()
	$('#parent').append("<option value='0'> Paling Atas </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/jabatan/getJabatan",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#parent').append("<option value=" + item.id + ">" + item.jabatan + "</option>");
			})
		}
	})

	$('#parent1').find('option').remove().end()
	$('#parent1').append("<option value='0'> Paling Atas </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/jabatan/getJabatan",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#parent1').append("<option value=" + item.id + ">" + item.jabatan + "</option>");
			})
		}
	})
}


function getUpk() {
	$('#upkna').find('option').remove().end()
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/jabatan/getUpk",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#upkna').append("<option value=" + item.id + ">" + item.upk + "</option>");
			})
		}
	})

	$('#upkna1').find('option').remove().end()
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/jabatan/getUpk",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#upkna1').append("<option value=" + item.id + ">" + item.upk + "</option>");
			})
		}
	})
}


$('#list_jabatan').on('click', '#on', function () {
    let id = $(this).data('id');
    confirmSweet("Data akan dinon-aktifkan  !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/jabatan/set/' + id + "/off",
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

$('#list_jabatan').on('click', '#off', function () {
    let id = $(this).data('id');
    confirmSweet("Data akan diaktifkan  !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/jabatan/set/' + id + "/on",
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

//js - btn event
//  multiple select off
$("#btnAllOff").on("click", function () {
	let dipilih = $("#dipilih").val()
	if (dipilih == '') {
		toastInfo("Tidak ada data terpilih", "Pilih Data")
	} else {
		let jml = dipilih.split(",")
		confirmSweet(`${jml.length - 1} Akun akan dinon-aktifkan  !`).then(respon => {
			if (respon) {
				$.ajax({
					url: `${baseUrl}/admin/jabatan/allOff`,
					data: {
						id: dipilih
					},
					type: "post",
					beforeSend: function () {
						disableButton()
					},
					complete: function () {
						enableButton()
					},
					success: function (result) {
						console.log(result);
						let response = JSON.parse(result)
						if (response.status == "ok") {
							msgSweetSuccess(response.msg, "Berhasil Merubah Data", 5000)
							table.ajax.reload(null, false)
						} else {
							msgSweetError(response.msg, "Gagal Merubah Data")
						}
					},
					error: function (error) {
						errorCode(error)
					}
				})
			}
		})
	}
})

//  multiple select on
$("#btnAllOn").on("click", function () {
	let dipilih = $("#dipilih").val()
	if (dipilih == '') {
		toastInfo("Tidak ada data terpilih", "Pilih Data")
	} else {
		let jml = dipilih.split(",")
		confirmSweet(`${jml.length - 1} Akun akan diaktifkan  !`).then(respon => {
			if (respon) {
				$.ajax({
					url: `${baseUrl}/admin/jabatan/allOn`,
					data: {
						id: dipilih
					},
					type: "post",
					beforeSend: function () {
						disableButton()
					},
					complete: function () {
						enableButton()
					},
					success: function (result) {
						console.log(result);
						let response = JSON.parse(result)
						if (response.status == "ok") {
							msgSweetSuccess(response.msg, "Berhasil Merubah Data", 5000)
							table.ajax.reload(null, false)
						} else {
							msgSweetError(response.msg, "Gagal Merubah Data")
						}
					},
					error: function (error) {
						errorCode(error)
					}
				})
			}
		})
	}
})

//  multiple select delete
$("#btnAllHapus").on("click", function () {
	let dipilih = $("#dipilih").val()
	if (dipilih == '') {
		toastInfo("Tidak ada data terpilih", "Pilih Data")
	} else {
		let jml = dipilih.split(",")
		confirmSweet(`${jml.length - 1} Akun akan dihapus  !`).then(respon => {
			if (respon) {
				$.ajax({
					url: `${baseUrl}/admin/jabatan/allDelete`,
					data: {
						id: dipilih
					},
					type: "post",
					beforeSend: function () {
						disableButton()
					},
					complete: function () {
						enableButton()
					},
					success: function (result) {
						console.log(result);
						let response = JSON.parse(result)
						if (response.status == "ok") {
							msgSweetSuccess(response.msg, "Berhasil Menghapus Data", 5000)
							$("#dipilih").val('') //clear pilihan
							cekPilihanNa() //cek pilihanna
							table.ajax.reload(null, false)
						} else {
							msgSweetError(response.msg, "Gagal Menghapus Data")
						}
					},
					error: function (error) {
						errorCode(error)
					}
				})
			}
		})
	}
})
