<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商签约管理<span>&gt;</span>已签约</div>
    <!--E crumbs-->   
    <!--S table_filter-->
    <div class="table_filter marginBottom10">  
	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
        	<div class="table_filter_main_row">  
                <div class="ui_title">单位：</div>
                <div class="ui_text"><input id="agent_name" class="inpCommon" type="text" name="agent_name"/></div>
                <div class="ui_title">地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;">
                    <select class="pri" name="pri" id="selProvince"></select>
                </div>
                <div class="ui_comboBox" style="margin-right:5px;">
                    <select class="city" name="city" id="selCity"></select>
                </div>
                <div class="ui_comboBox">
                    <select class="area" name="area" id="selArea"></select>
                </div>
                <div class="ui_title">签约产品：</div>
                <div class="ui_comboBox">
                    <select name="productType" id="productType">
                    <option value="0">全部</option>
                    {foreach from=$arrProductType item=type}
                        <option value="{$type.aid}">{$type.product_type_name}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="searchAgent()">搜 索</button></div> 
            </div>
	    </div>
	</form>
    </div>
    <!--E table_filter-->
    <!--S list_table_head-->
	<div class="list_table_head">
                <div class="list_table_head_right">
                    <div class="list_table_head_mid">
                        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>代理商签约审核列表</h4>
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
		    <div class="ui_table_thtext">单位名称</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
		<th style="" title="地区">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">地区</div>
		</div>
		</th>
		<th style="width:100px;" title="签约产品">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">签约产品</div>
		</div>
		</th>
		<th style="width:70px;" title="提交人">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">提交人</div>
		</div>
		</th>
		<th style="width:80px;" title="签约审核人">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">签约审核人</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
		<th style="width:130px;" title="签约审核时间">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">签约审核时间</div>
		</div>
		</th>
		<th style="width:80px;" title="代理商等级">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">代理商等级</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
		<th style="width:120px" title="操作">
		<div class="ui_table_thcntr ">
		    <div class="ui_table_thtext">操作</div>
		    <div class="ui_table_thsort"></div>
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
    <div class="list_table_foot">
	<div id="divPager" class="ui_pager">

	</div>
    </div>
<script>
    {literal}
$(document).ready(function(){
    pageList.strUrl={/literal}"{$strUrl}"{literal};
    pageList.init();
    $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
});
    
 function searchAgent()
 {
    var agentName = $.trim($('#agent_name').val());
    var provinceId = $('#selProvince').val();
    var cityId = $('#selCity').val();
    var areaId = $('#selArea').val();
    var productType=$('#productType').val();
    pageList.page = 1;
    pageList.param = '&agentName='+agentName+'&provinceId='+provinceId+'&cityId='+cityId+'&areaId='+areaId+'&productType='+productType;
    pageList.init();
 }
    {/literal}
</script>			    
