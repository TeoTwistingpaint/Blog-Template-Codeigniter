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

    public function set_news($image_info = NULL)
    {
        $this->load->helper('url');

        $slug = url_title($this->input->post('title'), 'dash', TRUE);
        $image_name = $image_info['raw_name'] . "." . $image_info['image_type'];

        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text'),
            'image' => $image_name
        );

        return $this->db->insert('news', $data);
    }
}
