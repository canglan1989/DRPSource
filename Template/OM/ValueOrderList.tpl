<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
        <div class="ui_title">订单号：</div>
        <div class="ui_text"><input id="tbxOrderNo" type="text" name="tbxOrderNo" style="width:120px;" value="" maxlength="30" /></div>
        
        <div class="ui_title">客户名称：</div>
        <div class="ui_text"><input id="tbxCustomerName" type="text" name="tbxCustomerName" value="" maxlength="48" style="width:200px;" /></div>
        
        <div class="ui_title">订单类型：</div>
        <div class="ui_text">
        <select id="cbOrderType" name="cbOrderType"></select>
        </div>         
        <div class="ui_title">产品：</div>
        <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType" ></select></div>
        <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProduct" name="cbProduct" ></select></div>         
    </div>
    <div class="table_filter_main_row">
        <div class="ui_title" title="审核通过将查询出所有审核通过的订单">订单状态：</div>
        <div class="ui_text">
        <select id="cbAuditState" name="cbAuditState"></select>
        </div> 
        <div class="ui_title" title="只在审核通过的订单里判断已失效或未失效">已失效：</div>
        <div class="ui_text" title="只在审核通过的订单里判断已失效或未失效">
        <select id="cbIsNotEffect" name="cbIsNotEffect">
        <option value="-100">请选择</option>
        <option value="1">是</option>
        <option value="0">否</option>
        </select>
        </div> 
        <div class="ui_title">提交人：</div>
        <div class="ui_comboBox">
        <select onchange="UserLevelChange(this)" id="cbUserLevel" name="cbUserLevel">
            <option value="-100">全部</option>
            <option value="1">自己</option>
            <option value="2">下级</option>
        </select>
        </div>
        <div id="divUserName" class="ui_text">
        <input id="tbxPostUserName" type="text" name="tbxPostUserName" style="width:100px;" value="" maxlength="30" />
        </div>
        <div class="ui_title">提交时间：</div>
        <div class="ui_text">
            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxPostSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
            至
            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxPostEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
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
            	<th title="订单号">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">订单号</div>
                        <div class="ui_table_thsort" sort="sort_order_no"></div>
                    </div>
                </th>
                <th title="客户名称">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">客户名称</div>
                        <div class="ui_table_thsort" sort="sort_convert(om_order.customer_name using gb2312)"></div>
                    </div>
                </th>
                <th title="产品">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">产品</div>
                        <div class="ui_table_thsort" sort="sort_convert(sys_product_type.product_type_name using gb2312),convert(sys_product.product_series using gb2312)"></div>
                    </div>
                </th>
                <th class="TA_r" style="width:80px;" title="代理进货价">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">代理进货价</div>
                    </div>
                </th>
                <th style="width:70px;" title="款项状态">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">款项状态</div>
                    </div>
                </th>
                <th style="width:80px;" title="订单时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">订单时间</div>
                        <div class="ui_table_thsort" sort="sort_order_sdate"></div>
                    </div>
                </th>
                <th style="width:80px;" title="订单类型">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">订单类型</div>
                    </div>
                </th>
                <th style="width:80px;" title="订单状态">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">订单状态</div>
                    </div>
                </th>
                <th style="width:90px;" title="订单有效期">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">订单有效期</div>
                    </div>
                </th>
                <th style="width:120px;" title="提交人">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">提交人</div>
                    </div>
                </th>
                <th style="width:80px;" title="提交时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">提交时间</div>
                        <div class="ui_table_thsort" sort="sort_post_date"></div>
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
    $GetProduct.Init("cbProductType", "cbProduct", true,null,ProductGroups.ValueIncrease);
    cbDataBind.OrderStatus("cbAuditState");
    cbDataBind.OrderTypes("cbOrderType");
    //删除未提交
    var cbAuditState = $DOM("cbAuditState");
    var objLength = cbAuditState.options.length;
    for (var cIndex = 0; cIndex < objLength; cIndex++) { 
        if(cbAuditState.options[cIndex].text == "未提交")
        {
            cbAuditState.options[cIndex] = null;
            break;
        }        
    }    
    
   	{/literal}
	var strUrl = "{$ValueOrderListBody}"; 
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
 
 function OrderPriceStatus(orderID)
 {
    IM.dialog.show({
         width: 400,
    	    height: null,
    	    title: '订单款项状态信息',
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    	       $('.DCont').html($PostData("/?d=OM&c=Order&a=OrderPriceStatus&id="+orderID,""));
        }
    });    
 }
 
function UserLevelChange(obj)
{
    if(parseInt(obj.value)!=1)
    {
        $("#divUserName").show();
    }
    else
    {
        $("#divUserName").hide();
    }
}

</script>
{/literal} 