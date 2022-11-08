<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tanah_Model extends CI_Model
{
    public function create($data)
    {
        $this->db->insert('tanah', $data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tanah', $data);
        return $this->db->insert_id();
    }
}
