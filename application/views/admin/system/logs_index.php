<body class="right_body">
	<div class="body">
		<div class="top_subnav">
		<?php echo $this->session->userdata('navigation');?>
		</div>
		<p class="line" style="margin-top:0;"></p>

<!-- ------ content start------ -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/My97DatePicker/WdatePicker.js"></script>
		
        <form method="get" action="<?php echo  relative_url('index'); ?>">
		<table class="table">
        	<tr>
            	<td colspan="6" style="background:#F6F6F6; text-align:left; line-height:40px;">
		        &nbsp;&nbsp;操作者：<input name="actor" value="<?php echo $actor;?>" type="text" class="text" size="15" />
		                时间：从 <input name="start_time" value="<?php echo $start_time;?>" type="text" class="text" size="10" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"/>
		        	  到 <input name="end_time" value="<?php echo $end_time;?>" type="text" class="text" size="10" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"/>
		       	详细操作：<input name="operate" value="<?php echo $operate;?>" type="text" class="text" size="20"/>
                <button type="submit" class="search">查询</button>
                </td>
            </tr>
			<tr>
				<th>ID</th>
				<th>操作者</th>
				<th>时间</th>
				<th>详细操作</th>
				<th>涉及ID</th>
				<th>备注</th>
			</tr>
<?php
			foreach( $logs as &$row ){
			?>
			<tr>
				<td><?php echo  $row['id']; ?></td>
				<td><?php echo  $row['actor']; ?></td>
				<td><?php echo  date('Y-m-d H:i:s',$row['create_time']); ?></td>
				<td style="text-align: left;padding-left:10px;"><?php echo  $row['operate']; ?></td>
				<td><?php echo  $row['related_id']; ?></td>
				<td><?php echo  $row['detail']; ?></td>
			</tr>
			<?php
			 }
			 ?>
			 <tr>
			 <td colspan="6" style="background:#FFF; text-align:center; line-height:30px;">
			 	<?php echo $pager; ?>
			</td>
			</tr>
		</table>
        </form>
        
<!-- ------ content end ------ -->        
        
        
	</div>
</body>
</html>
