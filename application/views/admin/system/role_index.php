<body class="right_body">
	<div class="body">
		<div class="top_subnav">
		<?php echo $this->session->userdata('navigation');?>
		</div>
		<p class="line" style="margin-top:0;"></p>

<!-- ------ content start------ -->

        <form method="get" action="<?php echo relative_url('index'); ?>">
		<table class="table">
        	<tr>
            	<td colspan="3" style="background:#F6F6F6; text-align:left; line-height:40px;">
                <button type="button" class="add" style="margin-right:50px;margin-left:10px;" onclick="javascript:window.location.href='<?php echo relative_url('add'); ?>'">添加</button>
                <span class="split" style="margin-right:50px;">&nbsp;</span>
		                角色名：<input name="role_name" value="<?php echo $this->input->get('role_name'); ?>" type="text" class="text" size="20">
                <button type="submit" class="search">查询</button>
                </td>
            </tr>
			<tr>
				<th>ID</th>
				<th>角色名</th>
				<th>操作</th>
			</tr>
<?php
			foreach( $roles as &$row ){
			?>
			<tr>
				<td><?php echo  $row['id']; ?></td>
				<td><?php echo  $row['role_name']; ?></td>
				<td width="200">
					<a class="detail" href="<?php echo relative_url('detail/'.$row['id']); ?>"><span>详细</span></a>
					&nbsp;&nbsp;
					<a class="edit" href="<?php echo relative_url('edit/'.$row['id']); ?>"><span>编辑</span></a>
					&nbsp;&nbsp;
					<a class="del" onclick="javasrcipt:return confirm('删除后可能导致部分用户无法使用某些模块，确定要删除吗？');" href="<?php echo relative_url('delete/'.$row['id']); ?>"><span>删除</span></a>
				</td>
			</tr>
			<?php
			 }
			 ?>
			 <tr>
			 <td colspan="3" style="background:#FFF; text-align:center; line-height:30px;">
			 	<?php echo $pager; ?>
			</td>
			</tr>
		</table>
        </form>
        
<!-- ------ content end ------ -->        
        
        
	</div>
</body>
</html>
