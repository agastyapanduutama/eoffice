<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'C_login/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



// notif
$route['admin/get/notif'] = 'C_notif/getNotif';
$route['admin/get/notif1'] = 'C_notif/getNotif1';
$route['admin/get/notif1/(:num)/(:num)'] = 'C_notif/getNotif1/$1/$2';



// Pengaturan
$route['admin/pengaturan/profil'] = 'admin/C_pengaturan/profile';
$route['admin/pengaturan/web'] = 'admin/C_pengaturan/web';
$route['admin/pengaturan/get/config'] = 'admin/C_pengaturan/getConfig';
$route["admin/pengaturan/update/data"] = 'admin/C_pengaturan/update';
$route["admin/pengaturan/format/surat"] = 'admin/C_pengaturan/format';
$route["admin/pengaturan/simpan/format"] = 'admin/C_pengaturan/simpanFormat';



// Track Surat
$route['admin/track'] = 'admin/C_track/index';
$route['admin/track/(:any)'] = 'admin/C_track/get/$1';



// Login
$route['admin/login'] = 'C_login/login';
$route['admin/login/masuk'] = 'C_login/aksi';
$route['admin/login/keluar/(:any)'] = 'C_login/logout';
$route['admin'] = 'admin/C_home/home';
$route['admin/dashboard'] = 'admin/C_home/home';






//config
$route['admin/yayasan'] = 'admin/C_yayasan/home';
$route["admin/yayasan/set/identitas"] = 'admin/C_yayasan/identitas';
$route["admin/yayasan/update/data"] = 'admin/C_yayasan/update';
$route["admin/yayasan/get/config"] = 'admin/C_yayasan/getConfig';
$route["admin/yayasan/getPegawai"] = 'admin/C_yayasan/getPegawai';




//aksi
$route['admin/aksi'] = 'admin/C_aksi/list';
$route['admin/aksi/data'] = 'admin/C_aksi/data';
$route['admin/aksi/get/(:any)'] = 'admin/C_aksi/get/$1';
$route['admin/aksi/set/(:any)/(:any)'] = 'admin/C_aksi/set/$1/$2';
$route['admin/aksi/insert'] = 'admin/C_aksi/insert';
$route['admin/aksi/update'] = 'admin/C_aksi/update';
$route['admin/aksi/delete/(:any)'] = 'admin/C_aksi/delete/$1';
//multipe select aksi
$route['admin/aksi/allOff'] = 'admin/C_aksi/allOff';
$route['admin/aksi/allOn'] = 'admin/C_aksi/allOn';
$route['admin/aksi/allDelete'] = 'admin/C_aksi/allDelete';




//akses
$route['admin/akses'] = 'admin/C_akses/list';
$route['admin/akses/data'] = 'admin/C_akses/data';
$route['admin/akses/get/(:any)'] = 'admin/C_akses/get/$1';
$route['admin/akses/set/(:any)/(:any)'] = 'admin/C_akses/set/$1/$2';
$route['admin/akses/insert'] = 'admin/C_akses/insert';
$route['admin/akses/update'] = 'admin/C_akses/update';
$route['admin/akses/delete/(:any)'] = 'admin/C_akses/delete/$1';
//multipe select akses
$route['admin/akses/allOff'] = 'admin/C_akses/allOff';
$route['admin/akses/allOn'] = 'admin/C_akses/allOn';
$route['admin/akses/allDelete'] = 'admin/C_akses/allDelete';




//tujuan
$route['admin/tujuan'] = 'admin/C_tujuan/list';
$route['admin/tujuan/data'] = 'admin/C_tujuan/data';
$route['admin/tujuan/get/(:any)'] = 'admin/C_tujuan/get/$1';
$route['admin/tujuan/set/(:any)/(:any)'] = 'admin/C_tujuan/set/$1/$2';
$route['admin/tujuan/insert'] = 'admin/C_tujuan/insert';
$route['admin/tujuan/update'] = 'admin/C_tujuan/update';
$route['admin/tujuan/delete/(:any)'] = 'admin/C_tujuan/delete/$1';
//multipe select tujuan
$route['admin/tujuan/allOff'] = 'admin/C_tujuan/allOff';
$route['admin/tujuan/allOn'] = 'admin/C_tujuan/allOn';
$route['admin/tujuan/allDelete'] = 'admin/C_tujuan/allDelete';




