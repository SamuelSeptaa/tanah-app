<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{

	protected $template = "app";
	protected $data = array();
	public $loginBehavior = true;

	public function __construct()
	{
		parent::__construct();

		if ($this->loginBehavior) {
			if (!isLogin()) redirect('/login');
		}
	}

	/**
	 * Fungsi untuk menampilkan view berdasarkan template yang ada
	 *
	 * @param string $filename
	 */
	protected function renderTo($filename = null)
	{
		$template = $this->load->view("template/" . $this->template, $this->data, true);

		$content = $this->load->view("/" . $filename, $this->data, true);

		exit(str_replace("{CONTENT}", $content, $template));
	}

	protected function responseJSON($status, $response)
	{
		return $this->output
			->set_content_type('application/json')
			->set_status_header($status)
			->set_output(json_encode($response));
	}

	protected function redirectIfNotLogin()
	{
		if (!isLogin()) redirect('/login');
	}
	protected function responseMethodPostOnly()
	{
		return $this->responseJSON(404, [
			'status'	=> 'Failed',
			'message'	=> [
				'title'	=> 'Failed',
				'body'	=> 'Only POST method allowed!'
			]
		]);
	}
}
