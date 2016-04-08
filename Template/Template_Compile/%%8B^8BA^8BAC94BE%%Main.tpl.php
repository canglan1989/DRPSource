<?php /* Smarty version 2.6.26, created on 2013-01-28 10:55:42
         compiled from Main.tpl */ ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="IE=7" http-equiv="X-UA-Compatible" />
<title>盘石渠道业务系统</title>
<link href="<?php echo $this->_tpl_vars['CSS']; ?>
drp-common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
drp.base.js" ></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
drp.imp.js" ></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
HistoryManager.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
GetDept.js" defer="true"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
drpCommon.js" defer="true"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
calendar/WdatePicker.js" defer="true"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
JSFrameWork/ps_frame_all.js"></script>
</head>
<body>
<div id="Wrapper">
<!--[if lte IE 6]><div id="Wrapper4ie6"><![endif]-->
<!--S Head-->
<div id="Head">
	<div id="logo" class="logo_qudao" title="盘石渠道业务管理系统"></div>
	<div id="Nav_add">
    	<span class="user"><?php echo $this->_tpl_vars['strEmpName']; ?>
，您好！</span>
        <?php if ($this->_tpl_vars['strAgentName'] != ""): ?>
       	<span class="area"><span class="icon_area"></span><?php echo $this->_tpl_vars['strAgentName']; ?>
</span>
        <?php endif; ?>
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
<div style="display:none">
<iframe id="iframeStockData" src="/?a=StockDataPage" style="height:10px;"></iframe>
<!--[if IE]><iframe id="HISTORY_ADAPTER" src="ajaxhistory.html" style="display:none"></iframe><![endif]-->
</div>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
MenuCreate.js"></script>
<?php echo ' 
<script language="javascript" type="text/javascript">

'; ?>
 
Config.evnFlag = parseInt(<?php echo $this->_tpl_vars['sys_evn']; ?>
);
Config.recoverQuery = false;
MenuCreate.RootMenu = "<?php echo $this->_tpl_vars['strRootMenuJson']; ?>
";
MenuCreate.MenuItem = "<?php echo $this->_tpl_vars['strMenuJoson']; ?>
";
<?php echo ' 
$(function () {
    var firstNo = MenuCreate.CreateRootMenu();
    MenuCreate.CreateLeftMenu();
    MenuCreate.GetLeftMenu($(\'#Nav li\').eq(0).find(\'a\')[0]);

    var strHash = window.location.hash;
    if(strHash != "")
    {
        strHash = strHash.substring(1);
        var pUrl = "/?"+strHash;
        JumpPage(pUrl);
        MenuCreate.SelectMenu(pUrl);
    }
    else
    {
        if($(\'#J_sidenav a\')[0])
            $(\'#J_sidenav a\')[0].onclick();
    }
});

</script>
'; ?>
 
</body>
</html>