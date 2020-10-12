<?php

class M_upk extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "t_upk";
        $this->table1 = "t_user";
        $this->column_order = array(null, 'kode_upk', 'upk', 'keterangan'); 
        $this->column_search = array('kode_upk', 'upk', 'keterangan');
        $this->order = array('id' => 'desc');
    }

    private function _get_datatables_query()
    {

        $this->db->select('t_upk.id, t_user.nama_user, t_upk.kode_upk, t_upk.upk, t_upk.keterangan, t_upk.status');
        $this->db->from($this->table, $this->table1);
        $this->db->join($this->table1, 't_upk.ketua_upk = t_user.id', 'left');
        
        

        $i = 0;

        foreach ($this->column_search as $item)
        {
            if ($_POST['search']['value'])
            {

                if ($i === 0)
                {
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
        $cek = $this->db->get_where($this->table, array('kode_upk' => $data['kode_upk']))->num_rows();
        if ($cek == 1) {
            return false;
        } else {
            $this->db->insert($this->table, $data);
            $this->db->insert('t_config', ['config' => 'logo-' . $data['kode_upk']]);
            return $this->cekPerubahan();
        }
    }

    function get($id)
    {
        return $this->db->get_where($this->table, $this->req->id($id))->row();
    }

    function ubahConfig($where, $data)
    {
        $upk = $this->db->get_where($this->table, $where)->row();
        $this->db->where('config', "logo-" . $upk->kode_upk);
        $this->db->update('t_config', array('config' => 'logo-' . $data['kode_upk']));
    }

    function hapusConfig($where)
    {
        $upk = $this->db->get_where($this->table, $where)->row();
        $this->db->where('config', "logo-" . $upk->kode_upk);
        $this->db->delete('t_config');
    }

    function update($data, $where)
    {
        $this->ubahConfig($where, $data);
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->cekPerubahan();
    }


    function updateUpk($data, $where)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->cekPerubahan();
    }

    function delete($where)
    {
        $this->hapusConfig($where);
        $this->db->where($where);
        $this->db->delete($this->table);
        return $this->cekPerubahan();
    }

    function data_pegawai()
    {
        $this->db->select('*');
        $this->db->from('t_user');
        $this->db->order_by('nama_user', 'ASC');
        $this->db->where('level', 3);
        $query = $this->db->get();
        return $query->result();
    }

}


?>