<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
        <div class="ui_title">发票虚拟号：</div>
        <div class="ui_text"><input id="tbxInvoiceVerNo" type="text" name="tbxInvoiceVerNo" value="{$strInvoiceVerNo}" maxlength="30" /></div>
        <div class="ui_title">发票号：</div>
        <div class="ui_text"><input id="tbxInvoiceNo" type="text" name="tbxInvoiceNo" style="width:100px;" value="" maxlength="30" /></div>
        <div class="ui_title">产品：</div>
        <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType" style="width:120px"></select></div>
         <div class="ui_title">发票种类：</div>
        <div class="ui_text">
        <select id="cbInvoiceType" name="cbInvoiceType"></select>
        </div>  
        <div class="ui_title">发票状态：</div>
        <div class="ui_text">
        <select id="cbInvoiceState" name="cbInvoiceState">
        <option value="-100">请选择</option>
        <option value="1">已开票</option>
        <option value="0">未开票</option>
        </select>        
        </div> 
        <div class="ui_button ui_button_search">
        <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
        </div>        
    </div>
    </div>
    </form>
</div>
<!--E table_filter-->
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
            	<th title="发票号">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">发票号</div>
                    </div>
                </th>
                <th style="width:100px;" title="发票虚拟号">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">发票虚拟号</div>
                    </div>
                </th>
                <th style="width:90px;" title="申请时间">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">申请时间</div>
                    </div>
                </th>
                <th title="产品">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">产品</div>
                    </div>
                </th>
                <th title="发票抬头">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">发票抬头</div>
                    </div>
                </th>
                <th title="发票种类">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">发票种类</div>
                    </div>
                </th>
                <th class="TA_r" style="width:90px;" title="开票金额(元)">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">开票金额(元)</div>
                    </div>
                </th>
                <th style="width:80px;" title="发票状态">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">发票状态</div>
                    </div>
                </th>
                <th style="width:90px;" title="开票时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">开票时间</div>
                    </div>
                </th>
                <th style="width:130px;" title="备注及摘要">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">备注及摘要</div>
                    </div>
                </th>
                <th style="width:80px;" title="操作">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">操作</div>
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
    $GetProduct.BindSignedProductType("cbProductType", true);
    cbDataBind.InvoiceTypes("cbInvoiceType");     
   	{/literal}
	var strUrl = "{$MakeInvoiceListBody}"; 
	{literal}
    
	pageList.strUrl = strUrl; 
	pageList.param = '&'+$("#tableFilterForm").serialize();   
   	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 

function InvoiceConfirm(id)
{
    IM.finance.ReceiptConfirm("/?d=FM&c=Invoice&a=InvoiceConfirm",{'id':id},"发票确认");
}
</script>
{/literal} 