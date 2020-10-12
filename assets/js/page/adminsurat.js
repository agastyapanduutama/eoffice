$(document).ready(function () {
	table = $('#list_adminsurat').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/adminsurat/data',
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
	getJabatan()
})

$('#list_adminsurat').on('click', '#edit', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/adminsurat/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result)
			$("#idData").val(response.id)
			$("#gelar_depan1").val(response.gelar_depan)
			$("#nama_user1").val(response.nama_user)
			$("#gelar_belakang1").val(response.gelar_belakang)
			$("#email1").val(response.email)
			$('#id_jabatan1').val(response.id_jabatan).change();
			$("#modalEdit").modal('show')
		},
		error: function (error) {
			errorCode(error)
		}
	})
})

$('#list_adminsurat').on('click', '#delete', function () {
	let id = $(this).data('id');
	confirmSweet("Data akan terhapus secara permanen !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/adminsurat/delete/' + id,
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

$('#list_adminsurat').on('click', '#on', function () {
	let id = $(this).data('id');
	confirmSweet("Akun akan dinon-aktifkan  !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/adminsurat/set/' + id + "/off",
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

$('#list_adminsurat').on('click', '#off', function () {
	let id = $(this).data('id');
	confirmSweet("Akun akan diaktifkan  !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/adminsurat/set/' + id + "/on",
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

$('#list_adminsurat').on('click', '#reset', function () {
	let id = $(this).data('id');
	confirmSweet("Kata Sandi Akun akan direset !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/adminsurat/set/' + id + "/reset",
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

$("#formAddAdminSurat").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/adminsurat/insert",
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

$("#formEditAdminSurat").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/adminsurat/update",
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
	$('#id_jabatan').find('option').remove().end()
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/adminsurat/getJabatan",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_jabatan').append("<option value=" + item.id + ">" + item.jabatan + "</option>");
			})
		}
	})

	$('#id_jabatan1').find('option').remove().end()
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/adminsurat/getJabatan",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_jabatan1').append("<option value=" + item.id + ">" + item.jabatan + "</option>");
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
					url: `${baseUrl}/admin/adminsurat/allOff`,
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
					url: `${baseUrl}/admin/adminsurat/allOn`,
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
					url: `${baseUrl}/admin/adminsurat/allDelete`,
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