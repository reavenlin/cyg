<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年8月1日 下午3:53:37
 * For     : 权限及菜单项管理
 */

class Action extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('MAction');
	}
	
	function index(){
		$system = intval( $this->input->get('system', TRUE) );
		$class = $this->input->get('class', TRUE);
		$ctrl = $this->input->get('ctrl', TRUE);
		$actions = $this->MAction->get_list_with_status();
		foreach ($actions as $url => &$act ) {
			if ( $class && $class != $act['class'] ) {
				unset( $actions[$url] );
			}
			if ($ctrl && $ctrl != $act['ctrl'] ) {
				unset( $actions[$url] );
			}
			if ($act['status'] == MAction::STATUS_NO_RECORD) {
				unset( $actions[$url] );
			}
			if ( 0 != $system && $system != $act['system'] ) {
				unset( $actions[$url] );
			}
		}
		$this->load->helper('dropdownlist');
		$this->load->helper('form');
		$class_list = $this->MAction->get_class();
		
		$data['system'] = $system;
		$data['system_list'] = array(
			0 => '所有',
			MAction::SYSTEM_FRONT => MAction::$system[MAction::SYSTEM_FRONT],
			MAction::SYSTEM_ADMIN => MAction::$system[MAction::SYSTEM_ADMIN],
		);
		$data['class_list'] = &$class_list;
		$data['actions'] = &$actions;
		$this->load->view('admin/head');
		$this->load->view('admin/system/action_index', $data);
	}
	
	function rank(){
		$menu = $this->MAction->get_admin_menu_list();
		if ( is_post() ) {
			$order = $this->input->post('order');
			$actions = $this->MAction->get_list();
			foreach ($actions as &$row ) {
				$row['rank'] = $order[ $row['id'] ] ? $order[ $row['id'] ] : 999;
			}
			$result = $this->MAction->update($actions, $err);
			if( $result ){
				//记录日志
				$this->load->model('MAdminLog');
				$this->MAdminLog->log();
				redirect(relative_url('index'));
			}
		}
		$data['menu'] = $menu;
		$data['err'] = $err ;
		$this->load->view('admin/head');
		$this->load->view('admin/system/menu_rank', $data);
	}

	
	private function check_form(&$actions, &$msg){
		if (! is_post()) {
			return FALSE;
		}
		$post_actions = $this->input->post('actions');
		foreach ($post_actions as $url => &$act) {
			if ( !$act['system'] || !$act['ctrl'] || !$act['act'] ) {
				$msg = '所属系统、控制器名、操作项名不能为空';
				return FALSE;
			}
			$act['guest'] = 1 == intval($act['guest']) ? 1 : 0;
			$actions[$url] = $post_actions[$url];
		}
		return TRUE;
	}
	
	function add(){
		if ( is_post() ){
			$all_actions = $this->MAction->get_list();
			if( $this->check_form( $all_actions, $msg ) && $this->MAction->update($all_actions, $msg) ){
				//记录日志
				$this->load->model('MAdminLog');
				$this->MAdminLog->log();
				redirect(relative_url('index'));
			}
			$actions = $this->input->post('actions');
		}else{
			$actions = $this->MAction->get_unrecord_actions();
		}
		$this->load->helper('dropdownlist');
		$this->load->helper('form');
		$class = $this->MAction->get_class();
		$data['class'] = &$class;
		$data['system_list'] = MAction::$system;
		$data['msg']  = $msg;
		$data['actions'] = &$actions;
		$data['post_url'] = relative_url('add');
		$this->load->view('admin/head');
		$this->load->view('admin/system/action_form', $data);
	}
	
	function edit(){
		
		if ( is_post() ){
			$all_actions = $this->MAction->get_list();
			if( $this->check_form( $all_actions, $msg ) && $this->MAction->update($all_actions, $msg) ){
				//记录日志
				$this->load->model('MAdminLog');
				$this->MAdminLog->log();
				redirect(relative_url('index'));
			}
		}
		
		$ids = $this->input->get("ids", TRUE);
		if (!is_array($ids)||empty($ids)) {
			redirect(relative_url('index'));
			return false;
		}
		$actions = array();
		$all_actions = $this->MAction->get_list();
		foreach ($ids as $id ) {
			foreach ($all_actions as $url => &$act ) {
				if ( $id == $act['id'] ) {
					$actions[$url] = $all_actions[$url];
					break;					
				}
			}
		}
		
		$this->load->helper('dropdownlist');
		$this->load->helper('form');
		$class = $this->MAction->get_class();
		$data['class'] = &$class;
		$data['system_list'] = MAction::$system;
		$data['msg']  = $msg;
		$data['actions'] = &$actions;
		$data['post_url'] = relative_url('edit');
		$this->load->view('admin/head');
		$this->load->view('admin/system/action_form', $data);
	}
	
	function delete(){
		$ids = $this->input->get("ids", TRUE);
		if (!is_array($ids)||empty($ids)) {
			redirect(relative_url('index'));
			return false;
		}
		$actions = $this->MAction->get_list();
		foreach ($ids as $id ) {
			foreach ($actions as $url => &$act) {
				if ($id == $act['id']) {
					unset($actions[$url]);
					break;
				}
			}
		}
		$result = $this->MAction->update($actions, $err);
		if ($result) {
			$this->load->model('MAdminLog');
			$this->MAdminLog->log( implode(',', $ids) ); //记录日志
			redirect(relative_url('index'));
		}
	}
}