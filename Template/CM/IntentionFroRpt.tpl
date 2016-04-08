<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：客户管理<span>&gt;</span>报表管理<span>&gt;</span>网盟意向等级统计</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
    <label>温馨提示：</label>统计的等级有A+、A-、B+、B-、C、D、E，没有以上等级的账号不进行统计。<br />
    <label>总计：</label>
    <span class="ui_link">A+：(<em><label id="rpt_item1">0</label></em>)</span>
    <span class="ui_link">A-：(<em><label id="rpt_item2">0</label></em>)</span>
    <span class="ui_link">B+：(<em><label id="rpt_item3">0</label></em>)</span>
    <span class="ui_link">B-：(<em><label id="rpt_item4">0</label></em>)</span>
    <span class="ui_link">C：(<em><label id="rpt_item5">0</label></em>)</span>
    <span class="ui_link">D：(<em><label id="rpt_item6">0</label></em>)</span>
    <span class="ui_link">E：(<em><label id="rpt_item7">0</label></em>)</span>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">
<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
<div class="table_filter_main" id="J_table_filter_main">
	<div class="table_filter_main_row">
        <div class="ui_title">统计日期：</div>
		<div class="ui_text"  id = "createTime">
	            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="rep_date" value="{$rep_date}" onClick="WdatePicker({literal}{isShowClear:false}){/literal}"/> 
		</div>
        <input type="hidden" id = "agent_id" name="agent_id" value="{$agent_id}"/>
        <div class="ui_title">客户经理：</div>
        {if $IsBack == 0}
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
        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>网盟意向等级统计列表</h4>
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
        	
        
           <th style="width:100px;" title="客户经理">
            	<div class="ui_table_thcntr" sort="sort_user_id">
                	<div class="ui_table_thtext">客户经理</div><div class="ui_table_thsort"></div>
                </div>
           </th>
           <th style="width:50px;" title="A+">
            	<div class="ui_table_thcntr" sort="sort_rating_1">
                	<div class="ui_table_thtext">A+</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
           <th style="width:50px;" title="A-">
            	<div class="ui_table_thcntr" sort="sort_rating_2">
                	<div class="ui_table_thtext">A-</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:50px;" title="B+">
            	<div class="ui_table_thcntr" sort="sort_rating_3" >
                	<div class="ui_table_thtext">B+</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:50px;" title="B-">
            	<div class="ui_table_thcntr" sort="sort_rating_4" >
                	<div class="ui_table_thtext">B-</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:50px;" title="C">
            	<div class="ui_table_thcntr" sort="sort_rating_5" >
                	<div class="ui_table_thtext">C</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:50px;" title="D">
            	<div class="ui_table_thcntr" sort="sort_rating_6" >
                	<div class="ui_table_thtext">D</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:50px;" title="E">
            	<div class="ui_table_thcntr" sort="sort_rating_7" >
                	<div class="ui_table_thtext">E</div>
                    <div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:100px;" title="预计到账金额">
            	<div class="ui_table_thcntr" sort="sort_income_money" >
                	<div class="ui_table_thtext">预计到账金额</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:100px;" title="预计到账单量">
            	<div class="ui_table_thcntr" sort="sort_order_count">
                	<div class="ui_table_thtext">预计到账单量</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:100px;" title="转款金额">
            	<div class="ui_table_thcntr" sort="sort_charge_money">
                	<div class="ui_table_thtext">转款金额</div><div class="ui_table_thsort"></div>
                </div>
            </th>
            <th style="width:80px;" title="转款次数">
            	<div class="ui_table_thcntr" sort="sort_charge_count">
                	<div class="ui_table_thtext">转款次数</div><div class="ui_table_thsort"></div>
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
<script language="javascript" type="text/javascript">
{literal}
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
    var data = $PostData("/?d=CM&c=CMReport&a=getIntentionFroTotalNum"+pageList.param);
    data = data.split("|");
    if(data.length < 7)
        return ;
    $("#rpt_item1").html(data[0]);
    $("#rpt_item2").html(data[1]);
    $("#rpt_item3").html(data[2]);
    $("#rpt_item4").html(data[3]);
    $("#rpt_item5").html(data[4]);
    $("#rpt_item6").html(data[5]);
    $("#rpt_item7").html(data[6]);


}

function ShowValidDetail(user_id,level_id)
{
    JumpPage('/?d=CM&c=ContactRecord&a=AdHaiIntentionRatingRecord&user_id='+user_id+'&rating_id='+level_id+'&bdate='+$("#J_editTimeS").val()+'&edate='+$("#J_editTimeS").val());
}
function ShowEstimateDetail(user_id)
{
    JumpPage('/?d=CM&c=ContactRecord&a=AdHaiIntentionRatingRecord&user_id='+user_id+'&isincome=1&bdate='+$("#J_editTimeS").val()+'&edate='+$("#J_editTimeS").val());
}

function GoUnitInMoneyList(opername){
    var starttime = $("#J_editTimeS").val();
    JumpPage('/?d=FM&c=UnitInMoney&a=UnitInMoneyList&starttime='+starttime+'&endtime='+starttime+'&customername='+encodeURIComponent(opername))
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