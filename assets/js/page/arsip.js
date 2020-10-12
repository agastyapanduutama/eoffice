var nomorSurat;

var tipena = $("#tipena").val()

$(document).ready(function () {

	table = $('#list_arsipmasuk').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/arsip/masuk/aksi/data/' + tipena,
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

$('#list_arsipmasuk').on('click', '#lihat', function () {
	let id = $(this).data('id');
	// alert(id)
	$.ajax({
		url: baseUrl + 'admin/arsip/masuk/aksi/get/' + id,
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
						<embed id="nempoFile" src="${baseUrl}/uploads/arsip/${lampiran[0]}" width="100%" height="400" type="">
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


function ubahFile(file) {
	$("#nempoFile").attr('src', `${baseUrl}/uploads/surat/${file}`)
}