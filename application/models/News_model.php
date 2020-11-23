<?php
class News_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_news($slug = FALSE)
    {
        if ($slug === FALSE) {
            $query = $this->db->get('news');
            return $query->result_array();
        }

        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }

    private function get_unique_slug($slug, $counter = 1)
    {
        // Verifico se lo slug è disponibile
        $slug_temp = $slug . "-" . $counter;
        $query = $this->db->query("SELECT * FROM news WHERE slug = '{$slug_temp}'");

        // Se non è disponibile, richiamo la funzione incrementando il counter
        if ($query->num_rows() != 0) {
            $counter += 1;
            return $this->get_unique_slug($slug, $counter);
        }
        // Altrimenti ritorno il nuovo slug
        else {
            return $slug_temp;
        }
    }

    public function delete_image($slug = NULL)
    {
        // Recupero le info della news
        $news_item = $this->get_news($slug);

        // Rimuovo l'img dal db
        $where_clause = array('id' => $news_item['id'], 'slug' => $slug);
        $update_data = array("image" => "");
        $this->db->where($where_clause);
        $res = $this->db->update("news", $update_data);

        // Se il campo viene aggiornato correttamente nel db e l'immagine viene rimossa dalla cartella, ritorno true
        if ($res && unlink("upload/" . $news_item['image'])) {
            return true;
        } else {
            return false;
        }
    }

    public function set_news($image_info = NULL)
    {
        $this->load->helper('url');

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        // Verifico se è stata caricata anche l'immagine
        $image_name = $image_info != NULL ? $image_info['raw_name'] . "." . $image_info['image_type'] : "";

        // Verifico se esiste già un record nel db con lo stesso slug
        $query = $this->db->query("SELECT * FROM news WHERE slug = '{$slug}'");

        if ($query->num_rows() != 0) {
            // Genero slug univoco
            $slug = $this->get_unique_slug($slug, 1);
        }

        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text'),
            'image' => $image_name
        );

        // Se insert va a buon fine, ritorna lo slug della news, altrimenti errore
        if ($this->db->insert('news', $data)) {
            return $slug;
        } else {
            return false;
        }
    }

    public function update_news($image_info = NULL)
    {
        $this->load->helper('url');

        // Recupero lo slug della news corrente
        $slug = $_GET['news_slug'];

        // Recupero le info della news
        $news_item = $this->get_news($slug);

        // Se il titolo della news è diverso, va aggiornato anche lo slug
        if ($this->input->post('title') != $news_item['title']) {

            // Verifico se il nuovo possibile slug della news esiste già nel db
            $slug_temp = url_title($this->input->post('title'), 'dash', TRUE);
            $query = $this->db->query("SELECT * FROM news WHERE slug = '{$slug_temp}'");

            // Se esiste già una news con questo slug, creo nuovo slug
            if ($query->num_rows() != 0) {
                // Genero slug univoco
                $slug = $this->get_unique_slug(url_title($this->input->post('title'), 'dash', TRUE), 1);
            }
            // Se lo slug non compare già nel db, posso usare il nuovo title della news
            else {
                $slug = url_title($this->input->post('title'), 'dash', TRUE);
            }
        }

        // Verifico se è stata caricata anche l'immagine
        $image_name = $image_info != NULL ? $image_info['raw_name'] . "." . $image_info['image_type'] : "";

        // Se non è stata caricata l'immagine, devo aggiornare solo gli altri parametri
        if ($image_name == "") {
            $image_name = $news_item['image'];
        }

        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text'),
            'image' => $image_name
        );

        $this->db->where('id', $news_item['id']);
        $this->db->update('news', $data);

        return $slug;
    }

    public function delete_news($news_item = NULL)
    {
        // Verifica se la news ha un'immagine associata
        if ($news_item['image'] != "" && $news_item['image'] != NULL) {

            // Cancello l'immagine dalla cartella, se andato a buon fine, proseguo con la cancellazione news
            if (unlink("upload/" . $news_item['image'])) {

                // Se cancello il record nel db, ritorna true
                if ($this->db->delete('news', array('id' => $news_item['id'], 'slug' => $news_item['slug']))) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        // Se non ha un'immagine associata, cancello dal db la news
        else {
            // Se cancello il record nel db, ritorna true
            if ($this->db->delete('news', array('id' => $news_item['id'], 'slug' => $news_item['slug']))) {
                return true;
            } else {
                return false;
            }
        }
    }
}
