<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tanah extends My_Controller
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

    public function datatable()
    {
        $this->load->model('Dt_table/Tanah_M', 'dt_tanah');
        $list = $this->dt_tanah->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[]    = '<div class="text-center icons-action"><a href="' . base_url('tanah/detail/' . $pel->id) . '"><i class="mdi mdi-eye"></i></a></div>';
            $row[] = $pel->nama;
            $row[] = $pel->alamat;
            $row[] = $pel->ukuran;
            $row[] = $pel->tahun_perolehan;
            $row[] = $pel->nomor;
            $row[] = $pel->nib;
            $row[] = $pel->nomor_site_plan;
            $row[] = currencyIDR($pel->harga);
            $row[] = $pel->keterangan;
            $row[] = currencyIDR($pel->anggaran);

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dt_tanah->count_all(),
            "recordsFiltered" => $this->dt_tanah->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
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
        $this->data['forms'] = $forms;
        $this->renderTo("page/admin/add");
    }
}
