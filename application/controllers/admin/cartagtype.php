<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年11月30日 下午4:57:05
 * For     : 
 */

class CarTagType extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('MCarTagType');
	}
	
	function index(){
		$result = $this->MCarTagType->get_all();
		print_r($result);
	}
}