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
            $row[]    = '<div class="text-center icons-action"><a href="' . base_url('tanah/detail/' . $pel->id) . '"><i class="mdi mdi-eye"></i></a>
                            <button class="custom-button" onclick="deleteData(' . $pel->id . ')"><i class="mdi mdi-delete"></i></button>
                        </div>';
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
            array('location', 'location'),
        ];
        $this->data['forms'] = $forms;
        $this->renderTo("page/admin/add");
    }

    public function detail($id)
    {
        $this->data['title']    = "Detail Data Tanah";
        $this->data['script']    = "page/admin/tanah/detail.js";

        $detail = $this->db->get_where('tanah', ['id' => $id])->row();

        if (!$detail)
            redirect('my404', 'refresh');

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
            array('location', 'location'),
        ];
        $this->data['forms'] = $forms;
        $this->data['page'] = $detail;


        $this->renderTo("page/admin/detail");
    }

    private function _runValidation()
    {
        $errors = FALSE;
        $this->config->set_item('language', 'indonesian');

        $this->form_validation->set_rules('pemilik_id', 'Pemilik', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('ukuran', 'Ukuran', 'required|is_natural');
        $this->form_validation->set_rules('tahun_perolehan', 'Tahun Perolehan', 'required|exact_length[4]');
        $this->form_validation->set_rules('hak', 'Hak', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('nomor', 'Nomor Sertifikat', 'required');
        $this->form_validation->set_rules('nib', 'NIB', 'required');
        $this->form_validation->set_rules('nomor_site_plan', 'Nomor Site Plan', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|is_natural');
        $this->form_validation->set_rules('plang_pemko', 'Plang Pemko', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('catatan', 'Catatan', 'required');
        $this->form_validation->set_rules('anggaran', 'Anggaran', 'required|is_natural');
        $this->form_validation->set_rules('longitudes', 'longitudes', 'required');
        $this->form_validation->set_rules('latitudes', 'latitudes', 'required');

        if ($this->form_validation->run() == FALSE) {
            $errors = [];
            foreach ($this->input->post() as $field => $value) {
                if (form_error($field)) {
                    $errors[] = [
                        'field'   => $field,
                        'message' => trim(form_error($field, ' ', ' ')),
                    ];
                };
            };
        };

        return $errors;
    }
    public function ajaxAdd()
    {
        $error = $this->_runValidation();
        if ($error) {
            return $this->responseJSON(400, [
                'message' => 'Failed',
                'data' => $error
            ]);
        }

        $data = $this->input->post();
        $this->tanah->create($data);

        return $this->responseJSON(200, [
            'status' => 'Success',
            'message'   => [
                'title' => 'Berhasil',
                'body'  => 'Berhasil menambahkan data'
            ]
        ]);
    }

    public function ajaxDelete()
    {
        $id = $this->input->post('id');
        $this->db->delete('tanah', ['id' => $id]);

        return $this->responseJSON(200, [
            'status' => 'Success',
            'message'   => [
                'title' => 'Berhasil',
                'body'  => 'Berhasil menghapus data'
            ]
        ]);
    }
}
