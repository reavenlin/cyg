<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月30日 下午12:04:36
 * For     : 权限及菜单项
 */

class MAction extends CI_Model {

	const SYSTEM_FRONT = 1;
	const SYSTEM_ADMIN = 2;
	public static $system = array(
		self::SYSTEM_FRONT => '前台',
		self::SYSTEM_ADMIN => '后台',
	);
	
	const STATUS_OK = 1;
	const STATUS_NOT_EXIST = 2;
	const STATUS_NO_RECORD = 3;
	public static $status = array(
		self::STATUS_OK => '正常',
		self::STATUS_NOT_EXIST => '不存在',
		self::STATUS_NO_RECORD => '未记录',
	);
	
	function __construct()
	{
		parent::__construct();
		$this->config->load('actions');
	}
	
	function get_list(){
		return $this->config->item('actions');
	}
	
	function get_item( $url ){
		return $this->config->item($url, 'actions');
	}
	
	function get_admin_menu_list(){
		$actions = $this->config->item('actions');
		$menus = array();
		foreach ($actions as $url => $item) {
			if( $item['system'] == self::SYSTEM_ADMIN && $item['menu'] ){
				$item['url']  = $url;
				$item['rank'] = $item['rank'] ? $item['rank'] : 999;
				array_push($menus, $item);
			}
		}
		
		$len = count($menus);
		for($i=1; $i<$len; $i++)
		{
			for($j=$len-1; $j>=$i; $j--){
				if($menus[$j]['rank'] < $menus[$j-1]['rank'] ){
					$tmp=$menus[$j];
					$menus[$j]=$menus[$j-1];
					$menus[$j-1]=$tmp;
				}
			}
		}
		return $menus;
	}
	
	function get_admin_menu_tree(){
		$menus = $this->get_admin_menu_list();
		$tree = array();
		foreach ($menus as $item) {
			if ( !$tree[ $item['class'] ] ) {
				$tree[ $item['class'] ] = array();
			}
			array_push( $tree[ $item['class']], $item );
		}
		return $tree;
	}
	
	
	function get_list_with_status(){
		$system_actions = $this->get_system_actions();
		$actions = $this->config->item('actions');
		$maxId = 0;
		foreach ($actions as $url => $item ) {
			$maxId = $item['id'] > $maxId ? $item['id'] : $maxId;
			if ( ! $system_actions[$url] ) {
				$actions[$url]['status'] = self::STATUS_NOT_EXIST;
			}
		}
		foreach ($system_actions as $act) {
			if ($actions[$act]) {
				$actions[$act]['status'] = self::STATUS_OK;
			}else{
				$actions[$act] = array();
				$actions[$act]['id'] = ++$maxId;
				$actions[$act]['status'] = self::STATUS_NO_RECORD;
			}
		}
		return $actions;
	}
	
	function get_system_actions(){
		$files = array();
		$dir = APPPATH.'controllers/';
		read_dir_all($dir, $files);
		
		$actions = array();
		foreach ( $files as $f ){
			$rel_path = dirname( $f );
			$rel_path = '.' == $rel_path ? '' : $rel_path.'/';
			$content = preg_replace('/\r|\n|\t/', '', file_get_contents($dir.$f) );
			preg_match('/class\s+(\w+)\s+extends\s+\w+Controller/', $content, $matchs_ctrl);
			preg_match_all('/\w*\s*function\s+[^_]\w+/', $content, $matchs_act);
			if ( !$matchs_ctrl || ! $matchs_ctrl[1] ){
				continue;
			}
			if ( !is_array( $matchs_act[0] ) || empty( $matchs_act[0] ) ){
				continue;
			}
			$methods = array();
			foreach ($matchs_act[0] as $a ) {
				$a = trim( $a );
				$match = NULL;
				if ( 0 === strpos($a, 'function')){
					preg_match('/function\s+(\w+)/', $a, $match);
				}elseif( 0 === strpos($a, 'public')) {
					preg_match('/public\s+function\s+(\w+)/', $a, $match);
				}else{
					continue;
				}
				if ($match[1]) {
					$methods[] = $match[1];
				}
			}
			if (empty($methods)){
				continue;
			}
			$controller = $matchs_ctrl[1];
			foreach ($methods as $m) {
				$act = strtolower( $rel_path.$controller.'/'.$m );
				$actions[ $act ] = $act ;
			}
		}
		return $actions;
	}
	
	function get_class(){
		$actions = $this->config->item('actions');
		$class = array();
		foreach ($actions as $act ) {
			$class[ $act['class'] ] = $act['class'];
		}
		return $class;
	}
	

