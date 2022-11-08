<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends My_Controller
{
    public $template = "admin";
    public $loginBehavior = false;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Account_model', 'account');
    }

    public function index()
    {
        if (isLogin())
            redirect('dashboard');
        $this->load->view('page/login');
    }

    public function sign_in()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            $this->responseMethodPostOnly();
        $error = false;
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[100]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $error = true;
            $errors = [];
            foreach ($this->input->post() as $field => $value) {
                if (form_error($field)) {
                    $errors[] = [
                        'field' => $field,
                        'message' => trim(form_error($field, ' ', ' ')),
                    ];
                }
            }
        }
        if ($error) {
            return $this->responseJSON(400, [
                'message' => 'Failed',
                'data' => $errors
            ]);
        }

        $data = $this->input->post();
        $loginSuccess = $this->account->login($data);

        if (!$loginSuccess['status'])
            return $this->responseJSON(404, $loginSuccess);


        if ($this->input->post('remember_me') == 'on') {
            $this->load->helper('cookie');
            $cookie = random_string('alnum', 64);
            set_cookie('user-cookie', $cookie, time() + (86400 * 30));
            $this->account->updateCookie($cookie, $loginSuccess['data']->id);
        }

        $this->setSessionUserData($loginSuccess['data']);
        return $this->responseJSON(200, $loginSuccess['message']);
    }

    private function setSessionUserData($user)
    {
        $prefix = "app_";

        $userData = array();
        $userData[$prefix . "isLogin"]      = true;
        $userData[$prefix . "userId"]       = $user->id;
        $userData[$prefix . "nama"]         = $user->real_name;
        $userData[$prefix . "email"]        = $user->email;
        $this->session->set_userdata($userData);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->load->helper('cookie');
        delete_cookie('user-cookie');
        redirect('/');
    }
}
