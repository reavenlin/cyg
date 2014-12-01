<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年8月3日 下午12:40:44
 * For     : 角色管理
 */

class MRole extends CI_Model {
	
	const TABLE='role';
		
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
		$record_count = $this->db->where($search)->count_all_results( self::TABLE );
		return $result;
	}

	function get_roles_actions( $ids ){
		if ( !is_array($ids) || empty($ids)) {
			return array();
		}
		$this->db->where_in('id', $ids);
		$query = $this->db->get(self::TABLE);
		$roles = $query->result_array();
		$str = '';
		foreach ( $roles as &$r ) {
			$str .= $r['actions'].',';
		}
		
		$actions = $this->config->item('actions');
		foreach ($actions as &$act) {
			if (1==$act['guest']) {
				$str .= $act['id'].',';
			};
		}
		
		$str = trim($str, ',');
		$actions = array_unique(myexplode(',', $str));
		return $actions;
	}

	function get_root_actions(){
		$actions = $this->config->item('actions');
		$ids = array();
		foreach ($actions as &$act) {
			$ids[] = $act['id'];
		}
		return $ids;
	}
	
	function insert( $data ){
		if ( empty( $data ) ){
			return;
		}
		$this->db->insert(self::TABLE, $data);
	}
	
	function update( $data , $id){
		$this->db->where('id', $id);
		$this->db->update(self::TABLE, $data);
	}
	
	function get_role_by_name( $role_name ) {
		$this->db->where('role_name', $role_name);
		$query = $this->db->get(self::TABLE);
		$result = $query->row_array();
		return $result;
	}

	function get_role_by_id( $id ) {
		$this->db->where('id', $id);
		$query = $this->db->get(self::TABLE);
		$result = $query->row_array();
		return $result;
	}
	
	function get_role_hash( $ids = array() ) {
		if (!empty($ids)) {
			$this->db->where_in('id', $ids);
		}
		$query = $this->db->get(self::TABLE);
		$tmp = $query->result_array();
		$result = array();
		foreach ($tmp as &$r ) {
			$result[ $r['id'] ] = $r['role_name'];
		}
		return $result;
	}

	function get_role_with_checked( $ids=array() ){
		$query = $this->db->get(self::TABLE);
		$roles = $query->result_array();
		$ids = is_array( $ids ) ? $ids : array();
		foreach ( $roles as &$r ) {
			if (in_array($r['id'], $ids)) {
				$r['checked'] = true;
			}
		}
		return $roles;
	}
	
	function delete( $id ){
		$this->db->where('id', $id);
		$this->db->delete( self::TABLE );
	}
}