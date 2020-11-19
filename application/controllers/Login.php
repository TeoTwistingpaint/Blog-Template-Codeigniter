<?php

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'username', TRUE);
		$this->load->model('menu');
		$this->load->helper('url_helper');
		$this->load->library('form_validation');
	}

	public function index()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('news/create', 'refresh');
		} else {
			$data = array();
			$data['titolo'] = 'Login';
			$data['menu'] = $this->menu->getMenu();
			$this->load->view('template/header', $data);
			$this->load->view('pages/login', $data);
			$this->load->view('template/footer');
		}
	}

	public function doLogin()
	{
		$data['menu'] = $this->menu->getMenu();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|sha1|callback_check_database');
		if ($this->form_validation->run() == FALSE) {
			$data = array();
			$data['titolo'] = 'Login';
			$data['menu'] = $this->menu->getMenu();
			$this->load->view('template/header', $data);
			$this->load->view('pages/login', $data);
			$this->load->view('template/footer');
		} else {
			redirect('news/create', 'refresh');
		}
	}

	function check_database($password)
	{
		$username = $this->input->post('username');
		$result = $this->username->login($username, $password);
		if ($result) {
			$sess_array = array();
			foreach ($result as $row) {
				$sess_array = array(
					'id' => $row->id,
					'username' => $row->utente
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return FALSE;
		}
	}

	public function logout() {
        session_start();
        $this->session->unset_userdata('logged_in');
        redirect('login');
    }
}
