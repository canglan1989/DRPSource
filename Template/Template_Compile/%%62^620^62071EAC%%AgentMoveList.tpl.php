<?php /* Smarty version 2.6.26, created on 2012-11-19 16:40:17
         compiled from Agent/AgentMoveList.tpl */ ?>
﻿    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商资料管理<span>&gt;</span>代理商转移记录</div>
    <!--E crumbs-->   
    <!--S table_filter-->
    <div class="table_filter marginBottom10">  
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
        	<div class="table_filter_main_row">     		
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input class="inpCommon" type="text" name="agent_name" id="agent_name"/></div>                    
                <div class="ui_title">注册地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="pri"></select></div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="city"></select></div>
                <div class="ui_comboBox"><select id="selArea" class="area" name="area"></select></div>	              
                <div class="ui_title">代理商编号/ID：</div>
		<div class="ui_text"><input class="inpCommon" type="text" name="agent_no" style="vertical-align:top;" id="agent_no"/></div>  
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onClick="searchAgentMove();">搜索</button></div>   
            </div>                             
        </div>
        </form>
    </div>
    <!--E table_filter-->
    <!--S list_table_head-->
    <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 代理商转移记录</h4>
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
                                <th style="width:90px;" title="代理商编号/ID">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">代理商编号/ID</div>
                                    </div>
                                </th>
                                <th style="" title="单位名称">
                                    <div class="ui_table_thcntr ">
                                        <div class="ui_table_thtext">单位名称</div>
                                        <div class="ui_table_thsort"></div>
                                    </div>
                                </th>
                                <th title="地区">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">地区</div>
                                    </div>
                                </th>
                                <th style="width:120px;" title="转出账号">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">转出账号</div>
                                    </div>
                                </th>  
                                <th style="width:120px;" title="转入账号">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">转入账号</div>
                                    </div>
                                </th>              					
                               <th style="width:130px;" title="转移时间">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">转移时间</div>
                                    </div>
                                </th>
                               <th style="width:130px;" title="操作人">
                                    <div class="ui_table_thcntr">
                                        <div class="ui_table_thtext">操作人</div>
                                    </div>
                                </th>
                           </tr>
                       </thead>
                       <tbody class="ui_table_bd" id="pageListContent">
                         
                        </tbody>
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
 function searchAgentMove()
 {
	var agent_no = $(\'#agent_no\').val();
	var agentName = $.trim($(\'#agent_name\').val());
	var provinceId = $(\'#selProvince\').val();
	var cityId = $(\'#selCity\').val();
	var areaId = $(\'#selArea\').val();
	pageList.page = 1;
	pageList.param = \'&agentName=\'+encodeURIComponent(agentName)+\'&provinceId=\'+provinceId+\'&cityId=\'+cityId+\'&areaId=\'+areaId+\'&agent_no=\'+agent_no;
	pageList.first();
 }
 '; ?>

 </script> 