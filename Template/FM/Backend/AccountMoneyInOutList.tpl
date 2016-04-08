<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<!--E table_filter--> 
<div class="table_filter marginBottom10">
    <form id="tableFilterForm" name="tableFilterForm" method="post" action="">
    <div class="table_filter_main" id="J_table_filter_main">
        <div class="table_filter_main_row">        
            <div class="ui_title">合同号：</div>
            <div class="ui_text"><input type="text" id="tbxContractNo" name="tbxContractNo" style="width:110px"/></div>
            <div class="ui_title">打款交易号：</div>
            <div class="ui_text"><input type="text" id="tbxPostMoneyNo" name="tbxPostMoneyNo" style="width:100px"/></div>
            <div class="ui_title">订单号：</div>
            <div class="ui_text"><input type="text" id="tbxSourceBillNo" name="tbxSourceBillNo" style="width:100px"/></div>     
            <div class="ui_title">代理商代码：</div>
            <div class="ui_text"><input type="text" id="tbxAgentNo" name="tbxAgentNo" style="width:100px"/></div>
            <div class="ui_title">代理商名称：</div>
            <div class="ui_text"><input type="text" id="tbxAgentName" name="tbxAgentName" style="width:160px;"/></div>
        </div>
        <div class="table_filter_main_row">
        <div class="ui_title">账户类型：</div>
            <div class="ui_text">
                <select id="cbAccountType" name="cbAccountType">
                </select>
            </div>   
           <div class="ui_title">产品：</div>
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType"></select></div>
		<div class="ui_title">操作类型：</div>
            <div class="ui_text">
                <select id="cbInOutType" name="cbInOutType">
                <option value="-100">请选择</option> 
                <option value="1">收入</option>
                <option value="-1">支出</option>
                </select>
            </div>
            <div class="ui_title">款项收支类型：</div>
            {literal}
			<div id="ui_comboBox_inOutTypes" onclick="IM.comboBox.init({'control':'inOutTypes',data:MM.A(this,'data')},this)" {/literal}
             class="ui_comboBox ui_comboBox_def" key="{$qInOutTypes}" value="{$qInOutTypeNames}" control="inOutTypes" data="{$strInOutTypeJson}" style="width:220px;"> 
             <div class="ui_comboBox_text" style="width:200px;">
                {if $qInOutTypeNames == ""}
                <nobr>全部</nobr>
                {else}
                <nobr>{$qInOutTypeNames}</nobr>
                {/if}
            </div>
            <div class="ui_icon ui_icon_comboBox"></div>                        
            </div>            
            <div class="ui_button ui_button_search"><button onclick="QueryData()" type="button" class="ui_button_inner">搜 索</button></div>
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
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>  
        </div>
    </div>			           
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
	<div class="ui_table">
    	<table width="100%" cellspacing="0" cellpadding="0" border="0">
        	<thead class="ui_table_hd">
            	<tr class="">
                	<th width="70">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">编号</div>
                        </div>
                    </th>
                    <th width="90">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">合同号</div>
                        </div>
                    </th>
                    <th width="130">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">打款交易号/订单号</div>
                        </div>
                    </th>   
                    <th width="110" >
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">代理商代码/名称</div>
                        </div>
                    </th>
                	<th >
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">账户类型</div>
                        </div>
                    </th> 
                	<th >
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">产品</div>
                        </div>
                    </th>
                    <th >
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">款项收支类型</div>
                        </div>
                    </th> 
                    <th class="TA_r" style="width:90px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">收入</div>
                        </div>
                    </th>
                    <th class="TA_r" style="width:90px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">支出</div>
                        </div>
                    </th>
                    <th >
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">操作人</div>
                        </div>
                    </th>
                    <th>
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">操作时间</div>
                        </div>
                    </th>
                    <th >
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">备注</div>
                        </div>
                    </th>
               </tr>
           </thead>
           <tbody id="pageListContent" class="ui_table_bd">
            </tbody>
       </table>
    </div>
    <!--E ui_table-->
</div>
<!--E list_table_main--> 
<!--S list_table_foot-->
<div class="list_table_foot">
    <div class="ui_pager">
    	<div id="divPager" class="ui_pager"></div>
    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal} 
<script language="javascript" type="text/javascript">
 $(function(){
    cbDataBind.AccountTypes("cbAccountType");
    $GetProduct.BindProductType("cbProductType", true);
    
	{/literal}
    var productTypeID = parseInt({$qProductTypeID});
    var accountType = parseInt({$qAccountType});
    var dataType = parseInt({$qDataType});
    var inOutType = parseInt({$qInOutType});
    var agentNo = "{$qAgentNo}";
    
	pageList.strUrl = "{$AccountMoneyInOutListBody}"; 
	{literal}
    $("#tbxAgentNo").val(agentNo);
    
    if(productTypeID > 0)
        $("#cbProductType").val(productTypeID);
        
    if(accountType > 0)
        $("#cbAccountType").val(accountType);
        
    if(dataType > 0)
        $("#cbDataType").val(dataType);
        
    if(inOutType != 0)
        $("#cbInOutType").val(inOutType);
                    
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&inOutTypes="+$("#ui_comboBox_inOutTypes").attr("key");   
   	pageList.init();
    
 });

function ExportExcel()
{
    window.open("/?d=FM&c=PreDeposits&a=Back_Export_AccountMoneyInOutList" + pageList.param + "&sortField=" + pageList.sortField);
}

 function QueryData()
 {
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&inOutTypes="+$("#ui_comboBox_inOutTypes").attr("key");
	pageList.first();
 }
 
</script>
{/literal} 