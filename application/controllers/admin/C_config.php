<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_config extends CI_Controller
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
        $this->load->model('admin/M_config');
    }

    function config()
    {
        $config = $this->uri->segment('4');
        $data = array(
            'title' => 'Yayasan wqweq',
            'menu' => 'yayasan',
            'konten' => "admin/yayasan/list",
            'config' => $this->M_config->getAllConfig($config),
            'script' => 'config'
        );
        $this->load->view('admin/templates/templates', $data);
    }

   
}
