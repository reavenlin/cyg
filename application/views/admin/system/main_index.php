<!DOCclass html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-class" content="text/html; charset=utf-8" />
<title>后台管理系统</title>
<link rel="stylesheet" class="text/css" href="<?php echo base_url();?>assets/admin/css/admin_style.css" />
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/artDialog.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/main.js"></script>
<script>
function openMsgWindow() {
	art.dialog({
		id:'msgDialog',
		title: '提示信息',
		lock:false,
		fixed:true,
		width:300,
		height:100,
		ok: function(){
			this.title('成功提示！').content('操作成功！').time(2);
			return false;
		 },
		 cancel: function(){
			
			return true;
		 },
		content: "<div style='line-height:25px'>您有新的站内信<Br><a href=\"http://www.uimaker.com\">点此阅读</a></div>"
	});
}

function makeLeftMenu( class_idx ){
	$("#class>li>a").removeClass("selected");
	$("#class_"+class_idx).addClass("selected");
	$(".left_title").text( $("#class_"+class_idx).text() );
	
	$.ajax({
	   type: "get",
	   url: "<?php echo relative_url('menu');?>",
	   data: "class=" + $("#class_"+class_idx).text(),
	   dataType: "json",
	   success: function( menu ){
		   $("ul.side").empty();
		   $.each(menu, function(k, v){
			   $("ul.side").append( '<li><a target="mainFrame" href="' + v.url + '">' + v.menu + '</a></li>' );
	       });
		   $("ul.side>li").delegate("a","click",function(){
			    $("#mainFrame").height(window.screen.availHeight);
	        	$("ul.side>li>a").removeClass("selected");
	        	$(this).addClass("selected");
	        });
	   }
	});
}
$(function(){
	$("ul.side>li>a").click(function(){
		$("#mainFrame").height(window.screen.availHeight);
	});	
});

</script>
</head>
<body>
<div class="top">
	<div class="top_member">
		<?php $admin = $this->session->userdata('admin');?>
		欢迎您，<?php echo $admin['username'];?> | <a href="<?php echo relative_url('logout') ;?>">登出</a> <?php /*| <a href="javascript:openMsgWindow();" >2条信息</a> */ ?>
	</div>
	<div class="admin_logo">
		<img width="150" height="40" src="<?php echo base_url();?>assets/admin/images/admin_logo.jpg" />
	</div>
	<div class="top_nav">
		<ul id="class">
			<?php
				$i = 0;
				foreach ($menu as $class => &$controllers ) {
					$selected = $default_class == $class ? ' class="selected" ' : '';
					echo "<li><a id=\"class_{$i}\" {$selected} href=\"javascript:makeLeftMenu({$i});\" >{$class}</a></li>";
					$i++;
				}
			?>
		</ul>
	</div>
</div>
<div class="side_switch" id="side_switch">
</div>
<div class="side_switchl" id="side_switchl">
</div>
<div class="left">
	<div class="left_title"><?php echo $default_class;?></div>
	<ul class="side">
		<?php
			foreach ($menu as $class => &$controllers ) {
				if ($default_class != $class) {
					continue;
				}
				foreach ($controllers as $ctrl => &$actions) {
					foreach ($actions as &$act ) {
						$selected = $default_url == $act['url'] ? ' class="selected" ' : '';
						$url = site_url( $act['url'] );
						echo "<li><a target='mainFrame' {$selected} href='{$url}'>{$act['menu']}</a></li>";
					}
				}
			}
		?>
	</ul>
</div>
<div class="right">
<iframe id="mainFrame" name="mainFrame" src="<?php echo site_url($default_url);?>" frameborder="0" scrolling="no" width="100%" height="100%"></iframe>
</div>
</body>
</html>
