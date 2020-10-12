<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_track extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_track', 'track');
	}

	 public function index()
    {
        $data = array(
            'title'  => 'Tracking Surat Keluar - SK001/AWD/AWD/2020XI',
            'script' => 'track',
            'konten' => 'admin/tracking/list'
        );

        $this->load->view('admin/templates/templates', $data, FALSE);
    }

    public function get($noSurat)
    {
        $kodeTracking = str_replace("-", "/", $noSurat); 
        $uwu = explode("/", $kodeTracking);
    	$dataSurat = $this->track->getTrackSurat($uwu[0]);

		  $data = array(
            'title'  => "Tracking Surat Keluar - $kodeTracking",
            'datana' => $dataSurat,
            'script' => 'track',
            'konten' => 'admin/tracking/list'
        );

        $this->load->view('admin/templates/templates', $data, FALSE);    	

    }

}

/* End of file C_track.php */
/* Location: ./application/controllers/admin/C_track.php */