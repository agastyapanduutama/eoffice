<?php

class M_config extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "t_config";
    }

    function get($config)
    {
        $data = $this->db->get_where($this->table, array("config" => $config))->row();
        return $data->value;
    }

    function getExtra($config)
    {
        $data = $this->db->get_where($this->table, array("config" => $config))->row();
        return $data->extra;
    }

    function getId($config)
    {
        $data = $this->db->get_where($this->table, array("config" => $config))->row();
        return $data->id;
    }

    function getData($config)
    {
        return $this->db->get_where($this->table, array("config" => $config))->row();
    }

    function getHeader()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->like('config', 'header', 'after');
        return $this->db->get()->result();
    }

    function setConfig($config, $value)
    {
        $this->db->where("config", $config);
        $this->db->update($this->table, array('value' => $value));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insert_batch($data)
    {
        $this->db->insert_batch($this->table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    function edit($data, $id)
    {
        $this->db->where('md5(id)', $id);
        $this->db->update($this->table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete($id)
    {
        $this->db->where('md5(id)', $id);
        $this->db->delete($this->table);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function deleteConfig($kode)
    {
        $this->db->like('config', $kode . "-", 'after');
        $this->db->delete($this->table);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getKodeUpk($id)
    {
        $data = $this->db->get_where('t_upk', ['id' => $id])->row();
        return $data->kode_upk;
    }

    function getAllConfig($config)
    {
        if ($config == 'header') {
            $data = [
                'logo1' => [
                    'file' => $this->get('logo1'),
                    'id' => md5($this->getId('logo1'))
                ],
                'logo2' => [
                    'file' => $this->get('logo2'),
                    'id' => md5($this->getId('logo2'))
                ],
            ];
            return $data;
        }
        if ($config == 'konten') {
            # code...
        }
        if ($config == 'footer') {
            # code...
        }
        if ($config == 'about') {
            # code...
        }
    }

    function data_pegawai()
    {
        $this->db->select('*');
        $this->db->from('t_user');
        $this->db->order_by('nama_user', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getFormat()
    {
        $format = $this->db->get_where("t_upk", ['id' => $this->session->upk])->row();
        return [
            'suratMasuk' => $format->format_surat_masuk,
            'suratKeluar' => $format->format_surat_keluar,
        ];
    }
}