	function update( &$actions, &$err ){
		$content = '';
		$arr = array();
		foreach ($actions as $url => &$act ){
			$arr[$url] = array(
				'id'     => intval( $act['id'] ),
				'system' => intval( $act['system'] ),
				'guest'  => 1 == intval( $act['guest'] ) ? 1 : 0,
				'class'  => $act['class'],
				'ctrl'   => $act['ctrl'],
				'act'   => $act['act'],
			);
			if ( $act['menu'] && trim($act['menu']) ) {
				$arr[$url]['menu'] = trim($act['menu']);
				$arr[$url]['rank'] = intval($act['rank']);
			}
		}
		foreach ($arr as $url => &$act) {
			$url = "\tADMIN_URL_PREFIX . '".str_replace(ADMIN_URL_PREFIX, '', $url )."'";
			$url = str_pad($url, 40, ' ', STR_PAD_RIGHT ).' => ';
			$str = preg_replace('/\n|\r/', '', var_export( $act , true) ).",\n";
			$str = str_replace('  ', ' ', $str);
			$content .= $url.$str;
		}
	
		//======读取配置文件头=========
		$path = APPPATH.'config/actions.php';
		$fp = fopen($path, 'r');
		if (!$fp){
			$err = "配置文件{$path} 无法读取.";
			return false;
		}
		$head = '';
		$flag = false;
		while ( !feof($fp) ) {
			$line = fgets($fp);
			$head .= $line;
			if ( strpos($line, '$config[\'actions\'] = array(') !== FALSE ) {
				$flag = true;
				break;
			}
		}
		if ( !$flag ){
			$err = '配置文件缺少关键行 ：$config[\'actions\'] = array(';
			return false;
		}
		//===========================
		$content = $head.$content.");";
		file_put_contents($path, $content);
		return true;
	}
	
	function get_unrecord_actions(){
		$actions = $this->get_list_with_status();
		$ret = array();
		foreach ($actions as $url => $act ) {
			if (self::STATUS_NO_RECORD == $act['status']) {
				$ret[$url] = $act;
			}
		}
		return $ret;
	}
	

	function get_tree_with_checked( $ids ){
		$admin = $this->session->userdata('admin');
		if (empty($admin) || empty($admin['actions'])) {
			return array();
		}
		
		$ids = is_array( $ids ) ? $ids : array();
		$actions = $this->get_list();
		
		$admin_guest   = array();
		$admin_have    = array();
		$front_guest   = array();
		$front_have    = array();
		
		foreach ($actions as $url => &$act ) {
			if ( 1 == $act['guest'] && self::SYSTEM_ADMIN == $act['system'] ) {
				if ( empty($admin_guest[$act['class']]) ) {
					$admin_guest[$act['class']] = array();
				}
				if ( empty( $admin_guest[$act['class']][$act['ctrl']] )) {
					$admin_guest[$act['class']][$act['ctrl']] = array();
				}
				$admin_guest[$act['class']][$act['ctrl']][$url] = $act;
				continue;
			}
			if ( 1 == $act['guest'] && self::SYSTEM_FRONT == $act['system'] ) {
				if ( empty($front_guest[$act['class']]) ) {
					$front_guest[$act['class']] = array();
				}
				if ( empty( $front_guest[$act['class']][$act['ctrl']] )) {
					$front_guest[$act['class']][$act['ctrl']] = array();
				}
				$front_guest[$act['class']][$act['ctrl']][$url] = $act;
				continue;
			}
			
			$flag = in_array( $act['id'], $admin['actions'] );
			if ( $flag && self::SYSTEM_ADMIN == $act['system'] ) {
				$act['checked'] = in_array( $act['id'], $ids );
				if ( empty($admin_have[$act['class']]) ) {
					$admin_have[$act['class']] = array();
				}
				if ( empty( $admin_have[$act['class']][$act['ctrl']] )) {
					$admin_have[$act['class']][$act['ctrl']] = array();
				}
				$admin_have[$act['class']][$act['ctrl']][$url] = $act;
				continue;
			}
			if ( $flag && self::SYSTEM_FRONT == $act['system'] ) {
				$act['checked'] = in_array( $act['id'], $ids );
				if ( empty($front_have[$act['class']]) ) {
					$front_have[$act['class']] = array();
				}
				if ( empty( $front_have[$act['class']][$act['ctrl']] )) {
					$front_have[$act['class']][$act['ctrl']] = array();
				}
				$front_have[$act['class']][$act['ctrl']][$url] = $act;
				continue;
			}
		}
		return array(
			'admin_guest'   => &$admin_guest,
			'admin_have'    => &$admin_have,
			'front_guest'   => &$front_guest,
			'front_have'    => &$front_have,
		);
	}
	
