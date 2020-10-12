<?php

class C_notif extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata($this->session->token) == true) {
            redirect(base_url());
        }
        error_reporting(0);
        $this->table = 't_notif';
        $hoho = [];
        $sifat = $this->db->get_where('t_sifat', ['id_upk' => $this->session->upk])->result();
        foreach ($sifat as $key => $value) {
            // echo "$key => $value->id ";
            $hoho[$value->id] = $value->sifat;
        }
        $this->sifat = $hoho;
        // $this->req->print($this->sifat);
        // $this->req->print($this->session);
    }

    function getJenis($id)
    {
        $data = $this->db->get_where('t_jenis', ['id' => $id])->row();
        return $data->jenis;
    }

    function getDataSurat($table, $id)
    {
        $data = $this->db->get_where($table, ['id' => $id])->row();
        // $this->req->query();
        return [
            "idSurat" => $data->id,
            "sifat" => $data->sifat_surat,
            "waktu_dibuat" => $data->waktu_dibuat,
            "jenisSurat" => $this->getJenis($data->jenis_surat),
            "noSurat" => $data->no_surat,
        ];
    }

    function getNotif()
    {
        $jmlNotif = 0;
        $dataNa = [];
        $where = array(
            "opened" => "0",
            'id_user' => $this->session->id_user
        );

        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->order_by('id', 'DESC');
        $this->db->where($where);
        $this->db->limit(10, 0);
        $data = $this->db->get();

        foreach($data->result() as $key){
            if ($key->id_surat_masuk != null) {
                $dataSuratNa = $this->getDataSurat("t_surat", $key->id_surat_masuk);
                $idSuratnya = $dataSuratNa['idSurat'];
                $sifat = $dataSuratNa['sifat'];
                $waktu_dibuat = $dataSuratNa['waktu_dibuat'];
                $jenis = $dataSuratNa['jenisSurat'];
                $noSurat = $dataSuratNa['noSurat'];
                $dari = "1";
            } 
            if ($key->id_surat_keluar != null) {
                $dataSuratNa = $this->getDataSurat("t_suratkeluar", $key->id_surat_keluar);
                $idSuratnya = $dataSuratNa['idSurat'];
                $waktu_dibuat = $dataSuratNa['waktu_dibuat'];
                $sifat = $dataSuratNa['sifat'];
                $jenis = $dataSuratNa['jenisSurat'];
                $noSurat = $dataSuratNa['noSurat'];
                $dari = "2";
            }
            if ($key->id_revisi != null) {
                $dataSuratNa = $this->getDataSurat("t_suratkeluar", $key->id_revisi);
                $idSuratnya = $dataSuratNa['idSurat'];
                $waktu_dibuat = $dataSuratNa['waktu_dibuat'];
                $sifat = $dataSuratNa['sifat'];
                $jenis = $dataSuratNa['jenisSurat'];
                $noSurat = $dataSuratNa['noSurat'];
                $dari = "3";
            }
            
            $dataNa[] = [
                'idNotif' => $this->req->acak($key->id),
                'idSurat' => $idSuratnya,
                'type' => $key->tipe,
                'dari' => $dari,
                'sifat' => $this->sifat[$sifat],
                'tanggal' => $waktu_dibuat,
                'jenis' => $jenis,
                'noSurat' => $noSurat,
                'idUser' => $key->id_user,
                'opened' => $key->opened
            ];
            if ($key->opened == 0) {
                $jmlNotif++;
            }
        }
        $dataNotif = [
            'count' => $jmlNotif,
            'data' => $dataNa
        ];
        echo json_encode($dataNotif);
    }

    function getNotif1($limit, $from)
    {
        $jmlNotif = 0;
        $dataNa = [];
        $where = array(
            'id_user' => $this->session->id_user
        );

        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->order_by('opened', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->where($where);
        $this->db->limit($limit, $from);
        $data = $this->db->get();

        foreach ($data->result() as $key) {
            if ($key->id_surat_masuk != null) {
                $dataSuratNa = $this->getDataSurat("t_surat", $key->id_surat_masuk);
                $idSuratnya = $dataSuratNa['idSurat'];
                $sifat = $dataSuratNa['sifat'];
                $waktu_dibuat = $dataSuratNa['waktu_dibuat'];
                $jenis = $dataSuratNa['jenisSurat'];
                $noSurat = $dataSuratNa['noSurat'];
                $dari = "1";
            }
            if ($key->id_surat_keluar != null) {
                $dataSuratNa = $this->getDataSurat("t_suratkeluar", $key->id_surat_keluar);
                $idSuratnya = $dataSuratNa['idSurat'];
                $waktu_dibuat = $dataSuratNa['waktu_dibuat'];
                $sifat = $dataSuratNa['sifat'];
                $jenis = $dataSuratNa['jenisSurat'];
                $noSurat = $dataSuratNa['noSurat'];
                $dari = "2";
            }
            if ($key->id_revisi != null) {
                $dataSuratNa = $this->getDataSurat("t_suratkeluar", $key->id_revisi);
                $idSuratnya = $dataSuratNa['idSurat'];
                $waktu_dibuat = $dataSuratNa['waktu_dibuat'];
                $sifat = $dataSuratNa['sifat'];
                $jenis = $dataSuratNa['jenisSurat'];
                $noSurat = $dataSuratNa['noSurat'];
                $dari = "3";
            }

            $dataNa[] = [
                'idNotif' => $this->req->acak($key->id),
                'idSurat' => $idSuratnya,
                'type' => $key->tipe,
                'dari' => $dari,
                'sifat' => $this->sifat[$sifat],
                'tanggal' => $waktu_dibuat,
                'jenis' => $jenis,
                'noSurat' => $noSurat,
                'idUser' => $key->id_user,
                'opened' => $key->opened
            ];
            if ($key->opened == 0) {
                $jmlNotif++;
            }
        }
        $dataNotif = [
            'count' => $jmlNotif,
            'data' => $dataNa
        ];
        echo json_encode($dataNotif);
    }


    function all($id = null){
        
        $data = array(
            'title'  => 'Notifikasi',
            'menu' => 'notif',
            'script' => 'notif',
            'konten' => 'admin/notif/all',
            'itemNotif' => $id
        );
        
        $this->load->view('admin/templates/templates' ,$data, FALSE);
        
    }
    
    function getData($table, $id)
    {
        return $this->db->get_where($table, ['id' => $id])->row();
    }

    function getAsalSurat($id)
    {
        return $this->db->get_where("t_upk", ['id' => $id])->row()->upk;
    }

    function getPengirim($id)
    {
        return $this->db->get_where("t_user", ['id' => $id])->row()->nama_user;
    }

    function get($id)
    {
        $this->db->where($this->req->id($id));
        $this->db->update($this->table, ['opened' => 1]);
        $data = $this->db->get_where($this->table, $this->req->id($id))->row();
        if ($data->id_surat_keluar != null) {
            $dataSurat = $this->getData("t_suratkeluar", $data->id_surat_keluar);
            $asalSurat = $this->getAsalSurat($dataSurat->asal_surat);
            $jenis = $this->getJenis($dataSurat->jenis_surat);
            $status = 2;
        }
        if ($data->id_surat_masuk != null) {
            $dataSurat = $this->getData("t_surat", $data->id_surat_masuk);
            $asalSurat = $dataSurat->asal_surat;
            $jenis = $this->getJenis($dataSurat->jenis_surat);
            $status = 1;
        }
        if ($data->id_revisi != null) {
            $dataSurat = $this->getData("t_suratkeluar", $data->id_revisi);
            $asalSurat = $this->getAsalSurat($dataSurat->asal_surat);
            $jenis = $this->getJenis($dataSurat->jenis_surat);
            $status = 3;
        }
        // $this->req->query();


        $dataNotif = [
            "noSurat" => $dataSurat->no_surat,
            "tanggal" => $dataSurat->tanggal_dibuat,
            "perihal" => $dataSurat->perihal,
            "asal" => $asalSurat,
            "jenis" => $jenis,
            "sifat" => $this->sifat[$dataSurat->sifat_surat],
            "pengirim" => $this->getPengirim($dataSurat->id_user),
            "status" => $status
        ];

        echo json_encode($dataNotif);
    }


}


?>