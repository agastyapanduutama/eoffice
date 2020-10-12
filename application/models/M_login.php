<?php

class M_login extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "t_user";
        $this->token = "wehehehe ngapain gan? >:D";
    }

    function cek($data)
    {
        $cek = $this->db->get_where($this->table, $data)->num_rows();
        if ($cek > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getData()
    {
        return $this->db->query($this->db->last_query())->row();
    }

    function changeDetail($version)
    {
        // $this->db->get_where('t_changelog', )->result();
        $this->db->select("*");
        $this->db->from('t_changelog');
        $this->db->where(['version' => $version]);
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    function changelog()
    {
        $chanelog = $this->db->query('SELECT c.version FROM t_changelog as c GROUP BY c.version ORDER BY c.version DESC')->result();
        $data = [];
        foreach ($chanelog as $key) {
            $data[] = [
                'version' => $key->version,
                'detail' => $this->changeDetail($key->version)
            ];
        }
        return $data;
        // $this->req->print($data);
    }
}
    