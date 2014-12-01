<body class="right_body">
	<div class="body">
		<div class="top_subnav">
		<?php echo $this->session->userdata('navigation');?>
		</div>
		<p class="line" style="margin-top:0;"></p>

<!-- ------ content start------ -->
		<style type="text/css">
			.input{
				width:96%;
				height:100%;
				text-align:center;
			}
		</style>
        <form method="post" id="form" action="<?php echo $post_url; ?>">
		<table class="table">
			<tr><td style="text-align: left;padding-left:50px;" colspan="8">注：<b>菜单名</b>，除非此是后台菜单，否则一般留空</td></tr>
			<tr>
				<th width="100">ID</th>
				<th>操作地址</th>
				<th>所属系统</th>
				<th>上级分类</th>
				<th>控制器名</th>
				<th>操作项名</th>
				<th>游客操作</th>
				<th>菜单名</th>
			</tr>
			<?php
			foreach( $actions as $url => &$row ){
			?>
			<tr>
				<td>
				<input type="text" readonly="readonly" class="input" name="actions[<?php echo $url;?>][id]" value="<?php echo $row['id'];?>"></td>
				<td><input type="text"  readonly="readonly" class="input" style="text-align:left;padding-left:50px;" value="<?php echo $url;?>"></td>
				<td><?php echo form_dropdown("actions[{$url}][system]", $system_list, $row['system'], 'style="height:24px;width:56px;"'); ?></td>
				<td><input type="text" class="input class" name="actions[<?php echo $url; ?>][class]" value="<?php echo $row['class'];?>"></td>
				<td><input type="text" class="input" name="actions[<?php echo $url; ?>][ctrl]" value="<?php echo $row['ctrl'];?>"></td>
				<td><input type="text" class="input" name="actions[<?php echo $url; ?>][act]" value="<?php echo $row['act'];?>"></td>
				<td><?php echo form_checkbox("actions[{$url}][guest]",1, 1 == $row['guest'] ); ?>允许</td>
				<td><input type="text" class="input" name="actions[<?php echo $url; ?>][menu]" value="<?php echo $row['menu'];?>"></td>
			</tr>
			<?php
			 }
 			 if( empty($actions) ){
			?>
			<tr>
 				<td colspan="8"><span style="color:red"><b>无新增加的操作项</b></td>
 			</tr>
			<?php
			 }
			 if ($msg){ 
			?>
			<tr>
				<td colspan="8">
					<span style="color:red;"><b><?php echo  $msg; ?></b></span>
				</td>
			</tr>
			<?php } ?>
			<tr>
            	<td colspan="8" style="background:#F6F6F6; text-align:center; line-height:40px;">
					<?php if( !empty($actions) ){ ?><button class="buttonBig" type="submit">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;<?php }?>
					<button class="buttonBig" type="button" onclick="javascript:window.location.href='<?php echo relative_url('index'); ?>'">返回</button>
				</td>
			</tr>
			
		</table>
        </form>
        <?php echo dropdownlist('.class', $class);?>
        
<!-- ------ content end ------ -->        
        
        
	</div>
</body>
</html>
