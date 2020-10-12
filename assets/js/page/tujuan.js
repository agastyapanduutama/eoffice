$(document).ready(function () {
	table = $('#list_tujuan').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/tujuan/data',
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
})

$('#list_tujuan').on('click', '#edit', function () {
	let id = $(this).data('id');
	$.ajax({
		url: baseUrl + 'admin/tujuan/get/' + id,
		type: "GET",
		success: function (result) {
			response = JSON.parse(result)
			$("#idData").val(response.id)
			$("#kode_tujuan1").val(response.kode_tujuan)
			$("#tujuan1").val(response.tujuan)
			$("#keterangan1").val(response.keterangan)
			$("#modalEdit").modal('show')
		},
		error: function (error) {
			errorCode(error)
		}
	})
})

$('#list_tujuan').on('click', '#delete', function () {
	let id = $(this).data('id');
	confirmSweet("Data akan terhapus secara permanen !")
		.then(result => {
			if (result) {
				$.ajax({
					url: baseUrl + 'admin/tujuan/delete/' + id,
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

$("#formAddTujuan").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/tujuan/insert",
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
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})

$("#formEditTujuan").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/tujuan/update",
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
					url: `${baseUrl}/admin/tujuan/allOff`,
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
					url: `${baseUrl}/admin/tujuan/allOn`,
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
					url: `${baseUrl}/admin/tujuan/allDelete`,
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
