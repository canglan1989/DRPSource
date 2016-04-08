<!DOCTYPE html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
{literal}
<meta http-equiv="Cache-control" content="no-cache" />
<style type="text/css">
body{font-size:medium;line-height:1.6em;text-align:center}
img{border:0}
form{margin:0;padding:0}
.a{padding-top:6px;margin-top:6px;margin-bottom:6px}
.h{color:#c60a00}
.s{font-size:small}
.b{font-size:small;color:#77C}
.loginErr{color:red}
</style>
{/literal}
<title>盘石渠道业务系统</title>
<script type="text/javascript" src="{$JS}jquery_min_183.js"></script>
{literal}
<script type="text/javascript">
    if (self != top && parent.document.body.tagName == "BODY")
        self.parent.location.href = self.location.href;
</script>
{/literal}
</head>
<div class="loginErrWrap"><div class="loginErr" style="display:none;"></div></div>
<form id="J_loginForm" action="" method="post" name="J_loginForm">
        <p><label>用户名：</label>
		<input class="inp username" type="text" name="username"  tabindex="1" maxlength="32" value="{$strUserName}" />
		<p style="margin-bottom:6px;"><label>密&nbsp;&nbsp;&nbsp;码：</label>
        <input class="inp password" type="password" name="password" tabindex="2" maxlength="32"/>
        </p>
        <p style="line-height:normal; margin-bottom:30px;"><label>&nbsp;</label><input style="margin:0; vertical-align:middle;" type="checkbox" name="rememberMe" class="checkInp rememberMe" value="1"/> <span>保存我的信息{$evnFlag}</span></p>               
		<p style="line-height:normal"><label>&nbsp;</label>
        	<button type="submit" name="submit" class="loginSubmitBtn">登 录</button>
        </p>                
</form>
{literal}
<script language="javascript" type="text/javascript">
var _InDealWith = false;
(function(){	
    {/literal}
    var err_msg = "{$errMsg}";
    {literal}
	$('.username').focus();
        
    if(err_msg.length > 0)
        $('.loginErr').html(err_msg).hide().fadeIn(200);
        
	$('#J_loginForm').submit(function(){
	   if (_InDealWith) 
		{
			IM.tip.warn("正在登录中，请稍等……");
			return false;
		}
		var username = $('.username').val();
		var password = $('.password').val();
		var loginErr = $('.loginErr');		
		if(username == "" ||password == ""){
			loginErr.html("请输入用户名或密码！").hide().fadeIn(200);
			return false;
		}
        
		_InDealWith = true;
		$.ajax({
			type: "POST",
			dataType: "text",
			url: "/?d=Login&a=LoginIn",
			data: $("#J_loginForm").serialize(),
			success: function (data) {
				if(parseInt(data) == 0)
				{
                    _InDealWith = false; 
					location.href = "/?a=ForBack";
				}
				else
				{
                    _InDealWith = false; 
					loginErr.html(data).hide().fadeIn(200);
				}
			}
		});
		return false;
	});
})();
</script>
{/literal}
</body>
</html>