	function get_tree_for_detail( $ids ){
		$actions = $this->get_list();
		$ids = is_array( $ids ) ? $ids : array();
		
		$admin_guest   = array();
		$admin_have    = array();
		$admin_havenot = array();
		$front_guest   = array();
		$front_have    = array();
		$front_havenot = array();
		
		foreach ($actions as $url => &$act ) {
			if ( 1 == $act['guest'] && self::SYSTEM_ADMIN == $act['system'] ) {
				if ( empty($admin_guest[$act['class']]) ) {
					$admin_guest[$act['class']] = array();
				}
				if ( empty( $admin_guest[$act['class']][$act['ctrl']] )) {
					$admin_guest[$act['class']][$act['ctrl']] = array();
				}
				$admin_guest[$act['class']][$act['ctrl']][$url] = $act['act'];
				continue;
			}
			if ( 1 == $act['guest'] && self::SYSTEM_FRONT == $act['system'] ) {
				if ( empty($front_guest[$act['class']]) ) {
					$front_guest[$act['class']] = array();
				}
				if ( empty( $front_guest[$act['class']][$act['ctrl']] )) {
					$front_guest[$act['class']][$act['ctrl']] = array();
				}
				$front_guest[$act['class']][$act['ctrl']][$url] = $act['act'];
				continue;
			}
			
			$flag = in_array( $act['id'], $ids);
			if ( $flag && self::SYSTEM_ADMIN == $act['system'] ) {
				if ( empty($admin_have[$act['class']]) ) {
					$admin_have[$act['class']] = array();
				}
				if ( empty( $admin_have[$act['class']][$act['ctrl']] )) {
					$admin_have[$act['class']][$act['ctrl']] = array();
				}
				$admin_have[$act['class']][$act['ctrl']][$url] = $act['act'];
				continue;
			}
			
			if ( !$flag && self::SYSTEM_ADMIN == $act['system'] ) {
				if ( empty($admin_havenot[$act['class']]) ) {
					$admin_havenot[$act['class']] = array();
				}
				if ( empty( $admin_havenot[$act['class']][$act['ctrl']] )) {
					$admin_havenot[$act['class']][$act['ctrl']] = array();
				}
				$admin_havenot[$act['class']][$act['ctrl']][$url] = $act['act'];
				continue;
			}
			
			if ( $flag && self::SYSTEM_FRONT == $act['system'] ) {
				if ( empty($front_have[$act['class']]) ) {
					$front_have[$act['class']] = array();
				}
				if ( empty( $front_have[$act['class']][$act['ctrl']] )) {
					$front_have[$act['class']][$act['ctrl']] = array();
				}
				$front_have[$act['class']][$act['ctrl']][$url] = $act['act'];
				continue;
			}
				
			if ( !$flag && self::SYSTEM_FRONT == $act['system'] ) {
				if ( empty($front_havenot[$act['class']]) ) {
					$front_havenot[$act['class']] = array();
				}
				if ( empty( $front_havenot[$act['class']][$act['ctrl']] )) {
					$front_havenot[$act['class']][$act['ctrl']] = array();
				}
				$front_havenot[$act['class']][$act['ctrl']][$url] = $act['act'];
				continue;
			}
		}
		return array(
			'admin_guest'   => &$admin_guest,
			'admin_have'    => &$admin_have,
			'admin_havenot' => &$admin_havenot,
			'front_guest'   => &$front_guest,
			'front_have'    => &$front_have,
			'front_havenot' => &$front_havenot,
		);
	}
	
	function get_tree_menu(){
		$admin = $this->session->userdata('admin');
		$actions_ids = $admin['actions'] && !empty($admin['actions']) ? $admin['actions'] : array();
		
		$actions = $this->get_admin_menu_list();
		$tree = array();
		foreach ($actions as $url => &$act ) {
			if ( !$act['menu'] ) {
				continue;
			}
			if ( in_array($act['id'], $actions_ids) ) {
				if ( empty($tree[$act['class']]) ) {
					$tree[$act['class']] = array();
				}
				if ( empty( $tree[$act['class']][$act['ctrl']] )) {
					$tree[$act['class']][$act['ctrl']] = array();
				}
				$tree[$act['class']][$act['ctrl']][$url] = $act;
			}
		}
		log_message('error', '==================='.print_r($tree, true));
		return $tree;
	}
	
	function get_menu_by_class($class)
	{
		$actions = $this->get_admin_menu_list();
		foreach ($actions as $k => &$act) {
			if ( $act['class'] != $class ) {
				unset( $actions[$k] );
			}
			$act['url'] = site_url($act['url']);
		}
		return $actions;
	}
}