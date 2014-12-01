<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年11月28日 下午5:21:35
 * For     : memcached 配置
 */

$config['memcached'] = array(
	'server1' => array(
		'host' => '127.0.0.1',
		'port'     => 11211,
		'weight'   => 1,
	),
);
