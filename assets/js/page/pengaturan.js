$(document).ready(function () {
    // $.ajax({
    // 	dataType: "json",
    // 	url: baseUrl + "admin/pengaturan/get/config",
    // 	success: function (data) {
    //         $.each(data, function (index, conf) {
    //             // console.log(conf.value)
    // 			if (conf.config != 'logo') {
    //                 $('#' + conf.config).val(conf.value)
    //             } else {
    //                 $("#output").attr('src', baseUrl + 'uploads/config/' + conf.value)
    //             }
    // 		})
    // 	}
	// })
})

$("#formUpdateData").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/pengaturan/update/data",
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
                toastSuccess(response.msg)
            }
        },
        error: function (event) {
            errorCode(event)
        }
    });
})