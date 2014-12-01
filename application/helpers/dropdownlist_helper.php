<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('dropdownlist'))
{	
	function dropdownlist($selector, $items, $width=200, $height=150){
		$str1=<<<HTML
		<!-- ================== start autocomplete ==================== -->
<script language="javascript">
	var offset = null;
	var eventSource = null;
	jQuery(document).ready(function(){
		jQuery("{$selector}").click(showItem).keyup(showItem);
		//jQuery("{$selector}").blur(function(){
		//	jQuery(".autoMain").hide();
		//});
		jQuery("#autoClose").click(function(){
			jQuery(".autoMain").hide();
		});
		jQuery(".autoList>li").click(function(){
			eventSource.val(jQuery(this).text());
			jQuery(".autoMain").hide();
		});
		jQuery("#autoReSet").click(function(){
			eventSource.val("");
			showItem();
		});
	});
	function showItem(){
		jQuery(".autoMain").show();
		offset = jQuery(this).offset();
		eventSource = jQuery(this);
		jQuery(".autoMain").css("top",offset.top+20).css("left",offset.left);
		keyWord = eventSource.val();
		if(keyWord && '' != keyWord){
			jQuery(".autoList>li").each(function(){
				liText = jQuery(this).text();
				if(-1!=liText.indexOf(keyWord)){
					jQuery(this).show();
				}else{
					jQuery(this).hide();
				}
			});
		}else{
			jQuery(".autoList>li").show();
		}
	}
</script>
<style type="text/css">
	.autoMain{
		position:absolute;
		background-color:#FFF;
		width:{$width}px;
		border:1px solid #CCC;
		display:none;
	}
	.autoClose{
		border-bottom:1px solid #DDD;
		background:#ccc;
		width:100%;
	}
	.autoList{
		list-style:none;
		margin:0px;
		padding:0px;
		height:{$height}px;
		overflow-y:auto;
	}
	.autoList li{
		border-bottom:1px solid #DDD;
		padding:2px 10px;
		cursor:pointer;
	}
	.autoList li:hover{
		background-color:#B5BDC4;
	}
</style>
<div class="autoMain">
	<div align="right" class="autoClose"><a id="autoReSet" href="javascript:void(0);">清空重选</a>&nbsp;&nbsp;<a id="autoClose" href="javascript:void(0);">关闭&nbsp;&nbsp;&nbsp;&nbsp;</a></div>
	<ul class="autoList">
HTML;

	$str2= '';
	foreach ($items as &$item) {
		if ($item) {
			$str2 .= "<li>{$item}</li>";
		}
	}
	$str3= <<<HTML
	</ul>
</div>

<!-- ================== end autocomplete ==================== -->
HTML;
		echo $str1, $str2, $str3;
	}
}
?>