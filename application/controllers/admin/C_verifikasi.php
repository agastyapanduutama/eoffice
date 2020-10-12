<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_verifikasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata($this->session->token) == true) {
            redirect(base_url());
        }
        if ($this->session->userdata('token') == NULL) {
            redirect(base_url());
        }
        $this->load->model('admin/M_verifikasi', 'verifikasi');
        $this->load->model('admin/M_histori', 'histori');
    }


    public function list()
    {
        // $this->req->print($this->session);
        $jabatan = $this->verifikasi->data_jabatan();
        $user = $this->verifikasi->data_user();
        $data = array(
            'title'   => 'Approval Surat Keluar',
            'jabatan' => $jabatan,
            'user'    => $user,
            'menu'    => 'verifikasi-masuk',
            'script'  => 'verifikasi',
            'konten'  => 'admin/surat/verifikasi',
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }


  function data($tipe = null)
    {
        error_reporting(0);
        $ketua = $this->verifikasi->getKetua();
        
        if ($tipe == 'user') { 
            $this->verifikasi->tipe = $this->session->userdata('id_user');
        }

        if ($_POST['tipeKirim'] != null) {
            $this->verifikasi->tipeKirim = $_POST['tipeKirim'];
        }

        if ($tipe == 'internal') {
            $this->verifikasi->tipe = 'internal';
        }

        $list = $this->verifikasi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $config_ = $this->db->get_where('t_config', ['config' => 'ketua_yayasan'])->row();
        $ketuaYayasan = $config_->value;
        $ketua = $this->verifikasi->getKetua();
        $ketuaUpk = $ketua['upk'];

        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);
            $accField = explode(',', $field->persetujuan);
            $confirm = $field->acc;

            // Jika tipe surat Internal
            if ($tipe == 'internal') {
                // JIka Belum di tanda tangani oleh Pejabat ke 2
                if ($field->acc_pejabat == NULL && $field->internal == 1 && $field->status_pengiriman == 1) {
                    $btnConfirm = "<button class='btn btn-success btn-sm' id='confirm' data-id='$idNa' title='Konfirmasi Surat'><i class='fas fa-check-circle'></i>Pejabat Ini </button>";

                // Jika Sudah di tanda tangani oleh Pejabat ke 2
                }elseif ($field->acc_pejabat != NULL && $field->internal == 1){  
                    // Konfirmasi Ketua Yayasan
                    if  ($this->session->id_user  == $ketuaYayasan && $field->status_pengiriman == 5){
                        $btnConfirm = "<button class='btn btn-success btn-sm' id='confirm' data-id='$idNa' title='Konfirmasi Surat'><i class='fas fa-check-circle'></i> Ketua Yayasan ini</button>";
                    // Konfirmasi Ketua UPK
                    }elseif($this->session->id_user == $ketuaUpk && $field->status_pengiriman == 7) {
                        $btnConfirm = "<button class='btn btn-success btn-sm' id='confirm' data-id='$idNa' title='Konfirmasi Surat'><i class='fas fa-check-circle'></i> Ketua UPK Ini</button>";
                    // Konfirmasi Pembina Yayasan
                    }elseif($field->status_pengiriman == 6){
                        $btnConfirm = "<button class='btn btn-success btn-sm' id='confirm' data-id='$idNa' title='Konfirmasi Surat'><i class='fas fa-check-circle'></i>Pembina Ini </button>";
                    }
                }
            // Jika Surat Eksternal
            }else{

                if (strpos($confirm, $this->session->id_user) > -1) {
                    $btnConfirm = "";
                } else {
                    if  ($this->session->id_user  == $ketuaYayasan){
                        $btnConfirm = "<button class='btn btn-success btn-sm' id='confirm' data-id='$idNa' title='Konfirmasi Surat'><i class='fas fa-check-circle'></i> Ketua Yayasan ini</button>";
                    }elseif($this->session->id_user == $ketuaUpk) {
                        
                        $btnConfirm = "<button class='btn btn-success btn-sm' id='confirm' data-id='$idNa' title='Konfirmasi Surat'><i class='fas fa-check-circle'></i> Ketua UPK Ini</button>";
                    }else{
                        $btnConfirm = "<button class='btn btn-success btn-sm' id='confirm' data-id='$idNa' title='Konfirmasi Surat'><i class='fas fa-check-circle'></i>Pembina Ini </button>";
                    }
                }
            }

            $button = $btnConfirm;

            if ($field->status_pengiriman == '1') {
                $statusNa= "<span style='color: blue'>Belum di verifikasi / Masih di Proses</span>";
            }
            if ($field->status_pengiriman == '2') {
                $statusNa= "<span style='color: black'>Dikembalikan / Revisi</span>";
            }
            if ($field->status_pengiriman == '0') {
                $statusNa= "<span style='color: green'>Selesai</span>";
                $button = "";
            }
            if ($field->status_pengiriman == '4') {
                $statusNa = "<span style='color: red'>Tidak Disetujui</span>";
            }
            if ($field->status_pengiriman == '6') {
                $statusNa = "<span style='color: green'>Disetujui Ketua Yayasan</span>";
            }
            if ($field->status_pengiriman == '5') {
                $statusNa = "<span style='color: green'>Disetujui Ketua UPK</span>";
            }
            if ($field->status_pengiriman == '7') {
                $statusNa = "<span style='color: green'>Disetujui Pejabat Terkait</span>";
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->no_surat;
            $row[] = $field->tanggal_dibuat;
            $row[] = $field->upk;
            $row[] = $field->jenis;
            $row[] = $field->sifat;
            $row[] = $field->perihal;
            $row[] = $statusNa;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->verifikasi->count_all(),
            "recordsFiltered" => $this->verifikasi->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get($id)
    {
        $data = $this->verifikasi->get($id);
        echo json_encode($data);
    }

    public function addVerif()
    {
        $id         = $this->req->input('id_surat');
        $emailUser  = $this->input->post('userNa');
        $surat      = $this->db->get_where('t_suratkeluar', ['id' => $id])->row();
        $accNa      = $surat->acc;
        $ketua      = $this->verifikasi->getKetua();
        $buatNotif  = $this->input->post('notifNa');
        $emailNa    = [];
        $jabatan    = [];
        $emailU     = $this->db->get_where('t_user', ['id' => $emailUser])->result();
        $uri        = $this->input->post('uri'); 
        foreach ($emailU as $uwu) {
            $emailNa[] = $uwu->email;
        }
      
        if ($accNa != '') {
            $accNa .= $this->session->id_user . ",";
        } else {
            $accNa = $this->session->id_user . ",";
        }

        // Deklarasi Status Pengiriman
        if ($uri == 'internal') {
            // Verifikasi Surat Keluar Internal
            // Jika Belum ACC pejaban Terkait
            if ($surat->acc_pejabat == NULL) {
                $statusPengiriman = '7';
                $data = array(
                    'acc_pejabat' => $this->session->userdata('id_user')
                );
                $accNa = '';
                $this->verifikasi->update($data, ['id' => $id,]);                
            // Acc Ketua UPK
            }elseif ($accNa == $ketua['upk'].',' && $surat->acc_pejabat != NULL) {
                $statusPengiriman = '5';
            // Acc ketua Yayasan
            }elseif ($accNa == $ketua['upk'] . ',' . $ketua['yayasan'] . ',' && $surat->acc_pejabat != NULL) {
                $statusPengiriman = '6';
            // Acc Pembina Yayasan
            }else{
                $statusPengiriman = '0';
            }

        }else{

            // Verifikasi Surat Keluar Eksternal
            // Acc ketua UPK
            if ($accNa == $ketua['upk'].',') {
                $statusPengiriman = '5';
            // Acc Ketua Yayasan
            }elseif ($accNa == $ketua['upk'] . ',' . $ketua['yayasan'] . ',') {
                $statusPengiriman = '6';
            // Acc Pembina Yayasan
            }else{
                $statusPengiriman = '0';
            }
        }

        // var_dump($accNa);
        // var_dump($statusPengiriman);
        // Jika Status Tidak Di ACC
        // Jika status di tolak tapi ada revisi
        if ($this->input->post('statusrevisi') == '2') {
            $data = [
                'acc' => $accNa,
                'status_pengiriman' => $this->input->post('statusrevisi'),
            ];
            $this->verifikasi->update($data, ['id' => $id]);

            $dataRevisi =[
                'id_suratkeluar' => $id,
                'catatan_revisi' => $this->input->post('catatanrevisi'),
                'status' => '1',
                'id_user_revisi' => $this->session->id_user, 
                'notif' => $buatNotif,
            ];
            if($this->verifikasi->insert_revisi($dataRevisi)){

                $this->req->insertNotif([
                    'table' => 't_revisi',
                    'tujuan' => $this->req->input('userNa'),
                    'notif' => $buatNotif,
                    'tipe' => '3'
                ]);
                
                $revisiNa = $this->input->post('catatanrevisi');

                $historiSurat = array(
                    'no_surat'          => $this->input->post('no_surat') ,
                    'aksi'              => 'Mengembalikan Surat Keluar',
                    'nama_user'         => $this->session->userdata('nama_user'),
                    // 'perihal'           => $this->input->post('perihal') ,
                    'status_pengiriman' => "Surat Dikembalikan / Revisi" ,
                    'keterangan' => $this->session->userdata('nama_user') . " Mengembalikan Surat Keluar" ,
                    'catatan_revisi'    => $this->input->post('catatanrevisi') ,
                    'tipe'  => '4',
                );

                $this->histori->insert($historiSurat);

                $mail = array(
                    'subjek'            => 'Anda Mendapatkan Notif baru - Surat Keluar',
                    'keterangan_surat'  => 'Revisi Surat Keluar',
                    'perihal'           => "Maaf, Surat Anda Mendapatkan Revisi : $revisiNa",
                    'isi_surat'         => $this->input->post('isi_surat'),
                    'email'             => $emailNa,
                    'jabatanemail'      => $jabatan,
                    // 'nama' => $userName,
                );
                $email = $this->req->sendMail($mail);

                if (!$email->send()) {
                    $msg = array(
                        'surat' => 'warning',
                    'msg' => 'Surat Berhasil Dikirim tapi Email Tidak Terdaftar  !'
                    );
                } else {
                    $msg = array(
                        'surat' => 'ok',
                        'msg' => 'Berhasil Mengirim Data !'
                    );
                }

                echo json_encode($msg);
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Mengembalikan Surat Keluar!'
                );
        }

        // Jika status surat di tolak dan tidak ada revisi
        }elseif ($this->input->post('statusrevisi') == '4') {
            
            $data = [
                'acc' => $accNa,
                'status_pengiriman' => '4',
            ];
            if ($this->verifikasi->update($data, ['id' => $id])) {

                $historiSurat = array(
                    'no_surat'          => $this->input->post('no_surat') ,
                    'aksi'              => 'Surat Keluar Di Tolak',
                    'nama_user'         => $this->session->userdata('nama_user'),
                    // 'perihal'           => $this->input->post('perihal') ,
                    'status_pengiriman' => "Surat Di tolak" ,
                    'keterangan' => $this->session->userdata('nama_user') . " Menolak Surat Keluar" ,
                    'tipe' => '3',
                    );

                $this->req->insertNotif([
                    'table' => 't_suratkeluar',
                    'tujuan' => $this->req->input('userNa'),
                    'notif' => $buatNotif,
                    'tipe' => '4'
                ]);

                $this->histori->insert($historiSurat);

                $mail = array(
                    'subjek'            => 'Anda Mendapatkan Notif baru - Surat Keluar',
                    'keterangan_surat'  => 'Surat Keluar Tidak Disetujui',
                    'perihal'           => "Mohon Maaf, Surat Anda Tidak Disetujui",
                    'isi_surat'         => $this->input->post('isi_surat'),
                    'email'             => $emailNa,
                    'jabatanemail'      => $jabatan,
                );
                $email = $this->req->sendMail($mail);

                if (!$email->send()) {
                    $msg = array(
                        'surat' => 'warning',
                        'msg' => 'Surat Berhasil Dikirim tapi Email Tidak Terdaftar  !'
                    );
                } else {
                    $msg = array(
                        'surat' => 'ok',
                        'msg' => 'Berhasil Mengirim Data !'
                    );
                }

                echo json_encode($msg);


            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Terjadi Kesalahan pada Server/Aplikasi :( !'
                );
                echo json_encode($msg);
            }
        
        // Jika Status ACC
        }else{
            $data = [
                'acc' => $accNa,
                'status_pengiriman' => $statusPengiriman,
                'tanggal_konfirmasi' => date('Y/m/d')
            ];
            if ($this->verifikasi->update($data, ['id' => $id])) {
                $historiSurat = array(
                    'no_surat'          => $this->input->post('no_surat') ,
                    'aksi'              => 'Approval Surat Keluar',
                    'nama_user'         => $this->session->userdata('nama_user'),
                    'status_pengiriman' => "Surat Di konfirmasi" ,
                    'keterangan' => $this->session->userdata('nama_user') . " Mengkonfirmasi Surat Keluar" ,
                    'tipe' => '0'
                    );

                $this->histori->insert($historiSurat);

                $mail = array(
                    'subjek'            => 'Anda Mendapatkan Notif baru - Surat Keluar',
                    'keterangan_surat'  => 'Surat Keluar',
                    'perihal'           => "Surat Anda sudah Di Konfirmasi",
                    'isi_surat'         => $this->input->post('isi_surat'),
                    'email'             => $emailNa,
                    'jabatanemail'      => $jabatan,
                );
                $email = $this->req->sendMail($mail);

                if (!$email->send()) {
                    $msg = array(
                        'surat' => 'warning',
                        'msg' => 'Surat Berhasil Dikirim tapi Email Tidak Terdaftar  !'
                    );
                } else {
                    $msg = array(
                        'surat' => 'ok',
                        'msg' => 'Berhasil Mengirim Data !'
                    );
                }
                echo json_encode($msg);

            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Terjadi Kesalahan pada Server/Aplikasi :( !'
                );
                echo json_encode($msg);
            }
        }
    }
    


    public function insert_revisi()
    {
        $id = $this->input->post('id_verifikasi');

         if ($this->verifikasi->update([
            'status_verifikasimasuk' => '0',
            'disposisi' => '2'
        ], $this->req->id($id)) == true) {
                // echo "verifikasi masuk asup";
            }

        $data = $this->req->all();
        if ($this->verifikasi->insert_disposisi($data) == true) {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil Disposisi !'
            );
        } else {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal Disposisi !'
            );
        }            
        // echo $this->db->last_query();
        echo json_encode($msg);
    }
}