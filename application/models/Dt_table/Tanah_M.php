<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/Datatable_Model.php');

class Tanah_M extends Datatable_Model
{
    var $table = 'tanah';
    var $column_order = array(null, 'nama', 'alamat', 'ukuran', 'tahun_perolehan', null, 'nib', null, 'harga', null, 'anggaran');
    var $column_search = array('nama', 'alamat', 'nomor_site_plan');
    var $order = array('tahun_perolehan' => 'desc');

    function _select_query()
    {
        $this->db->select([
            $this->table . '.*',
            'pemilik.nama'
        ]);
        $this->db->from($this->table);
        $this->db->join('pemilik', "pemilik.id = $this->table.pemilik_id");
    }

    function _custom_search_query()
    {
    }
}
