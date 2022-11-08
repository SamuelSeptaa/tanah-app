<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My404 extends My_Controller
{

    public $template = "admin";
    public $loginBehavior = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('page/error/error-404');
    }
}
