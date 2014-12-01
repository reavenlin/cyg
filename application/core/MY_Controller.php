<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年11月28日 下午5:03:10
 * For     : 自定义controller父类
 */

class MY_Controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file'));
		//$this->load->driver('cache', array('adapter' => 'memcached',));
	}
}