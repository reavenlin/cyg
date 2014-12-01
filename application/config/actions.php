<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月28日 上午11:29:51
 * For  : 权限项配置列表【！！！ 本文件可在 “权限菜单管理” 中编辑生成】
 */

/**
 * id  ：权限项ID
 * system ：所属系统，1前台、 2后台
 * guest  : 是否允许游客访问，1允许、0不允许
 * class  : 上级菜单分类
 * ctrl   : 对应控制器名
 * act    ：操作项名
 * menu   ：菜单名（注意！只有此项是菜单时才填写，大多不需要）
 * rank   ：菜单显示顺序（注意！只有此项是菜单时才填写，大多不需要）
 */
$config['actions'] = array(
	ADMIN_URL_PREFIX . 'action/index'       => array ( 'id' => 1, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '权限菜单', 'act' => '列表', 'menu' => '权限项管理', 'rank' => 5,),
	ADMIN_URL_PREFIX . 'action/rank'        => array ( 'id' => 2, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '权限菜单', 'act' => '菜单排序',),
	ADMIN_URL_PREFIX . 'action/add'         => array ( 'id' => 3, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '权限菜单', 'act' => '添加',),
	ADMIN_URL_PREFIX . 'action/edit'        => array ( 'id' => 4, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '权限菜单', 'act' => '编辑',),
	ADMIN_URL_PREFIX . 'action/delete'      => array ( 'id' => 5, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '权限菜单', 'act' => '删除',),
	ADMIN_URL_PREFIX . 'admins/index'       => array ( 'id' => 6, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台用户', 'act' => '列表', 'menu' => '后台用户', 'rank' => 3,),
	ADMIN_URL_PREFIX . 'admins/add'         => array ( 'id' => 7, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台用户', 'act' => '添加',),
	ADMIN_URL_PREFIX . 'admins/edit'        => array ( 'id' => 8, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台用户', 'act' => '编辑',),
	ADMIN_URL_PREFIX . 'admins/detail'      => array ( 'id' => 9, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台用户', 'act' => '详情',),
	ADMIN_URL_PREFIX . 'admins/enable'      => array ( 'id' => 10, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台用户', 'act' => '启用',),
	ADMIN_URL_PREFIX . 'admins/disable'     => array ( 'id' => 11, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台用户', 'act' => '禁用',),
	ADMIN_URL_PREFIX . 'admins/setting'     => array ( 'id' => 12, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台用户', 'act' => '修改密码', 'menu' => '修改密码', 'rank' => 2,),
	ADMIN_URL_PREFIX . 'logs/index'         => array ( 'id' => 13, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '操作日志', 'act' => '列表', 'menu' => '操作日志', 'rank' => 6,),
	ADMIN_URL_PREFIX . 'main/index'         => array ( 'id' => 14, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台主页', 'act' => '首页',),
	ADMIN_URL_PREFIX . 'main/hello'         => array ( 'id' => 15, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台主页', 'act' => '欢迎页', 'menu' => '后台首页', 'rank' => 1,),
	ADMIN_URL_PREFIX . 'main/login'         => array ( 'id' => 16, 'system' => 2, 'guest' => 1, 'class' => '系统管理', 'ctrl' => '后台主页', 'act' => '登录',),
	ADMIN_URL_PREFIX . 'main/code'          => array ( 'id' => 17, 'system' => 2, 'guest' => 1, 'class' => '系统管理', 'ctrl' => '后台主页', 'act' => '验证码',),
	ADMIN_URL_PREFIX . 'role/index'         => array ( 'id' => 18, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '角色管理', 'act' => '列表', 'menu' => '角色管理', 'rank' => 4,),
	ADMIN_URL_PREFIX . 'role/add'           => array ( 'id' => 19, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '角色管理', 'act' => '添加',),
	ADMIN_URL_PREFIX . 'role/edit'          => array ( 'id' => 20, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '角色管理', 'act' => '编辑',),
	ADMIN_URL_PREFIX . 'role/detail'        => array ( 'id' => 21, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '角色管理', 'act' => '详情',),
	ADMIN_URL_PREFIX . 'role/delete'        => array ( 'id' => 22, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '角色管理', 'act' => '删除',),
	ADMIN_URL_PREFIX . 'main/logout'        => array ( 'id' => 23, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台首页', 'act' => '登出',),
	ADMIN_URL_PREFIX . 'main/menu'          => array ( 'id' => 24, 'system' => 2, 'guest' => 0, 'class' => '系统管理', 'ctrl' => '后台首页', 'act' => 'ajax菜单',),
	ADMIN_URL_PREFIX . 'cartagtype/index'   => array ( 'id' => 25, 'system' => 2, 'guest' => 0, 'class' => '车辆信息', 'ctrl' => '标签类别', 'act' => '列表', 'menu' => '标签类别', 'rank' => 0,),
);