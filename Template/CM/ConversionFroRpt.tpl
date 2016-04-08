<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：客户管理<span>&gt;</span>报表管理<span>&gt;</span>意向转化率统计</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
    <label>总计：</label>
    <span class="ui_link">DE转B-：(<em><label id="avg_item1"></label></em>)</span>
    <span class="ui_link">DE转B+：(<em><label id="avg_item2"></label></em>)</span>
    <span class="ui_link">DE转A：(<em><label id="avg_item3"></label></em>)</span>
    <span class="ui_link">B-转B+：(<em><label id="avg_item4"></label></em>)</span>
    <span class="ui_link">B+转A：(<em><label id="avg_item5"></label></em>)</span>
    <span class="ui_link">B-转A：(<em><label id="avg_item6"></label></em>)</span>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">
<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
<div class="table_filter_main" id="J_table_filter_main">
	<div class="table_filter_main_row">
        <input type="hidden" id = "agent_id" name="agent_id" value="{$agent_id}"/>
        <div class="ui_title">统计时间段：</div>
		<div class="ui_text"  id = "createTime">
	            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="rep_date_begin" value="{$rep_dateb}" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/> 至
	            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="rep_date_end" value="{$rep_datee}" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>
		</div>
        <div class="ui_title">客户经理：</div>{if $IsBack == 0}
        <div class="ui_comboBox">
        <select onchange="UserLevelChange(this)" id="cbUserLevel" name="cbUserLevel">
            <option value="-100">全部</option>
            <option value="1">自己</option>
            <option value="2">下级</option>
        </select>
        </div>{/if}
		<div id="divUserName" class="ui_text"><input type="text" class="inpCommon" id = "user_name" name="user_name"/></div>                    
        <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>
    </div>
    
</div>
</form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
<a  class="ui_button" onclick="pageList.ExportExcel();" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">EXCEL下载</div></div></a>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
<div class="list_table_head_right">
    <div class="list_table_head_mid">
        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>意向等级转化率统计列表</h4>
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
            <th style="" title="客户经理">
            	<div class="ui_table_thcntr" sort="sort_user_id">
                	<div class="ui_table_thtext">客户经理</div><div class="ui_table_thsort"></div>
                </div>
            </th>
           <th style="width:80px;" title="DE转B-">
            	<div class="ui_table_thcntr" sort="sort_de2bm">
                	<div class="ui_table_thtext">DE转B-</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
           <th style="width:80px;" title="DE转B+">
            	<div class="ui_table_thcntr" sort="sort_de2bp">
                	<div class="ui_table_thtext">DE转B+</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="DE转A">
            	<div class="ui_table_thcntr" sort="sort_de2a" >
                	<div class="ui_table_thtext">DE转A</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="B-转B+">
            	<div class="ui_table_thcntr" sort="sort_bm2bp" >
                	<div class="ui_table_thtext">B-转B+</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="B+转A">
            	<div class="ui_table_thcntr" sort="sort_bp2a">
                	<div class="ui_table_thtext">B+转A</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="B-转A">
            	<div class="ui_table_thcntr" sort="sort_bm2a">
                	<div class="ui_table_thtext">B-转A</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="A转B+">
            	<div class="ui_table_thcntr" sort="sort_a2bp">
                	<div class="ui_table_thtext">A转B+</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="A转B-">
            	<div class="ui_table_thcntr" sort="sort_a2bm">
                	<div class="ui_table_thtext">A转B-</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="A转DE">
            	<div class="ui_table_thcntr" sort="sort_a2de">
                	<div class="ui_table_thtext">A转DE</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="B+转B-">
            	<div class="ui_table_thcntr" sort="sort_bp2bm">
                	<div class="ui_table_thtext">B+转B-</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="B+转DE">
            	<div class="ui_table_thcntr" sort="sort_bp2de">
                	<div class="ui_table_thtext">B+转DE</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="B-转DE">
            	<div class="ui_table_thcntr" sort="sort_bm2de">
                	<div class="ui_table_thtext">B-转DE</div><div class="ui_table_thsort"></div>
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
<div id="divPager" class="ui_pager"></div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal}
<script language="javascript" type="text/javascript">
$(function(){
    {/literal}
    pageList.strUrl="{$strUrl}";
    {literal}
    pageList.param = "&"+$('#tableFilterForm').serialize();
    pageList.init();
    GetTotal();
});
function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
    GetTotal();
}
function GetTotal()
{
    var data = $PostData("/?d=CM&c=CMReport&a=getConversionFroTotalNum"+pageList.param);
    data = data.split("|");
    if(data.length < 6)
        return ;
    $("#avg_item1").html(data[0]);
    $("#avg_item2").html(data[1]);
    $("#avg_item3").html(data[2]);
    $("#avg_item4").html(data[3]);
    $("#avg_item5").html(data[4]);
    $("#avg_item6").html(data[5]);
}


function UserLevelChange(obj)
{
    if(parseInt(obj.value)!=1)
    {
        $("#divUserName").show();
    }
    else
    {
        $("#divUserName").hide();
    }
}
{/literal}
</script>