<?php /* Smarty version 2.6.26, created on 2012-11-09 18:22:27
         compiled from FrontLogin.tpl */ ?>
﻿<!DOCTYPE html>
<html style="background:#f7f7f7">
<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
<meta content="IE=7" http-equiv="X-UA-Compatible"/>
<title>盘石渠道业务系统</title>
<link href="<?php echo $this->_tpl_vars['CSS']; ?>
drp-common.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
drp.base.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
drp.imp.js"></script>
<?php echo '
<script type="text/javascript">
    if (self != top && parent.document.body.tagName == "BODY")
        self.parent.location.href = self.location.href;
</script>
'; ?>

</head>
<body id="wm_login">
<div id="wm_login_wrapper">
	<div class="loginArea">
		<h1 class="logo"></h1>
		<div class="loginForm">        	
			<div class="loginFormInner">
            	<div class="loginErrWrap"><div class="loginErr" style="display:none;"></div></div>
            	<form id="J_loginForm" action="" method="post" name="J_loginForm">
                        <p><label>用户名：</label>
						<input class="inp username" type="text" name="username"  tabindex="1" maxlength="32" value="<?php echo $this->_tpl_vars['strUserName']; ?>
" />
						<p style="margin-bottom:6px;"><label>密&nbsp;&nbsp;&nbsp;码：</label>
                        <input class="inp password" type="password" name="password" tabindex="2" maxlength="32"/>
                        </p>
                        <p style="line-height:normal; margin-bottom:30px;"><label>&nbsp;</label><input style="margin:0; vertical-align:middle;" type="checkbox" name="rememberMe" class="checkInp rememberMe" value="1"/> <span>保存我的信息<?php echo $this->_tpl_vars['evnFlag']; ?>
</span></p>               
						<p style="line-height:normal"><label>&nbsp;</label>
                        	<button type="submit" name="submit" class="loginSubmitBtn">登 录</button>
                        </p>                
                </form>
            </div>
		</div>
	</div>
    <div class="ft" style="background:#f7f7f7">
        <p style="margin-bottom:30px;">Copyright©2011-2012 All Resrved 版权所有：盘石信息技术有限公司 浙ICP备06037229号<br/>业务咨询服务热线：400 100 1110&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;技术支持服务热线：400 100 1115</p>
        <div style="background:#ffeec9; padding:5px 10px; width:725px; margin:0 auto">
        	<p><b>温馨提示：</b>为了您的业务能更有效地进行，建议使用IE 8.0以上或Firefox 6.0以上版本浏览器。
            	您当前使用的浏览器是：<span id="spanBrowser" style="font-weight:700"></span>
            </p>
         <p><a href="http://drp.dpanshi.com/Downloads/IE8-WindowsXP-x86-CHS.rar" target="_blank" title="IE 8.0 下载">IE 8.0 下载</a>&nbsp;&nbsp;&nbsp;<a href="http://drp.dpanshi.com/Downloads/FirefoxSetup7.0.1_cn.rar" target="_blank" title="Firefox 7.0 下载">Firefox 7.0 下载</a></p>
         </div>
    </div>
</div>
<?php echo '
<script language="javascript" type="text/javascript">
var _InDealWith = false;
(function(){	
    '; ?>

    var err_msg = "<?php echo $this->_tpl_vars['errMsg']; ?>
";
    <?php echo '
	$(\'.username\').focus();
    
    var bro=$.browser;
    var binfo="";
    if(bro.msie) {binfo = "IE "+bro.version;}
    else if(bro.mozilla) {binfo = "Firefox " + bro.version;}
    else if(bro.safari) {binfo = "Safari " + bro.version;}
    else if(bro.opera) {binfo = "Opera " + bro.version;}
    else {binfo = "未知";}    
    $("#spanBrowser").html(binfo);
    
    if(err_msg.length > 0)
        $(\'.loginErr\').html(err_msg).hide().fadeIn(200);
        
	$(\'#J_loginForm\').submit(function(){
	   if (_InDealWith) 
		{
			IM.tip.warn("正在登录中，请稍等……");
			return false;
		}
		var username = $(\'.username\').val();
		var password = $(\'.password\').val();
		var loginErr = $(\'.loginErr\');		
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
'; ?>

</body>
</html>