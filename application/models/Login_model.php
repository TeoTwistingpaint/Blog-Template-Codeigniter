<?php

class Login_model extends CI_Model {

    public function login($username, $password) {
        $this->db->select('*');
        $this->db->from('utenti');
        $this->db->where('utente', $username);
        $this->db->where('password', $password);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

}