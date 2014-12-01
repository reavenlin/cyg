<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月30 上午00:24:30
 * For     : 角色管理
 */

class MAdminLog extends CI_Model {
	
	const TABLE='admin_log';

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
		return $result;
	}
	
	function log($related_id='', $detail=''){
		$admin = $this->session->userdata('admin');
		$navigation = $this->session->userdata('navigation');
		$navigation = str_replace('&nbsp;', '', $navigation);
		$navigation = str_replace('＞', '/', $navigation);
		$data['actor'] = $admin['username'];
		$data['operate'] = $navigation;
		$data['related_id'] = $related_id;
		$data['detail'] = $detail;
		$data['create_time'] = time();
		$this->db->insert(self::TABLE, $data);
	}
}