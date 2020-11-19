<?php

class About extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('menu');
	}

	public function index()
	{
		$data['menu'] = $this->menu->getMenu();

		$this->load->helper('url');

		$this->load->view('template/header', $data);
		$this->load->view('pages/about');
		$this->load->view('template/footer');
	}
}
