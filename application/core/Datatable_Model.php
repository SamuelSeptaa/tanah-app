<?php defined('BASEPATH') or exit('no access allowed');
/**
 * summary
 */
abstract class Datatable_Model extends CI_Model
{
    protected $table;
    protected $column_order;
    protected $column_search;
    protected $order;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->_select_query();
        $this->_custom_search_query();

        $i = 0;

        if (count($this->column_search) > 0) {
            foreach ($this->column_search as $item) {
                if (is_all_set($_POST, ['search', 'value'])) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if (count($this->column_search) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
        }

        if (count($this->column_order)) {
            if (is_all_set($_POST, ['order', '0', 'column']) && is_all_set($_POST, ['order', '0', 'dir'])) {
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } else if (isset($this->order)) {
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
    }

    abstract protected function _select_query();

    abstract protected function _custom_search_query();

    function get_datatables($isPost = true)
    {
        if (!$isPost) {
            $_POST = $_GET;
            $query = convert_json_to_datatable_query($_POST);
            $query['filename'] = isset($_POST['filename']) ? $_POST['filename'] : '';
            $_POST = $query;
        }
        $this->_get_datatables_query();

        if (isset($_POST['length']) && isset($_POST['start']) && $_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        // var_dump($this->db->last_query());
        // die;

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function filterData($column_name, $index_column, $is_array = false)
    {
        if (is_all_set_and_return($_POST, ['columns', $index_column, 'search', 'value']) != '') {
            $search = $_POST['columns'][$index_column]['search']['value'];

            if ($search != '') {
                if ($is_array) {
                    $filters = json_decode($search, true);
                    if (count($filters) > 0) {
                        $this->db->where_in($column_name, $filters);
                    }
                } else {
                    $this->db->where($column_name, $search);
                }
            }
        }
    }

    public function filterDateRange($column_name, $index_column)
    {
        if (is_all_set_and_return($_POST, ['columns', $index_column, 'search', 'value']) != '') {
            $filter = json_decode($_POST['columns'][$index_column]['search']['value']);
            if (count($filter) > 0) {
                $this->db->where($column_name . ' >=', $filter[0]);
                if (count($filter) > 1)
                    $this->db->where($column_name . ' <=', $filter[1]);
            }
        }
    }


    private function is_assoc($array)
    {
        $keys = array_keys($array);
        return $keys !== array_keys($keys);
    }
}
