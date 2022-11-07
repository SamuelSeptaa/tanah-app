<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pemilik_Model extends CI_Model
{
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

        $this->db->from('pemilik');
        $this->db->order_by('nama', 'asc');

        $query = $this->db->get();

        if ($limit === 1)
            return $query->row();
        return $query->result();
    }
}
