<body class="right_body">
	<style type="text/css">
		label.action {
			font-style:italic;
		}
		ul.type{
			border:2px solid #d6d6d6;
			margin:0px 5px 5px 5px;
			background:url(<?php echo base_url();?>assets/admin/images/table_th.jpg) repeat-x 0 0;
		}
		ul.type label{
			margin:0px 5px 0px 5px;
			vertical-align:middle;
		}
		ul.type label input{
			margin:0px 5px 0px 5px;
			vertical-align:middle;
		}
		li.controller{
			padding:0px 0px 0px 25px;
			line-height:25px;
			border-bottom:1px solid #dfdfdf;
			background:#fff;
		}
		li.controller label{
			margin:0px 5px 0px 5px;
			vertical-align:middle;
		}
		li.controller label input{
			margin:0px 5px 0px 5px;
			vertical-align:middle;
		}
		li.odd{
			background:#f1f1f1;
		}
	</style>
	<script type="text/javascript">
		$(function(){
			$(".class").click(function(){
				$(this).parent().parent().find(":checkbox").prop("checked", $(this).prop("checked"));
			});
			$(".ctrl").click(function(){
				$(this).parent().parent().find(":checkbox").prop("checked", $(this).prop("checked"));
			});
		});
	</script>
	<div class="body">
		<div class="top_subnav">
		<?php echo $this->session->userdata('navigation');?>
		</div>
		<p class="line" style="margin-top:0;"></p>

<!-- ------ content start------ -->
				
		<form method="post" action="<?php echo $post_url; ?>">
		<table class="form" style="width:800px;">
			<?php if ($msg){ ?>
			<tr>
				<td colspan="2">
					<span style="color:red;"><b><?php echo $msg; ?></b></span>
				</td>
			</tr>
			<?php } ?>
			<tr>
            	<th colspan="2"><?php echo $is_new ? '添加角色' : '修改角色'; ?></th>
            </tr>
			<tr>
				<td width="60"><b>角色名：</b></td>
				<td>
					<input type='text' name='role_name' value='<?php echo $role_name; ?>' />
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><b>系统赋予的后台游客权限：</b>
					<?php
						if (empty($admin_guest)) {
							echo '<br/>无';
						}
						foreach ($admin_guest as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => &$act ){
										echo '<label class="action" title="'.$url.'">' . $act['act'] . '</label>';
								 	}
								 ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><b>请选择后台操作权限：</b>
					<?php
						if (empty($admin_have)) {
							echo '<br/>无权授权';
						}
						foreach ($admin_have as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label><input class="class" type="checkbox" /><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label><input class="ctrl" type="checkbox" /><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => &$act ){
										echo '<label class="action" title="'.$url.'">' . form_checkbox('actions[]',$act['id'], $act['checked']) . $act['act'] . '</label>';
								 	}
								 ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><b>系统赋予的前台游客权限：</b>
					<?php
						if (empty($front_guest)) {
							echo '<br/>无';
						}
						foreach ($front_guest as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label><input class="class" type="checkbox" /><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label><input class="ctrl" type="checkbox" /><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => &$act ){
										echo '<label class="action" title="'.$url.'">' . $act['act'] . '</label>';
								 	}
								 ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><b>请选择前台操作权限：</b>
					<?php
						if (empty($front_have)) {
							echo '<br/>无权授权';
						}
						foreach ($front_have as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label><input class="class" type="checkbox" /><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label><input class="ctrl" type="checkbox" /><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => &$act ){
										echo '<label class="action" title="'.$url.'">' . form_checkbox('actions[]',$act['id'], $act['checked']) . $act['act'] . '</label>';
								 	}
								 ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
            	<td colspan="2" style="background:#F6F6F6; text-align:center; line-height:40px;">
					<button class="buttonBig" type="submit">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="buttonBig" type="button" onclick="javascript:window.location.href='<?php echo relative_url('index'); ?>'">返回</button>
				</td>
			</tr>
		</table>
		</form>
        
<!-- ------ content end ------ -->        
        
        
	</div>
</body>
</html>