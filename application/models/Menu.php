<?php

class Menu extends CI_Model
{

    public function getMenu()
    {
        $this->db->select("*");
        $this->db->from("categories"); 
        $this->q = $this->db->get();
        if ($this->q->num_rows() > 0) {
           return $this->q->result_array();
        }
    }
}
