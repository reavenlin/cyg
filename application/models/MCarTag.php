<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年11月28日 下午3:01:00
 * For     : 汽车标签管理
 */
 

class MCarTag extends CI_Model {

	const TABLE='car_tags';
	
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

	function get_by_id( $id ) {
		$this->db->where('id', $id);
		$query = $this->db->get(self::TABLE);
		$result = $query->row_array();
		return $result;
	}

	function insert( $type, $tag_name, $img='', $css='', $params='' ){
		if ( !$type || $tag_name ){
			return FALSE;
		}
		$data['tag_type'] = $type;
		$data['tag_name'] = $tag_name;
		$data['img'] = $img;
		$data['css'] = $css;
		$data['params'] = $params;
		$this->db->insert(self::TABLE, $data);
	}

	function update($id, $type, $tag_name, $img='', $css='', $params='' ){
		if ( !$type || $tag_name ){
			return FALSE;
		}
		$data['tag_type'] = $type;
		$data['tag_name'] = $tag_name;
		$data['img'] = $img;
		$data['css'] = $css;
		$data['params'] = $params;
		$this->db->where('id', $id);
		$this->db->update(self::TABLE, $data);
	}
}