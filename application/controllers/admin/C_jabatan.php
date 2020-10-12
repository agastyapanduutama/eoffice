<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_jabatan extends CI_Controller
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
        $this->jabatan->upk = $this->session->userdata('upk');
    }

    public function list()
    {
        $data = array(
            'title'  => 'Jabatan',
            'menu'   => 'jabatan',
            'script' => 'jabatan',
            'konten' => 'admin/jabatan/list'
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }


    function getJabatan()
    {
        echo json_encode($this->jabatan->data_jabatan());
    }

    function getUpk()
    {
        echo json_encode($this->jabatan->data_upk());
    }

    function data()
    {
        error_reporting(0);
        $list = $this->jabatan->get_datatables();
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


            $jabatan = $this->db->get_where('t_jabatan', ['parent' => $field->parent]);

            // kondisi jabatan
            $jabatanNa = "Tidak";
            if ($jabatan->num_rows() > 0)
                $jabatanNa = $jabatan->row()->jabatan;

            $no++;
            $row = array();
            $row[] = "<input type='checkbox' id='pilihGan-$idNa' value='$idNa'></input>";
            $row[] = $no;
            $row[] = $field->kode_jabatan;
            $row[] = $field->jabatan;
            $row[] = $jabatanNa;
            $row[] = $field->level;
            $row[] = $field->keterangan;
            $row[] = $status;
            $row[] = $button;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jabatan->count_all(),
            "recordsFiltered" => $this->jabatan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get($id)
    {
        $data = $this->jabatan->get($id);
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
        if ($this->jabatan->insert($data) == true) {
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

    function set($id, $action)
    {
        if ($action == 'on') {
            if ($this->jabatan->update(['status' => '1'], $this->req->id($id)) == true) {
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
            if ($this->jabatan->update(['status' => '0'], $this->req->id($id)) == true) {
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


    function update()
    {
        $id = $this->input->post('id');
        $data = $this->req->all(['id' => false]);
        if ($this->jabatan->update($data, $this->req->id($id)) == true) {
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
        // echo $this->db->last_query();
        echo json_encode($msg);
    }

    function delete($id)
    {
        if ($this->jabatan->delete($this->req->id($id)) == true) {
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
                if ($this->jabatan->update(['status' => 0], $this->req->id($id)) == true) $jmlNa++;
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
                if ($this->jabatan->update(['status' => 1], $this->req->id($id)) == true) $jmlNa++;
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
                if ($this->jabatan->delete($this->req->id($id)) == true) $jmlNa++;
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
