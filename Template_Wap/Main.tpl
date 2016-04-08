<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
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
</head>
<body>
<div id="Wrapper">
<!--[if lte IE 6]><div id="Wrapper4ie6"><![endif]-->
<!--S Head-->
<div id="Head">
	<div id="logo" class="logo_qudao" title="盘石渠道业务管理系统"></div>
	<div id="Nav_add">
    	<span class="user">{$strEmpName}，您好！</span>
        {if $strAgentName != ""}
       	<span class="area"><span class="icon_area"></span>{$strAgentName}</span>
        {/if}
        <a href="/?d=Login&a=LoginOut">退出</a>
    </div>
	<div id="Nav">
    	<ul id="ulNav" class="QuDao_nav">
        </ul>
    </div>
</div>
<!--E Head-->
<div id="Main" class="container">
<div id="J_sidenav" class="sidenav">
</div>
    <div id="mainContent" class="content sidenav_neighbour">
    </div>
</div>
{literal} 
<script language="javascript" type="text/javascript">

$(function () {
});

</script>
{/literal} 
</body>
</html>