//status
$route['admin/status'] = 'admin/C_status/list';
$route['admin/status/data'] = 'admin/C_status/data';
$route['admin/status/get/(:any)'] = 'admin/C_status/get/$1';
$route['admin/status/set/(:any)/(:any)'] = 'admin/C_status/set/$1/$2';
$route['admin/status/insert'] = 'admin/C_status/insert';
$route['admin/status/update'] = 'admin/C_status/update';
$route['admin/status/delete/(:any)'] = 'admin/C_status/delete/$1';
//multipe select status
$route['admin/status/allOff'] = 'admin/C_status/allOff';
$route['admin/status/allOn'] = 'admin/C_status/allOn';
$route['admin/status/allDelete'] = 'admin/C_status/allDelete';




//jabatan
$route['admin/jabatan'] = 'admin/C_jabatan/list';
$route['admin/jabatan/data'] = 'admin/C_jabatan/data';
$route['admin/jabatan/get/(:any)'] = 'admin/C_jabatan/get/$1';
$route['admin/jabatan/getJabatan'] = 'admin/C_jabatan/getJabatan';
$route['admin/jabatan/set/(:any)/(:any)'] = 'admin/C_jabatan/set/$1/$2';
$route['admin/jabatan/getUpk'] = 'admin/C_jabatan/getUpk';
$route['admin/jabatan/insert'] = 'admin/C_jabatan/insert';
$route['admin/jabatan/update'] = 'admin/C_jabatan/update';
$route['admin/jabatan/delete/(:any)'] = 'admin/C_jabatan/delete/$1';
//multipe select jabatan
$route['admin/jabatan/allOff'] = 'admin/C_jabatan/allOff';
$route['admin/jabatan/allOn'] = 'admin/C_jabatan/allOn';
$route['admin/jabatan/allDelete'] = 'admin/C_jabatan/allDelete';





//Satuan
$route['admin/satuan'] = 'admin/C_satuan/list';
$route['admin/satuan/data'] = 'admin/C_satuan/data';
$route['admin/satuan/get/(:any)'] = 'admin/C_satuan/get/$1';
$route['admin/satuan/set/(:any)/(:any)'] = 'admin/C_satuan/set/$1/$2';
$route['admin/satuan/insert'] = 'admin/C_satuan/insert';
$route['admin/satuan/update'] = 'admin/C_satuan/update';
$route['admin/satuan/delete/(:any)'] = 'admin/C_satuan/delete/$1';
//multipe select satuan
$route['admin/satuan/allOff'] = 'admin/C_satuan/allOff';
$route['admin/satuan/allOn'] = 'admin/C_satuan/allOn';
$route['admin/satuan/allDelete'] = 'admin/C_satuan/allDelete';




//jenis
$route['admin/jenis'] = 'admin/C_jenis/list';
$route['admin/jenis/data'] = 'admin/C_jenis/data';
$route['admin/jenis/getJenis'] = 'admin/C_jenis/getJenis';
$route['admin/jenis/get/(:any)'] = 'admin/C_jenis/get/$1';
$route['admin/jenis/set/(:any)/(:any)'] = 'admin/C_jenis/set/$1/$2';
$route['admin/jenis/insert'] = 'admin/C_jenis/insert';
$route['admin/jenis/update'] = 'admin/C_jenis/update';
$route['admin/jenis/delete/(:any)'] = 'admin/C_jenis/delete/$1';
//multipe select jenis
$route['admin/jenis/allOff'] = 'admin/C_jenis/allOff';
$route['admin/jenis/allOn'] = 'admin/C_jenis/allOn';
$route['admin/jenis/allDelete'] = 'admin/C_jenis/allDelete';




//sifat
$route['admin/sifat'] = 'admin/C_sifat/list';
$route['admin/sifat/data'] = 'admin/C_sifat/data';
$route['admin/sifat/get/(:any)'] = 'admin/C_sifat/get/$1';
$route['admin/sifat/set/(:any)/(:any)'] = 'admin/C_sifat/set/$1/$2';
$route['admin/sifat/insert'] = 'admin/C_sifat/insert';
$route['admin/sifat/update'] = 'admin/C_sifat/update';
$route['admin/sifat/delete/(:any)'] = 'admin/C_sifat/delete/$1';
//multipe select sifat
$route['admin/sifat/allOff'] = 'admin/C_sifat/allOff';
$route['admin/sifat/allOn'] = 'admin/C_sifat/allOn';
$route['admin/sifat/allDelete'] = 'admin/C_sifat/allDelete';




