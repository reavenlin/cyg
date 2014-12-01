<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年8月3日 下午12:43:44
 * For     : 后台操作日志
 */
 
class Logs extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('MAdminLog');
	}
	
	function index( $page=1 )
	{
		$page = $page < 1 ? 1: $page;
		$actor = $this->input->get('actor',  true);
		$start_time = $this->input->get('start_time',  true);
		$end_time = $this->input->get('end_time',  true);
		$operate = $this->input->get('operate',  true);
		
		$search = array();
		if ($actor) {
			$search['actor'] = $actor;
		}
		if ($start_time){
			$search['create_time >='] = strtotime($start_time);
		}
		if($end_time){
			$search['create_time <='] = strtotime($end_time.' 23:59:59');
		}
		if ($operate){
			$search['operate'] = $operate;
		}
		$data['logs'] = $this->MAdminLog->get_list($search, $page, $record_count);
		
		$this->load->helper('pager');
		$url = pager_url( relative_url('index'), $this->input->server('QUERY_STRING') );
		$data['pager'] = pager( $page, $record_count, $url );
		
		$data['actor'] = $actor;
		$data['start_time'] = $start_time;
		$data['end_time'] = $end_time;
		$data['operate'] = $operate;
		
		$this->load->view('admin/head');
		$this->load->view('admin/system/logs_index', $data);
	}
}