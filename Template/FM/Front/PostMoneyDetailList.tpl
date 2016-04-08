<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<div id="divNotice" class="table_attention marginBottom10">
</div>   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
		<form name="tableFilterForm" id="tableFilterForm" method="post" action="">
    <div id="J_table_filter_main" class="table_filter_main">    		
    	<div class="table_filter_main_row">
        	<div class="ui_title">预存款交易号：</div>
            <div class="ui_text"><input type="text" name="tbxFrNo" id="tbxFrNo" value="" style="width:100px;"/></div>	                
            <div class="ui_title">合同号：</div>
            <div class="ui_text"><input type="text" name="tbxRactNo" id="tbxRactNo" value="" style="width:100px;"/></div>	                
            <div class="ui_title">收据号：</div>
            <div class="ui_text"><input type="text" name="tbxReceiptNo" id="tbxReceiptNo" value="" style="width:100px;"/></div>	                
			<div class="ui_title">款项状态：</div>
            {literal}
			<div id="ui_comboBox_priceStatus" onclick="IM.comboBox.init({'control':'priceStatus',data:MM.A(this,'data')},this)" {/literal}
             class="ui_comboBox ui_comboBox_def" key="{$qPriceStatusValue}" value="{$qPriceStatusText}" control="priceStatus" data="{$strPriceStatus}" style="width:100px;">
             <div class="ui_comboBox_text" style="width:80px;">
             {if $qPriceStatusValue != ""}
             <nobr>{$qPriceStatusText}</nobr>
             {else}
             <nobr>全部</nobr>
             {/if}
            </div>
            <div class="ui_icon ui_icon_comboBox"></div>                        
            </div>
           	<div class="ui_title">产品：</div>
            {literal}
			<div id="ui_comboBox_agentPro" onclick="IM.comboBox.init({'control':'Pro',data:MM.A(this,'data')},this)" 
            {/literal}
             class="ui_comboBox ui_comboBox_def" key="{$qProductTypeIDs}" value="{$qProductTypeNames}" control="Pro" data="{$strProductTypeJson}" style="width:100px;">
             <div class="ui_comboBox_text" style="width:80px;">
                    {if $qProductTypeNames == ""}
                	<nobr>全部</nobr>
                    {else}
                	<nobr>{$qProductTypeNames}</nobr>
                    {/if}
                </div>
                <div class="ui_icon ui_icon_comboBox"></div>                        
            </div>
		</div>
        <div class="table_filter_main_row">	
           <div class="ui_title">预存款类型：</div>
            <div class="ui_comboBox">
            	<select id="cbFrTypes" name="cbFrTypes">
                <option value="-100">请选择</option>
                <option value="1">保证金</option>
                <option value="2">增值产品预存款</option>
                <option value="17">网盟预存款</option>
                </select>
           </div>
	       <div class="ui_title">收据状态：</div>
           <div class="ui_comboBox">
            	<select name="cbReceiptStatus">
                <option value="-100">请选择</option>
                <option value="1">已开收据</option>
                <option value="0">未开收据</option>
                </select>
           </div>
        	<div class="ui_title">充值状态：</div>
            <div class="ui_comboBox">
            	<select name="cbInAccount">
                    <option selected="selected" value="-100">请选择</option>
                    <option value="1">已充值</option>
                    <option value="0">未充值</option>
                </select>
           </div>	  
           <div class="ui_title">支付方式：</div>
           {literal}
			<div id="ui_comboBox_paymentModel" onclick="IM.comboBox.init({'control':'paymentModel',data:MM.A(this,'data')},this)" 
           {/literal}
            class="ui_comboBox ui_comboBox_def" key="" value="" control="paymentModel" data="{$strPayTypeJson}" style="width:140px;">
           <div class="ui_comboBox_text" style="width:120px;">
                	<nobr>全部</nobr>
                </div>
                <div class="ui_icon ui_icon_comboBox"></div>                        
            </div>      	
            <div class="ui_title">打款时间：</div>
            <div class="ui_text">
                <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxOptSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
                至
                <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxOptEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
            </div>		                                
           <div class="ui_button ui_button_search"><button class="ui_button_inner" type="button" onclick="QueryData()" >搜 索</button></div>	
        </div>
    </div>
    </form>
</div>
<!--E table_filter-->
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="pageList.ExportExcel();" href="javascript:;">
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
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">交易号</div></div></th>
                   <th width="125"><div class="ui_table_thcntr"><div class="ui_table_thtext">关联合同号</div></div></th>
                   <th width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">产品</div></div></th>
                   <th class="TA_r" width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款金额(元)</div></div></th>
                   <th ><div class="ui_table_thcntr"><div class="ui_table_thtext">打款信息</div></div></th>
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">打款底单</div></div></th>                                   
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">款项状态</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">提交人/打款时间</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">到账时间</div></div></th>
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">充值时间</div></div></th>
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">收据号</div></div></th>
                   <th class="TA_r" width="76"><div class="ui_table_thcntr"><div class="ui_table_thtext">收据金额</div></div></th>
                   <th width="90"><div class="ui_table_thcntr"><div class="ui_table_thtext">收据开票时间</div></div></th>
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
{literal} 
<script type="text/javascript">
$(function(){    
    {/literal}
    var frTypes = parseInt({$qFrTypes});
	pageList.strUrl = "{$PostMoneyDetailListBody}"; 
	{literal}
    
    if(frTypes > 0)
        $("#cbFrTypes").val(frTypes);
        
	pageList.param = '&'+$("#tableFilterForm").serialize()+"&productTypeIDs="+$("#ui_comboBox_agentPro").attr("key")
    +"&priceStatus="+$("#ui_comboBox_priceStatus").attr("key")+"&payMentModels="+$("#ui_comboBox_paymentModel").attr("key");
	pageList.init();
    
    UpdateNotice();
});

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize()+"&productTypeIDs="+$("#ui_comboBox_agentPro").attr("key")
    +"&priceStatus="+$("#ui_comboBox_priceStatus").attr("key")+"&payMentModels="+$("#ui_comboBox_paymentModel").attr("key");
    pageList.first();
}

function UpdateNotice()
{    
    $.ajax({
        async: true, 
        type: "POST",
        dataType: "text",
        url: "/?d=FM&c=PayMoney&a=UpdateNotice",
        data: "",
        success: function (backData) {
            $("#divNotice").html(backData);
        }
    });   
}

function ShowInvoiceIsseuInfo(id)
{
    IM.dialog.show({
         width: 350,
    	    height: null,
    	    title: '收据信息',
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    	       $('.DCont').html($PostData("/?d=FM&c=GuaranteeMoney&a=ShowInvoiceIsseuInfo","id="+id)); 
        }
    });    
}


function ShowInAccountInfo(id)
{
    IM.dialog.show({
     width: 350,
	    height: null,
	    title: '充值信息',
	    html: IM.STATIC.LOADING,
	    start: function () {
	       $('.DCont').html($PostData("/?d=FM&c=PreDeposits&a=ShowInAccountDetailInfo","id="+id)); 
    }
    }); 
}

</script>
{/literal} 