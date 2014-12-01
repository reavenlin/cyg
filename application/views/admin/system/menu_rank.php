<body class="right_body">
	<div class="body">
		<div class="top_subnav">
		<?php echo $this->session->userdata('navigation');?>
		</div>
		<p class="line" style="margin-top:0;"></p>

<!-- ------ content start------ -->
		<style type="text/css">
			#tblMenu tbody tr{
				cursor:move;
			}
			.ui-state-highlight{
				height:30px;
				line-height:30px;
				background-color:#FFFFC8;
			}
			.order{
				border:none;
				back-ground:none;
			}
			.hoverTd{
				background-color:#D7C8EA;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/js/jquery-ui-1.11.0/jquery-ui.min.css" />
		<script src="<?php echo base_url();?>assets/admin/js/jquery-ui-1.11.0/jquery-ui.min.js"></script>
		<script type="text/javascript">
		function sortableConf(){
			return {
				placeholder: 'ui-state-highlight',
				stop:reSort
			};
		}
		function reSort(){
			$("#tblMenu>tbody>tr").each(function(i){
				$(this).find(".order").val(i+1);
				$(this).find(".spanOrder").text(i+1);
			});
		}

		$(document).ready(function(){
			$("#tblMenu>tbody").sortable(sortableConf()); //排序
			$("#tblMenu>tbody").disableSelection();
			$("#tblMenu>tbody>tr").hover(
				function () {
					$(this).find("td").addClass("hoverTd");
			 	},
			   function () {
					$(this).find("td").removeClass("hoverTd");
			});
				
		});
		</script>

        <form method="post" id="form" action="<?php echo relative_url('rank'); ?>">
        <?php echo $err; ?>
		<table id="tblMenu" class="table" style="width: 500px;">
			<thead>
				<tr>
					<th>排序</th>
					<th>上级分类</th>
					<th>菜单名</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach( $menu as &$row ){
			?>
			<tr class="rank">
				<td><input type="hidden" class="order" name="order[<?php echo $row['id']; ?>]" value="<?php echo $row['rank'];?>" /><span class="spanOrder"><?php echo $row['rank'];?></span></td>
				<td><?php echo $row['class']; ?></td>
				<td><?php echo $row['menu']; ?></td>
			</tr>
			<?php
			 }
			 ?>
			 </tbody>
			 <tr>
            	<td colspan="3" style="background:#F6F6F6; text-align:center; line-height:40px;">
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
