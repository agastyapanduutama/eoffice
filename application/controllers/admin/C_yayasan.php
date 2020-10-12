<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_yayasan extends CI_Controller {

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
        if ($this->session->userdata('level') != 1) {
            redirect(base_url());
        }
        $this->load->model('admin/M_config', 'config_');
        $this->table = 't_config';
    }

    public function identitas()
    {
        $conf = $this->config_;
        $config = array(
            'logo' => $conf->get('logo'),
            'nama' => $conf->get('nama'),
            'alamat' => $conf->get('alamat'),
            'no_telp_1' => $conf->get('no_telp_1'),
            'no_telp_2' => $conf->get('no_telp_2'),
            'email' => $conf->get('email'),
        );
        $data = array(
            'title' => 'Informasi Yayasan' ,
            'konten' => 'admin/yayasan/list',
            'menu' => 'yayasan',
            'config' => $config,
            'script' => 'yayasan',
        );
        
        $this->load->view('admin/templates/templates', $data, FALSE);
        
    }

    function update()
    {
        $conf = array(
            'type' => 'img',
            'path' => 'config',
            'file' => 'logo',
            'encrypt' => true
        );
        $data = $this->req->upload_form($conf);
        $config = $this->config_;
        if ($_FILES['logo']['name']){
            unlink('./uploads/config/' . $this->config_->get('logo'));
        }
        foreach ($data as $key => $value) {
            $config->setConfig($key, $value);
        }
        $msg = array(
            'status' => 'ok',
            'msg' => 'Berhasil mengubah Data !'
        );
        echo json_encode($msg);
    }

    function getConfig()
    {
        $data = $this->db->get($this->table)->result();
        echo json_encode($data);
    }

    function getPegawai()
    {
        echo json_encode($this->config_->data_pegawai());
    }

}

/* End of file C_yayasan.php */
