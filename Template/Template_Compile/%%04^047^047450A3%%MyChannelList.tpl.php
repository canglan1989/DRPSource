<?php /* Smarty version 2.6.26, created on 2012-12-31 18:00:05
         compiled from Agent/MyChannelList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/MyChannelList.tpl', 2, false),)), $this); ?>
﻿    	<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showChannelPager'), $this);?>
')" href="javascript:;">我的渠道</a><span>&gt;</span>代理商列表</div>
<!--E crumbs-->   
<div class="form_edit">
    <div class="form_hd">
        <ul>
            <li>
                <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showPactAgentPager'), $this);?>
');">
                    <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>签约代理商</h2></div></div></div>
                </a>
            </li>
            <li class="cur">                
                    <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>潜在代理商</h2></div></div></div>
            </li>
        </ul>            
    </div>
    <!--S form_bd-->
    <div class="form_bd">
        <div class="form_block_bd">
            <!--S table_filter-->
            <div class="table_filter marginBottom10">  
                <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
                    <div class="table_filter_main" id="J_table_filter_main">
                        <div class="table_filter_main_row"> 		
                            <div class="ui_title">代理商名称：</div>
                            <div class="ui_text"><input style="width:200px" type="text" name="agent_name" id="agent_name"/></div>

                            <div class="ui_title">意向评级：</div>
                            <div class="ui_comboBox">
                                <select id="leval" name="leval">
                                    <option value="">全部</option>
                                    <option value="A">A</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>

                            <div class="ui_title">注册地区：</div>
                            <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="pri"></select></div>
                            <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="city"></select></div>
                            <div class="ui_comboBox"><select id="selArea" class="area" name="area"></select></div>	

                        </div>
                        <div class="table_filter_main_row">
                            <div class="ui_title">代理商来源：</div>
                            <div class="ui_comboBox">
                                <select id="agent_from" name="agent_from">
                                    <option value="-100">全部</option>
                                    <option value="0">我录入的</option>
                                    <option value="1">自动注册</option>
                                    <option value="2">上级分配</option>
                                </select>
                            </div>	
                            <div class="ui_title">录入/编辑时间：</div>
                            <div class="ui_text">
                                <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="editTimeS" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'J_editTimeE\')).focus()},maxDate:\'#F{$dp.$D(\\\'J_editTimeE\\\')}\'}'; ?>
)"/> 至
                                <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="editTimeE" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS\\\')}\'}'; ?>
)"/>
                            </div>

                            <div class="ui_title">最后联系时间：</div>
                            <div class="ui_text">
                                <input id="J_contactTimeS2" type="text" class="inpCommon inpDate" name="J_contactTimeS" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'J_contactTimeE2\')).focus()},maxDate:\'#F{$dp.$D(\\\'J_contactTimeE2\\\')}\'}'; ?>
)"/> 至
                                <input id="J_contactTimeE2" type="text" class="inpCommon inpDate" name="J_contactTimeE" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_contactTimeS2\\\')}\'}'; ?>
)"/>
                            </div>

                        </div>
                        <div class="table_filter_main_row">
                            <div class="ui_title">审核状态：</div>
                            <div class="ui_comboBox">
                                <select id="auditState" name="auditState">
                                    <option value="-100">全部</option>
                                    <option value="0">未审核</option>
                                    <option value="1">审核通过</option>
                                    <option value="2">审核不通过</option>
                                </select>
                            </div>
                            <div class="ui_title">渠道经理：</div>
                            <div class="ui_comboBox">
                                <input id="u_name" class="inpCommon" type="text" name="u_name" style="vertical-align:top;"/>
                            </div> 
                            <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="searchChannel();">搜 索</button></div>	
                        </div>  
                    </div>
                </form>
            </div>
            <!--E table_filter-->
            <!--S list_link--> 
            <div class="list_link marginBottom10">
                <a class="ui_button" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'AddShow'), $this);?>
')" m="AgentList" v="32" ispurview="true">
                    <div class="ui_button_left"></div>
                    <div class="ui_button_inner">
                        <div class="ui_icon ui_icon_add"></div>
                        <div class="ui_text">添加代理商</div>
                    </div>
                </a>
                <a m="HighSeasList" ispurview="true" v="4" class="ui_button" onclick="ToSea(0)" href="javascript:;">
                    <div class="ui_button_left"></div><div class="ui_button_inner">
                        <div class="ui_text">踢入公海</div></div></a>   
            </div>
            <!--E list_link-->
            <!--S list_table_head-->
            <div class="list_table_head">
                <div class="list_table_head_right">
                    <div class="list_table_head_mid">
                        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 代理商列表</h4>
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
                                <input onClick="<?php echo 'IM.table.selectAll(this.checked);IM.table.checkAll(\'listid\');'; ?>
" class="checkInp" type="checkbox" />
                            </div>
                        </div>
                        </th>
                        <th style="width:70px;" title="代理商ID">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">代理商ID</div>
                        </div>
                        </th>
                        <th title="代理商名称">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">代理商名称</div>
                            <div class="ui_table_thsort"></div>
                        </div>
                        </th>
                        <th title="注册地区">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">注册地区</div>
                        </div>
                        </th>                					
                        <th style="width:65px;" title="意向评级">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">意向评级</div>
                        </div>
                        </th>
                        <th style="width:80px;" title="代理商来源">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">代理商来源</div>
                        </div>
                        </th>
                        <th  title="渠道经理">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">渠道经理</div>
                        </div>
                        </th>
                        <th style="width:65px" title="审核状态">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">审核状态</div>
                        </div>
                        </th>
                        <th style="width:70px;" title="联系次数">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">联系次数</div>
                        </div>
                        </th>
                        <th style="width:130px;" title="录入/编辑时间">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">录入/编辑时间</div>
                            <div class="ui_table_thsort"></div>
                        </div>
                        </th>
                        <th  title="最后联系时间">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">最后联系时间</div>
                        </div>
                        </th>
                        <th style="width:70px" title="操作">
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
            <div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
            <!--E list_table_foot-->
        </div>
    </div>
    <!--E form_bd-->    
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
    <script type="text/javascript">
        <?php echo '
 $(function(){
 	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
        '; ?>

	pageList.strUrl = "<?php echo $this->_tpl_vars['strUrl']; ?>
"; 
        <?php echo '
	pageList.init();
 });
 function searchChannel()
 {
	var agentName  = $.trim($(\'#agent_name\').val());
	var leval      = encodeURIComponent($(\'#leval\').val());
	var provinceId = $(\'#selProvince\').val();
	var cityId     = $(\'#selCity\').val();
	var areaId     = $(\'#selArea\').val();
	var agent_from = $(\'#agent_from\').val();
	var status     = $(\'#auditState\').val();
	var startDate  = $(\'#J_editTimeS\').val();
	var endDate    = $(\'#J_editTimeE\').val();
	var sTime      = $(\'#J_contactTimeS2\').val();
	var eTime      = $(\'#J_contactTimeE2\').val();
    var u_name     = $.trim($(\'#u_name\').val());
    u_name = encodeURIComponent(u_name);
	pageList.page  = 1;
	pageList.param = \'&agentName=\'+encodeURIComponent(agentName)+\'&provinceId=\'+provinceId+\'&cityId=\'+cityId+\'&areaId=\'+areaId+\'&status=\'+status+\'&startDate=\'+startDate+\'&endDate=\'+endDate+\'&sTime=\'+sTime+\'&eTime=\'+eTime+\'&leval=\'+leval+\'&agent_from=\'+agent_from+\'&u_name=\'+u_name;
	//pageList.init();
	pageList.first();
 }

 function QueryData()
 {
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.first();
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