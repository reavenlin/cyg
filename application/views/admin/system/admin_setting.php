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
			label.role input{
				margin:0px 5px 0px 5px;
				vertical-align:middle;
			}
		</style>
		
		<script type="text/javascript">
		
		var ratingMsgs = ["太短","弱","一般","很好","极佳","未评级"];
		var ratingMsgColors = ["#676767","#aa0033","#f5ac00","#6699cc","#008000","#676767"];
		var barColors = ["#dddddd","#aa0033","#ffcc33","#6699cc","#008000","#676767"];

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
			document.getElementById('new_passwd').value = strPasswd;
			CreateRatePasswdReq();
		}
		
		function CreateRatePasswdReq() {
			var pwd = document.getElementById("new_passwd");
			if(!pwd) return false;
			passwd=pwd.value;
			var min_passwd_len = 6;
			if (passwd.length < min_passwd_len)  {
				if (passwd.length > 0) {
					DrawBar(0);
				} else {
					ResetBar();
				}
			} else {
				//We need to escape the password now so it won't mess up with length test
				rating = checkPasswdRate(passwd);
				DrawBar(rating);
			}
		}
		
		function DrawBar(rating) {
			var posbar = document.getElementById('posBar');
			var negbar = document.getElementById('negBar');
			var passwdRating = document.getElementById('passwdRating');
			var barLength = document.getElementById('passwdBar').width;
			if (rating >= 0 && rating <= 4) {  //We successfully got a rating
				posbar.style.width = barLength / 4 * rating + "px";
				negbar.style.width = barLength / 4 * (4 - rating) + "px";
			} else {
				posbar.style.width = "0px";
				negbar.style.width = barLength + "px";
				rating = 5; // Not rated Rating
			}
			posbar.style.background = barColors[rating];
			passwdRating.innerHTML = "<font color='" + ratingMsgColors[rating] + "'>" + ratingMsgs[rating] + "</font>";
		}
		
		//Resets the password strength bar back to its initial state without any message showing.
		function ResetBar() {
			var posbar = document.getElementById('posBar');
			var negbar = document.getElementById('negBar');
			var passwdRating = document.getElementById('passwdRating');
			var barLength = document.getElementById('passwdBar').width;
			posbar.style.width = "0px";
			negbar.style.width = barLength + "px";
			passwdRating.innerHTML = "";
		}
		
		
		//CharMode函数
		//测试某个字符是属于哪一类.
		function CharMode(iN){
			if (iN>=48 && iN <=57) //数字
			return 1;
			if (iN>=65 && iN <=90) //大写字母
			return 2;
			if (iN>=97 && iN <=122) //小写
			return 4;
			else
			return 8; //特殊字符
		}
		//bitTotal函数
		//计算出当前密码当中一共有多少种模式
		function bitTotal(num){
			modes=0;
			for (i=0;i<4;i++){
				if (num & 1) modes++;
				num>>>=1;
			}
			return modes;
		}
		//checkStrong函数
		//返回密码的强度级别
		function checkPasswdRate(sPW){
			if (sPW.length < 8)
			return 0; //密码太短
			Modes=0;
			for (i=0;i<sPW.length;i++){
				//测试每一个字符的类别并统计一共有多少种模式.
				Modes|=CharMode(sPW.charCodeAt(i));
			}
			return bitTotal(Modes);
		}
		</script>
		<form method="post" action="#">
		<table class="form" style="width:800px;">
			<tr>
            	<th colspan="2">修改密码</th>
            </tr>
			<tr>
				<td class="label">用户名：</td>
				<td><?php echo  $username; ?></td>
			</tr>
			<tr>
				<td class="label">真实姓名：</td>
				<td><?php echo $real_name;?></td>
			</tr>
			<tr>
				<td class="label">旧密码</td>
				<td>
					<input type='text' name='passwd' value='<?php echo  $passwd; ?>' id="passwd" />
				</td>
			</tr>
			<tr>
				<td class="label">新密码</td>
				<td>
					<input type='text' name='new_passwd' value='<?php echo  $passwd; ?>' id="new_passwd" onkeyup="CreateRatePasswdReq();" onchange="CreateRatePasswdReq();" />
					<button name="generate" type="button" onclick="getRandPasswd();" >生成</button>
				</td>
			</tr>
			<tr>
				<td class="label">密码强度</td>
				<td>
				<span style="color:#808080" id="passwdRating"></span>
				<table id="passwdBar" cellSpacing="0" cellPadding="0" border="0" width="160" height="8">
					<tr>
			            <td style="padding:0px;" id="posBar" width="0%" bgColor="#e0e0e0"></td>
			            <td style="padding:0px;" id="negBar" width="100%"  bgColor="#e0e0e0"></td>
			        </tr>
				</table>
				</td>
			</tr>
			<?php if ($msg){?>
			<tr>
				<td colspan="2" style="text-align:center;color: red;"><b><?php echo $msg;?></b></td>
			</tr>
			<?php }?>
			<tr>
            	<td colspan="2" style="background:#F6F6F6; text-align:center; line-height:50px;">
					<button class="buttonBig" type="submit">保存</button>
				</td>
			</tr>
		</table>
		</form>
        
<!-- ------ content end ------ -->        
        
        
	</div>
</body>
</html>
