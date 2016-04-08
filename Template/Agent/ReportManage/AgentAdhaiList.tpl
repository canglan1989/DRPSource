<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--E crumbs-->   
<div class="table_attention marginBottom10">
    <label>统计信息：</label>
    <span class="ui_link">今日新开：(<em>{$TodayNew}</em>)</span>
    <span class="ui_link">本月累计新开：(<em>{$MonthNew}</em>)</span>
    <span class="ui_link">今日续费：(<em>{$TodayOld}</em>)</span>
    <span class="ui_link">本月累计续费：(<em>{$MonthOld}</em>)</span>
    <br  />
    <span class="ui_link">今日新开总金额：(<em>{$TodayNewMoney}</em>)</span>
    <span class="ui_link">本月累计新开总金额：(<em>{$MonthNewMoney}</em>)</span>
    <span class="ui_link">今日续费总金额：(<em>{$TodayOldMoney}</em>)</span>
    <span class="ui_link">本月累计续费总金额：(<em>{$MonthOldMoney}</em>)</span>
</div> 
<!--S table_filter-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">  
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input id="agent_name" class="companyName" type="text" name="agent_name"/></div>
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
                    <th style="border-right: 1px solid #CBCBCB;" rowspan="2" width="100" title="区域">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">区域</div>
                        </div>
                    </th>
                    <th style="border-right: 1px solid #CBCBCB;" rowspan="2"  width="135" title="战区经理">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">战区经理</div>
                        </div>
                    </th>
            <th  rowspan="2" style="border-right: 1px solid #CBCBCB;" width="250" title="代理商名称">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商名称</div>
            </div>
            </th>
            <th style="text-align: center;border-right: 1px solid #CBCBCB;"  colspan="4">
                单量统计
            </th>
            <th style="text-align: center;"  colspan="4">
                金额统计
            </th>
            </tr>
            <tr>
                <th width="80" style="border-right: 1px solid #CBCBCB;" title="今日新开" class="TA_r" sort="sort_`tn`.`today_new_count`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">今日新开</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th width="100" style="border-right: 1px solid #CBCBCB;" title="本月新开" class="TA_r" sort="sort_`mn`.`month_new_count`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">本月新开</div>
                <div class="ui_table_thsort"  ></div>
            </div>
            </th>
            <th width="80"  style="border-right: 1px solid #CBCBCB;" title="今日续费" class="TA_r" sort="sort_`to1`.`today_old_count`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">今日续费</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th width="100" style="border-right: 1px solid #CBCBCB;" title="本月续费" class="TA_r" sort="sort_`mo`.`month_old_count`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">本月续费</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th width="80" style="border-right: 1px solid #CBCBCB;" title="今日新开" class="TA_r" sort="sort_`tn`.`today_new_money`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">今日新开</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th width="100" style="border-right: 1px solid #CBCBCB;" title="本月新开" class="TA_r" sort="sort_`mn`.`month_new_money`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">本月新开</div>
                <div class="ui_table_thsort"  ></div>
            </div>
            </th>
            <th width="80" style="border-right: 1px solid #CBCBCB;" title="今日续费" class="TA_r" sort="sort_`to1`.`today_old_money`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">今日续费</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th width="100" style="border-right: 1px solid #CBCBCB;" title="本月续费" class="TA_r" sort="sort_`mo`.`month_old_money`">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">本月续费</div>
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
$(document).ready(function () {
    {/literal}
	pageList.strUrl="{$BodyUrl}"; 
	{literal}
	pageList.init();
});

  function QueryData()
{
    pageList.page = 1;
	pageList.param = "&"+$('#tableFilterForm').serialize();//get 获取！      
	pageList.first();
}  
    
    function ExportExcel()
{
    window.open("/?d=Agent&c=ReportManage&a=DownLoad_AgentAdhaiList" + pageList.param + "&sortField=" + pageList.sortField);
}
    function showMoneyDialog(agentid,begintime,endtime,type){        
        IM.dialog.show({
        width: 500,
        height: null,
        title: '金额详细',
        html: IM.STATIC.LOADING,
        start: function () {
            $('.DCont').html($PostData("/?d=Agent&c=ReportManage&a=MoneyDetail&agentid=" + agentid +"&begintime="+begintime+"&endtime="+endtime+"&type="+type, ""));
        }
    });
}
    {/literal}
</script>
