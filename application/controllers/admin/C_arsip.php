<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_arsip extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //cek login
        if (!$this->session->userdata($this->session->token) == true) {
            redirect(base_url());
        }
        if ($this->session->userdata('token') == NULL) {
            redirect(base_url());
        }
        
        $this->load->model('admin/M_jabatan', 'jabatan');
        $this->load->model('admin/M_arsip', 'arsip');
    }

    public function masuk()
    {
        $data = array(
            'title'  => 'Arsip Surat Masuk',
            'menu'   => 'arsip-masuk',
            'script' => 'arsip',
            'konten' => 'admin/arsip/list'
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }

    public function keluar()
    {
        $data = array(
            'title'  => 'Arsip Surat Keluar',
            'menu'   => 'arsip-keluar',
            'script' => 'arsip_keluar',
            'konten' => 'admin/arsip/list_keluar'
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }

    function data($tipe = null)
    {
        error_reporting(0);

        // var_dump($tipe);

        if ($tipe == 'keluar') {
            $this->arsip->tipe = '1';
        }elseif($tipe == 'masuk'){
            $this->arsip->tipe = '2';
        }

        $list = $this->arsip->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            // $idNa = $field->id;
            // $idNa = $field->id;
            $idNa = $this->req->acak($field->id);
            $NoSuratNa = $field->no_surat;
            // $idNa = $field->id;
            if ($tipe == 'keluar') {
                $noTracking = str_replace("/", "-", $NoSuratNa); 
                $button = "
                    <button class='btn btn-primary btn-sm' id='lihat' data-id='$idNa' title='Lihat Berkas'><i class='fas fa-eye'></i></button>
                    <button class='btn btn-success btn-sm' id='track' data-surat='$noTracking' title='Tracking Surat'><i class='fas fa-shipping-fast'></i></button>
                "; 
            }else{
                $button = "
                    <button class='btn btn-primary btn-sm' id='lihat' data-id='$idNa' title='Lihat Berkas'><i class='fas fa-eye'></i></button>
                ";  
            }

             if ($field->disposisi == '1') {
                $disposisi= "Ya";
            }
            if ($field->disposisi == '2') {
                $disposisi= "Sudah Disposisi";
            }
            if ($field->disposisi == '0') {
                $disposisi= "Tidak";
            }


                $no++;
                $row = array();


            if ($tipe =='keluar') {
                $row[] = $no;
                $row[] = $field->no_surat;
                $row[] = $field->tanggal_dibuat;
                $row[] = $field->asal_surat;
                $row[] = $field->jenis;
                $row[] = $field->sifat;
                $row[] = $field->perihal;

            }else{
                $row[] = $no;
                $row[] = $field->no_surat;
                $row[] = $field->tanggal_surat;
                $row[] = $field->asal_surat;
                $row[] = $field->jenis;
                $row[] = $disposisi;
                $row[] = $field->perihal;
            }
                $row[] = $button;
                $data[] = $row;
            
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->arsip->count_all(),
            "recordsFiltered" => $this->arsip->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function getMasuk($id)
    {
        $data = $this->arsip->getMasuk($id);

        // echo $this->db->last_query();
        // foreach ($data as $key => $value) {
        //     if (strtolower($key) == 'id') {
        //         $data->$key = $value;
        //     }
        // }
        echo json_encode($data);
    }

    function getKeluar($id)
    {


        $data = $this->arsip->getKeluar($id);
        
        // echo $this->db->last_query();
        // foreach ($data as $key => $value) {
        //     if (strtolower($key) == 'id') {
        //         $data->$key = $value;
        //     }
        // }
        echo json_encode($data);
    }


    

}
