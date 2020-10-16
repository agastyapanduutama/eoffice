<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_pdf extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_surat', 'surat');
		$this->load->model('admin/M_suratkeluar', 'keluar');
		$this->load->model('admin/M_suratkeluarinternal', 'keluarInternal');
		$this->load->model('admin/M_user', 'user');
		$this->load->model('admin/M_config', '_config');

	}

	public function index()
	{
		$data = $this->load->view('v_mpdf');
	}

	public function surat_keluar($id)
	{
		$surat = $this->keluar->data_surat($id);

		$namaUpk = $this->_config->get('nama');
		// print_r($_SESSION);

		$sess = $this->session->userdata('kodeUpk');
		$namaUpk = $this->_config->get($sess."{}nama");
		$alamatUpk = $this->_config->get($sess."{}alamat");
		$telp1Upk = $this->_config->get($sess."{}no_telp_1");
		$telp2Upk = $this->_config->get($sess."{}no_telp_2");
		$emailUpk = $this->_config->get($sess."{}email");
		
		$acc = explode(',',$surat->acc);		
		$lampiran = explode(',', $surat->lampiran);
		$tembusan = explode(',', $surat->tembusan);

		$tembusanNa = [];
		foreach ($tembusan as $key) {
			$temb = $this->db->get_where('t_jabatan', ['id' => $key]);
			if ($temb->num_rows() > 0) {
				$saos = $temb->row();
				$tembusanNa[] = $saos->jabatan;
			}
		}

		$namaAcc = [];
		foreach($acc as $list):
			$user = $this->keluar->ambilData($list);
			if($user->num_rows() > 0){
				$source = $user->row();	
				$namaAcc[] = $source->nama_user;
				$gelarDepanAcc[] = $source->gelar_depan;
				$gelarBelakangAcc[] = $source->gelar_belakang;
				$jabatanNa[] = $source->jabatan;
			}
		endforeach;


		$data = array(
			'acc' 			=> $namaAcc ,
			'depan' 		=> $gelarDepanAcc ,
			'belakang' 		=> $gelarBelakangAcc ,
			'jabatan' 		=> $jabatanNa ,
			'lampiran' 		=> $lampiran,
			'tembusan' 		=> $tembusan,
			'tembusanNa' 	=> $tembusanNa,
			'surat' 		=> $surat,
			// Identitas UPK
			'namaupk'		=> $namaUpk,
			'alamatupk'		=> $alamatUpk,
			'telp1'			=> $telp1Upk,
			'telp2'			=> $telp2Upk,
			'emailupk'		=> $emailUpk,
		);

		$data['acc'] = $namaAcc;
		$mpdf = new \Mpdf\Mpdf([
			'setAutoTopMargin' => 'pad',
			'setAutoBottomMargin' => 'pad',
		]);
		$data = $this->load->view('pdf/surat_keluar', $data, TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output();

		// HTML Tanpa dijadikan PDF
		// $this->load->view('pdf/surat_keluar', $data, FALSE);
	
	}

	public function surat_keluarinternal($id)
	{
		$surat = $this->keluarInternal->data_surat($id);

		$acc = explode(',',$surat->acc);		
		$lampiran = explode(',', $surat->lampiran);
		$tembusan = explode(',', $surat->tembusan);
		$keteranganTtdNa = explode(',', $surat->keteranganttd);
		$pejabatTerkait = $this->db->get_where('t_user', ['id' => $surat->acc_pejabat]);

		$namaAcc = [];
		$jabata = [];
		foreach($acc as $list): 
			$user = $this->keluarInternal->ambilData($list);
			if($user->num_rows() > 0){
				$source = $user->row();	
				$namaAcc[] = $source->nama_user;
				$gelarDepanAcc[] = $source->gelar_depan;
				$gelarBelakangAcc[] = $source->gelar_belakang;
				$jabatanNa[] = $source->jabatan;
			}
		endforeach;

		$data = array(
			'acc' => $namaAcc ,
			'userAcc' => $user->row(),
			'depan' => $gelarDepanAcc ,
			'belakang' => $gelarBelakangAcc ,
			'jabatan' => $jabatanNa ,
			'pejabat' => $pejabatTerkait->row() ,
			'lampiran' => $lampiran,
			'tembusan' => $tembusan,
			'surat' => $surat,
			'keterangan' => $keteranganTtdNa,
		);

		$data['acc'] = $namaAcc;
		$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'pad']);
		$data = $this->load->view('pdf/surat_keluarinternal', $data, TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output();
	
		// $this->load->view('pdf/surat_keluarinternal', $data, FALSE);
	}

	public function pesan_balik($id)
	{
		$surat = $this->surat->data_disposisi($id);

		$data = array(
			'surat' => $surat , 
		);

		$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'pad']);
		$data = $this->load->view('pdf/kirim_balikan', $data, TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output();

		// $this->load->view('pdf/kirim_balikan', $data);

	}

	public function disposisi($id)
	{
		$surat = $this->surat->data_disposisi($id);
		// $this->req->print($surat['catatan']);


		$tujuanAwal = explode(",", $surat['surat']->aksi_kirim);

		$tujuanNa = [];
		foreach ($tujuanAwal as $keyNa) {
			if ($keyNa != '') {
				$jaba = $this->db->get_where('t_jabatan', ['id' => $keyNa])->row();
				$tujuanNa[] = $jaba->jabatan;
			}
		}

		//get diteruskan dari $surat
		$namaJabatan = $surat['diteruskan'];    
        
		// foreach ($dikirimKepda as $key) {
		// 	if ($key != '') {
		// 		$jab = $this->db->get_where('t_jabatan', ['id' => $key])->row();
		// 		$namaJabatan[] = $jab->jabatan;
		// 	}
		// }

		$datana = array(
			'surat' => $surat['surat'],
			'catatan' => $surat['catatan'],
			'tgl_disposisi' => $surat,
			'dikirimAwal' => $tujuanNa,
			'dikirimKepda' => $namaJabatan,
		);

			// var_dump($datana);


		// $mpdf = new \Mpdf\Mpdf();
		// $data = $this->load->view('pdf/disposisi', $datana, TRUE);
		// $mpdf->WriteHTML($data);
		// $mpdf->Output();

		$this->load->view('pdf/disposisi', $datana, FALSE);
	}

	public function disposisi_internal($id)
	{
		$surat = $this->surat->data_disposisi_internal($id);

		$tujuanAwal = explode(",", $surat['surat']->aksi_kirim);

		$tujuanNa = [];
		foreach ($tujuanAwal as $keyNa) {
			if ($keyNa != '') {
				$jaba = $this->db->get_where('t_jabatan', ['id' => $keyNa])->row();
				$tujuanNa[] = $jaba->jabatan;
			}
		}

		//get diteruskan dari $surat
		$namaJabatan = $surat['diteruskan'];        
		// foreach ($dikirimKepda as $key) {
		// 	if ($key != '') {
		// 		$jab = $this->db->get_where('t_jabatan', ['id' => $key])->row();
		// 		$namaJabatan[] = $jab->jabatan;
		// 	}
		// }

		$datana = array(
			'surat' => $surat['surat'],
			'catatan' => $surat['catatan'],
			'dikirimAwal' => $tujuanNa,
			'dikirimKepda' => $namaJabatan,
		);

		$mpdf = new \Mpdf\Mpdf();
		$data = $this->load->view('pdf/disposisi', $datana, TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output();

		// $this->load->view('pdf/disposisi', $datana, FALSE);
	}

}