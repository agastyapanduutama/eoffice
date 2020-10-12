<?php

class M_suratinternal extends CI_Model
{

    public $tipeKirim = null;
    public $tipe = null;
    public $upk;

    function __construct()
    {
        parent::__construct();
        $this->table = "t_surat";
        $this->table1 = "t_jenis";
        $this->column_order = array(null, 'no_surat', 'tanggal_dibuat');
        $this->column_search = array('no_surat', 'tanggal_dibuat');
        $this->order = array('t_surat.id' => 'desc');
    }

    private function _get_datatables_query()
    {

        $this->db->distinct('');
        $this->db->select('t_surat.no_surat, t_surat.*,t_surat.id, t_jenis.jenis, t_surat.status_suratmasuk, t_surat.arsipkan, t_aksi.aksi');
        $this->db->from($this->table);
        $this->db->join('t_jenis', 't_jenis.id = t_surat.jenis_surat', 'left');
        $this->db->join('t_aksi', 't_aksi.id = t_surat.aksi_surat', 'left');
        $this->db->where('t_surat.id_upk', $this->session->upk);
        $this->db->where('internal', '1');
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $this->db->where('arsipkan', '0');

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

    function data_user()
    {
        $this->db->select('id as value, nama_user as name');
        $this->db->from('t_user');
        $this->db->order_by('id', 'ASC');
        $this->db->where('id !=', $this->session->userdata('id_user'));
        $this->db->where('id_upk', $this->session->userdata('upk'));
        $this->db->where('level', 3);
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
        $this->db->where('id_upk', $this->upk);
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
        $cek = $this->db->get_where($this->table, array('id_upk' => $this->upk))->num_rows();
        if ($cek == 1) {
            return false;
        } else {
            $this->db->insert($this->table, $data);
            return $this->cekPerubahan();
        }
    }


    function insert_disposisi($data)
    {
        $this->db->insert('t_disposisi', $data);
        return $this->cekPerubahan();
    }

   
    function get($id)
    {
        // return $this->db->get_where($this->table, $this->req->id($id))->row();
        $this->db->select('*, t_surat.id as id_suratna');
        $this->db->from('t_surat');
        $this->db->where('t_surat.id', $id);
        $this->db->order_by('t_surat.id', 'desc');
        return $this->db->get()->row();
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

    function getKetua()
    {
        $upk = $this->db->get_where('t_upk', ['id' => $this->session->upk])->row();
        return [
            'upk' => $upk->ketua_upk,
        ];
    }

}
