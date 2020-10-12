<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_histori extends CI_Model {

	function get($id)
    {
        return $this->db->get_where('t_histori', $this->req->id($id))->row();
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
        $this->db->insert('t_histori', $data);
        return $this->cekPerubahan();
    }

    function getHistori($id)
    {
    	$this->db->from('t_histori');
    	$this->db->where('id', $id);
    	return $this->db->get()->row();
    }
	

}

/* End of file M_histori.php */
/* Location: ./application/models/admin/M_histori.php */