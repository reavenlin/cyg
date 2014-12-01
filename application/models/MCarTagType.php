<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年11月28日 下午3:01:00
 * For     : 汽车标签管理
 */
 

class MCarTagType extends CI_Model {

	const TABLE='car_tags_type';
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_all() {
		
		$query = $this->db->get(self::TABLE);
		return $query->result_array();
	}

	function get_kv() {
		$result = $this->get_all();
		$arr = array();
		foreach ($result as $row) {
			$arr[ $row['id'] ] = $row['type_name'];
		}
		return $arr;
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