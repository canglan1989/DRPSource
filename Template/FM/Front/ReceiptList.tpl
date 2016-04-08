<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">    
        <div class="ui_title">款项类型：</div>
        <div class="ui_text">
        <select id="cbAccountType" name="cbAccountType">
        <option value="-100">请选择</option>
        <option value="1">保证金</option>
        <option value="2">增值产品预存款</option>
        <option value="17">网盟预存款</option>
        </select>
        </div>    
         <div class="ui_title">合同号：</div>
        <div class="ui_text"><input id="tbxPactNo" type="text" name="tbxPactNo" style="width:100px;" value="" maxlength="30" /></div>
        <div class="ui_title">收据号：</div>
        <div class="ui_text"><input id="tbxInvoiceNo" type="text" name="tbxInvoiceNo" style="width:100px;" value="" maxlength="30" /></div>
        <div class="ui_title">收据抬头：</div>
        <div class="ui_text"><input id="tbxInvoiceHead" type="text" name="tbxInvoiceHead" style="width:200px;" value="" maxlength="30" /></div>
    </div>
    <div class="table_filter_main_row">
        <div class="ui_title">收据状态：</div>
        <div class="ui_text">
        <select id="cbReceiptState" name="cbReceiptState">
        <option value="-100">请选择</option> 
        <option value="1">已开</option>
        <option value="0">未开</option>
        </select>
        </div>      
        <div class="ui_title">开票时间：</div>
        <div class="ui_text">
            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxOptSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
            至
            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxOptEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
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
                <th  width="60" title="款项类型">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">款项类型</div>
                    </div>
                </th>
                <th  title="合同号">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">合同号</div>
                    </div>
                </th>
            	<th  title="收据号">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">收据号</div>
                    </div>
                </th>
                <th style="width:70px;" title="收据状态">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">收据状态</div>
                    </div>
                </th>
                <th title="开票时间">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">开票时间</div>
                    </div>
                </th>
                <th class="TA_r" style="width:90px;" title="开票金额(元)">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">开票金额(元)</div>
                    </div>
                </th>
                <th   title="收据抬头">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">收据抬头</div>
                    </div>
                </th>
                <th title="收据摘要">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">收据摘要</div>
                    </div>
                </th>
                <th class="TA_r" style="width:90px;" title="打款金额(元)">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">打款金额(元)</div>
                    </div>
                </th>
                <th class="TA_r" style="width:90px;" title="已收金额(元)">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">已收金额(元)</div>
                    </div>
                </th>
                <th class="TA_r" style="width:90px;" title="到账金额(元)">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">到账金额(元)</div>
                    </div>
                </th>
                <th style="width:70px;" title="款项状态">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">款项状态</div>
                    </div>
                </th>
                <th  title="操作">
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
    //cbDataBind.AccountTypes("cbAccountType");
   	{/literal}
	pageList.strUrl = "{$ReceiptListBody}"; 
	{literal}
    
	pageList.param = '&'+$("#tableFilterForm").serialize();   
   	pageList.init();
 });
 
function QueryData()
{
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.first();
}


function ReceiptConfirm(id)
{
    IM.finance.ReceiptConfirm("/?d=FM&c=Receipt&a=ReceiptConfirm",{'id':id},"收据确认");
}
</script>
{/literal} 