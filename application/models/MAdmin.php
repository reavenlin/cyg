<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月28 下午03:04:49
 * For     : 用户管理
 */

class MAdmin extends CI_Model {
	
	const TABLE='admin';
	
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;
	const STATUS_EXPIRE = 3;

	public static $status =array(
		self::STATUS_ENABLE => '启用中',
		self::STATUS_DISABLE => '禁用中',
		self::STATUS_EXPIRE => '被系统冻结',
	);
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_list( $search, $page, &$record_count ) {
		$page = $page < 1 ? 1 :$page;
		$start = ADMIN_ROW_PER_PAGE * ($page-1) ;
		$this->db->where( $search );
		$query = $this->db->get(self::TABLE, ADMIN_ROW_PER_PAGE, $start);
		$result = $query->result_array();
		$record_count = $this->db->where( $search )->count_all_results( self::TABLE );
		$now = time();
		foreach ( $result as &$row ) {
			if ( $row['status'] == self::STATUS_ENABLE && ( $now - $row['last_login_time']) > ADMIN_EXPIRE * 86400 ) {
				$row['status'] = self::STATUS_EXPIRE;
			}
			$row['status_text'] = MAdmin::$status[ $row['status'] ];
		}
		return $result;
	}
	
	function get_admin( $username, $id=0 ) {
		if ( !$username && ! $id ) {
			return array();
		}
		if ( $id ){
			$this->db->where('id', $id);
		}
		if ( $username ) {
			$this->db->where('username', $username);
		}
		$query = $this->db->get(self::TABLE);
		$result = $query->row_array();
		if ( $result['status'] == self::STATUS_ENABLE && ( time() - $result['last_login_time']) > ADMIN_EXPIRE * 86400 ) {
			$result['status'] = self::STATUS_EXPIRE;
		}
		return $result;
	}
	
	function insert( $data ){
		if ( empty( $data ) ){
			return;
		}
		$now = time();
		$data['create_time'] = $now;
		$data['status'] = self::STATUS_ENABLE;
		$data['last_login_time'] = $now;
		$this->db->insert(self::TABLE, $data);
	}
	
	function update( $data , $id){
		$this->db->where('id', $id);
		$this->db->update(self::TABLE, $data);
	}
	
}