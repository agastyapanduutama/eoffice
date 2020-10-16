<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_suratkeluarinternal extends CI_Controller
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
        $this->load->model('admin/M_jenis', 'jenis');
        $this->load->model('admin/M_suratkeluarinternal', 'surat');
        $this->load->model('admin/M_histori', 'histori');
    }

    public function keluar()
    {
        $user = $this->surat->data_user();
        $jabatan = $this->surat->data_pembina();
        $data = array(
            'title'  => 'Surat keluar Internal',
            'menu'   => 'surat-keluar',
            'user'   =>  $user,
            'jabatan' => $jabatan,
            'script' => 'surat_keluarinternal',
            'konten' => 'admin/surat/keluarinternal',
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }

    function data($tipe = null)
    {
        error_reporting(0);
        if ($tipe == 'user') {
            $this->surat->tipe = $this->session->userdata('id_user');
        }
        if ($_POST['statusPengiriman'] != null) {
            $this->surat->tatusPengiriman = $_POST['statusPengiriman'];
        }
        $list = $this->surat->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);
            // $idNa = $field->id;
           
            // JIka Surat belum di verifikasi
            if ($field->status_pengiriman == '1') {
                $statusNa= "<span style='color: blue'>Belum di verifikasi / Masih di Proses</span>";
                $button = "
                <button class='btn btn-danger btn-sm' id='delete' data-id='$idNa' title='Hapus Surat'><i class='fas fa-trash-alt'></i></button>";
            }

            // Jika SUrat Keluar Dikembalikan
            if ($field->status_pengiriman == '2') {
                $statusNa= "<span style='color: black'>Dikembalikan / Revisi</span>";

                $button = "
                <button class='btn btn-warning btn-sm' id='edit' data-id='$idNa' title='Revisi Surat'><i class='fas fa-pencil-alt'></i></button>
                ";
            }

            // Disetujui Ketua Yayasan
            if ($field->status_pengiriman == '6') {
                $statusNa = "<span style='color: green'>Disetujui Ketua Yayasan</span>";

                $button = "<button class='btn btn-primary btn-sm' id='lihat' data-id='$idNa' title='Lihat Berkas' ><i class='fas fa-eye'></i></button>";
            }

            // Jika Surat Keluar Selesai
            if ($field->status_pengiriman == '0') {
                $statusNa= "<span style='color: green'>Selesai</span>";
                
                $button = "<button class='btn btn-primary btn-sm' id='lihat' data-id='$idNa' title='Lihat Berkas' ><i class='fas fa-eye'></i></button>
                <button class='btn btn-info btn-sm' id='arsip' data-id='$idNa' title='Lihat Berkas'><i class='fas fa-file-archive' title='Lihat Berkas' ></i></button>";
            }

            // Jika Surat Keluar Tidak DIsetujui
            if ($field->status_pengiriman == '4') {
                $statusNa = "<span style='color: red'>Tidak Disetujui</span>";

                $button = "
                <button class='btn btn-info btn-sm' id='arsip' data-id='$idNa' title='Lihat Berkas'><i class='fas fa-file-archive' title='Lihat Berkas' ></i></button>";
            }

            // Jika Surat Keluar di ACC Ketua UPK
            if ($field->status_pengiriman == '5') {
                $statusNa = "<span style='color: green'>Disetujui Ketua UPK</span>";    
                
                $button = "<button class='btn btn-primary btn-sm' id='lihat' data-id='$idNa' title='Lihat Berkas' ><i class='fas fa-eye'></i></button>";          
            }
            // Jika Surat Keluar di ACC Jabatan Terkait
            if ($field->status_pengiriman == '7') {
                $statusNa = "<span style='color: green'>Disetujui Pejabat Terkait</span>";
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->no_surat;
            $row[] = $field->tanggal_dibuat;
            // $row[] = $field->upk;
            $row[] = $field->asal_surat;
            $row[] = $field->jenis;
            $row[] = $field->sifat;
            $row[] = $field->perihal;
            $row[] = $statusNa;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->surat->count_all(),
            "recordsFiltered" => $this->surat->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    function getJabatan()
    {
        echo json_encode($this->surat->data_user());
    }

    function getUser()
    {
        echo json_encode($this->surat->data_user());
    }

  
    function getCurUpk()
    {
        $upk = $this->db->get_where('t_upk', ['id' => $this->session->upk])->row();
        echo json_encode($upk);
    }

    function getAsalNa()
    {
        $userData = $this->db->get_where('t_user', ['id' => $this->session->id_user])->row();
        $jabatan = [
            'id' => $userData->id_jabatan,
            'upk' => $this->db->get_where('t_upk', ['id' => $userData->id_upk])->row()->upk,
            'name' => $this->db->get_where('t_jabatan', ['id' => $userData->id_jabatan])->row()->jabatan,
            'user' => $this->session->nama_user
        ];
        echo json_encode($jabatan);
        // var_dump($jabatan);
    }

    function getUpk()
    {
        echo json_encode($this->surat->data_upk());
    }

    function getSifat()
    {
        echo json_encode($this->surat->data_sifat());
    }

    function getJenis()
    {
        echo json_encode($this->surat->data_jenis());
    }

    function getNomorUrut()
    {
        echo json_encode($this->surat->getNomorUrut());
    }   

    function getStaff($jabatan)
    {
        echo json_encode($this->surat->data_staff($jabatan));
    }

    function getUpkSelected()
    {
        $id_upk = $_GET['id_upks'];
        echo json_encode($this->surat->data_jabatan($id_upk));
    }

    function get($id)
    {
        $data = $this->surat->get($id);

        // echo $this->db->last_query();
        // foreach ($data as $key => $value) {
        //     if (strtolower($key) == 'id_suratkeluar') {
        //         $data->$key = $this->req->acak($value);
        //     }
        // }
        echo json_encode($data);
    }

    function insert()
    {
        $id = explode('-', $this->input->post('jenis_surat'));
        $ttd = $this->input->post('ttd_pejabat');
        $pejabat2 = $this->input->post('persetujuan2');
        $ketua = $this->surat->getKetua();
        $buatNotif = time();
        
        if ($ttd == 2) {
            $persetujuan = "$pejabat2,$ketua[yayasan],$ketua[upk]";   
        }elseif ($ttd == 1 ) {
            $persetujuan = "$pejabat2,$ketua[upk]"; 
        } else {
            $persetujuan = "$pejabat2,$ttd,$ketua[yayasan],$ketua[upk]";   
        }

        $ket1 = $this->input->post('keteranganttd');
        $ket2 = $this->input->post('keteranganttd2');
        $keteranganttdNa = "$ket1,$ket2";

        if ($pejabat2 != '') {
            // Jika Pejabat 2 Kosong
            $pej2 = 1;
        }else{
            // Jika pejabat 2 Tidak Kosong
            $pej2 = 0;
        }


        $custom = [
            'jenis_surat'       => $id[1],
            'persetujuan2'      => false,
            'ttd_pejabat'       => false,
            'keteranganttd2'    => false,
            'pej2'              => $pej2,
            'keteranganttd'     => $keteranganttdNa,
            'persetujuan'       => $persetujuan,
            // 'asal_surat'        => $this->session->upk,
            'id_upk'            => $this->session->upk,
            'id_user'           => $this->session->id_user,
            'notif'             => $buatNotif
        ];

        $config = [
            'path' => 'surat',
            'file' => 'lampiran',
            'encrypt' => false,
            'type' => 'doc',
            'customInput' => $custom
        ];

        $data = $this->req->upload_form_multi($config);

        // echo $pej2;
        // var_dump($data);
        if ($this->surat->insert($data) == true) {

            $historiSurat = array(
                'no_surat' => $this->input->post('no_surat'),
                'aksi'  => 'Buat Surat',
                'nama_user' => $this->session->userdata('nama_user'),
                'perihal' => $this->input->post('perihal'),
                'isi_surat' => $this->input->post('isi_surat'),
                'keterangan' => $this->session->userdata('nama_user') . " Membuat Surat Keluar",
                'status_pengiriman' => " Membuat Surat Keluar",
                'tipe'  => '1',
            );

            $this->histori->insert($historiSurat);

            // $this->req->insertNotif([
            //     'table' => 't_suratkeluar',
            //     'tujuan' => $persetujuan,
            //     'notif' => $buatNotif,
            //     'tipe' => '2'
            // ]);
            
            $emailNa = explode(',', $persetujuan);

            $jabatan = [];
            $ketuaEmail = []; 
                foreach ($emailNa as $keyNa) {
                    $getEmail = $this->db->get_where('t_user', ['id' => $keyNa])->result();
                    foreach ($getEmail as $keyEmail) {
                        $ketuaEmail[] = $keyEmail->email;
                    }
                }

            $mail = array(
                    'subjek'            => 'Anda Mendapatkan Notif baru - Surat Keluar' ,
                    'keterangan_surat'  => 'Surat Keluar',
                    'perihal'           => $this->input->post('perihal'),
                    'isi_surat'         => $this->input->post('isi_surat'),
                    'email'             => $ketuaEmail,
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
    
        } else {
            $msg = array(
                'surat' => 'fail',
                'msg' => 'Gagal menambahkan data !'
            );
            echo json_encode($msg);
        }
    }

    function update()
    {
        $id = $this->input->post('id');
        $data = $this->req->all(['id' => false]);
        if ($this->surat->update($data, $this->req->id($id)) == true) {
            $msg = array(
                'surat' => 'ok',
                'msg' => 'Berhasil mengubah data !'
            );
        } else {
            $msg = array(
                'surat' => 'fail',
                'msg' => 'Gagal mengubah data !'
            );
        }
        echo json_encode($msg);
    }

    function delete($id)
    {

        if ($this->surat->delete($this->req->id($id)) == true) {
            $msg = array(
                'surat' => 'ok',
                'msg' => 'Berhasil menghapus data !'
            );
        } else {
            $msg = array(
                'surat' => 'fail',
                'msg' => 'Gagal menghapus data !'
            );
        }

        // echo $this->db->last_query();

        echo json_encode($msg);
    }

    public function insert_revisi()
    {

        $userTuju = $this->input->post('persetujuan');
        $id = $this->input->post('id');
        $idSuratJenis = explode('-', $this->input->post('jenis_surat'));
        $buatNotif = $this->input->post('notifNa');
        
        // Cek surat apakah ada atau tidak
        $cekSuratNa = $this->db->get_where('t_suratkeluar', array('id' => $id))->num_rows();
        
        $accNaNa = explode(',', $cekSuratNa->acc);

        $this->req->print($accNaNa);

        // Jika ada
        if ($cekSuratNa > 0) {
        // if ($cekSuratNa > 10) {
            
            $id = $this->input->post('id');
            $dataNa = array(
                'id' => false,
                'jenis_surat' => false,
                // 'status' => 0,
            );
            $data = $this->req->all($dataNa);
            if ($this->surat->update($data, array('id' => $id) ) == true) {
                $msg = array(
                    'surat' => 'ok',
                    'msg' => 'Berhasil mengubah data !'
                );
            }

            $dataInsert = array(
                'status' => 1,
                'status_pengiriman' => 1, 
                'id'    => false,
                'asal_surat' => $this->input->post('asal_surat'),
                'jenis_surat' => $idSuratJenis[1],
                'persetujuan' => $this->input->post('persetujuan'),
                'id_user' => $this->session->userdata('id_user'),
                'id_upk'    => $this->session->upk,
                'notif' => $buatNotif,
                
            );

            $masuk = $this->req->all($dataInsert); 
            if ($this->surat->insert($masuk) == true) {

                $historiSurat = array(
                        'no_surat'          => $this->input->post('no_surat') ,
                        'aksi'              => 'Merevisi Surat Keluar',
                        'nama_user'         => $this->session->userdata('nama_user'),
                        // 'perihal'           => $this->input->post('perihal') ,
                        'status_pengiriman' => "Mengirim Ulang Surat Keluar / Melakukan Revisi" ,
                        'keterangan' => $this->session->userdata('nama_user') . " Mengirim Ulang / Melakukan Revisi pada Surat Keluar" ,
                        'tipe'  => '2',
                    );
                $this->histori->insert($historiSurat);

                $tujuaNa = explode(',', $userTuju );
                $JabatanEmailNa = [];
                $emailNa = [];
                foreach ($tujuaNa as $key) {
                    $dataUser = $this->db->get_where('t_user', ['id' => $key])->result();
                    foreach ($dataUser as $list) {
                        $emailNa[] = $list->email;
                    }
                }

                // echo $this->req->input('userNa'),
                // $this->req->print($_POST);

                // $this->req->query();
                // exit(0);

                $mail = array(
                    'subjek'            => 'Anda Mendapatkan Notif baru - Hasil Revisi Surat Keluar',
                    'keterangan_surat'  => 'Hasil Revisi Surat Keluar',
                    'perihal'           => $this->input->post('perihal'),
                    'isi_surat'         => $this->input->post('isi_surat'),
                    'email'             => $emailNa,
                    'jabatanemail'      => $JabatanEmailNa,
                    // 'nama' => $userName,
                );
                $email = $this->req->sendMail($mail);

                if (!$email->send()) {
                    $msg = array(
                            'surat' => 'fail',
                            'msg' => 'Surat Berhasil Dikirim tapi Email Tidak Terdaftar  !'
                        );
                } else {
                    $msg = array(
                        'surat' => 'ok',
                        'msg' => 'Berhasil Mengirim Data !'
                    );
                }

                echo json_encode($msg);

                // $this->req->print($emailNa);


                // $msg = array(
                //     'surat' => 'ok',
                //     'msg' => 'Berhasil Me-Revisi data !'
                // );
            };         

        // Jika Tidak 
        }else{
            $msg = array(
                    'surat' => 'fail',
                    'msg' => 'Maaf nih kayaknya Terjadi Kesalahan pada Sistem/Server :( !'
                );
            echo json_encode($msg);
        }
    }

    function arsip($id, $action)
    {
        if ($action == 'arsip') {
            if ($this->surat->update(['arsipkan' => '1'], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Mengarsipkan Surat !'
                );
            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Sepertinya Terjadi kesalahan !'
                );
            }
            echo json_encode($msg);
        }
        
    }
}