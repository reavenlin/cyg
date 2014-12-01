<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author  : Reaven (619132675@qq.com)
 * Created : 2014年7月29日 下午10:42:51
 * For     : 分页函数
 */

if ( ! function_exists('pager_url'))
{
	function pager_url( $base_url, $query_string, $pager_key='{p}'){
		$url = $base_url . '/' . $pager_key;
		if ( $query_string ) {
			$url .= '?'.$query_string;
		}
		return $url;
	}
}

if ( ! function_exists('pager'))
{
	function pager($page, $record_count, $url, $per_page_record = ADMIN_ROW_PER_PAGE, $url_key='{p}') {
		$record_count = intval($record_count);
		$total_page = ceil($record_count / $per_page_record);
		if ($total_page < 1) {
			return "<div class=\"page\">共有 {$record_count} 条数据，当前第 0  页</div>";
		}
		$start=max(1, $page-(int)( ADMIN_LINKS_COUNT / 2 ) );
		if( ($end=$start+ ADMIN_LINKS_COUNT -1) >= $total_page )
		{
			$end=$total_page;
			$start=max(1,$end- ADMIN_LINKS_COUNT +1);
		}
		
		$arr['首页'] = 1;
		$arr['上页'] = ($page > 1) ? ($page -1) : 1;
		for ($i = $start; $i <= $end; $i++) {
			$arr[$i] = $i;
		}
		$arr['下页'] = ($page < $total_page) ? ($page +1) : $total_page;
		$arr['末页'] = $total_page;
		
		$str = '<div class="page">';
		foreach ($arr as $k => $i ) {
			$href = str_replace($url_key, $i, $url);
			if ( '首页' == $k ) {
				$str .= "<a href=\"{$href}\">{$k}</a>";
				continue;
			}
			if ( '末页' == $k ) {
				$str .= "<a href=\"{$href}\">{$k}</a>";
				continue;
			}
			if ('上页' == $k && $page <= 1 ) {
				$str .= "<span class=\"disabled\">{$k}</span>";
				continue;
			}
			if ('下页' == $k && $page >= $total_page ) {
				$str .= "<span class=\"disabled\">{$k}</span>";
				continue;
			}
			if ( $i == $page ) {
				$str .= "<span class=\"current\">{$k}</span>";
				continue;
			}
			$str .= "<a href=\"{$href}\">{$k}</a>";
		}
		$str .= "共有 {$record_count} 条数据，当前第 {$page} 页</div>";
		return $str;
	}
}