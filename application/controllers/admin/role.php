<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月29 下午11:53:06
 * For     : 角色管理
 */
 
class Role extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('MRole');
		$this->load->model('MAction');
	}
	
	function index( $page=1 )
	{
		$page = $page < 1 ? 1: $page;
		$role_name = $this->input->get('role_name',  true);
		$search = array();
		if ($role_name) {
			$search['role_name'] = $role_name;
		}
		$data['roles'] = $this->MRole->get_list($search, $page, $record_count);
		$this->load->helper('pager');
		$url = pager_url( relative_url('index'), $this->input->server('QUERY_STRING') );
		$data['pager'] = pager( $page, $record_count, $url );
		
		$this->load->view('admin/head');
		$this->load->view('admin/system/role_index', $data);
	}
	
	private function check_form( $is_new = FALSE ){
		$msg = array();
		if ( is_post() ){
			$role_name = $this->input->post('role_name',  true);
			if ( ! $role_name ) {
				$msg['roleName'] = '角色名不能为空';
			}
			$actions = $this->input->post('actions',  true);
			if( empty($actions) ){
				$msg['actions'] = '请选择权限项';
			}
			if ( !empty($msg) ) {
				return $msg;
			}
			if ($is_new) {
				$role = $this->MRole->get_role_by_name( $role_name );
				if ( !empty($role) ){
					$msg['role_name'] = '角色名已经被占用';
				}
			}
		}
		return $msg;
	}
	
	function add(){
		$msg = $this->check_form( TRUE );
		$role['role_name'] = $this->input->post('role_name',  true);
		$actions = $this->input->post('actions',  true);
		$actions = is_array($actions) ? $actions : array();
		if ( is_post() && empty($msg) ) {
			$role['actions'] = implode( ',', $actions );
			$this->MRole->insert( $role );
			//记录日志
			$insert_id = $this->db->insert_id();
			if ($insert_id) {
				$this->load->model('MAdminLog');
				$this->MAdminLog->log($insert_id);
			}
			redirect(relative_url('index'));
			return;
		}
		$this->load->helper('form');
		$data = $this->MAction->get_tree_with_checked( $actions );
		$data['msg'] = implode( '<br />', $msg );
		$data['role_name'] = $role['role_name'];
		$data['post_url'] = relative_url('add');
		$data['is_new'] = true;
		$this->load->view('admin/head');
		$this->load->view('admin/system/role_form', $data);
	}
	
	function edit( $id ){
		if ( !$id ){
			redirect( relative_url('index'));
			return ;
		}
		
		$msg = $this->check_form();
		$role['role_name'] = $this->input->post('role_name',  true);
		$actions = $this->input->post('actions',  true);
		$actions = is_array($actions) ? $actions : array();
		if ( is_post() && empty($msg) ) {
			$role['actions'] = implode( ',', $actions );
			$this->MRole->update( $role, $id );
			//记录日志
			$this->load->model('MAdminLog');
			$this->MAdminLog->log($id);
			redirect(relative_url('index'));
			return;
		}
		
		if ( ! is_post() ){
			$role = $this->MRole->get_role_by_id( $id );
			$actions = myexplode(',', $role['actions']);
		}
		$this->load->helper('form');
		$data = $this->MAction->get_tree_with_checked( $actions );
		$data['msg'] = implode( '<br />', $msg );
		$data['role_name'] = $role['role_name'];
		$data['post_url'] = relative_url('edit/'.$id);
		$data['is_new'] = false;
		$this->load->view('admin/head');
		$this->load->view('admin/system/role_form', $data);
	}
	
	function detail( $id ){
		if ( !$id ){
			redirect( relative_url('index') );
			return ;
		}
		$role = $this->MRole->get_role_by_id( $id );
		$actions = myexplode(',', $role['actions']);
		$data = $this->MAction->get_tree_for_detail( $actions );
		$data['id'] = $id;
		$data['role_name'] = $role['role_name'];
		$this->load->view('admin/head');
		$this->load->view('admin/system/role_detail', $data);
	}

	function delete( $id ){
		$this->MRole->delete( $id );
		$this->load->model('MAdminLog');
		$this->MAdminLog->log( $id ); //记录日志
		redirect( relative_url('index') );
	}

}