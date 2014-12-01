<body class="right_body">
	<div class="body">
		<div class="top_subnav">
		<?php echo $this->session->userdata('navigation');?>
		</div>
		<p class="line" style="margin-top:0;"></p>

<!-- ------ content start------ -->
		<style type="text/css">
			.tdhover{
				background:#bcd4ec !important ;
			}
		</style>
		<script type="text/javascript">
		$(function(){
			$("#selectAll").change(function(){
				var flag = $(this).prop("checked");
				$(".ids").prop("checked", flag);
				if(flag){
					$("tr>td").addClass("tdhover");
				}else{
					$("tr>td").removeClass("tdhover");
				}
			});
			
			$("#btnEdit").click(function(){
				var flag = false;
				$(".ids").each(function(){
					if($( this).prop("checked") ){
						flag = true;
						return true;
					}
				});
				if(!flag){
					alert('未选取任何数据');
					return false;
				}
				$("#form").attr("action", '<?php echo relative_url('edit'); ?>').submit();
			});

			$("#btnDelete").click(function(){
				var flag = false;
				$(".ids").each(function(){
					if($( this).prop("checked") ){
						flag = true;
						return true;
					}
				});
				if(!flag){
					alert('未选取任何数据');
					return false;
				}
				var flag = confirm('确定要删除？');
				if(flag){
					$("#form").prop("action", '<?php echo relative_url('delete'); ?>').submit();
				}
			});

			$("tr").click(function(){
				var obj = $(this).find(":checkbox")
				obj.prop("checked", ! obj.prop("checked"));
			});
			$("tr").hover(
				function(){
					$(this).find("td").addClass("tdhover");
				},
				function(){
					if( ! $(this).find(":checkbox").prop("checked") ){
						$(this).find("td").removeClass("tdhover");
					}
				}
			);
			$(":checkbox").click(function(e){
				e.stopPropagation();
			});
		});
		</script>
        <form method="get" id="form" action="<?php echo relative_url('index'); ?>">
		<table class="table">
			<tr>
            	<th colspan="9" style="background:#F6F6F6; text-align:left; line-height:40px;">
                <button type="button" class="add" style="margin-right:0px;" onclick="javascript:window.location.href='<?php echo relative_url('add'); ?>'">添加</button>
                <button type="button" id="btnEdit" class="buttonBig">编辑</button>
                <button type="button" id="btnDelete" class="buttonBig">删除</button>
                <button type="button" class="buttonBig" style="margin-right:40px;" onclick="javascript:window.location.href='<?php echo relative_url('rank'); ?>'">菜单排序</button>
                <span class="split" style="margin-right:40px;">&nbsp;</span>
           		所属系统：<?php echo form_dropdown('system', $system_list, $system, 'style="width:60px;height:24px;"' ); ?>&nbsp;&nbsp;&nbsp;&nbsp;
		               上级分类：<input id="class" name="class" value="<?php echo $this->input->get('class');?>" type="text" size="15">
		               控制器名：<input id="ctrl" name="ctrl" value="<?php echo $this->input->get('ctrl'); ?>" type="text" size="15">
                <button type="submit" class="search">查询</button>
                </th>
            </tr>
            <tr><th style="text-align: left;" colspan="9">注：字体颜色为<span style="color: red">红色</span>的行,对应的 controller/action 已经不存在。</th></tr>
			<tr>
				<th width="50"><input type="checkbox" id="selectAll" name="selectAll" /><label for="selectAll">全选</label></th>
				<th>ID</th>
				<th>所属系统</th>
				<th>上级分类</th>
				<th>控制器名</th>
				<th>操作项名</th>
				<th>操作地址</th>
				<th>游客访问</th>
				<th>菜单名</th>
			</tr>
			<?php
			foreach( $actions as $url => &$row ){
			?>
			<tr<?php if( $row['status'] == MAction::STATUS_NOT_EXIST ){ echo ' style="color:red;"'; } ?>>
				<td><input type="checkbox" class="ids" name="ids[]" value="<?php echo $row['id'];?>" /></td>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo MAction::$system[$row['system']]; ?></td>
				<td><?php echo $row['class']; ?></td>
				<td><?php echo $row['ctrl']; ?></td>
				<td><?php echo $row['act']; ?></td>
				<td width="200" style="text-align:left; padding-left:50px;"><?php echo $url; ?></td>
				<td><?php echo 1==$row['guest'] ? '允许' : '&nbsp;'; ?></td>
				<td><?php echo $row['menu']; ?></td>
			</tr>
			<?php
			 }
			 ?>
		</table>
        </form>
<?php echo dropdownlist('#class', $class_list);?>        
<!-- ------ content end ------ -->        
        
        
	</div>
</body>
</html>
