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
		$data['edit_url'] = "/news/edit?news_slug=" . $data['news_item']['slug'];

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
		// Accedo alla view solo se loggato
		if (!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}

		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->helper('url', 'form');

		$data['menu'] = $this->menu->getMenu();

		$data['title'] = 'Crea una nuova news:';

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'Text');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('template/header', $data);
			$this->load->view('pages/news/create');
			$this->load->view('template/footer');
		} else {

			// Verifico se è stata caricata anche l'immagine per la news
			if ($_FILES and $_FILES['news_image']['name']) {
				$upload_res = $this->upload();

				// Se l'upload del file è andato a buon fine, salvo nel db e rimando a view di success
				if ($upload_res['status'] === true) {

					$slug_def = $this->news_model->set_news($upload_res['message']);
					$data['slug'] = $slug_def != false ? $slug_def : "error";

					$this->load->view('template/header', $data);
					$this->load->view('pages/news/success', $data);
					$this->load->view('template/footer');
				}
				// Altrimenti, verifica dati inseriti
				else {
					$data['error'] = $upload_res['message'];
					$this->load->view('template/header', $data);
					$this->load->view('pages/news/create');
					$this->load->view('template/footer');
				}
			}

			// Se non è stata caricata, salvo i dati nel db senza img
			else {
				$slug_def = $this->news_model->set_news();
				$data['slug'] = $slug_def != false ? $slug_def : "error";

				$this->load->view('template/header', $data);
				$this->load->view('pages/news/success', $data);
				$this->load->view('template/footer');
			}
		}
	}

	public function delete($news_slug = NULL)
	{
		// Accedo alla view solo se loggato
		if (!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}

		$this->load->helper('url');

		$data['menu'] = $this->menu->getMenu();

		// Recupero il parametro dall'url per recuperare i dati della news
		$news_slug = isset($_GET['news_slug']) && ($_GET['news_slug'] != NULL || $_GET['news_slug'] != "") ? $_GET['news_slug'] : NULL;
		$data['news_item'] = $this->news_model->get_news($news_slug);

		if (empty($data['news_item']) || $news_slug === NULL) {
			show_404();
		}

		// Passo al model i dati della news per eliminarla
		if ($this->news_model->delete_news($data['news_item'])) {
			$data['result'] = array(
				"message" => "News eliminata correttamente.",
				"status" => true
			);
		} else {
			$data['result'] = array(
				"message" => "Errore durante l'eliminazione, riprova più tardi.",
				"status" => true
			);
		}

		// Recupero le news da mostrare in elenco pagina
		$data['news'] = $this->news_model->get_news();

		$this->load->view('template/header', $data);
		$this->load->view('pages/news/news', $data);
		$this->load->view('template/footer');
	}

	public function edit()
	{
		// Accedo alla view solo se loggato
		if (!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}

		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->helper('url', 'form');

		$data['menu'] = $this->menu->getMenu();

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'Text');

		if ($this->form_validation->run() === FALSE) {

			// Recupero il parametro dall'url per mostrare i dati della news
			$news_slug = isset($_GET['news_slug']) && ($_GET['news_slug'] != NULL || $_GET['news_slug'] != "") ? $_GET['news_slug'] : NULL;
			$data['news_item'] = $this->news_model->get_news($news_slug);

			if (empty($data['news_item']) || $news_slug === NULL) {
				show_404();
			}

			$this->load->view('template/header', $data);
			$this->load->view('pages/news/edit', $data);
			$this->load->view('template/footer');
		} else {

			// Verifico se è stata caricata anche l'immagine per la news
			if ($_FILES and $_FILES['news_image']['name']) {
				$upload_res = $this->upload();

				// Se l'upload del file è andato a buon fine, salvo nel db e rimando a view di success
				if ($upload_res['status'] === true) {

					$slug_def = $this->news_model->update_news($upload_res['message']);
					if ($slug_def != false) {
						$data['result'] = array(
							"message" => "News aggiornata con successo.",
							"status" => true
						);
					} else {
						$data['result'] = array(
							"message" => "Errore durante l'aggiornamento, riprova più tardi.",
							"status" => false
						);
					}

					$data['news_item'] = $this->news_model->get_news($slug_def);

					if (empty($data['news_item']) || $slug_def === NULL) {
						show_404();
					}

					$data['slug'] = $slug_def;

					$this->load->view('template/header', $data);
					$this->load->view('pages/news/edit', $data);
					$this->load->view('template/footer');
				}
				// Altrimenti, verifica dati inseriti
				else {
					$data['error'] = $upload_res['message'];
					$this->load->view('template/header', $data);
					$this->load->view('pages/news/edit', $data);
					$this->load->view('template/footer');
				}
			}
			// Se non è stata caricata, salvo i dati nel db senza img
			else {
				// Verifico se l'update è andato a buon fine
				$slug_def = $this->news_model->update_news();
				if ($slug_def != false) {
					$data['result'] = array(
						"message" => "News aggiornata con successo.",
						"status" => true
					);
				} else {
					$data['result'] = array(
						"message" => "Errore durante l'aggiornamento, riprova più tardi.",
						"status" => false
					);
				}

				$data['news_item'] = $this->news_model->get_news($slug_def);

				if (empty($data['news_item']) || $slug_def === NULL) {
					show_404();
				}

				$data['slug'] = $slug_def;

				$this->load->view('template/header', $data);
				$this->load->view('pages/news/edit', $data);
				$this->load->view('template/footer');
			}
		}
	}

	public function delimage($news_slug = NULL)
	{
		// Accedo alla view solo se loggato
		if (!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}

		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->helper('url', 'form');

		$data['menu'] = $this->menu->getMenu();
		$data['title'] = 'Modifica News:';

		// Recupero il parametro dall'url per verificare esista la news con l'url passato
		$news_slug = isset($_GET['news_slug']) && ($_GET['news_slug'] != NULL || $_GET['news_slug'] != "") ? $_GET['news_slug'] : NULL;
		$data['news_item'] = $this->news_model->get_news($news_slug);

		if (empty($data['news_item']) || $news_slug === NULL) {
			show_404();
		}

		// Se esiste il record nel db con l'immagine, passo al model
		if ($data['news_item']['image'] != NULL && $data['news_item']['image'] != "") {

			// Se l'immagine è rimossa con successo, return
			if ($this->news_model->delete_image($news_slug)) {
				$data['result'] = array(
					"message" => "Immagine rimossa correttamente.",
					"status" => true
				);

				// Recupero i dati della news aggiornata (senza img)
				$data['news_item'] = $this->news_model->get_news($news_slug);

				$this->load->view('template/header', $data);
				$this->load->view('pages/news/edit', $data);
				$this->load->view('template/footer');
			}
			// Altrimenti ritorno alla view con errore
			else {
				$data['result'] = array(
					"message" => "Errore durante l'eliminazione, riprova più tardi.",
					"status" => false
				);

				$this->load->view('template/header', $data);
				$this->load->view('pages/news/edit', $data);
				$this->load->view('template/footer');
			}
		}
		// Altrimenti ritorno alla view con errore
		else {
			$data['result'] = array(
				"message" => "Non è associata alcuna immagine a questa news.",
				"status" => false
			);

			$this->load->view('template/header', $data);
			$this->load->view('pages/news/edit', $data);
			$this->load->view('template/footer');
		}
	}
}
