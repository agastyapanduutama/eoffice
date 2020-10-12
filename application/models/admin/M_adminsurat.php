<?php

class M_adminsurat extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "t_user";
        $this->table1 = "t_jabatan as j";
        $this->column_order = array('t_user.username', 't_user.nama_user', 't_user.username', 'j.jabatan', 't_user.status');
        $this->column_search = array('t_user.username', 't_user.nama_user', 't_user.username', 'j.jabatan');
        $this->order = array('t_user.id' => 'desc');
    }

    private function _get_datatables_query()
    {
        $this->db->select('t_user.id, t_user.username, t_user.nama_user, t_user.username, j.jabatan, t_user.status, t_user.gelar_depan, t_user.gelar_belakang, t_user.email');
        $this->db->from($this->table, $this->table1);
        $this->db->join($this->table1, 'j.id = t_user.id_jabatan', 'left');
        $this->db->where('t_user.id_upk', $this->session->userdata('upk'));
        $this->db->where('t_user.level', '4');

        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->where('level != ', '1');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function cekPerubahan()
    {
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert($data)
    {
        $cek = $this->db->get_where($this->table, array('username' => $data['username']))->num_rows();
        if ($cek == 1) {
            return false;
        } else {
            $this->db->insert($this->table, $data);
            return $this->cekPerubahan();
        }
    }

    function get($id)
    {
        return $this->db->get_where($this->table, $this->req->id($id))->row();
    }

    function update($data, $where)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->cekPerubahan();
    }

    function delete($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table);

        return $this->cekPerubahan();
    }

    function data_jabatan()
    {
        $this->db->select('*');
        $this->db->from('t_jabatan');
        $this->db->where('id_upk', $this->session->userdata('upk'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
}
