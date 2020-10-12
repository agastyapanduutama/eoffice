$(document).ready(function(){
    getProfile()
})

$("#reset").on('click', function() {
    getProfile()
})

function getProfile() {
    $.ajax({
        dataType: "json",
        url: baseUrl + 'admin/get/profile',
        beforeSend: function(){
            disableButton()
        },
        complete: function(){
            enableButton()
        },
        success: function (result) {
            let response = jQuery.parseJSON(JSON.stringify(result))
            $("#username").val(response.email)
            $("#gelar_depan").val(response.gelar_depan)
            $("#gelar_belakang").val(response.gelar_belakang)
            $("#nama_user").val(response.nama_user)
            $("#niy").val(response.niy)
        }
    })
}

$("#formProfile").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: `${baseUrl}admin/profile/set`,
        type: "post",
		data: new FormData(this),
		processData: false,
		contentType: false,
		cache: false,
        beforeSend: function(){
            disableButton()
        },
        complete: function(){
            enableButton()
        },
        success: function(result){
            let response = JSON.parse(result)
            if (response.status == "salah") {
                isInvalid("#passwordUbahProfile")
            } 
            if (response.status == "ok") {
                noValid("#passwordUbahProfile")
                msgSweetSuccess(response.msg)
                getProfile()
                $("#passwordUbahProfile").val("")
            } 
            if (response.status == "fail") {
                noValid("#passwordUbahProfile")
                msgSweetWarning(response.msg)
                $("#passwordUbahProfile").val("")
            }
        },
        error: function(error){
            errorCode(error)
        }
    })
})

$("#formPassword").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: `${baseUrl}/admin/profile/set/password`,
		type: "post",
		data: new FormData(this),
		processData: false,
		contentType: false,
		cache: false,
        beforeSend: function(){
            disableButton()
        },
        complete: function(){
            enableButton()
        },
        success: function(result){
            let response = JSON.parse(result)
            if (response.status == "benar") {
                msgSweetSuccess("Berhasil Mengganti Password !")
                $("#passBaru").val('')
                $("#passLama").val('')
                $("#confirmPass").val('')
            }
            if (response.status == "fail") {
                msgSweetError("Password tidak boleh sama dengan sebelumnya")
            }
            if (response.status == "salah") {
                isInvalid("#passLama")
            } else {
                noValid("#passLama")
            }
        },
        error: function(error){
            errorCode(error)
        }
    })
})

function passCheck(pass) {
    var strength = 1;
    var arr = [/.{5,}/, /[a-z]+/, /[0-9]+/, /[A-Z]+/];
    jQuery.map(arr, function (regexp) {
        if (pass.match(regexp))
            strength++;
    });
    console.log(strength);
}

$("#passBaru").on('change', function(){
    let pass = $(this).val()
    passCheck(pass)
})

setInterval(() => {
    let passBaru = $("#passBaru").val()
    if (passBaru != '' && passBaru.length >= 6) {
        isValid("#passBaru")
        cekPassBaru()
    } else {
        isInvalid("#passBaru")
        isInvalid("#confirmPass")
        cekPassBaru()
    }
}, 300);

function cekPassBaru() {
    $("#btnUbahPass").attr('disabled', true)
    if ($("#confirmPass").val() != "") {
        let passBaru = $("#passBaru").val()
        let passConf = $("#confirmPass").val()
        if (passBaru == passConf) {
            isValid("#confirmPass")
            $("#btnUbahPass").removeAttr("disabled")
        } else {
            isInvalid("#confirmPass")
            $("#btnUbahPass").attr('disabled', true)
        }
    } else {
        noValid("#confirmPass")
        $("#btnUbahPass").attr('disabled', true)
    }
}