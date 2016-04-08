<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">    		
    	<div class="table_filter_main_row">
        <div class="ui_title">代理商代码：</div>
        <div class="ui_text"><input type="text" name="tbxAgentNo" id="tbxAgentNo" value="{$agentNo}" style="width:100px;"/></div>	                
        <div class="ui_title">代理商名称：</div>
        <div class="ui_text"><input type="text" name="tbxAgentName" id="tbxAgentName" value="" style="width:200px;"/></div>
        <div class="ui_title">合同号：</div>
        <div class="ui_text"><input type="text" name="tbxPactNo" id="tbxPactNo" value="" style="width:130px;"/></div>
        <div class="ui_title">产品：</div>
        <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType"></select></div>
        <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
		</div>
    </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;">
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
            <a href="javascript:;" onclick="pageList.reflash()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
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
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">合同号</div></div></th>
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商代码</div></div></th>
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">代理商名称</div></div></th>
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">代理产品</div></div></th>                   
                   <th  width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">签约类型</div></div></th>
                   <th  width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">代理等级</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">应收保证金</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">已打保证金</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">已收保证金</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">应收预存款</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">已打预存款</div></div></th>
                   <th class="TA_r" width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">已收预存款</div></div></th>
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
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
<script type="text/javascript">
var unitProductTypeID = parseInt({$unitProductTypeID});
{literal} 
$(function(){    
    $GetProduct.BindProductType("cbProductType", true);
    
	{/literal}
    var productTypeID = parseInt({$qProductTypeID});
	pageList.strUrl = "{$PactMoneyInAccountListBody}"; 
	{literal}
    if(productTypeID > 0)
        $("#cbProductType").val(productTypeID);
        
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init(); 
    
}); 

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}

function ViewPostMoneyDetail(agentNo,accountType,productTypeID,productTypeName)
{
    productTypeName = encodeURIComponent(productTypeName);
    if(accountType == 2 && productTypeID == unitProductTypeID)
    {
        accountType = 17;        
    }
    
    JumpPage("/?d=FM&c=InMoney&a=AgentPostMoneyDetailList&agentNo="+agentNo+"&accountType="+accountType
    +"&productTypeID="+productTypeID+"&productTypeName="+productTypeName);
}
</script>
{/literal} 