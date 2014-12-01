<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月28 下午02:53:06
 * For     : 用户管理
 */
 
class Admins extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('MAdmin');
		$this->load->model('MRole');
	}
	
	function index( $page=1 )
	{
		$page = $page < 1 ? 1: $page;
		$username = $this->input->get('username',  true);
		$real_name = $this->input->get('real_name',  true);
		
		$search = array();
		if ($username) {
			$search['username'] = $username;
		}
		if ($real_name) {
			$search['real_name'] = $real_name;
		}
		
		$admins = $this->MAdmin->get_list($search, $page, $record_count);
		$roles = $this->MRole->get_role_hash();
		foreach ( $admins as &$u ) {
			$role_ids = myexplode(',', $u['roles'] );
			$str = '';
			foreach ( $role_ids as $rid ) {
				if ( $roles[$rid] ) {
					$str .= $roles[$rid].',';
				}
			}
			$u['roles'] = trim($str, ',');
		}
		
		$this->load->helper('pager');
		$url = pager_url( relative_url('index'), $this->input->server('QUERY_STRING') );
		$data['pager'] = pager( $page, $record_count, $url );
		$data['admins'] = $admins;
		$this->load->view('admin/head');
		$this->load->view('admin/system/admin_index', $data);
	}
	
	private function check_form( $is_new = TRUE ){
		$msg = array();
		$username = $this->input->post('username',  true);
		$passwd   = $this->input->post('passwd',    true);
		$real_name = $this->input->post('real_name',  true);
		if ( is_post() ){
			if ( ! $username ) {
				$msg['username'] = '用户名不能为空';
			}
			if ( $is_new && ! $passwd ) {
				$msg['passwd'] = '初始密码不能为空';
			}
			if ( ! $real_name ) {
				$msg['real_name'] = '真实姓名不能为空';
			}
			if ( !empty($msg) ) {
				return $msg;
			}
			if ($is_new) {
				$admin = $this->MAdmin->get_admin( $username );
				if ( !empty($admin) ){
					$msg['username'] = '用户名已经被占用';
				}
			}
		}
		return $msg;
	}

	function add(){
		$roles = array();
		$msg = $this->check_form( TRUE );
		if ( is_post() && empty($msg) ) {
			$admin['username'] = $this->input->post('username',  true);
			$admin['passwd']   = md5( md5( $this->input->post('passwd', true) ) );
			$admin['real_name'] = $this->input->post('real_name',  true);
			$roles = $this->input->post('roles',  true);
			$admin['roles'] = implode(',', $roles);
			$this->MAdmin->insert( $admin );
			//记录日志
			$insert_id = $this->db->insert_id();
			if ($insert_id) {
				$this->load->model('MAdminLog');
				$this->MAdminLog->log($insert_id);
			}
			redirect( relative_url('index') );
			return ;
		}
		
		$this->load->helper('form');
		$data['msg'] = implode( '<br />', $msg );
		$data['username'] = $this->input->post('username');
		$data['real_name'] = $this->input->post('real_name');
		$data['passwd'] = $this->input->post('passwd');
		$data['roles']  = $this->MRole->get_role_with_checked( $this->input->post('roles') );
		$data['url'] = relative_url('add');
		$data['is_new'] = TRUE;
		$this->load->view('admin/head');
		$this->load->view('admin/system/admin_form', $data);
	}
	
	function edit( $id ){
		if ( !$id ){
			redirect('AdminUser/index');
			return ;
		}
		$roles = array();
		$msg = $this->check_form( FALSE );
		if ( is_post() && empty($msg) ) {
			$passwd = $this->input->post('passwd', true);
			if ($passwd) {
				$admin['passwd']   = md5( md5( $passwd ) );
			}
			$admin['real_name'] = $this->input->post('real_name',  true);
			$roles = $this->input->post('roles',  true);
			$admin['roles'] = implode(',', $roles);
			$this->MAdmin->update( $admin, $id );
			//记录日志
			$this->load->model('MAdminLog');
			$this->MAdminLog->log($id);
			
			redirect( relative_url('index') );
			return ;
		}
		
		if ( ! is_post() ){
			$admin = $this->MAdmin->get_admin(FALSE, $id );
			$roles = myexplode( ',', $admin['roles'] );
		}else{
			$roles = $this->input->post('roles');
		}
		
		$this->load->helper('form');
		$data['msg'] = implode( '<br />', $msg );
		$data['username'] = &$admin['username'];
		$data['real_name'] = &$admin['real_name'];
		$data['passwd'] = $this->input->post('passwd');
		$data['roles']  = $this->MRole->get_role_with_checked($roles);
		$data['url'] = relative_url('edit/'.$id);
		$data['is_new'] = FALSE;
		$this->load->view('admin/head');
		$this->load->view('admin/system/admin_form', $data);
	}
	
	function detail( $id ){
		if ( !$id ){
			redirect( relative_url('index'));
			return ;
		}
		$this->load->model('MAction');
		$admin = $this->MAdmin->get_admin(FALSE, $id );
		$role_ids = myexplode( ',', $admin['roles'] );
		$roles = $this->MRole->get_role_hash( $role_ids );
		$role_names = '';
		foreach ( $role_ids as $rid ) {
			if ( $roles[$rid] ) {
				$role_names .= $roles[$rid].',';
			}
		}
		$role_names = trim($role_names, ',');
		$action_ids = $this->MRole->get_roles_actions( $role_ids );
		$data = $this->MAction->get_tree_for_detail( $action_ids );
		$data['id'] = $admin['id'];
		$data['username'] = $admin['username'];
		$data['real_name'] = $admin['real_name'];
		$data['role_names'] = $role_names;
		
		$this->load->view('admin/head');
		$this->load->view('admin/system/admin_detail', $data);
	}
	
	function enable( $id ){
		$data['status'] = MAdmin::STATUS_ENABLE;
		$data['last_login_time'] = time();
		$this->MAdmin->update( $data, $id );
		$this->load->model('MAdminLog');
		$this->MAdminLog->log( $id ); //记录日志
		redirect( relative_url('index') );
	}
	
	function disable( $id ){
		$data['status'] = MAdmin::STATUS_DISABLE;
		$this->MAdmin->update( $data, $id );
		$this->load->model('MAdminLog');
		$this->MAdminLog->log($id); //记录日志
		redirect( relative_url('index') );
	}
	
	function setting(){
		$admin = $this->session->userdata('admin');
		$msg = array();
		if ( $admin['username'] == ADMIN_ROOT_USER) {
			$msg[] = 'ROOT用户不能在此更改密码';
		}
		if ( is_post() && empty($msg)) {
			$passwd = $this->input->post('passwd');
			$new_passwd = $this->input->post('new_passwd');
			if (!$passwd || md5(md5($passwd)) != $admin['passwd'] ) {
				$msg['passwd'] = '旧密码错误';
			}
			if ( !$new_passwd ){
				$msg['new_passwd'] = '新密码不能为空';
			}
			if (empty($msg) && $admin['id']) {
				$new = md5(md5($new_passwd));
				$user['passwd'] = $new;
				$this->MAdmin->update( $user, $admin['id']);
				$this->load->model('MAdminLog');
				$this->MAdminLog->log($admin['id']); //记录日志
				$admin['passwd'] = $new;
				$this->session->set_userdata('admin', $admin);
				$msg[] = '密码修改成功，请记住新密码!';
			}
		}
		$data['username'] = $admin['username'];
		$data['real_name'] = $admin['real_name'];
		$data['msg'] = implode('<br />', $msg);
		$this->load->view('admin/head');
		$this->load->view('admin/system/admin_setting', $data);
	}

}