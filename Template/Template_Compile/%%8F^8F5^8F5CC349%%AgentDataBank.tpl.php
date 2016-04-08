<?php /* Smarty version 2.6.26, created on 2012-12-17 14:25:11
         compiled from Agent/AgentDataBank.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/AgentDataBank.tpl', 35, false),)), $this); ?>
    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
    <!--E crumbs-->   
    
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">
                <div class="table_filter_main_row">    		
                        <div class="ui_title">代理商名称：</div>
                        <div class="ui_text"><input type="text" name="agent_name" style="vertical-align:top;width:200px" id="agent_name"/></div>
                        <div class="ui_title">渠道经理姓名/工号：</div>
                        <div class="ui_text"><input class="inpCommon" type="text" name="channel_name" style="vertical-align:top;" id="channel_name"/></div>
                        <div class="ui_title">意向评级：</div>
                        <div style="width:100px;" id="agent_level" data="[<?php echo '{\'key\':\'A\',\'value\':\'A\'},{\'key\':\'B\',\'value\':\'B\'},{\'key\':\'C\',\'value\':\'C\'},{\'key\':\'D\',\'value\':\'D\'},{\'key\':\'E\',\'value\':\'E\'}'; ?>
]" value="" key="" control="agentPro" class="ui_comboBox ui_comboBox_def" onclick="IM.comboBox.init(<?php echo '{\'control\':MM.A(this,\'control\'),data:MM.A(this,\'data\')}'; ?>
,this)">
                        <div style="width:80px;" class="ui_comboBox_text">
                        	<nobr>全部</nobr>
                        </div>
                        <div class="ui_icon ui_icon_comboBox"></div>                        
                    </div>
                   </div>
                   <div class="table_filter_main_row">   
                        <div class="ui_title">注册地区：</div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="pri"></select></div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="city"></select></div>
                        <div class="ui_comboBox"><select id="selArea" class="area" name="area"></select></div>        
                        <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" id="AgentSearch" name="AgentSearch" onclick="searchAgent()">搜索</button></div>        
                  </div>
            </div>
        </form>
        </div>
        <!--E table_filter-->
        <!--S list_link-->
        <div class="list_link marginBottom10">
            <a class="ui_button" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'AddCheckShow'), $this);?>
')"  m="showAgentPager" v="4" ispurview="true"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_add"></div><div class="ui_text">添加代理商</div></div></a>       
            <a m="HighSeasList" ispurview="true" v="4" class="ui_button" onclick="ToSea(0)" href="javascript:;">
                    <div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">踢入公海</div></div></a>                       
            <a href="javascript:;" class="ui_button" onClick="IM.account.delOper('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'mulitPhysicsDel'), $this);?>
',<?php echo '{}'; ?>
,'放入回收库')" ><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">放入回收库</div></div></a>            
            <a m="showAgentPager" v="32" ispurview="true" class="ui_button ui_button_dis" href="javascript:;" onClick="IM.account.delOper('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'mulitDelAgent'), $this);?>
',<?php echo '{}'; ?>
,'彻底删除')" ><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">彻底删除</div></div></a>
            <a class="ui_button" onclick="ExportExcel()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">导出Excel</div></div></a>
        </div>
        <!--E list_link-->
        <!--S list_table_head-->
        <div class="list_table_head">
                <div class="list_table_head_right">
                    <div class="list_table_head_mid">
                        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
			<a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
                    </div>
                </div>
        </div>
        <!--E list_table_head-->
        <!--S list_table_main-->
        <div class="list_table_main">
        <div id="J_ui_table" class="ui_table">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                <th title="全选/反选" style="width:30px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                <input class="checkInp" type="checkbox" onClick="<?php echo 'IM.table.selectAll(this.checked);IM.table.checkAll(\'listid\');'; ?>
"/>
                </div>
            </div>
            </th>
            <th style="width:90px;" title="编号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">编号</div>
            </div>
            </th>
            <th title="单位名称">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">单位名称</div>
            </div>
            </th>
            <th title="意向评级" style="width:80px;">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">意向评级</div>
            </div>
            </th>
            <th title="地区">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">注册地区</div>
            </div>
            </th>              					
            <th style="width:80px;" title="负责人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">负责人</div>
            </div>
            </th>
            <th style="width:130px;" title="渠道经理">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">渠道经理</div>
            </div>
            </th>
            <th style="width:100px;" title="负责人联系方式">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">负责人联系方式</div>
            </div>
            </th>
            <th style="width:130px;" title="审核时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">审核时间</div>
            </div>
            </th>                                   
            <th style="width:90px;"title="操作">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">操作</div>
            </div>
            </th>
            </tr>
            </thead>
            <tbody class="ui_table_bd" id="pageListContent"></tbody>
            </table>
        </div>
        <!--E ui_table-->
        </div>
        <!--E list_table_main-->           
        <!--S list_table_foot-->
        <div class="list_table_foot"><div id="divPager" class="ui_pager"></div>
        <!--E list_table_foot-->

    
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<script type="text/javascript">
    <?php echo '
 $(function(){
 	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['strUrl']; ?>
"; 
    <?php echo '
	pageList.init();
 });
 function searchAgent()
 {
	var agentName    = $.trim($(\'#agent_name\').val());
	var provinceId   = $(\'#selProvince\').val();
	var cityId       = $(\'#selCity\').val();
	var areaId       = $(\'#selArea\').val();
	var channel_name = $(\'#channel_name\').val();
	var agentLevel   = $(\'#agent_level\').attr(\'key\');
	pageList.param = \'&agentName=\'+encodeURIComponent(agentName)+\'&provinceId=\'+provinceId+\'&cityId=\'+cityId+\'&areaId=\'+areaId+\'&channel_name=\'+encodeURIComponent(channel_name)+\'&agentLevel=\'+agentLevel;

	pageList.first();
 }
    
function QueryData()
{
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.first();
}

function ExportExcel()
{
    window.open("/?d=Agent&c=Agent&a=ExcelExportAgentList" + pageList.param + "&sortField=" + pageList.sortField);
}

_InDealWith = false;
 function ToSea(agentID)
 {    
    if(agentID == 0)
    {
        var chkID = document.getElementsByName("listid");
        var ids = "";
    	for(var i = 0;i < chkID.length;i++)
    	{
    		if(chkID[i].checked && chkID[i].disabled == false)
            {
    			ids += "," + chkID[i].value;
            }
    	}
            
    	if(ids.length > 1)
            agentID = ids.substring(1, ids.length);
        else
        {
            IM.tip.warn("请选择代理商！");
            return ;
        }
    }

    if(!confirm("你确定要将代理商踢入公海吗？"))
		return false;
        
    if (_InDealWith) 
    {
    	IM.tip.warn("数据已提交，正在处理中！");
    	return false;
    }

    _InDealWith = true;
    var backData = $PostData(\'/?d=Agent&c=HighSeas&a=InSea&ids=\'+agentID); 
    if(parseInt(backData) == 0){
        pageList.reflash();
	    _InDealWith = false;
        IM.tip.show("操作成功！");
	}else{
        _InDealWith = false;
        IM.tip.warn(backData);
	}
 }

'; ?>

</script>    