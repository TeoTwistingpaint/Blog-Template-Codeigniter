<?php

class Contact_model extends CI_Model
{

    /*
    *   Get ip address on form's submission
    */
    private function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function saveFormData($mailData)
    {

        $ip_address = $this->get_client_ip();

        $data = [
            'id'         => NULL,
            'name'       => $mailData['name'],
            'surname'    => $mailData['surname'],
            'email'      => $mailData['email'],
            'phone'      => $mailData['phone'],
            'message'    => $mailData['message'],
            'ip_address' => $ip_address
        ];

        $this->db->set($data);

        return $this->db->insert('form_request') ? true : false;
    }
}
