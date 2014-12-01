<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月31日 下午6:31:55
 * For     : 用于检查后台用户权限
 */

class UserAuth
{
	function auth() {
		$ci = &get_instance();
		$dir =  $ci->router->fetch_directory();
		$class = $ci->router->fetch_class();
		$method = $ci->router->fetch_method();
		$url = strtolower("{$dir}{$class}/{$method}");
		$action = $ci->config->item($url, 'actions');
		if (empty($action) || !$action['id'] ) {
			show_error('No such action.', 500);
			return false;
		}
		if ( 1 == $action['guest'] ) {
			return true;
		}
		
		if ( 1==$action['system'] ) {
			$user = $ci->session->userdata('user');
			if ( empty($user) || empty($user['actions']) ){
				redirect( site_url() );
				return false;
			}
			if ( ! in_array($action['id'], $user['actions'])) {
				show_error('Permission deny!', 403);
				return false;
			}
			
		}else{
			$admin = $ci->session->userdata('admin');
			if ( empty($admin) || empty($admin['actions']) ){
				redirect( site_url(ADMIN_URL_PREFIX.'main/login') );
				return false;
			}
			if ( ! in_array($action['id'], $admin['actions'])) {
				show_error('Permission deny!', 403);
				return false;
			}
			$nav = "{$action['class']}&nbsp;＞&nbsp;{$action['ctrl']}&nbsp;＞&nbsp;{$action['act']}";
			$ci->session->set_userdata('navigation', $nav );
		}
		
		return true;
	}
}
 