var nomorSurat;

var tipena = $("#tipena").val()

$(document).ready(function () {

	table = $('#list_arsipkeluar').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax": {
			"url": baseUrl + 'admin/arsip/keluar/aksi/data/' + tipena,
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

	// $("#asalnasurat").hide();
})

$('#list_arsipkeluar').on('click', '#track', function () {
	let id = $(this).data('surat');
		window.open(`${baseUrl}admin/track/${id}`, '_blank');
})


$('#list_arsipkeluar').on('click', '#lihat', function () {

	let id = $(this).data('id');
	
	$.ajax({
		url: baseUrl + 'admin/arsip/keluar/aksi/get/' + id,
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

function ubahFile(file) {
	$("#nempoFile").attr('src', `${baseUrl}/uploads/surat/${file}`)
}	