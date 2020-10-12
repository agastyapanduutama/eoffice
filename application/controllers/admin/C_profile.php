<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_profile extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata($this->session->token) == true) {
            redirect(base_url());
        }
        if ($this->session->userdata('token') == NULL) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array(
            'title' => 'Pengaturan Profile',
            'konten' => 'admin/profile/profile',
            'menu' => 'profile',
            'script' => 'profile',
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }

    function get()
    {
        $userData = $this->db->get_where('t_user', ['id' => $this->session->id_user])->row();
        echo json_encode($userData);
    }

    function setPassword()
    {
        $passLama = $this->req->input('passwordLama');
        $password = $this->req->input('password');
        $userData = $this->db->get_where('t_user', 
        [
            'id' => $this->session->id_user, 
            'password' => $this->req->acak($passLama)
        ]
        )->row();
        if (!$userData) {
            echo json_encode([
                'status' => 'salah'
            ]);
        } else {
            $this->db->where('id', $this->session->id_user);
            $this->db->update('t_user', 
            [
                'password' => $this->req->acak($password)
            ]);
            if ($this->db->affected_rows() > 0) {
                echo json_encode([
                    'status' => 'benar'
                ]);
            } else {
                echo json_encode([
                    'status' => 'fail'
                ]);
            }
        }
    }

    function setProfile()
    {
        $password = $this->req->input('password');
        $data = $this->req->all(['password' => false]);
        $userData = $this->db->get_where(
            't_user',
            [
                'id' => $this->session->id_user,
                'password' => $this->req->acak($password)
            ]
        )->row();
        if (!$userData) {
            echo json_encode([
                'status' => 'salah'
            ]);
        } else {
            $this->db->where('id', $this->session->id_user);
            $this->db->update("t_user", $data);
            if ($this->db->affected_rows() > 0) {
                echo json_encode([
                    'status' => 'ok',
                    'msg' => "Berhasil merubah Data !"
                ]);
            } else {
                echo json_encode([
                    'status' => 'fail',
                    'msg' => "Tidak ada perubahan !"
                ]);
            }
        }
    }
}


?>