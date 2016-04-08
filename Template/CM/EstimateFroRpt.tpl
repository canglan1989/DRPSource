<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：客户管理<span>&gt;</span>报表管理<span>&gt;</span>网盟预计到账统计</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
    <label>温馨提示：</label>新开转款金额和新开转款次数只统计第一次操作的订单；同一个客户在统计时间段内只被统计一次。<br />
        <label>总计：</label>
        <span class="ui_link">预计到账总额：(<em><label id="income_total">0</label></em>)</span>
        <span class="ui_link">预计到账总量：(<em><label id="order_num">0</label></em>)</span>
        <span class="ui_link">实际转款总额：(<em><label id="charge_total">0</label></em>)</span>
        <span class="ui_link">实际转款次数：(<em><label id="charge_num">0</label></em>)</span>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">
	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
    	<div class="table_filter_main_row">
            <input type="hidden" id = "agent_id" name="agent_id" value="{$agent_id}"/>
            {if $IsBack == 0}
            <div class="ui_title">客户经理：</div>
            <div class="ui_comboBox">
            <select id="cbUserLevel" name="cbUserLevel">
                <option value="-100">全部</option>
                <option value="1">自己</option>
                <option value="2">下级</option>
            </select>
            </div>{/if}
            <div class="ui_title">统计时间段：</div>
			<div class="ui_text"  id = "createTime">
    	            <select  name="rep_date" id="rep_date">
                        <option value="1" {if $bDate == "1"}selected{/if} >当前月</option>
                        <option value="2" {if $bDate == "2"}selected{/if} >下个月</option>
                        <option value="3" {if $bDate == "3"}selected{/if} >连续三个月</option>
                    </select>
			</div>
                    <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>
        </div>
    </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="ExportExcel()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">EXCEL下载</div></div></a>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>预计到账统计列表</h4>
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
                    	<th style="" title="日期">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">日期</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                       
                        <th style="width:100px;" title="预计到账总额">
                        	<div class="ui_table_thcntr"  >
                            	<div class="ui_table_thtext">预计到账总额</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                        <th style="width:100px;" title="预计到账总量">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">预计到账总量</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                        <th style="width:100px;" title="实际转款总额">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">实际转款总额</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                        <th style="width:100px;" title="实际转款次数">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">实际转款次数</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                        <th style="" title="日期">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">日期</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                       
                        <th style="width:100px;" title="预计到账总额">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">预计到账总额</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                        <th style="width:100px;" title="预计到账总量">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">预计到账总量</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                        <th style="width:100px;" title="实际转款总额">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">实际转款总额</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                        <th style="width:100px;" title="实际转款次数">
                        	<div class="ui_table_thcntr" >
                            	<div class="ui_table_thtext">实际转款次数</div><div class="ui_table_thtext"></div>
                            </div>
                        </th>
                       
                   </tr>
               </thead>
               <tbody class="ui_table_bd" id="tableContent">

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

{literal} 
<script language="javascript" type="text/javascript">
$(function(){
    QueryData();
});
function QueryData()
{
    var returnData = $PostData("/?d=CM&c=CMReport&a=showEstimateFroRptBody"+'&'+$("#tableFilterForm").serialize());
    $("#tableContent").html(returnData+"");     
    GetTotal();
}

function GetTotal()
{
    var data = $PostData("/?d=CM&c=CMReport&a=getEstimateFroTotalNum"+'&'+$("#tableFilterForm").serialize());
    data = data.split("|");
    if(data.length < 4)
        return ;
    $("#income_total").html(data[0]);
    $("#order_num").html(data[1]);
    $("#charge_total").html(data[2]);
    $("#charge_num").html(data[3]);

}
function ShowEstimateDetail(report_date)
{
    JumpPage('/?d=CM&c=ContactRecord&a=AdHaiIntentionRatingRecord&isincome=1&bdate='+report_date+'&edate='+report_date);
}

function ExportExcel()
{
    window.open("/?d=CM&c=CMReport&a=excelExportEstimateFroRpt" + '&'+$("#tableFilterForm").serialize());
}

</script>
{/literal} 