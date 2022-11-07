<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemilik extends My_Controller
{

    public $template = "admin";
    public $loginBehavior = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tanah_Model', 'tanah');
        $this->load->model('Pemilik_Model', 'pemilik');
        $this->data['controller']  = strtolower(static::class);
    }

    public function index()
    {
        $this->data['title']    = "Data Tanah";
        $this->data['script']    = "page/admin/tanah/index.js";
        $this->renderTo("page/admin/tanah/index");
    }

    public function add()
    {
        $this->data['title']    = "Tambah Data Tanah";
        $this->data['script']    = "page/admin/tanah/add.js";

        $pemilik = $this->pemilik->get();
        $pemilik = array_map(function ($data) {
            return (object)
            [
                'id' => $data->id,
                'text'    => $data->nama
            ];
        }, $pemilik);

        $hak = get_enum_values('tanah', 'hak');
        $hak = array_map(function ($data) {
            return (object)
            [
                'id' => $data,
                'text'    => $data
            ];
        }, $hak);

        $status = get_enum_values('tanah', 'status');
        $status = array_map(function ($data) {
            return (object)
            [
                'id' => $data,
                'text'    => $data
            ];
        }, $status);

        $forms = [
            array('pemilik_id', 'select', $pemilik),
            array('alamat', 'textarea'),
            array('ukuran', 'number'),
            array('tahun_perolehan', 'year'),
            array('hak', 'select', $hak),
            array('tanggal', 'date'),
            array('nomor', 'text'),
            array('nib', 'text'),
            array('nomor_site_plan', 'text'),
            array('status', 'select', $status),
            array('harga', 'number'),
            array('plang_pemko', 'text'),
            array('keterangan', 'textarea'),
            array('catatan', 'textarea'),
            array('anggaran', 'number'),
        ];
        $this->data['controller']  = "tanah";
        $this->data['forms'] = $forms;
        $this->renderTo("page/admin/add");
    }
}
