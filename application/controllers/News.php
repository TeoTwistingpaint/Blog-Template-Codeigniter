<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		$this->load->model('menu');
		$this->load->helper('url_helper');
	}

	public function index()
	{
		$data['menu'] = $this->menu->getMenu();
		$data['news'] = $this->news_model->get_news();

		$this->load->view('template/header', $data);
		$this->load->view('pages/news/news', $data);
		$this->load->view('template/footer');
	}

	public function view($slug = NULL)
	{
		$data['menu'] = $this->menu->getMenu();
		$data['news_item'] = $this->news_model->get_news($slug);

		if (empty($data['news_item'])) {
			show_404();
		}

		$data['title'] = $data['news_item']['title'];

		$this->load->view('template/header', $data);
		$this->load->view('pages/news/view', $data);
		$this->load->view('template/footer');
	}

	private function upload()
	{
		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 2000;
		$config['max_width'] = 1500;
		$config['max_height'] = 1500;
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('news_image')) {
			$error = $this->upload->display_errors();

			//$this->load->view('imageupload_form', $error);
			$info = array(
				'status' => false,
				'message' => $error
			);
			return $info;
		} else {
			$data = $this->upload->data();

			//$this->load->view('imageupload_success', $data);
			$info = array(
				'status' => true,
				'message' => $data
			);
			return $info;
		}
	}

	public function create()
	{
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->helper('url', 'form');

		$data['menu'] = $this->menu->getMenu();

		$data['title'] = 'Create a news item';

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('template/header', $data);
			$this->load->view('pages/news/create');
			$this->load->view('template/footer');
		} else {
			$upload_res = $this->upload();
			if ($upload_res['status'] === true) {

				$this->news_model->set_news($upload_res['message']);
				$slug = url_title($this->input->post('title'), 'dash', TRUE);
				$data['slug'] = $slug;

				$this->load->view('template/header', $data);
				$this->load->view('pages/news/success', $data);
				$this->load->view('template/footer');
			} else {
				$data['error'] = $upload_res['message'];
				$this->load->view('template/header', $data);
				$this->load->view('pages/news/create');
				$this->load->view('template/footer');
			}
		}
	}
}
