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

    public function get($select = null, $where = null, $limit = null)
    {
        if ($select != null)
            $this->db->select($select);
        else
            $this->db->select('*');

        if ($where != null)
            $this->db->where($where);

        if ($limit != null)
            $this->db->limit($limit);

        $this->db->from('tanah');
        $this->db->join('pemilik', "pemilik.id = tanah.pemilik_id");

        $query = $this->db->get();

        if ($limit === 1)
            return $query->row();

        return $query->result();
    }
}
