<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_jenis extends CI_Controller
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

        if ($this->session->userdata('level') != 2) {
            redirect(base_url());
        }
        $this->load->model('admin/M_jenis', 'jenis');
        $this->jenis->upk = $this->session->userdata('upk');
    }

    public function list()
    {
        $data = array(
            'title'  => 'Jenis Surat',
            'menu'   => 'jenis',
            'script' => 'jenis',
            'konten' => 'admin/jenis/list'
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }

    function getJenis()
    {
        echo json_encode($this->jenis->data_jenis());
    }

    function data()
    {
        error_reporting(0);
        $list = $this->jenis->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $idNa = $this->req->acak($field->id);
            // $idNa = $field->id;
            $status = ($field->status) == '1' ? "<button class='btn btn-success btn-sm' id='on' data-id='$idNa' title='User Aktif'><i class='fas fa-toggle-on' ></i> On</button>" : "<button class='btn btn-danger btn-sm' id='off' data-id='$idNa' title='User Tidak Aktif'><i class='fas fa-toggle-off'></i> Off</button>";
           
            $button = "
                <button class='btn btn-danger btn-sm' id='delete' data-id='$idNa' title='Hapus Data'><i class='fas fa-trash-alt'></i></button>
                <button class='btn btn-warning btn-sm' id='edit' data-id='$idNa' title='Edit Data'><i class='fas fa-pencil-alt'></i></button>
            ";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' id='pilihGan-$idNa' value='$idNa'></input>";
            $row[] = $no;
            $row[] = $field->kode_jenis;
            $row[] = $field->jenis;
            $row[] = $field->keterangan;
            $row[] = $status;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jenis->count_all(),
            "recordsFiltered" => $this->jenis->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get($id)
    {
        $data = $this->jenis->get($id);
        foreach ($data as $key => $value) {
            if (strtolower($key) == 'id') {
                $data->$key = $this->req->acak($value);
            }
        }
        echo json_encode($data);
    }

    function insert()
    {
        $data = $this->req->all();
        if ($this->jenis->insert($data) == true) {
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
        if ($this->jenis->update($data, $this->req->id($id)) == true) {
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
        if ($this->jenis->delete($this->req->id($id)) == true) {
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

    function set($id, $action)
    {
        if ($action == 'on') {
            if ($this->jenis->update(['status' => '1'], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Mengaktifkan Data !'
                );
            } else {
                $msg = array(
                    'status' => 'fail',
                    'msg' => 'Gagal Mengaktifkan data !'
                );
            }
            echo json_encode($msg);
        } elseif ($action == 'off') {
            if ($this->jenis->update(['status' => '0'], $this->req->id($id)) == true) {
                $msg = array(
                    'status' => 'ok',
                    'msg' => 'Berhasil Me-nonaktifkan Data !'
                );
            } else {
            }
            // echo $this->db->last_query();;
            echo json_encode($msg);
        }
    }



    // multiple select off data
    function allOff()
    {
        $idNa = explode(",", $this->req->input("id"));
        $total = count($idNa) - 1;
        $jmlNa = 0;
        foreach ($idNa as $id) {
            if ($id != "") {
                if ($this->jenis->update(['status' => 0], $this->req->id($id)) == true) $jmlNa++;
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
                if ($this->jenis->update(['status' => 1], $this->req->id($id)) == true) $jmlNa++;
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
                if ($this->jenis->delete($this->req->id($id)) == true) $jmlNa++;
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
