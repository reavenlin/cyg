<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月30日 上午9:45:17
 * For     : 后台首页及主框架页
 */

class Main extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('MAction');
	}
	
	function index(){
		$admin = $this->session->userdata('admin');
		$data['default_url'] = ADMIN_URL_PREFIX.'main/hello';
		$act = $this->MAction->get_item( $data['default_url'] );
		$data['default_class'] = $act && $act['class'] ? $act['class'] : '';
		$data['menu']    = $this->MAction->get_tree_menu();
		$this->load->view('admin/system/main_index', $data);
	}
	
	function hello(){
		$this->load->view('admin/head');
		$this->load->view('admin/system/main_hello');
	}
	
	private function check_form( &$admin, &$msg ){
		if (!is_post()) {
			return FALSE;
		}
		
		$username = $this->input->post('username', true);
		$passwd = $this->input->post('passwd', true);
		$captcha  = $this->input->post('captcha', true);
		$captcha2 = $this->session->userdata('captcha');
		if (!$username || !$passwd) {
			$msg['username'] = '用户名或密码错误';
		}
		if ( ADMIN_CAPTCHA_SWITCH && strtolower($captcha) != strtolower($captcha2) ){
			$msg['captcha'] = '验证码错误';
		}
		if (!empty($msg)) {
			return FALSE;
		}
		
		if ( ADMIN_ROOT_USER == $username ){
			if ( !ADMIN_ROOT_PASS == $passwd ) {
				$msg['username'] = '用户名或密码错误';
				return FALSE;
			}
			if ( !ADMIN_ROOT_ENABLE ) {
				$msg['username'] = 'ROOT用户已禁用';
				return FALSE;
			}
			$admin = array('id'=>999999,'username'=>ADMIN_ROOT_USER);
			return TRUE;
		}
		
		$this->load->model('MAdmin');
		$admin = $this->MAdmin->get_admin( $username );
		if ( $admin['passwd'] != md5( md5( $passwd )) ){
			$msg['username'] = '用户名或密码错误';
			return FALSE;
		}
		if ( $admin['status'] == MAdmin::STATUS_DISABLE ) {
			$msg['username'] = '您的帐号已被禁用，请联系管理员。';
			return FALSE;
		}elseif ( $admin['status'] == MAdmin::STATUS_EXPIRE ){
			$msg['username'] = '您的帐号超过 '.ADMIN_EXPIRE.' 天未登录，已被系统禁用，请联系管理员。';
			return FALSE;
		}
		return TRUE;
	}
	
	function login(){
		$admin = $this->session->userdata('admin');
		if (!empty($admin)) {
			redirect( relative_url('index') );
			return ;
		}
		$admin = array();
		$msg = array();
		$result = $this->check_form($admin, $msg);
		if( is_post() && $result && !empty($admin) ){
			//获取角色权限
			$this->load->model('MRole');
			if (ADMIN_ROOT_USER == $admin['username']) {
				$admin['actions'] = $this->MRole->get_root_actions();
			}else{
				$roles = myexplode(',', $admin['roles']);
				$admin['actions'] = $this->MRole->get_roles_actions( $roles );
				//更新登录信息
				$update['last_login_time'] = time();
				$update['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
				$this->MAdmin->update( $update, $admin['id']);
			}
			$this->session->set_userdata('admin', $admin);
			//记录日志
			$this->load->model('MAdminLog');
			$this->MAdminLog->log($admin['id']);
			
			redirect( relative_url('index'));
		}
		
		$data['msg'] = empty($msg) ? '' : implode($msg, '<br />');
		$this->load->view('admin/head');
		$this->load->view('admin/system/main_login', $data);
	}
	
	function code(){
		$this->load->helper('mycaptcha');
		$cap = mycaptcha('chars', 4, 50, 20, 20);
		$img = $cap['image'];
		imagejpeg($img);
		imagedestroy($img);
		$this->session->set_userdata('captcha', $cap['word']);
	}
	
	function logout(){
		$this->session->unset_userdata('admin');
		redirect( relative_url('login') );
	}
	
	function menu()
	{
		$class = trim( $this->input->get('class', TRUE) );
		$menu = $this->MAction->get_menu_by_class( $class );
		echo json_encode( $menu );
	}
}