<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Account_model extends CI_Model
{

	public function create($data)
	{
		$this->db->insert('user', $data);
		$id = $this->db->insert_id();
	}

	public function login($data)
	{
		$isExist = $this->db->get_where(
			'user',
			array(
				'email' => $data['email'],
			)
		)->row();

		if (!$isExist)
			return [
				'status'	=> false,
				'message'	=> [
					'title'	=> 'Failed',
					'body'		=> 'Email didnt found in our system!'
				]
			];

		$isLoginSuccess =	$this->db->get_where(
			'user',
			array(
				'email' => $data['email'],
				'password' => hashpassword($data['password']),
			)
		)->row();
		$now = date('Y-m-d H:i:s');

		if (!$isLoginSuccess && ($isExist->first_failed_login == null || $isExist->failed_login_count < 5)) {
			$this->db->update('user', [
				'first_failed_login' => $now,
				'failed_login_count' => $isExist->failed_login_count + 1,
			], ['email' => $data['email']]);
			return [
				'status'	=> false,
				'message'	=> [
					'title'	=> 'Failed',
					'body'		=> "Email and password didnt match! Failed login counts: " . $isExist->failed_login_count + 1
				]
			];
		}

		$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($isExist->first_failed_login);
		if (!$isLoginSuccess && $isExist->failed_login_count == 5 && $diff < 3540) {
			$minutes = 60 - floor($diff / 60);
			return [
				'status'	=> false,
				'message'	=> [
					'title'	=> 'Failed',
					'body'		=> "You've tried login too much, please wait for another $minutes minutes!"
				]
			];
		}

		if (!$isLoginSuccess) {
			$this->db->update('user', [
				'failed_login_count' => 1,
			], ['email' => $data['email']]);
			return [
				'status'	=> false,
				'message'	=> [
					'title'	=> 'Failed',
					'body'		=> "Email and password didnt match! Failed login counts: 1"
				]
			];
		}

		if ($isLoginSuccess) {
			$this->db->update('user', [
				'first_failed_login' => null,
				'failed_login_count' => 0,
			], ['email' => $data['email']]);

			return [
				'status'	=> true,
				'message'	=> [
					'title'	=> 'Success',
					'body'	=> "Login Success"
				],
				'data'		=> $isLoginSuccess
			];
		}
	}

	public function updateCookie($cookie, $id)
	{
		$this->db->where('id', $id);
		$this->db->update(
			'user',
			['cookies' => $cookie]
		);
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

		$this->db->from('user');
		$query = $this->db->get();

		if ($limit === 1)
			return $query->row();

		return $query->result();
	}

	public function updateuserByID($data, $id)
	{
		$this->db->update('user', $data, ['id' => $id]);
	}
}
