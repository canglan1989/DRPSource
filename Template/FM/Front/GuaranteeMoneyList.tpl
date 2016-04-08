<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<div id="divNotice" class="table_attention marginBottom10">
</div>   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">    		
    	<div class="table_filter_main_row">
           <div class="ui_title">保证金交易号：</div>
           <div class="ui_text"><input type="text" name="tbxFrNo" id="tbxFrNo" value="" style="width:100px;"/></div>	                
           <div class="ui_title">合同号：</div>
           <div class="ui_text"><input type="text" name="tbxPactNo" id="tbxPactNo" value="" style="width:100px;"/></div>
           <div class="ui_title">产品：</div>
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType"></select></div>
            <div class="ui_title">款项状态：</div>
            <div class="ui_comboBox">
            	<select name="cbPriceStatus">
                <option {if $qPriceStatus == -100 } selected="selected" {/if} value="-100">请选择</option>
                <option {if $qPriceStatus == 0 } selected="selected" {/if} value="0">未到账</option>
                <option {if $qPriceStatus == 1 } selected="selected" {/if} value="1">底单入款</option>
                <option {if $qPriceStatus == 2 } selected="selected" {/if} value="2">到账</option>
                <option {if $qPriceStatus == -1 } selected="selected" {/if} value="-1">款项信息退回</option>
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
            <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
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
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">保证金交易号</div></div></th>
                   <th width="125"><div class="ui_table_thcntr"><div class="ui_table_thtext">合同号/有效时间</div></div></th>
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
                   <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
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
    $GetProduct.BindSignedProductType("cbProductType", true);
    
	{/literal}
    var productTypeID = parseInt({$qProductTypeID});
	pageList.strUrl = "{$GuaranteeMoneyListBody}"; 
	{literal}
    if(productTypeID > 0)
        $("#cbProductType").val(productTypeID);
        
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init();
    
}); 


function UpdateNotice()
{    
    $.ajax({
        async: true, 
        type: "POST",
        dataType: "text",
        url: "/?d=FM&c=GuaranteeMoney&a=UpdateNotice",
        data: "",
        success: function (backData) {
            $("#divNotice").html(backData);
        }
    });   
}

function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
    UpdateNotice();
}


function ReceiptConfirm(id)
{
    IM.finance.ReceiptConfirm("/?d=FM&c=Receipt&a=ReceiptConfirm",{'id':id},"收据确认");
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
	       $('.DCont').html($PostData("/?d=FM&c=PreDeposits&a=ShowInAccountInfo","id="+id)); 
    }
    }); 
}
function ExportExcel()
{
    window.open("/?d=FM&c=GuaranteeMoney&a=ExcelExportGuaranteeMoneyList" + pageList.param + "&sortField=" + pageList.sortField);
}

 
UpdateNotice();
</script>
{/literal} 