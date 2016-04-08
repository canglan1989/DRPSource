<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：财务管理<span>&gt;</span><a href="javascript:;" onclick="JumpPage('/?d=FM&c=GuaranteeMoney&a=GuaranteeMoneyAccount');">保证金账户管理</a><span>&gt;</span>{$strTitle}</div>
<!--E crumbs-->           
<!--E table_filter--> 
<div class="table_filter marginBottom10">
    <form id="tableFilterForm" name="tableFilterForm" method="post" action="">
    <div class="table_filter_main" id="J_table_filter_main">
        <div class="table_filter_main_row">        
            <div class="ui_title">保证金交易号：</div>
            <div class="ui_text"><input type="text" id="tbxAccountDetailNo" name="tbxAccountDetailNo" style="width:120px"/></div>
            <div class="ui_title">合同号：</div>
            <div class="ui_text"><input type="text" id="tbxContractNo" name="tbxContractNo" style="width:120px"/></div>
            <div class="ui_title">款项操作类型：</div>
            <div class="ui_comboBox">
            <select name="cbDataType" class="pri" id="cbDataType">
            <option selected="selected" value="-100">请选择</option>
            <option value="1">保证金打款</option>
            <option value="24">帐户间款项转入</option>
            <option value="25">帐户间款项转出</option>
            <option value="14">违规罚款</option>                        
            </select>
            </div> 
            <div class="ui_title">产品：</div>       
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType"></select></div>   
            
        </div>
        <div class="table_filter_main_row"> 
        	<div class="ui_title">款项操作时间：</div>   
            <div class="ui_text">
            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxOptSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
            至
            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxOptEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>
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
                	<th style="width:120px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">保证金交易号</div>
                        </div>
                    </th>
                    <th style="width:120px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">合同号</div>
                        </div>
                    </th>
					<th>
                    	<div class="ui_table_thcntr ">
                        	<div class="ui_table_thtext">产品</div>
                            <div class="ui_table_thsort" sort="sort_product_type_name"></div>
                        </div>
                    </th>
                    <th style="width:120px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">款项操作类型</div>
                            <div class="ui_table_thsort" sort="sort_data_type"></div>
                        </div>
                    </th>  
                    <th class="TA_r" style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">收入(元)</div>
                        </div>
                    </th>
                    <th class="TA_r" style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">支出(元)</div>
                        </div>
                    </th>
                    <th class="TA_r" style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">余额(元)</div>
                        </div>
                    </th>
                    <th>
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">款项操作时间</div>
                            <div class="ui_table_thsort" sort="sort_create_time"></div>
                        </div>
                    </th>
                    <th>
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">操作备注</div>
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
    $GetProduct.BindSignedProductType("cbProductType", true);
    
    {/literal}
    var productTypeID = parseInt({$qProductTypeID});        
    var strUrl = "{$GuaranteeMoneyInOutListBody}"; 
    {literal}
    
    if(productTypeID > 0)
        $("#cbProductType").val(productTypeID);
        
    pageList.strUrl = strUrl; 
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
    window.open("/?d=FM&c=GuaranteeMoney&a=ExcelExportGuaranteeMoneyInOutList" + pageList.param + "&sortField=" + pageList.sortField);
}
</script>
{/literal} 