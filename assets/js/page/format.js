$(document).ready(function() {
    console.log(`Bulan ${getBulanRomawi()}`);
    parseFormat()
})

function parseFormat() {
    let format = {
        "NO_URUT": "0012",
        "JENIS_SURAT": "UND",
        "UPK": "SY",
        "BULAN": getBulanRomawi(),
        "TAHUN": new Date().getFullYear()
    }

    let formatSuratMasuk = $("#formatSuratMasuk").val()
    let formatSuratKeluar = $("#formatSuratKeluar").val()

    Object.keys(format).forEach(key => {
        formatSuratMasuk = formatSuratMasuk.replace(new RegExp(`{{${key}}}`, "g"), format[key])
        formatSuratKeluar = formatSuratKeluar.replace(new RegExp(`{{${key}}}`, "g"), format[key])
    })

    $("#noSuratMasuk").html(formatSuratMasuk)
    $("#noSuratKeluar").html(formatSuratKeluar)
}

setInterval(() => {
    parseFormat()
}, 500);

$("#formPenomoran").submit(function(e) {
    e.preventDefault()
    $.ajax({
        url: `${baseUrl}/admin/pengaturan/simpan/format`,
        type: "post",
        data: new FormData(this),
		processData: false,
		contentType: false,
		cache: false,
        beforeSend: function() {
            disableButton()
        },
        complete: function() {
            enableButton()
        },
        success: function(result) {
            let response = JSON.parse(result)
            if (response.status == "ok") {
                msgSweetSuccess(response.msg)
            } else {
                msgSweetError(response.msg)
            }
        },
        error: function(error) {
            errorCode(error)
        }
    })
})