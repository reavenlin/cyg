<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年8月1日 下午2:31:04
 * For     : 自定义全局函数
 */
 
//自定义explode函数，解决字串为空时，explode() 仍返回一个空元素的问题
if ( !function_exists('myexplode')) {
	function myexplode($delimiter, $string){
		if ( !$string ) {
			return array();
		}
		return explode($delimiter, $string);
	}
}

//格式化为相对url
if ( !function_exists('relative_url')) {
	function relative_url( $action ){
		$ci = &get_instance();
		$dir = $ci->router->fetch_directory();
		$dir = $dir ? rtrim( $dir, '/').'/' : '';
		$class = $ci->router->fetch_class();
		return site_url($dir.$class.'/'.$action);
	}
}

//递归获取某目录下的文件
if ( !function_exists('read_dir_all')) {
	function read_dir_all( $dir, &$ret, $cur=''){
		$files = scandir($dir.$cur);
		if (!is_array($files)) {
			continue;
		}
		foreach ($files as $f) {
			if ('.' == $f || '..' == $f) {
				continue;
			}
			$f2 = $dir.$cur.$f;
			if ( is_file( $f2 )) {
				$ret[] = $cur.$f;
				continue;
			}
			if (is_dir( $f2 )) {
				read_dir_all($dir, $ret, $cur.$f.'/');
			}
		}
	}
}

//用于判断当前是否有post数据
if ( !function_exists('is_post')) {
	function is_post() {
		return (strtolower($_SERVER['REQUEST_METHOD']) == 'post');
	}
}
