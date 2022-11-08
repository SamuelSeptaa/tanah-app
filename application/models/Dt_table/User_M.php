<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/Datatable_Model.php');

class User_M extends Datatable_Model
{
    var $table = 'user';
    var $column_order = array(null, 'real_name', 'email');
    var $column_search = array('real_name', 'email');
    var $order = array('real_name' => 'asc');

    function _select_query()
    {
        $this->db->select([
            $this->table . '.*',
        ]);
        $this->db->from($this->table);
    }

    function _custom_search_query()
    {
    }
}
