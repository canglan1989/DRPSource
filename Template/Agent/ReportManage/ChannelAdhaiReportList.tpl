<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<div class="table_attention marginBottom10">
    <label>统计信息：</label>
    <span class="ui_link">本月累计新开：(<em>{$COUNT}</em>)</span>
    <span class="ui_link">本月累计新开总金额：(<em>{$NewMoney}</em>)</span>
    <span class="ui_link">本月累计新开总保证金：(<em>{$NewCashMoney}</em>)</span>
    <span class="ui_link">本月累计新开总预存款：(<em>{$NewPreMoney}</em>)</span>
</div> 
<!--S table_filter-->



<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">  
                <div class="ui_title">战区经理：</div>
                <div class="ui_text"><input id="channel_name" class="inpCommon" type="text" name="channel_name"/></div>
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>
            </div>
        </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a href="javascript:;" onclick="ExportExcel()" class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">导出Excel</div></div></a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
                    <th  title="区域">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">区域</div>
                        </div>
                    </th>
                    <th width="150" title="战区经理">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">战区经理</div>
                        </div>
                    </th>
            <th width="150" title="本月累计新开" sort="sort_`new_count`.`count`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">本月累计新开</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            
             <th width="150" title="本月累计新开总金额">
            <div class="ui_table_thcntr" sort="sort_`new_count`.`new_money`">
                <div class="ui_table_thtext">本月累计新开总金额</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th width="150" title="本月累计新开总保证金">
            <div class="ui_table_thcntr" sort="sort_`new_count`.`new_cash_money`">
                <div class="ui_table_thtext">本月累计新开总保证金</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th width="150" title="本月累计新开总预存款">
            <div class="ui_table_thcntr" sort="sort_`new_count`.`new_pre_money`">
                <div class="ui_table_thtext">本月累计新开总预存款</div>
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
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script> 
<script type="text/javascript">
    {literal}
$(function(){    
    {/literal}
	pageList.strUrl = "{$BodyUrl}"; 
    {literal}
        
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init(); 
    
}); 

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}
    
function ExportExcel()
{
    window.open("/?d=Agent&c=ReportManage&a=DownLoad_ChannelAdhaiReportBody" + pageList.param + "&sortField=" + pageList.sortField);
}
    
function jump2sign(username,begintime){
    var userrealname = encodeURIComponent(username);
    JumpPage("/?d=Agent&c=AgentMove&a=SignDetailIndex&username="+userrealname+"&begintime="+begintime+"&pacttype=1");
}
    {/literal}
</script>
