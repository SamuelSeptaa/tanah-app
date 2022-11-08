<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/Datatable_Model.php');

class Pemilik_M extends Datatable_Model
{
    var $table = 'pemilik';
    var $column_order = array(null, 'nama', 'total_tanah');
    var $column_search = array('nama');
    var $order = array('nama' => 'asc');

    function _select_query()
    {
        $this->db->select([
            $this->table . '.*',
            '(SELECT COUNT(*) from tanah WHERE pemilik_id = pemilik.id) AS total_tanah'
        ]);
        $this->db->from($this->table);
    }

    function _custom_search_query()
    {
    }
}
