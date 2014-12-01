<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


//=======================my own define========================
define( 'ADMIN_URL_PREFIX', 'admin/' ); //管理后台url前缀
define( 'ADMIN_ROW_PER_PAGE', 20 ); //每页显示记录数
define( 'ADMIN_LINKS_COUNT',    10 ); //分页按钮中最多多少个数字链接
define( 'ADMIN_EXPIRE',  60); //超过多少天未登录自动禁用其帐号登录后台
define( 'ADMIN_CAPTCHA_SWITCH', FALSE); //是否开启后台登录验证码 ，true 开， false关
define( 'ADMIN_ROOT_USER', 'root'); //root管理员
define( 'ADMIN_ROOT_PASS', 'root'); //root管理员密码
define( 'ADMIN_ROOT_ENABLE', TRUE); //是否开启root管理员
//============================================================

/* End of file constants.php */
/* Location: ./application/config/constants.php */