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
		<table class="form" style="width:800px;">
			<tr>
            	<th colspan="2">后台用户详细信息</th>
            </tr>
			<tr>
				<td class="label" width="80">用户ID：</td>
				<td><?php echo $id; ?></td>
			</tr>
			<tr>
				<td class="label" width="80">用户名：</td>
				<td><?php echo $username; ?></td>
			</tr>
			<tr>
				<td class="label" width="80">真实姓名：</td>
				<td><?php echo $real_name;?></td>
			</tr>
			<tr>
				<td class="label" width="80">权限角色组：</td>
				<td><?php echo $role_names; ?></td>
			</tr>
			
			<tr>
				<td colspan="2"><h3 style="color: green;">游客后台权限：</h3>
					<?php
						if (empty($admin_guest)) {
							echo '无';
						}
						foreach ($admin_guest as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label class="class"><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label class="ctrl"><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => $act ){
								 ?>
								<label class="action" title="<?php echo $url;?>"><?php echo $act; ?></label>
								<?php } ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><h3 style="color: green;">拥有的后台权限：</h3>
					<?php
						if (empty($admin_have)) {
							echo '无';
						}
						foreach ($admin_have as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label class="class"><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label class="ctrl"><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => $act ){
								 ?>
								<label class="action" title="<?php echo $url;?>"><?php echo $act; ?></label>
								<?php } ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><h3 style="color: red;">没有的后台权限：</h3>
					<?php
						if (empty($admin_havenot)) {
							echo '无';
						} 
						foreach ($admin_havenot as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label class="class"><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label class="ctrl"><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => $act ){
								 ?>
								<label class="action" title="<?php echo $url;?>"><?php echo $act; ?></label>
								<?php } ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><h3 style="color: green;">游客前台权限：</h3>
					<?php
						if (empty($front_guest)) {
							echo '无';
						}
						foreach ($front_guest as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label class="class"><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label class="ctrl"><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => $act ){
								 ?>
								<label class="action" title="<?php echo $url;?>"><?php echo $act; ?></label>
								<?php } ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><h3 style="color: green;">拥有的前台权限：</h3>
					<?php
						if (empty($front_have)) {
							echo '无';
						}
						foreach ($front_have as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label class="class"><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label class="ctrl"><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => $act ){
								 ?>
								<label class="action" title="<?php echo $url;?>"><?php echo $act; ?></label>
								<?php } ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2"><h3 style="color: red;">没有的前台权限：</h3>
					<?php
						if (empty($front_havenot)) {
							echo '无';
						} 
						foreach ($front_havenot as $class => &$controllers ){
					 ?>
					<ul class="type">
						<label class="class"><b><?php echo $class;?>：</b></label>
						<?php
							foreach ( $controllers as $ctrl => &$actions ) {
						?>
							<li class="controller">
								<label class="ctrl"><?php echo $ctrl;?></label>
								<span style="font-size:16px;margin-left:10px;vertical-align:middle;">[</span>
								<?php
									foreach ($actions as $url => $act ){
								 ?>
								<label class="action" title="<?php echo $url;?>"><?php echo $act; ?></label>
								<?php } ?>
								<span style="font-size:16px;vertical-align:middle;">]</span>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			
			<tr>
            	<td colspan="2" style="background:#F6F6F6; text-align:center; line-height:40px;">
					<button class="buttonBig" type="button" onclick="javascript:window.location.href='<?php echo relative_url('edit/'.$id); ?>'">编辑</button>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="buttonBig" type="button" onclick="javascript:window.location.href='<?php echo relative_url('index'); ?>'">返回</button>
				</td>
			</tr>
		</table>
        
<!-- ------ content end ------ -->        
        
        
	</div>
</body>
</html>
