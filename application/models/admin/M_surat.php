<?php

class M_surat extends CI_Model
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
        $this->column_order = array(null, 'no_surat', 'tanggal_dibuat');
        $this->column_search = array('no_surat', 'tanggal_dibuat');
        $this->order = array('t_surat.id' => 'desc');
    }

    private function _get_datatables_query()
    {

        $this->db->distinct('');
        $this->db->select('t_surat.no_surat, t_surat.*,t_surat.id, t_jenis.jenis, t_surat.status_suratmasuk, t_surat.arsipkan, t_aksi.aksi, t_disposisi.user_tujuan, t_disposisi.jabatan_terkait, t_disposisi.status as sts');
        $this->db->from($this->table);
        $this->db->join('t_jenis', 't_jenis.id = t_surat.jenis_surat', 'left');
        $this->db->join('t_aksi', 't_aksi.id = t_surat.aksi_surat', 'left');
        $this->db->join('t_disposisi', 't_disposisi.id_surat = t_surat.id', 'left');
        $this->db->where('t_surat.id_upk', $this->session->upk);
        $this->db->where('arsipkan', '0');

        // Jika User
        if ($this->tipe == 'user') {
            $this->db->like('t_surat.tujuan_kirim', $this->session->userdata('id_user'));
            $this->db->or_like('t_surat.aksi_kirim', $this->session->userdata('jabatan'));
            $this->db->or_like('t_disposisi.user_tujuan', $this->session->userdata('jabatan'));
        }

        // Jika adminsurat
        if ($this->tipe == 'adminsurat') {
            $this->db->like('t_surat.tujuan_kirim', $this->session->userdata('id_user'));
        }

        // Buat Surat masuk untuk Adminpersuratan
        if ($this->tipe == 'masuk') {
            $this->db->where('t_surat.id_user', $this->session->userdata('id_user'));
        }

        if ($this->tipe != null) {
            // $this->db->group_start();
            // $this->db->or_like('t_surat.aksi_kirim', $this->session->userdata('jabatan'));
            // $this->db->or_like('t_disposisi.user_tujuan', $this->session->userdata('jabatan'));
            // $this->db->where('t_surat.disposisi', '2');
            // $this->db->group_end();
            // $this->db->or_like('t_disposisi.user_tujuan', $this->session->userdata('jabatan'));
            // $this->db->where('status_suratmasuk', '1');
            // $this->db->where('status_suratmasuk', '0');
        }

        if ($this->tipeKirim != NULL) {
            $this->db->where('t_surat.jenis_kirim', $this->tipeKirim);
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
        // $this->db->where('t_surat.arsipkan', '0');
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
        $this->db->select('*, t_surat.id as id_suratna, t_disposisi.jabatan_terkait');
        $this->db->from('t_surat');
        $this->db->join('t_disposisi', 't_disposisi.id_surat = t_surat.id', 'left');
        // $this->db->join('t_disposisi', 't_disposisi.id_surat =' . $this->req->encKey('t_surat.id'), 'left');
        $this->db->where('t_surat.id', $id);
        $this->db->order_by('t_disposisi.id', 'desc');
        return $this->db->get()->row();
    }

    function update($data, $where)
    {
        $this->db->where($where);
        $this->db->update('t_surat', $data);
        return $this->cekPerubahan();
    }

    function updateDisposisi($data, $where)
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

    // function data_jabatan()
    // {
    //     $this->db->select('*');
    //     $this->db->from('t_jabatan');
    //     $this->db->order_by('jabatan', 'ASC');
    //     $this->db->where('id_upk', $this->session->userdata('upk'));
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    function data_surat($id)
    {
        $this->db->select('*');
        $this->db->from('t_surat');
        $this->db->order_by('id', 'desc');
        $this->db->where('id', $id);
        $this->db->where('id_upk', $this->session->userdata('upk'));
        $query = $this->db->get();
        return $query->result();
    }


    function data_disposisi($id)
    {

        $this->db->select('*');
        $this->db->from('t_surat');
        $this->db->join('t_disposisi', 't_disposisi.id_surat = t_surat.id', 'left');
        $this->db->join('t_jabatan', 't_jabatan.id = t_surat.aksi_kirim', 'left');
        $this->db->join('t_aksi', 't_aksi.id = t_surat.aksi_surat', 'left');
        $this->db->where('t_surat.id', $id);
        $this->db->order_by('t_disposisi.id', 'desc');
        $surat = $this->db->get()->row();

        //get catatan sama disposisi
        $cacatan = $this->db->select("nama_user, jabatan, catatan, isi_disposisi as disposisi")->from("t_disposisi")
            ->join('t_surat', 't_surat.id = t_disposisi.id_surat')
            ->join('t_user', 't_user.id = t_disposisi.id_user')
            ->join('t_jabatan', 't_jabatan.id = t_user.id_jabatan')
            ->where(['no_surat' => $surat->no_surat])
            ->get()->result();

        //get diteruskan
        $diteruskan = $this->db->select("jabatan")->from("t_disposisi")
            ->join('t_surat', 't_surat.id = t_disposisi.id_surat')
            ->join('t_jabatan', 't_jabatan.id = t_disposisi.jabatan_terkait')
            ->where(['no_surat' => $surat->no_surat])
            ->get()->result();

        return [
            'surat' => $surat,
            'catatan' => $cacatan,
            'diteruskan' => $diteruskan
        ];
    }

    function data_disposisi_internal($id)
    {
        $this->db->select('*');
        $this->db->from('t_surat');
        $this->db->join('t_disposisi', 't_disposisi.id_surat = t_surat.id', 'left');
        $this->db->join('t_jabatan', 't_jabatan.id = t_surat.aksi_kirim', 'left');
        $this->db->join('t_aksi', 't_aksi.id = t_surat.aksi_surat', 'left');
        $this->db->where('t_surat.id', $id);
        $this->db->order_by('t_disposisi.id', 'desc');
        $surat = $this->db->get()->row();

        //get catatan sama disposisi
        $cacatan = $this->db->select("nama_user, jabatan, catatan, isi_disposisi as disposisi")->from("t_disposisi")
            ->join('t_surat', 't_surat.id = t_disposisi.id_surat')
            ->join('t_user', 't_user.id = t_disposisi.id_user')
            ->join('t_jabatan', 't_jabatan.id = t_user.id_jabatan')
            ->where(['no_surat' => $surat->no_surat])
            ->get()->result();

        //get diteruskan
        $diteruskan = $this->db->select("jabatan")->from("t_disposisi")
            ->join('t_surat', 't_surat.id = t_disposisi.id_surat')
            ->join('t_jabatan', 't_jabatan.id = t_disposisi.jabatan_terkait')
            ->where(['no_surat' => $surat->no_surat])
            ->get()->result();

        // $this->req->print($diteruskan);

        return [
            'surat' => $surat,
            'catatan' => $cacatan,
            'diteruskan' => $diteruskan
        ];
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

    function data_upk()
    {
        $this->db->select('*');
        $this->db->from('t_upk');
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
        $this->db->where('id != ', $this->session->jabatan);
        $query = $this->db->get();
        return $query->result();
    }

    function data_jabatan_spesifik()
    {
        $this->db->select('t_user.id as value, jabatan as name, nama_user ');
        $this->db->from('t_user');
        $this->db->join('t_jabatan', 't_jabatan.id = t_user.id_jabatan', 'left');
        $this->db->order_by('t_jabatan.jabatan', 'ASC');
        $this->db->where('t_user.id_upk', $this->session->userdata('upk'));
        $this->db->where('t_user.id != ', $this->session->jabatan);
        $this->db->where('t_user.level', 3);
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

        // $nomor = $this->db->get_where($this->table, $where)->num_rows();
        $this->db->select("no_surat");
        $this->db->from($this->table);
        $this->db->distinct();
        // $nomor = $this->db->get()->num_rows();
        $this->db->where($where);
        $nomor = $this->db->get()->num_rows();
        $panjang = strlen($nomor);
        $urut_ = substr($urut, 0, strlen($urut) - $panjang);
        $format = $this->db->get_where('t_upk', ['id' => $this->session->upk])->row()->format_surat_masuk;
        return [
            'FORMAT' => $format,
            'NO_URUT' => "$urut_" . ($nomor + 1),
            'TAHUN' => date('Y', time()),
            'BULAN' => $bulan,
            'UPK'   => $this->getNamaUPK()
        ];
    }
}
