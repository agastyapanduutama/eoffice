$(document).ready(function () {
    $.ajax({
    	dataType: "json",
    	url: baseUrl + "admin/yayasan/get/config",
    	success: function (data) {
            $.each(data, function (index, conf) {
                // console.log(conf.value)
    			if (conf.config != 'logo') {
                    $('#' + conf.config).val(conf.value)
                } else {
                    $("#output").attr('src', baseUrl + 'uploads/config/' + conf.value)
                }
    		})
    	}
	})
	getPegawai();
})

$("#formUpdateData").submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/yayasan/update/data",
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

function getPegawai() {
	$('#id_pegawai').find('option').remove().end()
	$('#id_pegawai').append("<option value=''> -- Pilih Ketua -- </option>");
	$.ajax({
		dataType: "json",
		url: baseUrl + "admin/yayasan/getPegawai",
		success: function (result) {
			console.log(result);
			let response = jQuery.parseJSON(JSON.stringify(result));
			response.forEach(item => {
				$('#id_pegawai').append("<option value=" + item.id + ">" + item.nama_user + "</option>");
			})
		}
	})
}