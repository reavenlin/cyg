<body class="right_body">
	<div class="body">
		<div class="top_subnav">
		<?php echo $this->session->userdata('navigation');?>
		</div>
		<p class="line" style="margin-top:0;"></p>

<!-- ------ content start------ -->

		<script type="text/javascript">
			function getRandPasswd(){
				var strPasswd = '';
				var str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				var len = str.length;
				var rand = 0;
				var i = 0;
				for(i=0; i<8; i++){
					rand = parseInt( len * Math.random());
					strPasswd += str.charAt(rand);
				}
				document.getElementById('passwd').value = strPasswd;
			}
		</script>
		<style type="text/css">
			label.role{
				margin:0px 5px 0px 5px;
				vertical-align:middle;
			}
			label.role input{
				margin:0px 5px 0px 5px;
				vertical-align:middle;
			}
		</style>	
		<form method="post" action="<?php echo $url; ?>">
		<table class="form" style="width:800px;">
			<?php if ($msg){ ?>
			<tr>
				<td colspan="2">
					<span style="color:red;"><b><?php echo $msg; ?></b></span>
				</td>
			</tr>
			<?php } ?>
			<tr>
            	<th colspan="2">添加后台用户</th>
            </tr>
			<tr>
				<td class="label">用户名：</td>
				<td>
					<input type='text' name='username' value='<?php echo $username; ?>' <?php if ( !$is_new ) { ?>readonly="readonly"<?php }?>  />
				</td>
			</tr>
			<tr>
				<td class="label">密码<?php if( !$is_new ){ ?>(不修改则留空)：<?php } ?></td>
				<td>
					<input type='text' name='passwd' value='<?php echo $passwd; ?>' id="passwd" />
					<button name="generate" type="button" onclick="getRandPasswd();" >生成</button>
				</td>
			</tr>
			<tr>
				<td class="label">真实姓名：</td>
				<td>
					<input type='text' name='real_name' value='<?php echo $real_name;?>' />
				</td>
			</tr>
			<tr>
				<td class="label">权限角色组：</td>
				<td>
				<?php
					foreach ( $roles as &$r ) {
						echo '<label class="role">' . form_checkbox('roles[]',$r['id'], $r['checked']) . $r['role_name'] .'</label>';
					}
				?>
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
