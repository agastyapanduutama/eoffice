<?php

class M_suratkeluarinternal extends CI_Model
{

    public $tipeKirim = null;
    public $tipe = null;
    public $upk;
    public $tatusPengiriman = null;

    function __construct()
    {
        parent::__construct();
        $this->table = "t_suratkeluar";
        $this->table1 = "t_jenis";
        $this->table2 = "t_disposisi";
        $this->column_order = array(null, 'no_surat', 'tanggal_dibuat');
        $this->column_search = array('no_surat', 'tanggal_dibuat');
        $this->order = array('t_suratkeluar.id' => 'desc');
    }

    private function _get_datatables_query()
    {

        $this->db->select('*,t_suratkeluar.id, t_jenis.jenis, t_suratkeluar.status');
        $this->db->from($this->table);
        $this->db->join('t_upk', 't_upk.id = t_suratkeluar.asal_surat', 'LEFT');
        $this->db->join('t_jenis', 't_jenis.id = t_suratkeluar.jenis_surat', 'LEFT');
        $this->db->join('t_sifat', 't_sifat.id = t_suratkeluar.sifat_surat', 'LEFT');
        $this->db->where('t_suratkeluar.arsipkan', '0');
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $this->db->where('t_suratkeluar.status', '1');
        $this->db->where('internal', '1');

        if ($this->tatusPengiriman != 3) {
            $this->db->where('t_suratkeluar.status_pengiriman', $this->tatusPengiriman);
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
        // $cek = $this->db->get_where('t_disposisi', array('id_upk' => $this->upk))->num_rows();
        // if ($cek == 1) {
        // return false;
        // } else {
        $this->db->insert('t_disposisi', $data);
        return $this->cekPerubahan();
        // }
    }

    function get($id)
    {
        $this->db->select('t_suratkeluar.*,t_user.nama_user, t_revisi.*, t_revisi.id_user_revisi, t_jenis.kode_jenis, t_suratkeluar.id_user');
        $this->db->from($this->table);
        $this->db->join('t_revisi', 't_revisi.id_suratkeluar = t_suratkeluar.id', 'left');
        $this->db->join('t_jenis', 't_suratkeluar.jenis_surat = t_jenis.id');
        $this->db->join('t_user', 't_user.id = t_revisi.id_user_revisi', 'left');
        $this->db->where($this->req->encKey("t_suratkeluar.id"), $id);
        $this->db->order_by('t_revisi.id', 'desc');
        $data = $this->db->get()->row();
        return $data;
        // $this->req->print($data);
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

    function data_aksi()
    {
        $this->db->select('*');
        $this->db->from('t_aksi');
        $this->db->order_by('aksi', 'ASC');
        $this->db->where('id_upk', $this->session->userdata('upk'));
        $query = $this->db->get();
        return $query->result();
    }

    function data_sifat()
    {
        $this->db->select('*');
        $this->db->from('t_sifat');
        $this->db->order_by('sifat', 'ASC');
        $this->db->where('id_upk', $this->session->userdata('upk'));
        $query = $this->db->get();
        return $query->result();
    }

    function data_jenis()
    {
        $this->db->select('*');
        $this->db->from('t_jenis');
        $this->db->order_by('jenis', 'ASC');
        $this->db->where('id_upk', $this->session->userdata('upk'));
        $query = $this->db->get();
        return $query->result();
    }

    function data_user()
    {
        $this->db->select('t_user.id as value, nama_user as name, t_jabatan.jabatan');
        $this->db->from('t_user');
        $this->db->join('t_jabatan', 't_jabatan.id = t_user.id_jabatan', 'left');
        $this->db->where('t_user.id !=', $this->session->userdata('jabatan'));
        $this->db->where('t_user.id_upk', $this->session->userdata('upk'));
        $this->db->where('t_user.level', 3);
        $this->db->where('kode_jabatan != ', 'PBNYSN');
        $this->db->where('id_jabatan !=', $this->session->userdata('jabatan'));
        $this->db->order_by('t_jabatan.jabatan', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function data_upk()
    {
        $this->db->select('id, upk');
        $this->db->from('t_upk');
        $this->db->where('id !=', $this->session->userdata('upk'));
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function data_jabatan()
    {
        $this->db->select('id as value, jabatan as name');
        $this->db->from('t_jabatan');
        $this->db->order_by('id', 'ASC');
        $this->db->where('id_upk', $this->session->userdata('upk'));
        $this->db->where('id !=', $this->session->userdata('jabatan'));
        $this->db->where('kode_jabatan != ', 'PBNYSN');
        $query = $this->db->get();
        return $query->result();
    }

    function data_pembina()
    {
        $this->db->select('t_user.id, jabatan, nama_user');
        $this->db->from('t_user');
        $this->db->join('t_jabatan', 't_jabatan.id = t_user.id_jabatan', 'left');
        $this->db->where('t_user.id_upk', $this->session->userdata('upk'));
        $this->db->where('kode_jabatan', 'PBNYSN');
        $query = $this->db->get();
        return $query->result();
    }

    function data_staff($jabatan)
    {
        $this->db->select('id, nama_user as name');
        $this->db->from('t_user');
        $this->db->order_by('name', 'ASC');
        $this->db->where('id_upk', $this->session->userdata('upk'));
        $this->db->where('id_jabatan', $jabatan);
        $query = $this->db->get();
        return $query->result();
    }

    //  function data_jabatan($where = null)
    // {
    //     $this->db->select('*');
    //     $this->db->from('t_jabatan');
    //     $this->db->join('t_upk', 't_upk.id = t_jabatan.id_upk', 'left');
    //     if($where != null)
    //         $this->db->where('t_upk.upk',$where);
    //     $this->db->order_by('t_jabatan.id', 'desc');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    function getNamaUPK()
    {
        error_reporting(0);
        if ($_SESSION['kodeUpk']) {
            return $_SESSION['kodeUpk'];
        } else {
            $upk = $this->db->get_where('t_upk', ['id' => $_SESSION['upk']])->row();
            $_SESSION['kodeUpk'] = $upk->kode_upk;
            return $upk->kode_upk;
        }
    }

    function getKetua()
    {
        $yayasan = $this->db->get_where('t_config', ['config' => 'ketua_yayasan'])->row();
        $upk = $this->db->get_where('t_upk', ['id' => $this->session->upk])->row();
        return [
            'upk' => $upk->ketua_upk,
            'yayasan' => $yayasan->value
        ];
    }

    function getNomorUrut()
    {

        $urut = "0000";
        $where = [
            'DATE_FORMAT(tanggal_dibuat, "%Y") = ' => date('Y', time())
        ];

        $bul = date('n');

        switch ($bul) {
            case 1:
                $bulan = "I";
                break;
            case 2:
                $bulan = "II";
                break;
            case 3:
                $bulan = "III";
                break;
            case 4:
                $bulan = "IV";
                break;
            case 5:
                $bulan = "V";
                break;
            case 6:
                $bulan = "VI";
                break;
            case 7:
                $bulan = "VII";
                break;
            case 8:
                $bulan = "VIII";
                break;
            case 9:
                $bulan = "IX";
                break;
            case 10:
                $bulan = "X";
                break;
            case 11:
                $bulan = "XI";
                break;
            case 12:
                $bulan = "XII";
                break;
        }
        $this->db->select("no_surat");
        $this->db->from($this->table);
        $this->db->distinct();
        // $nomor = $this->db->get()->num_rows();
        $this->db->where($where);
        $nomor = $this->db->get()->num_rows();
        $panjang = strlen($nomor);
        $urut_ = substr($urut, 0, strlen($urut) - $panjang);
        $format = $this->db->get_where('t_upk', ['id' => $this->session->upk])->row()->format_surat_keluar;
        // $urutna = 
        return [
            'FORMAT' => $format,
            'NO_URUT' => "$urut_" . ($nomor + 1),
            'TAHUN' => date('Y', time()),
            'BULAN' => $bulan,
            'UPK'   => $this->getNamaUPK()
        ];
    }

    public function data_surat($id)
    {
        $this->db->select('*');
        $this->db->from('t_suratkeluar');
        $this->db->join('t_upk', 't_upk.id = t_suratkeluar.id_upk', 'left');
        $this->db->join('t_jenis', 't_jenis.id = t_suratkeluar.jenis_surat', 'left');
        $this->db->join('t_user', 't_user.id = t_suratkeluar.id_user', 'left');
        // $this->db->join('t_aksi', 't_aksi.id = t_suratkeluar.id_ak', 'left');
        // $this->db->join('t_user', 't_user.id = t_suratkeluar.column', 'left');
        $this->db->where($this->req->encKey('t_suratkeluar.id'), $id);
        // $this->db->where('t_suratkeluar.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function ambilData($list)
    {
        $this->db->select('*');
        $this->db->from('t_user');
        $this->db->join('t_jabatan', 't_jabatan.id = t_user.id_jabatan', 'left');
        $this->db->where('t_user.id', $list);
        return $query = $this->db->get();
    }
}
