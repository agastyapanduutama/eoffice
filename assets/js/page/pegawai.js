var table;

$(document).ready(function () {
    viewData()
    getJabatan()
    getUpk()
})

function getData() {
    
}

async function viewData() {
    // let filterNa = $("#filterNa").val();
    table = $('#list_pegawai').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": baseUrl + 'admin/pegawai/data',
            "type": "POST",
            "complete": function() {
                cekPilihanNa()
            },
            "error": function (error) {
                errorCode(error)
            },
        },

        "columnDefs": [
        {
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
        {
            "sClass": "text-center",
            "targets": [5],
        },
        {
            // "sClass": "text-center",
            "targets": [6],
            "orderable": false
        },
        {
            "sClass": "text-center",
            "targets": [7],
            "orderable": false
        },
        {
            "sClass": "text-center",
            "targets": [8],
            "orderable": false
        }
        ],
    });
}

$('#filterNa').on('change', function () {
    viewData()
});

$('#list_pegawai').on('click', '#edit', function () {
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

$('#list_pegawai').on('click', '#delete', function () {
    let id = $(this).data('id');
    confirmSweet("Data akan terhapus secara permanen !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/pegawai/delete/' + id,
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

$('#list_pegawai').on('click', '#on', function () {
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

$('#list_pegawai').on('click', '#off', function () {
    let id = $(this).data('id');
    confirmSweet("Akun akan diaktifkan  !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/pegawai/set/' + id + "/on",
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

$('#list_pegawai').on('click', '#reset', function () {
    let id = $(this).data('id');
    confirmSweet("Kata Sandi Akun akan direset !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/pegawai/set/' + id + "/reset",
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

$("#formAddPegawai").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/pegawai/insert",
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

$("#formEditPegawai").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/pegawai/update",
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

// Ambil Data Jabatan
function getJabatan() {
    $('#id_jabatan1').find('option').remove().end()
    $.ajax({
        dataType: "json",
        url: baseUrl + "admin/pegawai/getJabatan",
        success: function (result) {
            console.log(result);
            let response = jQuery.parseJSON(JSON.stringify(result));
            response.forEach(item => {
                $('#id_jabatan1').append("<option value=" + item.id + ">" + item.jabatan + "</option>");
            })
        }
    })
}

// Ambil Data UPK
function getUpk() {

    $('#id_upk').find('option').remove().end()
    $('#id_upk').append("<option value=''> -- Pilih UPK -- </option>");
    $.ajax({
        dataType: "json",
        url: baseUrl + "admin/pegawai/getUpk",
        success: function (result) {
            console.log(result);
            let response = jQuery.parseJSON(JSON.stringify(result));
            response.forEach(item => {
                $('#id_upk').append("<option value=" + item.id + ">" + item.upk + "</option>");
            })
        }
    })

    
    $('#id_upk1').find('option').remove().end()
    $.ajax({
        dataType: "json",
        url: baseUrl + "admin/pegawai/getUpk",
        success: function (result) {
            console.log(result);
            let response = jQuery.parseJSON(JSON.stringify(result));
            response.forEach(item => {
                $('#id_upk1').append("<option value=" + item.id + ">" + item.upk + "</option>");
            })
        }
    })

    $('#filter_upk').find('option').remove().end()
    $('#filter_upk').append("<option value=''> Semua UPK </option>");
    $.ajax({
        dataType: "json",
        url: baseUrl + "admin/pegawai/getUpk",
        
        success: function (result) {
            console.log(result);
            let response = jQuery.parseJSON(JSON.stringify(result));
            response.forEach(item => {
                $('#filter_upk').append("<option value=" + item.id + ">" + item.upk + "</option>");
            })
        }
    })

}

$("#filter_upk").on('change', function(){
    table.ajax.url(baseUrl + 'admin/pegawai/data/' + $(this).val()).load()
})

$('#id_upk').change(function(evt){
    let id_upk = $(this).val();
    $.ajax({
        dataType: "json",
        url: baseUrl + "admin/pegawai/getUpkSelected",
        data: {'id_upks': id_upk},
        type : 'GET',
        success: function (result) {
            // alert("hello")
            let response = jQuery.parseJSON(JSON.stringify(result));
            $('#id_jabatan').html('')
            response.forEach(item => {
                $('#id_jabatan').append("<option value=" + item.id + ">" + item.jabatan + "</option>");
            })
        }
    })

})

$('#id_upk1').change(function (evt) {
    let id_upk = $(this).val();
    $.ajax({
        dataType: "json",
        url: baseUrl + "admin/pegawai/getUpkSelected",
        data: {
            'id_upks': id_upk
        },
        type: 'GET',
        success: function (result) {
            let response = jQuery.parseJSON(JSON.stringify(result));
            $('#id_jabatan1').html('')
            response.forEach(item => {
                $('#id_jabatan1').append("<option value=" + item.id + ">" + item.jabatan + "</option>");
            })
        }
    })
})

//  multiple select off
$("#btnAllOff").on("click", function(){
    let dipilih = $("#dipilih").val()
    if (dipilih == '') {
        toastInfo("Tidak ada data terpilih", "Pilih Data")
    } else {
        let jml = dipilih.split(",")
        confirmSweet(`${jml.length - 1} Akun akan dinon-aktifkan  !`).then(respon => {
            if (respon) {
                $.ajax({
                    url: `${baseUrl}/admin/pegawai/allOff`,
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
                    url: `${baseUrl}/admin/pegawai/allOn`,
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

setInterval(() => {
    table.ajax.reload(null, false);
}, 30000); 