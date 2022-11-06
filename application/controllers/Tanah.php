<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tanah extends My_Controller
{

    public $template = "admin";
    public $loginBehavior = true;

    public function __construct()
    {
        parent::__construct();
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
}
