var table
var baseUrl = $('meta[name="baseUrl"]').attr('content')
var menu = $('meta[name="menu"]').attr('content')
var token = $('meta[name="token"]').attr('content')
var upk = $('meta[name="upk"]').attr('content')

getNotif()
if (menu == "notif") {
  getNotif1()
}

autosize($('textarea'));

$('body').delegate('#logout', 'click', function (event) {
  var id = $(this).data('id');  
  window.location = baseUrl + 'logout/' + id
});

var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    }
  }
};

function disableButton(){
  $(':submit').append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
  $(':submit').attr('disabled', true)
}

function enableButton(){
  $(':submit').find('span').remove()
  $(':submit').removeAttr("disabled")
}

function isInvalid(idNa){
  $(idNa).removeClass("is-valid")
  $(idNa).addClass("is-invalid")
}

function isValid(idNa) {
  $(idNa).removeClass("is-invalid")
  $(idNa).addClass("is-valid")
}

function noValid(idNa) {
  $(idNa).removeClass("is-invalid is-valid")
}

function errorCode(event){
  iziToast.error({
    title: "Error",
    message: event.status + " " + event.statusText,
    position: 'topRight'
  });
}

function toastInfo(msg, title = 'Info') {
    iziToast.info({
      title: title,
      message: msg,
      position: 'topRight'
    });
}

function toastSuccess(msg, title = 'Success') {
  iziToast.success({
    title: title,
    message: msg,
    position: 'topRight'
  });
}

function toastWarning(msg, title = 'Warning') {
  iziToast.warning({
    title: title,
    message: msg,
    position: 'topRight'
  });
}

function toastError(msg, title = 'Error') {
  iziToast.error({
    title: title,
    message: msg,
    position: 'topRight'
  });
}

