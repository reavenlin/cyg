<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站内容管理系统</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/style.css" />
</head>
<body>
<form action="<?php echo relative_url('login');?>" method="post">
	<div class="login">
		<div class="login_form">			
			<div class="form_info">
				<div class="field">
					<label>用户名：</label>
					<input name="username" type="text" class="text" size="16" value="<?php echo $this->input->post('username'); ?>">
				</div>
				<div class="field">
					<label>密　码：</label>
					<input name="passwd" type="password" class="text" size="16">
				</div>
				<?php if( ADMIN_CAPTCHA_SWITCH ){ ?>
				<div class="field">
					<label>验证码：</label>
					<input name="captcha" type="text" class="text" size="10">
                    <img src="<?php echo relative_url('code');?>" onclick="this.src='<?php echo relative_url('code');?>/?id='+Math.random()*5;" style="cursor:pointer;" alt="验证码,看不清楚?请点击刷新验证码" align="absmiddle" />
				</div>
				<?php } ?>
				<div class="field">
					<label></label>
					<button class="button" style="margin-left:50px;_margin-left:48px"></button>
				</div>
				<?php if($msg){ ?>
				<div class="field" style="color:red;"><?php echo $msg; ?></div>
				<?php } ?>
			</div>
		</div>
	</div>
</form>
</body>
</html>