//upk
$route['admin/upk'] = 'admin/C_upk/list';
$route['admin/upk/data'] = 'admin/C_upk/data';
$route['admin/upk/get/(:any)'] = 'admin/C_upk/get/$1';
$route['admin/upk/set/(:any)/(:any)'] = 'admin/C_upk/set/$1/$2';
$route['admin/upk/insert'] = 'admin/C_upk/insert';
$route['admin/upk/update'] = 'admin/C_upk/update';
$route['admin/upk/delete/(:any)'] = 'admin/C_upk/delete/$1';
$route['admin/upk/getPegawai'] = 'admin/C_upk/getPegawai';
//multipe select upk
$route['admin/upk/allOff'] = 'admin/C_upk/allOff';
$route['admin/upk/allOn'] = 'admin/C_upk/allOn';
$route['admin/upk/allDelete'] = 'admin/C_upk/allDelete';




//Admin UPK 
$route['admin/user/upk'] = 'admin/C_user/list';
$route['admin/user/upk/data'] = 'admin/C_user/data';
$route['admin/user/upk/get/(:any)'] = 'admin/C_user/get/$1';
$route['admin/user/upk/getUpk'] = 'admin/C_user/getUpk';
$route['admin/user/upk/getUser'] = 'admin/C_user/getUser';
$route['admin/user/upk/getUpkSelected'] = 'admin/C_user/getUpkSelected';
$route['admin/user/upk/insert'] = 'admin/C_user/insert';
$route['admin/user/upk/update'] = 'admin/C_user/update';
$route['admin/user/upk/delete/(:any)'] = 'admin/C_user/delete/$1';
$route['admin/user/upk/set/(:any)/(:any)'] = 'admin/C_user/set/$1/$2';
//multipe select status
$route['admin/user/upk/allOff'] = 'admin/C_user/allOff';
$route['admin/user/upk/allOn'] = 'admin/C_user/allOn';
$route['admin/user/upk/allDelete'] = 'admin/C_user/allDelete';




//Pegawai UPK 
$route['admin/pegawai'] = 'admin/C_pegawai/list';
$route['admin/pegawai/data'] = 'admin/C_pegawai/data';
$route['admin/pegawai/data/(:any)'] = 'admin/C_pegawai/data/$1';
$route['admin/pegawai/get/(:any)'] = 'admin/C_pegawai/get/$1';
$route['admin/pegawai/getJabatan'] = 'admin/C_pegawai/getJabatan';
$route['admin/pegawai/getUpk'] = 'admin/C_pegawai/getUpk';
$route['admin/pegawai/getUpkSelected'] = 'admin/C_pegawai/getUpkSelected';
$route['admin/pegawai/getPegawaiSelected'] = 'admin/C_pegawai/getPegawaiSelected';
$route['admin/pegawai/insert'] = 'admin/C_pegawai/insert';
$route['admin/pegawai/update'] = 'admin/C_pegawai/update';
$route['admin/pegawai/delete/(:any)'] = 'admin/C_pegawai/delete/$1';
$route['admin/pegawai/set/(:any)/(:any)'] = 'admin/C_pegawai/set/$1/$2';
//multipe select Pegawai
$route['admin/pegawai/allOff'] = 'admin/C_pegawai/allOff';
$route['admin/pegawai/allOn'] = 'admin/C_pegawai/allOn';
$route['admin/pegawai/allDelete'] = 'admin/C_pegawai/allDelete';




//Staf UPK 
$route['admin/staf'] = 'admin/C_staf/list';
$route['admin/staf/data'] = 'admin/C_staf/data';
$route['admin/staf/get/(:any)'] = 'admin/C_staf/get/$1';
$route['admin/staf/getJabatan'] = 'admin/C_staf/getJabatan';
$route['admin/staf/set/(:any)/(:any)'] = 'admin/C_staf/set/$1/$2';
$route['admin/staf/insert'] = 'admin/C_staf/insert';
$route['admin/staf/update'] = 'admin/C_staf/update';
$route['admin/staf/delete/(:any)'] = 'admin/C_staf/delete/$1';
$route['admin/staf/set/(:any)/(:any)'] = 'admin/C_staf/set/$1/$2';
//multipe select staf
$route['admin/staf/allOff'] = 'admin/C_staf/allOff';
$route['admin/staf/allOn'] = 'admin/C_staf/allOn';
$route['admin/staf/allDelete'] = 'admin/C_staf/allDelete';





