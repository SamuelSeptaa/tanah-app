<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends My_Controller
{

    public $template = "admin";
    public $loginBehavior = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pemilik_Model', 'pemilik');
        $this->data['controller']  = strtolower(static::class);
    }

    public function index()
    {
        $this->data['title']    = "Data User";
        $this->data['script']    = "page/admin/user/index.js";
        $this->renderTo("page/admin/user/index");
    }
    public function datatable()
    {
        $this->load->model('Dt_table/User_M', 'dt_user');
        $list = $this->dt_user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = '
                    <div class="btn-group">
                        <a class="btn btn-primary icons-action" href="' . base_url('user/detail/' . $pel->id) . '"><i class="mdi mdi-eye"></i></a>
                        <button type="button" class="btn btn-danger icons-action" onclick="deleteData(' . $pel->id . ')"><i class="mdi mdi-delete"></i></button>
                    </div>          
            ';
            $row[] = $pel->real_name;
            $row[] = $pel->email;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dt_user->count_all(),
            "recordsFiltered" => $this->dt_user->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add()
    {
        $this->data['title']    = "Tambah Data Pemilik";
        $this->data['script']    = "page/admin/pemilik/add.js";

        $forms = [
            array('nama', 'text'),
        ];
        $this->data['forms'] = $forms;
        $this->renderTo("page/admin/add");
    }

    private function _runValidation()
    {
        $errors = FALSE;
        $this->config->set_item('language', 'indonesian');

        $this->form_validation->set_rules('nama', 'Nama Pemilik', 'required|max_length[255]');

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
        $this->pemilik->create($data);

        return $this->responseJSON(200, [
            'status' => 'Success',
            'message'   => [
                'title' => 'Berhasil',
                'body'  => 'Berhasil menambahkan data'
            ]
        ]);
    }
    public function detail($id)
    {
        $this->data['title']    = "Detail Data Pemilik";
        $this->data['script']    = "page/admin/pemilik/detail.js";

        $detail = $this->pemilik->get(null, ['id' => $id], 1);

        if (!$detail)
            redirect('my404', 'refresh');
        $forms = [
            array('nama', 'text')
        ];

        $this->data['forms'] = $forms;
        $this->data['page'] = $detail;
        $this->renderTo("page/admin/detail");
    }

    public function ajaxEdit()
    {
        $error = $this->_runValidation();
        if ($error) {
            return $this->responseJSON(400, [
                'message' => 'Failed',
                'data' => $error
            ]);
        }

        $data = $this->input->post();
        $this->pemilik->update($data, $data['id']);

        return $this->responseJSON(200, [
            'status' => 'Success',
            'message'   => [
                'title' => 'Berhasil',
                'body'  => 'Berhasil mengubah data'
            ]
        ]);
    }

    public function ajaxDelete()
    {
        $id = $this->input->post('id');
        $this->db->delete('pemilik', ['id' => $id]);

        return $this->responseJSON(200, [
            'status' => 'Success',
            'message'   => [
                'title' => 'Berhasil',
                'body'  => 'Berhasil menghapus data'
            ]
        ]);
    }
}
