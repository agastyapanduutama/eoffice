<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_home extends CI_Controller {

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
    }

    public function home()
    {

        // $this->req->print($_SESSION);

        $quote = $this->db->query("SELECT * FROM t_quotes ORDER BY RAND ()")->row();

        $data = array(
            'title' => 'Dashboard - E Office' ,
            'konten' => 'admin/home/dashboard',
            'menu' => 'home',
            'quote' => $quote->quotes,
            'script' => '',    
        );
        
        $this->load->view('admin/templates/templates', $data, FALSE);
        
    }

}

/* End of file C_home.php */