//Admin Surat 
$route['admin/adminsurat'] = 'admin/C_adminsurat/list';
$route['admin/adminsurat/data'] = 'admin/C_adminsurat/data';
$route['admin/adminsurat/get/(:any)'] = 'admin/C_adminsurat/get/$1';
$route['admin/adminsurat/getJabatan'] = 'admin/C_adminsurat/getJabatan';
$route['admin/adminsurat/set/(:any)/(:any)'] = 'admin/C_adminsurat/set/$1/$2';
$route['admin/adminsurat/insert'] = 'admin/C_adminsurat/insert';
$route['admin/adminsurat/update'] = 'admin/C_adminsurat/update';
$route['admin/adminsurat/delete/(:any)'] = 'admin/C_adminsurat/delete/$1';
$route['admin/adminsurat/set/(:any)/(:any)'] = 'admin/C_adminsurat/set/$1/$2';
//multipe select adminsurat
$route['admin/adminsurat/allOff'] = 'admin/C_adminsurat/allOff';
$route['admin/adminsurat/allOn'] = 'admin/C_adminsurat/allOn';
$route['admin/adminsurat/allDelete'] = 'admin/C_adminsurat/allDelete';





// Login
$route["admin/login"] = "C_login/login";
$route["admin/login/aksi"] = "C_login/aksi";





// arsip masuk
$route["admin/arsip/masuk"] = "admin/C_arsip/masuk";
$route['admin/arsip/masuk/aksi/data'] = 'admin/C_arsip/data';
$route['admin/arsip/masuk/aksi/data/(:any)'] = 'admin/C_arsip/data/$1';
$route['admin/arsip/masuk/aksi/get/(:any)'] = 'admin/C_arsip/getMasuk/$1';





// Arsip Keluar
$route["admin/arsip/keluar"] = "admin/C_arsip/keluar";
$route['admin/arsip/keluar/aksi/data'] = 'admin/C_arsip/data';
$route['admin/arsip/keluar/aksi/data/(:any)'] = 'admin/C_arsip/data/$1';
$route['admin/arsip/keluar/aksi/get/(:any)'] = 'admin/C_arsip/getKeluar/$1';






// Aproval Surat
$route['admin/verifikasi'] = 'admin/C_verifikasi/list';
$route['admin/verifikasi/internal'] = 'admin/C_verifikasi/list';
$route['admin/verifikasi/add'] = 'admin/C_verifikasi/addVerif';
$route['admin/verifikasi/aksi/lihat/(:any)'] = 'C_pdf/surat_keluar/$1';
$route['admin/verifikasi/internal/aksi/lihat/(:any)'] = 'C_pdf/surat_keluarinternal/$1';
$route['admin/verifikasi/aksi/data/(:any)'] = 'admin/C_verifikasi/data/$1';
$route['admin/verifikasi/aksi/get/(:any)'] = 'admin/C_verifikasi/get/$1';
$route['admin/verifikasi/aksi/getJenis'] = 'admin/C_verifikasi/getJenis';
$route['admin/verifikasi/aksi/getAksi'] = 'admin/C_verifikasi/getAksi';
$route['admin/verifikasi/aksi/getUpk'] = 'admin/C_verifikasi/getUpk';
$route['admin/verifikasi/aksi/getJabatan'] = 'admin/C_verifikasi/getJabatan';
$route['admin/verifikasi/aksi/getUpkSelected'] = 'admin/C_verifikasi/getUpkSelected';
$route['admin/verifikasi/aksi/getUser'] = 'admin/C_verifikasi/getUser';
$route['admin/verifikasi/aksi/getSifat'] = 'admin/C_verifikasi/getSifat';
$route['admin/verifikasi/aksi/getNomorUrut'] = 'admin/C_verifikasi/getNomorUrut';
$route['admin/verifikasi/aksi/insert'] = 'admin/C_verifikasi/insert';
$route['admin/verifikasi/aksi/update'] = 'admin/C_verifikasi/update';
$route['admin/verifikasi/aksi/delete/(:any)'] = 'admin/C_verifikasi/delete/$1';





