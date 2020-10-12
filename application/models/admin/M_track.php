<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_track extends CI_Model {


	function getTrackSurat($kodeTracking)
	{
		$this->db->from('t_histori');
		$this->db->like('no_surat', $kodeTracking, 'RIGHT');
		return $this->db->get()->result();
	}

}

/* End of file M_track.php */
/* Location: ./application/models/admin/M_track.php */