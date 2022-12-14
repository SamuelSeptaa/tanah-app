<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends My_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tanah_Model', 'tanah');
	}


	public function index()
	{
		$this->renderTo("page/index");
	}

	public function koordinat()
	{

		$status = $this->input->post('tipe_status');

		if ($status && $status != 'ALL')
			$location = $this->tanah->get(['latitude', 'longitude', 'nama', 'panjang', 'lebar', 'anggaran', 'status as status_type'], ['status' => $status]);
		else
			$location = $this->tanah->get(['latitude', 'longitude', 'nama', 'panjang', 'lebar', 'anggaran', 'status as status_type']);

		$location = array_map(function ($data) {
			return [
				'geometry' 		=> [
					'coordinates' => [$data->longitude, $data->latitude]
				],
				'properties'	=> [
					'nama'			=> $data->nama,
					'panjang'		=> $data->panjang,
					'lebar'			=> $data->lebar,
					'anggaran'		=> $data->anggaran,
					'status_type'	=> $data->status_type,
				]
			];
		}, $location);

		$geojson = [
			"type" => "FeatureCollection",
			"crs" => [
				"type" => "name",
				"properties" => [
					"name" => "undefined"
				]
			],
			"features"	=> $location
		];

		return $this->responseJSON(200, [
			'status'	=> 'Success',
			'message'	=> [
				'title' 	=> 'Success',
				'body'		=> 'koordinat didapatkan'
			],
			'data'		=> [
				'geojson' => $geojson
			]
		]);
	}
}
