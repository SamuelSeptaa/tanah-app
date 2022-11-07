<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends My_Controller
{

    public $template = "admin";
    public $loginBehavior = true;

    public function __construct()
    {
        parent::__construct();
        $this->data['controller']  = strtolower(static::class);
    }

    public function index()
    {
        $this->data['title']    = "Dashboard";
        $this->renderTo("page/admin/index");
    }
}
