    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showBackInfoList"}')">客户管理</a><span>&gt;</span>客户资料修改记录</div>
        <!--E crumbs-->   
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">
            	<div class="table_filter_main_row"> 
                    <div class="ui_title">客户名称：</div>
                    <div class="ui_text"><input class="inpCommon" type="text" name="customer_name" style="vertical-align:top;"/></div>
                    <div class="ui_title">录入人：</div>
					<div class="ui_text"><input type="text" class="inpCommon inputer" id = "user_name" name="user_name"/></div>	
                    <div class="ui_title">录入时间：</div>
					<div class="ui_text"  id = "createTime">
                                    <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="create_time_begin" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/> 至
                                    <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="create_time_end" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>
					</div>
                    <div class="ui_title">行业分类：</div>
					<div class="ui_comboBox" name = "industryId" id = "industryId">
                            <select id="industry_pid" name="industry_pid"></select>
                            <select id="industry_id" name="industry_id"></select>
					</div>
                    </div>
		<div class="table_filter_main_row"> 
                        <div class="ui_title">地区：</div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" name="selProvince" class="pri" name="selProvince"></select></div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="selCity" tabindex="3"></select></div>
                        <div class="ui_comboBox"><select id="area_id" class="area" name="area_id"></select></div>
                    	<div class="ui_title">所属代理商：</div>
	                	<div class="ui_text"><input type="text" class="inpCommon" id = "agent_name" name="agent_name"/></div>
	                    <div class="ui_title">客户ID：</div>
	                    <div class="ui_text"><input type="text" class="inpCommon idNum" id = "customer_no" name="customer_no"/></div>
                        <div class="ui_button ui_button_search"> <button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>
                </div>
            </div>
            </form>
        </div>
        <!--E list_link-->
        <!--S list_table_head-->
        <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 客户资料修改记录列表</h4>
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
                                	<th style="width:80px;" title="客户ID">
                                    	<div class="ui_table_thcntr" sort="sort_customer_id">
                                        	<div class="ui_table_thtext">客户ID</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="" title="客户名称">
                                    	<div class="ui_table_thcntr " sort="sort_customer_name">
                                        	<div class="ui_table_thtext">客户名称</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:160px" title="行业">
                                    	<div class="ui_table_thcntr" sort="sort_industry_fullname">
                                        	<div class="ui_table_thtext">行业</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="" title="地区">
                                    	<div class="ui_table_thcntr" sort="sort_area_fullname">
                                        	<div class="ui_table_thtext">地区</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th style="width:90px" title="所属代理商">
                                    	<div class="ui_table_thcntr" sort="sort_agent_name">
                                        	<div class="ui_table_thtext">所属代理商</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:130px" title="录入时间">
                                    	<div class="ui_table_thcntr" sort="sort_create_time">
                                        	<div class="ui_table_thtext">录入时间</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:120px" title="录入人">
                                    	<div class="ui_table_thcntr" sort="sort_user_name">
                                        	<div class="ui_table_thtext">录入人</div><div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:70px;" title="操作">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">操作</div>
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
        <div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
        <!--E list_table_foot-->
            <script type="text/javascript" src="{$JS}pageCommon.js"></script>  
	<script type="text/javascript">
	{literal}
	$(function(){
        $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:true});
        $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
        {/literal}
    	pageList.strUrl="{$strUrl}"; 
    	{literal}
    	pageList.param = "&"+$('#tableFilterForm').serialize();
    	pageList.init();
	});
    
    function QueryData()
    {
        pageList.param = '&'+$("#tableFilterForm").serialize();
        pageList.first();
    }
    
	{/literal}
	</script>