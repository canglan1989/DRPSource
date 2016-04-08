<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<div class="table_filter marginBottom10">  
	<form name="tableFilterForm" id="tableFilterForm" method="post" action="">
    <div id="J_table_filter_main" class="table_filter_main">    		
    	<div class="table_filter_main_row">
        	<div class="ui_title">转款交易号：</div>
            <div class="ui_text"><input type="text" name="tbxNo" id="tbxNo" value="" style="width:100px;"/></div>                
            <div class="ui_title">代理商代码：</div>
            <div class="ui_text"><input type="text" id="tbxAgentNo" name="tbxAgentNo" value="{$qAgentNo}" style="width:100px"/></div>
            <div class="ui_title">代理商名称：</div>
            <div class="ui_text"><input type="text" name="tbxAgentName" id="tbxAgentName" value="" style="width:200px;"/></div>
            <div class="ui_title">转款类型：</div>
            <div class="ui_text">
                <select name="chargetype" >
                    <option value="0" >全部</option>
                    <option value="1" {if $ChargeType == "1"}selected{/if}>新签</option>
                    <option value="2" {if $ChargeType == "2"}selected{/if}>续费</option>
                </select>
            </div>
        </div>
        <div class="table_filter_main_row"> 
            <div class="ui_title">客户名称：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerName" id="tbxCustomerName" value="" style="width:200px;"/></div>	                         	        	
            <div class="ui_title">操作时间：</div>
            <div class="ui_text">
                <input id="J_editTimeS" type="text" value="{$BeginIime}" class="inpCommon inpDate" name="tbxOptSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
                至
                <input id="J_editTimeE" type="text" value="{$EndTime}" class="inpCommon inpDate" name="tbxOptEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
            </div>
            <div class="ui_title">仅扣预存款：</div>
            <div class="ui_text"><select id="cbOnlyChargePre" name="cbOnlyChargePre">
            <option value="-100">请选择</option>
            <option {if $iOnlyChargePre == 1} selected="selected" {/if} value="1">是</option>
            <option {if $iOnlyChargePre == 0} selected="selected" {/if} value="0">否</option>
            </select></div>		                                
           <div class="ui_button ui_button_search"><button class="ui_button_inner" type="button" onclick="QueryData()" >搜 索</button></div>	
        </div>
    </div>
    </form>
</div>
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
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> {$strTitle}</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
        </div>
    </div>			           
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
	<div class="ui_table" id="J_ui_table">                    	
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        	<thead class="ui_table_hd">
            	<tr class="">                              	
                   <th width="110"><div class="ui_table_thcntr"><div class="ui_table_thtext">转款交易号</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">订单号</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商名称</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">客户名称</div></div></th>
                   <th width="120"><div class="ui_table_thcntr"><div class="ui_table_thtext">帐户名</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">转款金额</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">预存款</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">返点</div></div></th>   
                   <th width="150"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作人</div></div></th>
                   <th width="150"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作时间</div></div></th>
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">转款类型</div></div></th>
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
    <div class="ui_pager" id="divPager">    	
    </div>
</div>
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal}
<script type="text/javascript">
$(function(){    
	{/literal}
	pageList.strUrl = "{$UnitInMoneyListBody}"; 
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
    window.open(pageList.strUrl+"&exportExcel=1" + pageList.param + "&sortField=" + pageList.sortField);
}

</script>
{/literal}