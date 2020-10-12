$(document).ready(function () {
	table = $('#list_user').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/user/upk/data',
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
			},
			{
				"sClass": "text-center",
				"targets": [5],
				"orderable": false
			}
		],
	});
	getUpk()
	// getUser()
})

$('#list_user').on('click', '#edit', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/user/upk/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result)
			$("#idData").val(response.id)
			$("#nama_user1").val(response.nama_user)
			// $("#email1").val(response.email)
			$('#id_upk1').val(response.id_upk).change();
			$("#modalEdit").modal('show')
		},
		error: function (error) {
			errorCode(error)
		}
	})
})

$('#list_user').on('click', '#delete', function () {
	let id = $(this).data('id');
	confirmSweet("Data akan terhapus secara permanen !")
	.then(result => {
		if (result) {
			$.ajax({
				url: baseUrl + 'admin/user/upk/delete/' + id,
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

$('#list_user').on('click', '#on', function () {
	let id = $(this).data('id');
	confirmSweet("Akun akan dinon-aktifkan  !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/user/upk/set/' + id + "/off",
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

$('#list_user').on('click', '#off', function () {
	let id = $(this).data('id');
	confirmSweet("Akun akan diaktifkan  !")
	.then(result => {
		if (result) {
			$.ajax({
				url: baseUrl + 'admin/user/upk/set/' + id + "/on",
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

$('#list_user').on('click', '#reset', function () {
	let id = $(this).data('id');
	confirmSweet("Kata Sandi Akun akan direset !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/user/upk/set/' + id + "/reset",
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

$("#formAddUser").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/user/upk/insert",
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
				msgSweetError(response.msg, "Nama Pengguna sudah ada !")
			} else {
				table.ajax.reload(null, false)
				toastSuccess(response.msg)
				clearInput($("input"))
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

$("#formEditUser").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/user/upk/update",
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

function getUpk() {
	$('#id_upk').find('option').remove().end()
	$('#id_upk').append("<option value=''> -- Pilih UPK -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/user/upk/getUpk",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_upk').append("<option value=" + item.id + ">" + item.upk + "</option>");
			})
		}
	})

	$('#id_upk').change(function (evt) {
		let id_upk = $(this).val();
		$.ajax({
			dataType: "json",
			url: baseUrl + "admin/user/upk/getUpkSelected",
			data: {
				'id_upks': id_upk
			},
			type: 'GET',
			success: function (result) {
				let response = jQuery.parseJSON(JSON.stringify(result));
				$('#adminupk').html('')
				response.forEach(item => {
					$('#adminupk').append('<option value="' + item.nama_user +'">' + item.nama_user + '</option>');
				})
			}
		})

	})

	$('#id_upk1').find('option').remove().end()
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/user/upk/getUpk",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_upk1').append("<option value=" + item.id + ">" + item.upk + "</option>");
			})
		}
	})
}

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
					url: `${baseUrl}/admin/user/allOff`,
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
					url: `${baseUrl}/admin/user/allOn`,
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
					url: `${baseUrl}/admin/user/allDelete`,
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


setInterval(() => {
	table.ajax.reload(null, false);
}, 30000);