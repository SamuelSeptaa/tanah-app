<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tanah_Model extends CI_Model
{
    public function create($data)
    {
        $this->db->insert('tanah', $data);
        return $this->db->insert_id();
    }
}
