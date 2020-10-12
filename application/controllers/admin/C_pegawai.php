<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_pegawai extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //cek login
        if (!$this->session->userdata($this->session->token) == true) {
        }
        if ($this->session->userdata('token') == NULL) {
            redirect(base_url());
        }
        $this->load->model('admin/M_pegawai', 'pegawai');
    }

    public function list()
    {

        $data = array(
            'title' => 'Pegawai UPK',
            'menu' => 'pegawai',
            'script' => 'pegawai',
            'konten' => 'admin/pegawai/list'
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }

    function getJabatan()
    {
        echo json_encode($this->pegawai->data_jabatan());
    }

    function getUpk()
    {
        // ini cok harusnya jadi dia ngambil id tapi udah di hash kalo yang ini
        echo json_encode($this->pegawai->data_upk());
    }
    
    function getUpkSelected(){
        // ini buat get jabatan jadi diambil dari id upk yang ada cok
        $id_upk = $_GET['id_upks'];
        echo json_encode($this->pegawai->data_jabatan($id_upk));
    }
    
    function getPegawaiSelected(){
        $id_upk = $_GET['id_upks'];
        echo json_encode($this->pegawai->data_pegawai($id_upk));
    }

    function data($upk = null)
    {
        error_reporting(0);
        $this->pegawai->upk = $upk;
        $list = $this->pegawai->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);
            $status = ($field->status) == '1' ? "<button class='btn btn-success btn-sm' id='on' data-id='$idNa'><i class='fas fa-toggle-on'></i> On</button>" : "<button class='btn btn-danger btn-sm' id='off' data-id='$idNa'><i class='fas fa-toggle-off'></i> Off</button>";
            // $idNa = $field->id;
            $button = "
                <button class='btn btn-danger btn-sm' id='delete' data-id='$idNa'><i class='fas fa-trash-alt'></i></button>
                <button class='btn btn-warning btn-sm' id='edit' data-id='$idNa'><i class='fas fa-pencil-alt'></i></button>
                <button class='btn btn-info btn-sm' id='reset' data-id='$idNa'><i class='fas fa-sync-alt'></i></button>
            ";
            $no++;
            $row = array();
            //buat multiple
            $row[] = "<input type='checkbox' id='pilihGan-$idNa' value='$idNa'></input>";
            $row[] = $no;
            // $row[] = $field->gelar_depan;
            $row[] = $field->nama_user;
            // $row[] = $field->gelar_belakang;
            // $row[] = $field->username;
            $row[] = $field->email;
            $row[] = $field->niy;
            $row[] = $field->upk;
            $row[] = $field->jabatan;
            $row[] = $status;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pegawai->count_all(),
            "recordsFiltered" => $this->pegawai->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function set($id, $action)
    {
        if ($action == 'on') {
            if ($this->pegawai->update(['status' => '1'], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Mengaktifkan Akun !'
                );
            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Gagal menambahkan data !'
                );
            }
            echo json_encode($msg);
        } elseif ($action == 'off') {
            if ($this->pegawai->update(['status' => '0'], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Me-nonaktifkan Akun !'
                );
            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Gagal Me-nonaktifkan data !'
                );
            }
            echo json_encode($msg);
        } elseif ($action == 'reset') {
            if ($this->pegawai->update(['password' => $this->req->acak('123')], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Me-reset Akun !'
                );
            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Gagal Me-reset data !'
                );
            }
            echo json_encode($msg);
        }
    }

    function get($id)
    {
        $data = $this->pegawai->get($id);
        foreach ($data as $key => $value) {
            if (strtolower($key) == 'id') {
                $data->$key = $this->req->acak($value);
            }
        }
        echo json_encode($data);
    }

    function insert()
    {
        $idPeg = $this->pegawai->getIdUpk($this->req->input('id_upk'));
        $custom = array(
            'password' => $this->req->acak('123'),
            'username' => time(),
            'id_upk' => $idPeg
        );
        $data = $this->req->all($custom);
        if ($this->pegawai->insert($data) == true) {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil menambahkan data !'
            );
        } else {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal menambahkan data !'
            );
        }
        echo json_encode($msg);
    }

    function update()
    {
        $id = $this->input->post('id');
        $data = $this->req->all(['id' => false]);
        if ($this->pegawai->update($data, $this->req->id($id)) == true) {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil mengubah data !'
            );
        } else {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal mengubah data !'
            );
        }
        echo json_encode($msg);
    }

    function delete($id)
    {
        if ($this->pegawai->delete($this->req->id($id)) == true) {
            $msg = array(
                'status' => 'ok',
                'msg' => 'Berhasil menghapus data !'
            );
        } else {
            $msg = array(
                'status' => 'fail',
                'msg' => 'Gagal menghapus data !'
            );
        }
        echo json_encode($msg);
    }

    
    // multiple select off data
    function allOff()
    {
        $idNa = explode(",", $this->req->input("id"));
        $total = count($idNa) - 1;
        $jmlNa = 0;
        foreach ($idNa as $id) {
            if ($id != "") {
                if ($this->pegawai->update(['status' => 0], $this->req->id($id)) == true) $jmlNa++;
            }
        }
        if ($jmlNa > 0) {
            echo json_encode([
                "status" => "ok",
                "msg" => "Berhasil Me-nontaktifkan $jmlNa dari $total Akun"
            ]);
        } else {
            echo json_encode([
                "status" => "fail",
                "msg" => "Tidak ada data yg berubah !"
            ]);
        }
    }

    // multiple select on data
    function allOn()
    {
        $idNa = explode(",", $this->req->input("id"));
        $total = count($idNa) - 1;
        $jmlNa = 0;
        foreach ($idNa as $id) {
            if ($id != "") {
                if ($this->pegawai->update(['status' => 1], $this->req->id($id)) == true) $jmlNa++;
            }
        }
        if ($jmlNa > 0) {
            echo json_encode([
                "status" => "ok",
                "msg" => "Berhasil Mengaktifkan $jmlNa dari $total Akun"
            ]);
        } else {
            echo json_encode([
                "status" => "fail",
                "msg" => "Tidak ada data yg berubah !"
            ]);
        }
    }

    // multiple select delete data
    function allDelete()
    {
        $idNa = explode(",", $this->req->input("id"));
        $total = count($idNa) - 1;
        $jmlNa = 0;
        foreach ($idNa as $id) {
            if ($id != "") {
                if ($this->pegawai->delete($this->req->id($id)) == true) $jmlNa++;
            }
        }
        if ($jmlNa > 0) {
            echo json_encode([
                "status" => "ok",
                "msg" => "Berhasil Mengaktifkan $jmlNa dari $total Akun"
            ]);
        } else {
            echo json_encode([
                "status" => "fail",
                "msg" => "Tidak ada data yg berubah !"
            ]);
        }
    }
}
