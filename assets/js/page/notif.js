var table;

$(document).ready(function () {
    viewData()
})

function getData() {

}

async function viewData() {
    // let filterNa = $("#filterNa").val();
    table = $('#list_notif').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": baseUrl + 'admin/notif/data',
            "type": "POST",
            "complete": function () {
                cekPilihanNa()
            },
            "error": function (error) {
                errorCode(error)
            },
        },

        "columnDefs": [{
                "sClass": "text-center",
                "targets": [0],
                "orderable": false,
            },
            {
                "sClass": "text-center",
                "targets": [1],
                "orderable": false,
            },
            {
                "targets": [2],
                "orderable": true
            },
            {
                "targets": [3],
                "orderable": true,
            },
        ],
    });
}

$('#filterNa').on('change', function () {
    viewData()
});

$('#list_notif').on('click', '#edit', function () {
    let id = $(this).data('id');
    $.ajax({
        url: baseUrl + 'admin/pegawai/get/' + id,
        type: "json",
        success: function (result) {
            response = JSON.parse(result)
            $("#idData").val(response.id)
            $("#gelar_depan1").val(response.gelar_depan)
            $("#nama_user1").val(response.nama_user)
            $("#email1").val(response.email)
            $("#gelar_belakang1").val(response.gelar_belakang)
            $("#niy1").val(response.niy)
            $('#id_jabatan1').val(response.id_jabatan).change();
            $('#id_upk1').val(response.id_upk).change();
            $("#modalEdit").modal('show')
        },
        error: function (error) {
            errorCode(error)
        }
    })
})

$('#list_notif').on('click', '#lihat', function () {

    let id = $(this).data('id');
    $.ajax({
        url: baseUrl + 'admin/notif/get/' + id,
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


$('#list_notif').on('click', '#on', function () {
    let id = $(this).data('id');
    confirmSweet("Akun akan dinon-aktifkan  !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/pegawai/set/' + id + "/off",
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



$("#filter_upk").on('change', function () {
    table.ajax.url(baseUrl + 'admin/pegawai/data/' + $(this).val()).load()
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
                    url: `${baseUrl}/admin/pegawai/allDelete`,
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

// setInterval(() => {
//     table.ajax.reload(null, false);
// }, 30000);