<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends My_Controller
{

    public $template = "admin";
    public $loginBehavior = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Account_model', 'account');
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
        $this->data['title']    = "Tambah Data User";
        $this->data['script']    = "page/admin/user/add.js";

        $forms = [
            array('real_name', 'text'),
            array('email', 'text'),
            array('password', 'password'),
            array('password_confirm', 'password'),
        ];
        $this->data['forms'] = $forms;
        $this->renderTo("page/admin/add");
    }

    private function _runValidation($is_update = false)
    {
        $errors = FALSE;
        $this->config->set_item('language', 'indonesian');

        $this->form_validation->set_rules('real_name', 'Nama Asli', 'required|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[255]');
        $this->form_validation->set_rules('password', 'Password', 'min_length[5]' . (!$is_update ? '|required' : ''));
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'min_length[5]|matches[password]' . (!$is_update ? '|required' : ''));
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
        $data['password']   = hashpassword($data['password_confirm']);
        unset($data['password_confirm']);

        $this->account->create($data);
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
        $this->data['title']    = "Detail Data User";
        $this->data['script']    = "page/admin/user/detail.js";

        $detail = $this->account->get(null, ['id' => $id], 1);

        if (!$detail)
            redirect('my404', 'refresh');
        $forms = [
            array('real_name', 'text'),
            array('email', 'text'),
            array('password', 'password'),
            array('password_confirm', 'password'),
        ];

        $this->data['forms'] = $forms;
        $this->data['page'] = $detail;
        $this->renderTo("page/admin/detail");
    }

    public function ajaxEdit()
    {
        $error = $this->_runValidation($is_update = true);
        if ($error) {
            return $this->responseJSON(400, [
                'message' => 'Failed',
                'data' => $error
            ]);
        }
        $data = $this->input->post();
        $data['password']   = hashpassword($data['password_confirm']);
        unset($data['password_confirm']);
        $this->account->updateuserByID($data, $data['id']);

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
        if ($id == 1)
            return $this->responseJSON(403, [
                'status' => 'Failed',
                'message'   => [
                    'title' => 'Failed',
                    'body'  => 'Forbidden'
                ]
            ]);
        $this->db->delete('user', ['id' => $id]);

        return $this->responseJSON(200, [
            'status' => 'Success',
            'message'   => [
                'title' => 'Berhasil',
                'body'  => 'Berhasil menghapus data'
            ]
        ]);
    }
}
