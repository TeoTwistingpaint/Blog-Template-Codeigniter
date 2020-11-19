<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->model('menu');
		$data['menu'] = $this->menu->getMenu();

		$this->load->helper('url');

		$this->load->view('template/header', $data);
		$this->load->view('pages/home');
		$this->load->view('template/footer');
	}
}