// surat masuk
$route['admin/surat/masuk'] = 'admin/C_surat/masuk';
$route['admin/surat/masuk/aksi/data'] = 'admin/C_surat/data';
$route['admin/surat/masuk/aksi/get/(:any)'] = 'admin/C_surat/get/$1';
$route['admin/surat/masuk/aksi/getJenis'] = 'admin/C_surat/getJenis';
$route['admin/surat/masuk/aksi/getAksi'] = 'admin/C_surat/getAksi';
$route['admin/surat/masuk/aksi/getUpk'] = 'admin/C_surat/getUpk';
$route['admin/surat/masuk/aksi/getJabatan'] = 'admin/C_surat/getJabatan';
$route['admin/surat/masuk/aksi/getUpkSelected'] = 'admin/C_surat/getUpkSelected';
$route['admin/surat/masuk/aksi/getUser'] = 'admin/C_surat/getUser';
$route['admin/surat/masuk/aksi/getSifat'] = 'admin/C_surat/getSifat';
$route['admin/surat/masuk/aksi/getNomorUrut'] = 'admin/C_surat/getNomorUrut';
$route['admin/surat/masuk/aksi/insert'] = 'admin/C_surat/insert';
$route['admin/surat/masuk/aksi/update'] = 'admin/C_surat/update';
$route['admin/surat/masuk/aksi/delete/(:any)'] = 'admin/C_surat/delete/$1';
// Khusus surat masuk ke user
$route['admin/surat/masuk/user'] = 'admin/C_surat/user';
$route['admin/surat/masuk/aksi/data/(:any)'] = 'admin/C_surat/data/$1';
$route['admin/surat/masuk/aksi/data/user'] = 'admin/C_surat/user';
// Khusus surat masuk ke adminpersuratan
$route['admin/surat/masuk/adminsurat'] = 'admin/C_surat/adminsurat';
$route['admin/surat/masuk/aksi/data/adminsurat'] = 'admin/C_surat/adminsurat';
$route['admin/surat/disposisi/kode/(:any)'] = 'C_pdf/disposisi/$1';
$route['admin/surat/disposisi/kode/internal/(:any)'] = 'C_pdf/disposisi_internal/$1';
$route['admin/surat/pesanbalik/kode/(:any)'] = 'C_pdf/pesan_balik/$1';
$route['admin/surat/masuk/aksi/disposisi/insert'] = 'admin/C_surat/insert_disposisi';
$route['admin/surat/masuk/aksi/getCurJabatan'] = 'admin/C_surat/getCurJabatan';
$route['admin/surat/masuk/aksi/getAdminPersuratan'] = 'admin/C_surat/getAdminPersuratan';
// Arsipkan surat
$route['admin/surat/masuk/aksi/(:any)/(:any)'] = 'admin/C_surat/arsip/$1/$2';





// Khusus Internal
$route['admin/surat/masuk/internal'] = 'admin/C_suratinternal/internal';
$route['admin/surat/masuk/internal/aksi/data/internal'] = 'admin/C_suratinternal/data';
$route['admin/surat/masuk/internal/aksi/get/(:any)'] = 'admin/C_suratinternal/get/$1';
$route['admin/surat/masuk/internal/aksi/insert'] = 'admin/C_suratinternal/insert';
$route['admin/surat/masuk/internal/aksi/getCurJabatan'] = 'admin/C_suratinternal/getCurJabatan';
$route['admin/surat/masuk/internal/aksi/getAdminPersuratan'] = 'admin/C_suratinternal/getAdminPersuratan';
$route['admin/surat/masuk/internal/aksi/delete/(:any)'] = 'admin/C_surat/delete/$1';
$route['admin/surat/masuk/internal/aksi/update'] = 'admin/C_suratinternal/update';
$route['admin/surat/masuk/internal/aksi/tindakan/insert'] = 'admin/C_suratinternal/kirim_ulang';
$route['admin/surat/masuk/internal/aksi/(:any)/(:any)'] = 'admin/C_surat/arsip/$1/$2';






