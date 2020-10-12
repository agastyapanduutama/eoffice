<?php

class M_arsip extends CI_Model
{

    public $tipeKirim = null;
    public $tipe = null;
    public $upk;

    function __construct()
    {
        parent::__construct();
        $this->table = "t_surat";
        $this->table1 = "t_jenis";
        $this->table2 = "t_disposisi";
        $this->table3 = "t_suratkeluar";
        $this->column_order = array(null, 'kode_surat', 'surat', 'keterangan');
        $this->column_search = array('kode_surat', 'surat', 'keterangan');
        if ($this->tipe == '1') {
            $this->order = array('t_suratkeluar.id' => 'desc');
        }elseif ($this->tipe == '2'){
            $this->order = array('t_surat.id' => 'desc');
        }
    }

    private function _get_datatables_query()
    {

        // var_dump($this->tipe);

         if ($this->tipe == '1') {
            $this->db->from($this->table3);
            $this->db->select('*,t_suratkeluar.id');
            $this->db->join('t_jenis', 't_jenis.id = t_suratkeluar.jenis_surat', 'left');
            $this->db->join('t_sifat', 't_sifat.id = t_suratkeluar.sifat_surat', 'left');
            $this->db->where('arsipkan', '1');
            $this->db->where('t_suratkeluar.id_upk', $this->session->userdata('upk'));
            $this->db->where('status_pengiriman', '0');
        }elseif($this->tipe == '2') {
            $this->db->from($this->table);
            $this->db->select('*, t_surat.id');
            $this->db->join('t_jenis', 't_jenis.id = t_surat.jenis_surat', 'left');
            $this->db->where('arsipkan', '1');
            $this->db->where('t_surat.id_upk', $this->session->userdata('upk'));
        }
     
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
        $this->db->where('id_upk', $this->upk);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

   
    function getMasuk($id)
    {
        return $this->db->get_where($this->table, $this->req->id($id))->row();
    }
  
    function getKeluar($id)
    {
        return $this->db->get_where($this->table3, array('id' => $id , ))->row();
    }

    

  
}
