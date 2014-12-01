<body class="right_body">
	<div class="body">
		<div class="top_subnav">
		<?php echo $this->session->userdata('navigation');?>
		</div>
		<p class="line" style="margin-top:0;"></p>

<!-- ------ content start------ -->
		<style type="text/css">
			label.role{
				margin:0px 5px 0px 5px;
				vertical-align:middle;
			}
		</style>
        <form method="get" action="<?php echo relative_url('index'); ?>">
		<table class="table">
        	<tr>
            	<td colspan="9" style="background:#F6F6F6; text-align:left; line-height:40px;">
                <button type="button" class="add" style="margin-right:50px;margin-left:10px;" onclick="javascript:window.location.href='<?php echo relative_url('add'); ?>'">添加</button>
                <span class="split" style="margin-right:50px;">&nbsp;</span>
		                用户名：<input name="username" value="<?php echo $this->input->get('username');?>" type="text" class="text" size="20">
		                真实姓名：<input name="real_name" value="<?php echo $this->input->get('real_name');?>" type="text" class="text" size="20">
                <button type="submit" class="search">查询</button>
                </td>
            </tr>
			<tr>
				<th>ID</th>
				<th>帐号名</th>
				<th>真实姓名</th>
				<th>状态</th>
				<th>权限角色</th>
				<th>注册时间</th>
				<th>最后登录时间</th>
				<th>最后登录IP</th>
				<th>操作</th>
			</tr>
<?php
			foreach( $admins as &$row ){
			?>
			<tr>
				<td><?php echo  $row['id']; ?></td>
				<td><?php echo  $row['username']; ?></td>
				<td><?php echo  $row['real_name']; ?></td>
				<td><span style="color:<?php if ( $row['status'] == MAdmin::STATUS_ENABLE ){ ?>green<?php }else{?>red<?php } ?>;"><b><?php echo $row['status_text']; ?></b></span></td>
				<td><label class="role"><?php echo $row['roles'];?></label></td>
				<td><?php echo  date('Y-m-d H:i', $row['create_time']); ?></td>
				<td><?php echo  date('Y-m-d H:i', $row['last_login_time']); ?></td>
				<td><?php echo  $row['last_login_ip']; ?></td>
				<td width="200">
					<a class="detail" href="<?php echo relative_url('detail/'.$row['id']); ?>"><span>详细</span></a>
					&nbsp;&nbsp;
					<a class="edit" href="<?php echo relative_url('edit/'.$row['id']); ?>"><span>编辑</span></a>
					&nbsp;&nbsp;
					<?php if ( $row['status'] == MAdmin::STATUS_ENABLE ) {?>
					<a class="del" onclick="javasrcipt:return confirm('禁用后此帐号无法登录，确定要禁用吗？');" href="<?php echo relative_url('disable/'.$row['id']); ?>"><span>禁用</span></a>
					<?php }else{ ?>
					<a class="ok" href="<?php echo relative_url('enable/'.$row['id']); ?>"><span>启用</span></a>
					<?php } ?>
				</td>
			</tr>
			<?php
			 }
			 ?>
			 <tr>
			 <td colspan="9" style="background:#FFF; text-align:center; line-height:30px;">
			 	<?php echo $pager; ?>
			</td>
			</tr>
		</table>
		
        </form>
        
<!-- ------ content end ------ -->        
        
        
	</div>
</body>
</html>
