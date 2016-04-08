<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->           
<!--E table_filter--> 
<div class="table_filter marginBottom10">
    <form id="tableFilterForm" name="tableFilterForm" method="post" action="">
    <div class="table_filter_main" id="J_table_filter_main">
        <div class="table_filter_main_row">        
            <div class="ui_title">预存款交易号：</div>
            <div class="ui_text"><input type="text" id="tbxAccountDetailNo" name="tbxAccountDetailNo" style="width:120px"/></div>
            <div class="ui_title">合同号：</div>
            <div class="ui_text"><input type="text" id="tbxContractNo" name="tbxContractNo" style="width:120px"/></div>
            <div class="ui_title">充值类型：</div>
            {literal}<div id="ui_comboBox_AccountTypeModel" onclick="IM.comboBox.init({'control':'AccountTypeModel',data:MM.A(this,'data')},this)" class="ui_comboBox ui_comboBox_def" {/literal}
             key="{$qAccountType}" value="{$qAccountTypeText}" control="AccountTypeModel" {literal} data="[{'key':'2','value':'增值预存款充值'},{'key':'6','value':'销奖'},{'key':'17','value':'网盟预存款充值'},{'key':'18','value':'网盟返点'}]" style="width:200px;">{/literal}
           <div class="ui_comboBox_text" style="width:180px;">
                {if $qAccountType != ""}
             <nobr>{$qAccountTypeText}</nobr>
             {else}
                	<nobr>全部</nobr>
             {/if}
                </div>
                <div class="ui_icon ui_icon_comboBox"></div>                        
            </div> 
           <div class="ui_title" id="divProductType1">产品：</div>       
            <div class="ui_comboBox" style="margin-right:5px" id="divProductType2"><select id="cbProductType" name="cbProductType"></select></div>
        </div>
        <div class="table_filter_main_row"> 
        	<div class="ui_title">充值时间：</div>   
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
                	<th>
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">预存款交易号</div>
                        </div>
                    </th>
                    <th>
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
                    <th class="TA_r" style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">充值金额(元)</div>
                        </div>
                    </th>
                    <th style="width:100px;">
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">充值类型</div>
                            <div class="ui_table_thsort" sort="sort_data_type"></div>
                        </div>
                    </th>
                    <th>
                    	<div class="ui_table_thcntr">
                        	<div class="ui_table_thtext">充值时间</div>
                            <div class="ui_table_thsort" sort="sort_create_time"></div>
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
	var strUrl = "{$PreDepositsChangeBody}"; 
	{literal}
    
    if(productTypeID > 0)
        $("#cbProductType").val(productTypeID);
        
	pageList.strUrl = strUrl; 
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&accountType="+$("#ui_comboBox_AccountTypeModel").attr("key");   
   	pageList.init();
    
 });

function ExportExcel()
{
    window.open("/?d=FM&c=PreDeposits&a=ExcelExportPreDepositsChangeList"+ pageList.param + "&sortField=" + pageList.sortField);
}

function QueryData()
{
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&accountType="+$("#ui_comboBox_AccountTypeModel").attr("key");
	pageList.first();
}

/*
function DataTypeChange(obj)
{
	if(parseInt(obj.value) == 6)
	{
		$DOM("divProductType1").style.display = "";
		$DOM("divProductType2").style.display = "";		
	}
	else
	{
		$DOM("divProductType1").style.display = "none";
		$DOM("divProductType2").style.display = "none";
		
		var cbProductType = $DOM("cbProductType");
		if(cbProductType.options.length > 0)
		{
			cbProductType.options[0].selected = true;
		}
	}
}
*/
</script>
{/literal} 