// surat kelar
$route['admin/surat/keluar'] = 'admin/C_suratkeluar/keluar';
$route['admin/surat/keluar/aksi/data'] = 'admin/C_suratkeluar/data';
$route['admin/surat/keluar/aksi/get/(:any)'] = 'admin/C_suratkeluar/get/$1';
$route['admin/surat/keluar/aksi/getJenis'] = 'admin/C_suratkeluar/getJenis';
$route['admin/surat/keluar/aksi/insert/revisi'] = 'admin/C_suratkeluar/insert_revisi';
$route['admin/surat/keluar/aksi/getAksi'] = 'admin/C_suratkeluar/getAksi';
$route['admin/surat/keluar/aksi/getJabatan'] = 'admin/C_suratkeluar/getJabatan';
$route['admin/surat/keluar/aksi/getCurUpk'] = 'admin/C_suratkeluar/getCurUpk';
$route['admin/surat/keluar/aksi/getSifat'] = 'admin/C_suratkeluar/getSifat';
$route['admin/surat/keluar/aksi/getAsalNa'] = 'admin/C_suratkeluar/getAsalNa';
$route['admin/surat/keluar/aksi/getNomorUrut'] = 'admin/C_suratkeluar/getNomorUrut';
$route['admin/surat/keluar/aksi/insert'] = 'admin/C_suratkeluar/insert';
$route['admin/surat/keluar/aksi/update'] = 'admin/C_suratkeluar/update';
$route['admin/surat/keluar/aksi/delete/(:any)'] = 'admin/C_suratkeluar/delete/$1';
$route['admin/surat/keluar/aksi/getStaff/(:any)'] = 'admin/C_suratkeluar/getStaff/$1';
// Arsipkan surat
$route['admin/surat/keluar/aksi/(:any)/(:any)'] = 'admin/C_suratkeluar/arsip/$1/$2';







// surat kelar
$route['admin/surat/internal/keluar'] = 'admin/C_suratkeluarinternal/keluar';
$route['admin/surat/internal/keluar/aksi/data'] = 'admin/C_suratkeluarinternal/data';
$route['admin/surat/internal/keluar/aksi/get/(:any)'] = 'admin/C_suratkeluarinternal/get/$1';
$route['admin/surat/internal/keluar/aksi/getJenis'] = 'admin/C_suratkeluarinternal/getJenis';
$route['admin/surat/internal/keluar/aksi/insert/revisi'] = 'admin/C_suratkeluarinternal/insert_revisi';
$route['admin/surat/internal/keluar/aksi/getAksi'] = 'admin/C_suratkeluarinternal/getAksi';
$route['admin/surat/internal/keluar/aksi/getJabatan'] = 'admin/C_suratkeluarinternal/getJabatan';
$route['admin/surat/internal/keluar/aksi/getCurUpk'] = 'admin/C_suratkeluarinternal/getCurUpk';
$route['admin/surat/internal/keluar/aksi/getAsalNa'] = 'admin/C_suratkeluarinternal/getAsalNa';
$route['admin/surat/internal/keluar/aksi/getSifat'] = 'admin/C_suratkeluarinternal/getSifat';
$route['admin/surat/internal/keluar/aksi/getUpk'] = 'admin/C_suratkeluarinternal/getUpk';
$route['admin/surat/internal/keluar/aksi/getNomorUrut'] = 'admin/C_suratkeluarinternal/getNomorUrut';
$route['admin/surat/internal/keluar/aksi/insert'] = 'admin/C_suratkeluarinternal/insert';
$route['admin/surat/internal/keluar/aksi/update'] = 'admin/C_suratkeluarinternal/update';
$route['admin/surat/internal/keluar/aksi/delete/(:any)'] = 'admin/C_suratkeluarinternal/delete/$1';
$route['admin/surat/internal/keluar/aksi/getStaff/(:any)'] = 'admin/C_suratkeluarinternal/getStaff/$1';
// Arsipkan surat
$route['admin/surat/keluar/internal/aksi/(:any)/(:any)'] = 'admin/C_suratkeluarinternal/arsip/$1/$2';



// Surat Keluar Internal



$route['admin/surat/internal/keluar'] = 'admin/C_suratkeluarinternal/keluar';
$route['admin/profile'] = 'admin/C_profile';
$route['admin/get/profile'] = 'admin/C_profile/get';
$route['admin/profile/set'] = 'admin/C_profile/setProfile';
$route['admin/profile/set/password'] = 'admin/C_profile/setPassword';

$route['admin/notifikasi'] = 'C_notif/all';
$route['admin/notifikasi/(:any)'] = 'C_notif/all/$1';
$route['admin/notifikasi/get/(:any)'] = 'C_notif/get/$1';