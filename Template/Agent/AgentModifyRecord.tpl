    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商资料管理<span>&gt;</span>代理商修改记录</div>
        <!--E crumbs-->   
        <!--S table_filter-->
        <div class="table_filter marginBottom10">  
        	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
            <div class="table_filter_main" id="J_table_filter_main">    		
            	<div class="table_filter_main_row">  
	                <div class="ui_title">代理商名称：</div>
	                <div class="ui_text"><input class="inpCommon" type="text" name="agent_name" style="vertical-align:top;" id="agent_name"/></div>
					<div class="ui_title">注册地区：</div>
	                <div class="ui_comboBox">
<select id="selProvince" class="pri" name="pri"></select>
<select id="selCity" class="city" name="city"></select>
<select id="selArea" class="area" name="area"></select>
</div>
                    <div class="ui_title">创建时间：</div>
					<div class="ui_text">
						<input type="text" onclick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}{/literal})" name="startDate" class="inpCommon inpDate" id="J_editTimeS"> 至
						<input type="text" onclick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}{/literal})" name="endDate" class="inpCommon inpDate" id="J_editTimeE">
					</div>
					<div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="searchModifyList();">搜索</button></div>    
                </div>
            </div>
            </form>
        </div>
        <!--E table_filter-->

        <!--S list_table_head-->
        <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 代理商修改记录</h4>
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
                                	<th style="width:80px;" title="编号">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">编号</div>
                                        </div>
                                    </th>
    								<th style="" title="单位名称">
                                    	<div class="ui_table_thcntr ">
                                        	<div class="ui_table_thtext">代理商名称</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                					<th title="地区">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">地区</div>
                                        </div>
                                    </th>          					
                                   <th style="width:80px;" title="负责人">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">负责人</div>
                                        </div>
                                    </th>
    								<th style="width:100px;" title="负责人联系方式">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">负责人联系方式</div>
                                        </div>
                                    </th>
                                    <th title="录入/编辑时间">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">录入/编辑时间</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th title="审核人">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">审核人</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th  title="审核时间">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">审核时间</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                   <th  title="操作人">
                                    	<div class="ui_table_thcntr">
                                        	<div class="ui_table_thtext">操作人</div>
                                            <div class="ui_table_thsort"></div>
                                        </div>
                                    </th>
                                    <th style="width:70px" title="操作">
                                    	<div class="ui_table_thcntr ">
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
	//绑定省市区联动菜单
	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
	//搜索代理商
	{/literal}
	pageList.strUrl="{$strUrl}"; 
	{literal}
	pageList.init();
});
function searchModifyList()
{
	var agentName = $.trim($('#agent_name').val());
	var provinceId = $('#selProvince').val();
	var cityId = $('#selCity').val();
	var areaId = $('#selArea').val();
	var startDate = $('#J_editTimeS').val();
	var endDate = $('#J_editTimeE').val();
	pageList.param = '&agentName='+encodeURIComponent(agentName)+'&provinceId='+provinceId+'&cityId='+cityId+'&areaId='+areaId+'&startDate='+startDate+'&endDate='+endDate;
	pageList.init();
}
{/literal}
</script>