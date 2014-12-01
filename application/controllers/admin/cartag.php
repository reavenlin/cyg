<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年11月28日 下午2:58:35
 * For     : 汽车标签管理
 */
 
class CarTag extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('MCarTag');
	}
}