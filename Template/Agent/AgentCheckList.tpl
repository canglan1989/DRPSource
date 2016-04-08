<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商资料管理<span>&gt;</span>{$strTitle}</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
    <label>提醒：</label>
    <span class="ui_link"><a href="javascript:;" onclick="JumpPage('/?d=Agent&c=Agent&a=showAgentCheckPager')">未处理：</a>(<em>{$intUnCheckCount}</em>)</span>
    <span class="ui_link"><a href="javascript:searchAgentCheck(0);">新增：</a>(<em>{if $arrCheckNum.addNum eq ''}0{else}{$arrCheckNum.addNum}{/if}</em>)</span>
    <span class="ui_link"><a href="javascript:searchAgentCheck(1);">修改：</a>(<em>{if $arrCheckNum.editNum eq ''}0{else}{$arrCheckNum.editNum}{/if}</em>)</span>
    <span class="ui_link"><a href="javascript:searchAgentCheck(2);">删除：</a>(<em>{if $arrCheckNum.delNum eq ''}0{else}{$arrCheckNum.delNum}{/if}</em>)</span>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">  		
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input type="text" name="agent_name" style="vertical-align:top;" id="agent_name" style="width:200px;"/></div>
                <div class="ui_title">注册地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="pri"></select></div>
                <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="city"></select></div>
                <div class="ui_comboBox"><select id="selArea" class="area" name="area"></select></div>
            </div> 
            <div class="table_filter_main_row"> 
				<div class="ui_title">录入人：</div>
                <div class="ui_text"><input class="inpCommon" name="tbxCreateName" id="tbxCreateName" type="text"/></div>
            	<div class="ui_title">录入时间：</div>
                <div class="ui_text">
                    <input type="text" onclick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}{/literal})" name="startDate" class="inpCommon inpDate" id="J_editTimeS"> 至
                    <input type="text" onclick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}{/literal})" name="endDate" class="inpCommon inpDate" id="J_editTimeE">
                </div>
                <div class="ui_button ui_button_search"><button onclick="searchAgentCheck(100)" class="ui_button_inner" type="button">搜 索</button></div>
            </div>                   
        </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_table_head-->
<!--
<div class="list_link marginBottom10">
    <a m="AgentCheckList" v="8" ispurview="true" class="ui_button" href="javascript:;" onclick="IM.agent.addAuditer('{au d=Agent c=TaskAssign a=TaskAssign}','','审核任务分配')" style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_taskDist"></div><div class="ui_text">审核任务分配</div></div></a>
</div>
-->

<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 代理商资料审核</h4>
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
                   <!--  <th title="全选/反选" style="width:30px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    <input class="checkInp" type="checkbox" onClick="{literal}IM.table.selectAll(this.checked);IM.table.checkAll('listid');{/literal}"/>
                </div>
            </div>
            </th>-->
            <th style="width:80px;" title="编号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">编号</div>
            </div>
            </th>
            <th style="" title="单位名称">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">代理商名称</div>
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
            <th style="width:195px;" title="联系方式">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">联系方式</div>
            </div>
            </th>
            <th style="width:120px;" title="审核人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">审核人</div>
            </div>
            </th>
            <th style="width:80px;" title="信息类型">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">信息类型</div>
            </div>
            </th>
            <th title="录入人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">录入人</div>
            </div>
            </th>
            <th style="width:130px" title="录入\编辑时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">录入\编辑时间</div>
            </div>
            </th>
            <th style="width:60px;" title="操作">
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
	var agentName = $.trim($('#agent_name').val());
	var provinceId = $('#selProvince').val();
	var cityId = $('#selCity').val();
	var areaId = $('#selArea').val();
	var startDate = $('#J_editTimeS').val();
	var endDate = $('#J_editTimeE').val();
	var dataType = 100;
	pageList.param = '&agentName='+encodeURIComponent(agentName)+'&provinceId='+provinceId+'&cityId='+cityId+'&areaId='+areaId
        +'&startDate='+startDate+'&endDate='+endDate+'&dataType='+dataType+"&tbxCreateName="+encodeURIComponent($("#tbxCreateName").val());
	pageList.init();
});

function searchAgentCheck(type)
{
	var agentName = $.trim($('#agent_name').val());
	var provinceId = $('#selProvince').val();
	var cityId = $('#selCity').val();
	var areaId = $('#selArea').val();
	var startDate = $('#J_editTimeS').val();
	var endDate = $('#J_editTimeE').val();
	var dataType = type;
	pageList.param = '&agentName='+encodeURIComponent(agentName)+'&provinceId='+provinceId+'&cityId='+cityId+'&areaId='+areaId
        +'&startDate='+startDate+'&endDate='+endDate+'&dataType='+dataType+"&tbxCreateName="+encodeURIComponent($("#tbxCreateName").val());

	pageList.first();
}
    {/literal}
</script>