<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('M_login');
    }


    public function login()
    {
        if (!$this->session->userdata($this->session->token) == true) {
            redirect(base_url('admin'));
        }
        $data = array(
            'script' => 'login',
            'changelog' => $this->M_login->changelog()
        );
        $this->load->view('admin/login', $data);
    }

    function aksi()
    {
        $user = $this->input->post('username');
        $email = $this->input->post('email');
        $pass = $this->input->post('password');
        $where = array(
            // 'username' => $user,
            'email' => $email,
            'password' => $this->req->acak($pass)
        );
        if ($this->M_login->cek($where) == true) {
            $userData = $this->M_login->getData();
            if ($userData->status == 1) {
                $token = $this->req->acak(($this->M_login->token . $user . time()));
                $jabatan = $this->db->get_where('t_jabatan', ['id' => $userData->id_jabatan]);
                $pembina = false;
                $upkLevel = $this->db->get_where('t_upk', ['id' => $userData->id_upk])->row();
                if($jabatan->num_rows() > 0){
                    $source = $jabatan->row();
                    if($source->kode_jabatan == "PBNYSN")
                       $pembina = true;
                }

                // var_dump($pembina);
                $session = array(
                    'id_user' => $userData->id,
                    'username' => $userData->username,
                    'level' => $userData->level,
                    'satuan' => $userData->id_satuan,
                    'jabatan' => $userData->id_jabatan,
                    'upk' => $userData->id_upk,
                    'nama_user' => $userData->nama_user,
                    'pembina' => $pembina,
                    'levelUpk' => (isset($upkLevel->level)) ? $upkLevel->level : "0",
                    $token => true,
                    'token' => $token
                );
                $this->session->set_userdata($session);
                $pesan = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Login !'
                );
                echo json_encode($pesan);
            } else {
                $pesan = array(
                    'status' => 'fail',
                    'msg' => 'Akun Anda tidak aktif !'
                );
                echo json_encode($pesan);
            }
        } else {
            $pesan = array(
                'status' => 'fail',
                'msg' => 'Kata Sandi atau Nama Pengguna salah !'
            );
            echo json_encode($pesan);
        }
    }

    public function logout()
    {
        $token = $this->uri->segment('4');
        if ($this->session->userdata('token') == $token) {
            $this->session->sess_destroy();
            redirect(base_url());
        } else {
            show_404();
        }
    }
}
