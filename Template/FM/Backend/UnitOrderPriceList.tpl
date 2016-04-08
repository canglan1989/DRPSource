<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：财务管理<span>&gt;</span>款项账户管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=UnitPreDepositAccountAmount');">网盟预存款账户</a><span>&gt;</span>{$strTitle}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
        <div class="ui_title">订单号：</div>
        <div class="ui_text"><input id="tbxOrderNo" type="text" name="tbxOrderNo" style="width:100px;" value="" maxlength="30" /></div>
        <div class="ui_title">合同号：</div>
        <div class="ui_text"><input type="text" name="tbxRactNo" id="tbxRactNo" value="" style="width:100px;"/></div>
        <div class="ui_title">代理商代码：</div>
        <div class="ui_text"><input id="tbxAgentNo" type="text" name="tbxAgentNo" style="width:100px;" value="{$qAgentNo}" maxlength="48" /></div>
        <div class="ui_title">代理商名称：</div>
        <div class="ui_text"><input id="tbxAgentName" type="text" name="tbxAgentName" style="width:200px;" value="" maxlength="64" /></div>
    </div>
    <div class="table_filter_main_row">        
        <div class="ui_title">仅扣预存款：</div>
        <div class="ui_text"><select id="cbOnlyChargePre" name="cbOnlyChargePre">
        <option value="-100">请选择</option>
        <option {if $iOnlyChargePre == 1} selected="selected" {/if} value="1">是</option>
        <option {if $iOnlyChargePre == 0} selected="selected" {/if} value="0">否</option>
        </select></div>
        <div class="ui_title">款项状态：</div>
        <div class="ui_text"><select id="cbPriceStatus" name="cbPriceStatus">
        </select></div>
        <div class="ui_title" title="提交时间">提交时间：</div>
        <div class="ui_text">
            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxPostSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
            至
            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxPostEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
        </div>
        <div class="ui_title" title="扣款时间">扣款时间：</div>
        <div class="ui_text">
            <input id="tbxChargeSDate" type="text" class="inpCommon inpDate" name="tbxChargeSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'tbxChargeEDate\')}'}){/literal}"/>
            至
            <input id="tbxChargeEDate" type="text" class="inpCommon inpDate" name="tbxChargeEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxChargeSDate\')}'}){/literal}"/>	
        </div>
        <div class="ui_button ui_button_search">
        <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
        </div>        
    </div>
    </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="ExportExcel()" href="javascript:;">
    <div class="ui_button_left"></div>
    <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
    </div>
</a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
<div class="list_table_head_right">
<div class="list_table_head_mid">
	<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
            	<th  title="订单号">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">订单号</div>
                    </div>
                </th>
            	<th  title="合同号">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">合同号</div>
                    </div>
                </th>
                <th  title="代理商名称">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">代理商名称</div>
                    </div>
                </th>
                <th  title="客户名称">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">客户名称</div>
                    </div>
                </th>
                <th title="产品">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">产品</div>
                    </div>
                </th>
                <th class="TA_r" style="width:100px;" title="产品价格(元)">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">产品价格(元)</div>
                    </div>
                </th>
                <th style="width:80px;" title="订单状态">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">订单状态</div>
                    </div>
                </th>
                <th style="width:80px;" title="款项状态">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">款项状态</div>
                    </div>
                </th>
                <th class="TA_r" style="width:100px;" title="预存款(元)">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">预存款(元)</div>
                    </div>
                </th>
                <th class="TA_r" style="width:100px;" title="返点(元)">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">返点(元)</div>
                    </div>
                </th>
                <th style="width:80px;" title="提交时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">提交时间</div>
                    </div>
                </th>
                <th style="width:80px;" title="扣款时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">扣款时间</div>
                    </div>
                </th>
           </tr>
           </thead>
           <tbody class="ui_table_bd" id="pageListContent"></tbody>
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
{literal} 
<script language="javascript" type="text/javascript">
$(function(){
    cbDataBind.ValueProductPriceStatus("cbPriceStatus");
    {/literal}
    var priceStatus = parseInt({$priceStatus});
    pageList.strUrl = "{$UnitOrderPriceListBody}"; 
    {literal}
    
    if(priceStatus > 0)
        $("#cbPriceStatus").val(priceStatus);
                
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
    window.open("/?d=FM&c=FM_Order&a=Back_ExportUnitOrderPriceList" + pageList.param + "&sortField=" + pageList.sortField);
}

</script>
{/literal} 