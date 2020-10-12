$('#formLogin').submit(function (e) {
	e.preventDefault();
	$.ajax({
		url: baseUrl + "admin/login/aksi",
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
				$("#username").focus()
				clearInput($("input"))
			} else {
                msgSweetSuccess(response.msg)
                .then(() => {
					$(location).attr('href', baseUrl + "admin");
				})
			}
		},
		error: function (event) {
			errorCode(event)
		}
	});
})