function msgSweetError(pesan, title = 'Error', timer = 1500) {
  return swal({
    icon: 'error',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetSuccess(pesan, title = 'Sukses', timer = 1500) {
  return swal({
    icon: 'success',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetWarning(pesan, title = 'Peringatan', timer = 1500) {
  return swal({
    icon: 'warning',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetInfo(pesan, title = 'Info', timer = 1500) {
  return swal({
    icon: 'info',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function confirmSweet(pesan, title = 'Anda Yakin ?') {
  return swal({
    icon: 'warning',
    title: title,
    text: pesan,
    buttons: true,
    dangerMode: true,
  })
}

function post_data(url, data_, table = null) {
  $.ajax({
    url: baseUrl + url,
    type: "post",
    data: data_,
    processData: false,
    contentType: false,
    cache: false,
    beforeSend: function () {
      $(':submit').append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
      $(':submit').attr('disabled', true)
    },
    complete: function () {
      $(':submit').find('span').remove()
      $(':submit').removeAttr("disabled")
    },
    success: function (result) {
      
      console.log(result)
      
    },
    error: function () {
      toastr.error('Error')
    }
  });
}

function input_validate(inp) {
  var u = "",
    b = "";
    // console.log(inp);
  for (let index = inp.length; index > 0; index--) {
    if (inp[index - 1].required == true && inp[index - 1].value.trim() == "") {
      b += "b";
      inp[index - 1].select();
    } else {
      b += "u";
    }
    u += "u";
  }
  if (u == b) {
    return true;
  } else {
    toastr.error("Isi semua field !");
    return false;
  }
}

function clearInput(inp) {
  for (let index = 0; index < inp.length; index++) {
    inp[index].value = "";
  }
}

function getSelect() {
  $('#id_upk').find('option').remove().end()
  $.ajax({
    dataType: "json",
    url: baseUrl + "admin/user/upk/getUpk",
    success: function (result) {
      console.log(result);
      let response = jQuery.parseJSON(JSON.stringify(result));
      response.forEach(item => {
        $('#id_upk').append("<option value=" + item.id + ">" + item.upk + "</option>");
      })
    }
  })
}

$(document).ready(function(){
  $("#menu-" + menu).addClass('active')
})

$("#btnKeluar").on('click', function(){
  confirmSweet("", 'Yakin ingin Keluar ?').then((result) => {
    // alert(result)
    if (result) {
      $(location).attr('href', baseUrl + 'admin/login/keluar/' + token)
    }
  })
})

function getNotif() {
  moment.locale('id');
  // moment().format('LLL');
  let dataNotif = $("#dataNotif")
  let notif = '', notif1 = ''
  $.ajax({
    url: `${baseUrl}admin/get/notif`,
    dataType: "JSON",
    success: function(result) {
      console.log(result);
      if (result.data.length > 0) {
        let tipeNa = {
          "1": {
            'tipe': "Surat Masuk",
            'icon': "sign-in-alt"
          },
          "2": {
            'tipe': "Surat Keluar",
            'icon': "sign-out-alt"
          },
          "3": {
            'tipe': "Revisi Surat",
            'icon': "edit"
          },
          "4": {
            'tipe': "Surat Tidak di Setujui",
            'icon': "times"
          }
        }
        result.data.forEach(surat => {
          let tipe = tipeNa[surat.type]['tipe'];
          let icon = tipeNa[surat.type]['icon'];
          let kabuka = (surat.opened == "0") ? '' : "opened"
          notif1 += `
            <a href="#" data-id="${surat.idNotif}" id="notifItem" class="dropdown-item ${kabuka}">
                <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-${icon}"></i>
                </div>
                <div class="dropdown-item-desc">
                    ${tipe} - ${surat.sifat}
                    <div>${surat.jenis}</div>
                    <div class="w-100 text-right time">${moment(surat.tanggal, "YYYY-MM-DD HH:mm:ss").fromNow()}</div>
                </div>
            </a>
          `
          if (surat.opened == '0') {
            notif += `
              <a href="#" data-id="${surat.idNotif}" id="notifItemBell" class="dropdown-item ${kabuka}">
                  <div class="dropdown-item-icon bg-info text-white">
                      <i class="fas fa-${icon}"></i>
                  </div>
                  <div class="dropdown-item-desc w-100">
                      ${tipe} - ${surat.sifat}
                      <div>${surat.jenis}</div>
                      <div class="text-right time">${moment(surat.tanggal, "YYYY-MM-DD HH:mm:ss").fromNow()}</div>
                  </div>
              </a>
            `
          }
        })
        if (result.count == 0) {
          $("#bell").removeClass("beep")
          notif += `
            <a href="#" class="dropdown-item">
                <div class="text-center w-100">
                    -- Tidak ada notifikasi --
                </div>
            </a>
          `
        } else {
          $("#bell").addClass("beep")
        }
      } else {
        notif += `
          <a href="#" class="dropdown-item">
              <div class="text-center w-100">
                  -- Tidak ada notifikasi --
              </div>
          </a>
        `
      }
      let ko = dataNotif.val()
      if (ko.replace(/[\n]/g, '').trim() != notif.replace(/[\n]/g, '').trim()) {
        // let audio = new Audio(`${baseUrl}/assets/admin/sounds/notif.mp3`)
        dataNotif.val(notif)
        $("#notifNa").html(notif)
        // audio.play()
      }
      (result.count < 5) ? $("#notifNa").addClass("h-auto") : $("#notifNa").removeClass("h-auto")
    }
  })
}

function getNotif1() {
  moment.locale('id');
  moment().format('LLL');
  let dataNotif = $("#dataNotif1")
  let notif = ''
  let fromNa = $("#fromGet").val()
  let limit = parseInt(fromNa) + parseInt(10)
  $.ajax({
    url: `${baseUrl}admin/get/notif1/${limit}/0`,
    dataType: "JSON",
    success: function (result) {
      console.log(result);
      if (result.data.length > 0) {
        let tipeNa = {
          "1": {
            'tipe': "Surat Masuk",
            'icon': "sign-in-alt"
          },
          "2": {
            'tipe': "Surat Keluar",
            'icon': "sign-out-alt"
          },
          "3": {
            'tipe': "Revisi Surat",
            'icon': "edit"
          },
          "4": {
            'tipe': "Surat Tidak di Setujui",
            'icon': "times"
          }
        }
        result.data.forEach(surat => {
          let tipe = tipeNa[surat.type]['tipe'];
          let icon = tipeNa[surat.type]['icon'];
          let kabuka = (surat.opened == "0") ? '' : "opened"
          notif += `
            <a href="#" data-id="${surat.idNotif}" data-tipe="${surat.type}" id="notifItem" class="dropdown-item ${kabuka}">
                <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-${icon}"></i>
                </div>
                <div class="dropdown-item-desc">
                    ${tipe} - ${surat.sifat}
                    <div>${surat.jenis}</div>
                    <div class="w-100 text-right time">${moment(surat.tanggal, "YYYY-MM-DD HH:mm:ss").fromNow()}</div>
                </div>
            </a>
          `
        })
      } else {
        notif += `
          <a href="#" class="dropdown-item">
              <div class="text-center w-100">
                  -- Tidak ada notifikasi --
              </div>
          </a>
        `
      }
      let ko = dataNotif.val()
      if (ko.replace(/[\n]/g, '').trim() != notif.replace(/[\n]/g, '').trim()) {
        // let audio = new Audio(`${baseUrl}/assets/admin/sounds/notif.mp3`)
        dataNotif.val(notif)
        $("#notifNa1").html(notif)
        // audio.play()
      }
    }
  })
}

$(".notifna").on('scroll', function (event) {
  let from = $("#fromGet")
  // console.log($(this).scrollTop() + $(this).innerHeight() + " / " + $(this)[0].scrollHeight);
  if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
    let next = parseInt(from.val()) + parseInt(10)
    let notif = ''
    console.log(`Sampe Bawah`)
    $.ajax({
      url: `${baseUrl}/admin/get/notif1/${next}/${from.val()}`,
      dataType: "json",
      beforeSend: function() {
        $(".loadingNa").addClass("showLoading")
      },
      complete: function() {
        $(".loadingNa").removeClass("showLoading")
      },
      success: function(result) {
        let tipeNa_ = {
          "1": {
            'tipe': "Surat Masuk",
            'icon': "sign-in-alt"
          },
          "2": {
            'tipe': "Surat Keluar",
            'icon': "sign-out-alt"
          },
          "3": {
            'tipe': "Revisi Surat",
            'icon': "edit"
          },
          "4": {
            'tipe': "Surat Tidak di Setujui",
            'icon': "times"
          }
        }
        let data = result.data
        // console.log(surat);
        if (data.length > 0) {
          from.val(next)
          data.forEach(surat => {
            let tipe = tipeNa_[surat.type]['tipe'];
            let icon = tipeNa_[surat.type]['icon'];
            let kabuka = (surat.opened == "0") ? '' : "opened"
            notif += `
            <a href="#" data-id="${surat.idNotif}" id="notifItem" class="dropdown-item ${kabuka}">
                <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-${icon}"></i>
                </div>
                <div class="dropdown-item-desc">
                    ${tipe} - ${surat.sifat}
                    <div>${surat.jenis}</div>
                    <div class="w-100 text-right time">${moment(surat.tanggal, "YYYY-MM-DD HH:mm:ss").fromNow()}</div>
                </div>
            </a>
          `
          })
          // console.log(notif);
          $("#dataNotif1").append(notif)
          $("#notifNa1").append(notif)
        }
      }
    })
  }
});

$(document).delegate("#notifItem", 'click', function (e) {
  let id = $(this).data('id')
  let tipe = $(this).data('tipe')
  let itemNa = $(this)
  e.preventDefault()
  getNotifDetail(id, tipe)
})

$(document).delegate("#notifItemBell", 'click', function (e) {
  let id = $(this).data('id')
  $(location).attr("href", `${baseUrl}admin/notifikasi/${id}`);
})

if ($("#idItemNotif").val() != '') {
  let id = $("#idItemNotif").val()
  getNotifDetail($("#idItemNotif").val())
}

function getNotifDetail(id, tipe = '') {
  $.ajax({
    url: `${baseUrl}admin/notifikasi/get/${id}`,
    dataType: "JSON",
    beforeSend: function () {
      $("#notifDetail").html(`
        <div class="ph-item p-0 m-0" style="border: 0px ;">
            <div class="ph-col-12 p-0 m-0">
                <div class="ph-row">
                    <div class="ph-col-6 big"></div>
                    <div class="ph-col-4 empty big"></div>
                    <div class="ph-col-2 big"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-8 empty"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-8 empty"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-8 empty"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-8 empty"></div>
                    <div class="ph-col-10 empty"></div>
                    <div class="ph-col-2 big"></div>
                </div>
            </div>
        </div>
      `)
    },
    complete: function () {
      getNotif()
      getNotif1()
    },
    success: function (result) {
      var linkNa
      console.log(`tipena : ${result.status}`);
      switch (result.status) {
        case 1:
          linkNa = `${baseUrl}admin/surat/masuk/user?kode=${result.noSurat}`
          break;
        case 2:
          linkNa = `${baseUrl}admin/verifikasi?kode=${result.noSurat}`
          break;
        default:
          linkNa = ``
          break;
      }
      let html = `
        <div class="w-100">
            <table class="w-100">
                <tr>
                    <td>No Surat</td>
                    <td>:</td>
                    <td colspan="3"> <b>${result.noSurat}</b> - <b>${result.sifat.toUpperCase()}</b></td>
                    <td colspan="2" class="text-right">${moment(result.tanggal).format("D-MMMM-YYYY")}</td>
                </tr>
                <tr>
                    <td style="width: 70px;">Asal</td>
                    <td>:</td>
                    <td>${result.asal}</td>
                </tr>
                <tr>
                    <td>Pengirim</td>
                    <td>:</td>
                    <td>${result.pengirim}</td>
                </tr>
                <tr>
                    <td>Jenis</td>
                    <td>:</td>
                    <td>${result.jenis}</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td>${result.perihal}</td>
                    <!-- <td colspan="3" class="text-right"></td> -->
                </tr>
                <tr>
                    <td colspan="6" class="text-right"> <a href="${linkNa}"> <button class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> Lihat Surat</button> </a> </td>
                </tr>
            </table>
        </div>
      `
      window.history.pushState("data", "Title", `${baseUrl}admin/notifikasi/${id}`);
      console.log(`path ${window.location.pathname}`);
      // item.addClass("active")
      // console.log(result)
      // console.log(item);
      setTimeout(() => {
        $("#notifDetail").html(html)
      }, 700);
    },
    error: function (error) {
      errorCode(error)
    }
  })
}

setInterval(() => {
  getNotif()
  if (menu == "notif") {
    getNotif1()
  }
}, 100000);

function cekPilihanNa() {
  let dipilih = $("#dipilih").val()
  let pilihanNa = dipilih.split(",")
  let dipilihNa = $("input[id^='pilihGan-']");
  let jumlahInput = dipilihNa.length
  pilihanNa.forEach(id => {
    if (id != '') {
      if (!$(`#pilihGan-${id}`).is(":checked")) {
        $(`#pilihGan-${id}`).prop('checked', true);
      }
    }
  });
  let jmlCek = 0;
  Object.values(dipilihNa).forEach(cekNa => {
    if ($(cekNa).is(":checked")) {
      jmlCek++
    }
  })
  if (jmlCek == jumlahInput) {
    $("#checkAll").prop('checked', true)
  } else {
    $("#checkAll").prop('checked', false)
  }
  if (dipilih != '') {
    $("#denganData").html(`Dengan ${pilihanNa.length - 1} data terpilih`)
  } else {
    $("#denganData").html(`Dengan data terpilih`)
  }
}

$(document).delegate("#checkAll", 'click', function () {
  if ($(this).is(":checked")) {
    let pilihan = $("input[id^='pilihGan-']"),
      dipilih = $("#dipilih"),
      pilih = ''
    if (dipilih.val() != '') {
      pilih = dipilih.val()
    } else {
      pilih = ''
    }
    Object.values(pilihan).forEach(input => {
      if (!pilih.includes($(input).val())) {
        pilih += `${$(input).val()},`
        dipilih.val(pilih);
        cekPilihanNa()
      }
    })
  } else {
    let dipilihna = $("#dipilih").val()
    let dipilihNa = $("input[id^='pilihGan-']");
    Object.values(dipilihNa).forEach(cekNa => {
      $(cekNa).prop('checked', false)
      dipilihna = dipilihna.replace(new RegExp(`${$(cekNa).val()},`, "g"), "")
      $("#dipilih").val(dipilihna)
      cekPilihanNa()
    })
  }
})

$(document).delegate("input[id^='pilihGan-']", 'click', function() {
  let id = `${$(this).val()},`
  let dipilihna = $("#dipilih").val()
  if ($(this).is(":checked")) {
    $("#dipilih").val(dipilihna + id)
  } else {
    $("#dipilih").val(dipilihna.replace(new RegExp(id, "g"), ""))
  }
  cekPilihanNa()
})

function getBulanRomawi(bul = '') {
  let bulan
  if (bul != '') {
    bulan = bul
  } else {
    bulan = new Date().getMonth()
  }

  bulan = parseInt(bulan) + parseInt(1)

  switch (bulan) {
    case 1:
      bulan = "I";
      break;
    case 2:
      bulan = "II";
      break;
    case 3:
      bulan = "III";
      break;
    case 4:
      bulan = "IV";
      break;
    case 5:
      bulan = "V";
      break;
    case 6:
      bulan = "VI";
      break;
    case 7:
      bulan = "VII";
      break;
    case 8:
      bulan = "VIII";
      break;
    case 9:
      bulan = "IX";
      break;
    case 10:
      bulan = "X";
      break;
    case 11:
      bulan = "XI";
      break;
    case 12:
      bulan = "XII";
      break;
  }
  return bulan
}