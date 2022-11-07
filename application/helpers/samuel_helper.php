<?php
function hashpassword($password)
{
    return hash('sha256', $password);
}
function random_string($type = 'alnum', $len = 8)
{
    switch ($type) {
        case 'basic':
            return mt_rand();
        case 'alnum':
        case 'numeric':
        case 'nozero':
        case 'alpha':
            switch ($type) {
                case 'alpha':
                    $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'alnum':
                    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'numeric':
                    $pool = '0123456789';
                    break;
                case 'nozero':
                    $pool = '123456789';
                    break;
            }
            return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
        case 'unique': // todo: remove in 3.1+
        case 'md5':
            return md5(uniqid(mt_rand()));
        case 'encrypt': // todo: remove in 3.1+
        case 'sha1':
            return sha1(uniqid(mt_rand(), TRUE));
    }
}

function currencyIDR($nominal, $symbol = true)
{
    $val = "";
    if ($symbol) {
        $val .= "Rp. ";
    }

    $val .= number_format($nominal, 0, ",", ".");
    return $val;
}

function isLogin()
{
    $_this = &get_instance();
    $_this->load->helper('cookie');

    if (get_cookie('user-cookie')) {
        $_this->load->model('Account_model', 'account');
        $isAccount = $_this->account->get(['real_name', 'email', 'id'], ['cookies' => get_cookie('user-cookie')], 1);
        if ($isAccount) {
            $prefix = "app_";
            $userData = array();
            $userData[$prefix . "isLogin"]      = true;
            $userData[$prefix . "userId"]       = $isAccount->id;
            $userData[$prefix . "nama"]         = $isAccount->real_name;
            $userData[$prefix . "email"]        = $isAccount->email;
            $_this->session->set_userdata($userData);
            return true;
        }
        return false;
    } elseif ($_this->session->userdata('app_isLogin')) {
        return true;
    }
    return false;
}


function returnValueOrNull($value)
{
    if ($value != null) return $value;
    return '';
}

function lastNomor($prefix, $table, $column)
{
    $_this = &get_instance();
    $_this->db->select($column);
    $_this->db->order_by($column, 'desc');
    $_this->db->where($column . ' LIKE "' . $prefix . '%"');
    $query =  $_this->db->get($table, 1);

    $result = $query->row_array();
    if ($result != null) {
        return intval(str_replace($prefix, "", $result[$column]));
    }
    return 0;
}

function generateOrderNumber()
{
    $prefix = 'WTR' . date('y') . date('m');
    $last_code = lastNomor($prefix, 'order', 'kode');
    $new_code = str_pad(($last_code + 1), 4, "0", STR_PAD_LEFT);
    return $prefix . $new_code;
}

function isEcomerceActive()
{
    $_this = &get_instance();
    $_this->db->select('is_active');
    $query =  $_this->db->get('system_settings', 1);
    $result = $query->row();

    if ($result->is_active == 1)
        return true;
    return false;
}

function is_all_set($var, $keys, $is_base_level = false)
{
    $pointer = $var;
    foreach ($keys as $key) {
        if (!isset($pointer[$key])) {
            return false;
        }
        if (!$is_base_level)
            $pointer = $pointer[$key];
    }
    return true;
}
function convert_json_to_datatable_query($json)
{
    // Just for IDE
    $length = 'length';
    $start = 'start';
    $filename = 'filename';
    $json['length'] = isset($json['length']) ? $json[$length] : 10;
    $query = [
        "columns" => [],
        "search" => [],
        "length" => isset($json['length']) ? $json[$length] : 10,
        "start" => isset($json['start']) ? $json[$start] : 0,
        "order" => isset($json['order']) ? json_decode($json['order'], true) : [],
        "filename" => isset($json['filename']) ? $json[$filename] : null,
    ];
    $orderables = isset($json['ordbls']) ? json_decode($json['ordbls']) : [];
    $searchables = isset($json['sbls']) ? json_decode($json['sbls']) : [];

    if (isset($json['columns'])) {
        $json['columns'] = json_decode($json['columns']);
        foreach ($json['columns'] as $index => $value) {
            $query['columns'][$index] = [
                'searchable' => in_array($index, $searchables),
                'orderable' => in_array($index, $orderables),
                'search' => [
                    'value' => $value,
                    'regex' => false,
                ]
            ];
        }
    }

    return $query;
}
function is_all_set_and_return($var, $keys)
{
    if (is_all_set($var, $keys)) {
        foreach ($keys as $key) {
            $var = $var[$key];
        }
        return $var;
    }
    return false;
}

function parseTanggal($date)
{
    date_default_timezone_set('Asia/Jakarta');
    $day_name = getDayName(date('w', strtotime($date)));
    $day = date('d', strtotime($date));
    $month = getMonthName(date('m', strtotime($date)));
    $year = date('Y', strtotime($date));
    return "$day_name, $day $month $year";
}

function getDayName($day_of_week)
{
    switch ($day_of_week) {
        case 1:
            return 'Senin';
            break;

        case 2:
            return 'Selasa';
            break;

        case 3:
            return 'Rabu';
            break;

        case 4:
            return 'Kamis';
            break;

        case 5:
            return 'Jumat';
            break;

        case 6:
            return 'Sabtu';
            break;

        case 0:
            return 'Minggu';
            break;

        default:
            return 'Senin';
            break;
    }
}
function getMonthName($month)
{
    switch ($month) {
        case 1:
            return 'Januari';
            break;

        case 2:
            return 'Februari';
            break;

        case 3:
            return 'Maret';
            break;

        case 4:
            return 'April';
            break;

        case 5:
            return 'Mei';
            break;

        case 6:
            return 'Juni';
            break;

        case 7:
            return 'Juli';
            break;

        case 8:
            return 'Agustus';
            break;

        case 9:
            return 'September';
            break;

        case 10:
            return 'Oktober';
            break;

        case 11:
            return 'November';
            break;

        case 12:
            return 'Desember';
            break;

        default:
            # code...
            break;
    }
}

function get_enum_values($table, $field)
{
    $_this = &get_instance();
    $type = $_this->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'")->row(0)->Type;
    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
    $enum = explode("','", $matches[1]);
    return $enum;
}
