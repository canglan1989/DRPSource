<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
        <div id="J_table_filter_main" class="table_filter_main">
            <div class="table_filter_main_row">
                <div class="ui_title">订单号：</div>
                <div class="ui_text"><input id="tbxOrderNo" type="text" name="tbxOrderNo" value="" maxlength="30" /></div>        
                <div class="ui_title">代理商：</div>
                <div class="ui_text"><input id="tbxAgentName" type="text" name="tbxAgentName"  value="" maxlength="48" /></div>        
                <div class="ui_title">客户名称：</div>
                <div class="ui_text"><input id="tbxCustomerName" type="text" name="tbxCustomerName" value="" maxlength="48" /></div>      
                    {if $product_group == 0}                    
                    <div class="ui_title">产品：</div>
                    <div class="ui_comboBox"><select id="cbProductType" name="cbProductType"></select>
                        <select id="cbProduct" name="cbProduct"></select></div>
                    {/if}   
            </div>
            <div class="table_filter_main_row">

                <div class="ui_title">订单类型：</div>
                <div class="ui_text">
                    <select id="cbOrderType" name="cbOrderType"></select>
                </div> 
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
                <div class="ui_text">
                    <input id="tbxPostUserName" type="text" name="tbxPostUserName" style="width:90px;" value="" maxlength="30" />
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
<div class="list_link marginBottom10">
    <a class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">导出Excel</div></div></a>
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
                    <th>
            <div class="ui_table_thcntr" sort="sort_order_no">
                <div class="ui_table_thtext">订单号</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th >
            <div class="ui_table_thcntr" sort="sort_convert(om_order.agent_name using gb2312)">
                <div class="ui_table_thtext">代理商</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th >
            <div class="ui_table_thcntr" sort="sort_convert(om_order.customer_name using gb2312)">
                <div class="ui_table_thtext">客户名称</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th >
            <div class="ui_table_thcntr" sort="sort_convert(sys_product_type.product_type_name using gb2312),convert(sys_product.product_series using gb2312)">
                <div class="ui_table_thtext">产品</div>
                <div class="ui_table_thsort" ></div>
            </div>
            </th>
            <th class="TA_r" style="width:90px;" title="代理进货价">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">代理进货价</div>
            </div>
            </th>
            <th style="width:70px;" title="款项状态">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">款项状态</div>
            </div>
            </th>
            <th style="width:70px;" title="订单类型">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">订单类型</div>
            </div>
            </th>
            <th style="width:80px;" title="订单状态">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">订单状态</div>
            </div>
            </th>
            <th style="width:80px;" title="订单时间">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">订单时间</div>
            </div>
            </th>
            <th style="width:80px;" title="订单有效期">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">订单有效期</div>
            </div>
            </th>
            <th style="width:80px;" title="提交时间">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">提交时间</div>
            </div>
            </th>
            <th style="width:50px;" title="操作">
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
{/literal}
    var strUrl = "{$orderListBody}";     
    var product_group = "{$product_group}"; 
{literal}

    if(product_group == "0" || product_group == "")
        $GetProduct.Init("cbProductType", "cbProduct", true,"",ProductGroups.ValueIncrease);

    cbDataBind.OrderTypes("cbOrderType");

    cbDataBind.OrderStatus("cbAuditState");
    var cbAuditState = $DOM("cbAuditState");
    var objLength = cbAuditState.options.length;
    for (var cIndex = 0; cIndex < objLength; cIndex++) { 
        if(cbAuditState.options[cIndex].text == "未提交")
        {
            cbAuditState.options[cIndex] = null;
            break;
        }        
    }    


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

_InDealWith = false;  
function BackOrderAndMoney(orderID)
{
    IM.dialog.show({
        width: 580,
	    height: null,
	    title: '退单退款',
	    html: IM.STATIC.LOADING,
        start:function(){
                $('.DCont')[0].innerHTML= $PostData("/?d=OM&c=Back_Order&a=BackOrderAndMoney","id="+orderID);
                
                new Reg.vf($('#J_backForm'),{callback:function(formData){
            if($("#tbxRemark").val().length>200){
                IM.tip.warn("备注不得超过200字");
                		return false;
            }
                    //数据已提交，正在处理标识
                	if (_InDealWith) 
                	{
                		IM.tip.warn("数据已提交，正在处理中！");
                		return false;
                	}
                    
                    var postData = $("#J_backForm").serialize();
                    
                    _InDealWith = true;   
                    var backData = $PostData("/?d=OM&c=Back_Order&a=BackOrderAndMoneySubmit",postData);
                    
                    if(backData == 0)
                    {
                        IM.dialog.hide();	
                	IM.tip.show("退单成功！");
                        _InDealWith = false;  
                        pageList.reflash();
                    }    
                    else
                    {
                        IM.tip.warn(backData);
                        _InDealWith = false;                    
                    } 
                }});
        }
    });
}

</script>
{/literal} 