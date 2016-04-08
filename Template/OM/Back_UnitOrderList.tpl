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
        <div class="ui_title">代理商：</div>
        <div class="ui_text"><input id="tbxAgentName" type="text" name="tbxAgentName"  value="" maxlength="48" /></div>        
                
        <div class="ui_title">客户名称：</div>
        <div class="ui_text"><input id="tbxCustomerName" type="text" name="tbxCustomerName" value="" maxlength="48" style="width:200px;" /></div>
        
        <div class="ui_title">订单类型：</div>
        <div class="ui_text">
        <select id="cbOrderType" name="cbOrderType"></select>
        </div>               
    </div>
    <div class="table_filter_main_row">
        <div class="ui_title" title="审核通过将查询出所有审核通过的订单">订单状态：</div>
        <div class="ui_text">
        <select id="cbAuditState" name="cbAuditState"></select>
        </div> 
        <div class="ui_title">提交人：</div>
        <div class="ui_text">
        <input id="tbxPostUserName" type="text" name="tbxPostUserName" style="width:120px;" value="" maxlength="30" />
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
                <th title="代理商">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">代理商</div>
                        <div class="ui_table_thsort" sort="sort_convert(om_order.agent_name using gb2312)"></div>
                    </div>
                </th>
                <th title="客户名称">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">客户名称</div>
                        <div class="ui_table_thsort" sort="sort_convert(om_order.customer_name using gb2312)"></div>
                    </div>
                </th>
                <th class="TA_r" style="width:80px;" title="已充值">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">已充值</div>
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
                <th style="width:90px;" title="操作">
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
	var strUrl = "{$orderListBody}"; 
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
     
function OrderTransfer(orderid){
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: '网盟订单转移',
	    html: IM.STATIC.LOADING,
        start:function(){
                MM.get("/?d=OM&c=Back_Order&a=showBackOrderTransfer","orderid="+orderid,function(q){
                $('.DCont')[0].innerHTML= q; 
                 $('#to_agent').autocomplete('/?d=CM&c=CMTransfer&a=getAgentName_ID', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                        max: 5, //只显示5行
                        width: 150, //下拉列表的宽
                        parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
                            var parsed = [];                            
                            if(backData == "" || backData.length == 0)
                                return parsed;
                                
                            backData = MM.json(backData);
                            var value = backData.value;
                            if(value == undefined)
                                 return parsed;
                            for (var i = 0; i < value.length; i++) {
                                parsed[parsed.length] = {
                                    data: value[i],
                                    value: value[i].id,
                                    result: value[i].no +"("+ value[i].user_name +")("+value[i].name +")"
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return "<div>" + item.no +"("+ item.user_name +")("+item.name +")"+ "</div>";
                        }
                    }).result(function (data,value) {//执行模糊匹配
                        var id = value.id;
                        $("#to_agent_id").val(id);
                    });

                
                new Reg.vf($('#J_backForm'),{callback:function(formData){
                    if(parseInt($("#to_agent_id").val()) <=0){
                        IM.tip.warn("转入的代理商信息获取出错");
                            return false;
                        }
                    //数据已提交，正在处理标识
//                	if (_InDealWith != undefend) 
//                	{
//                		IM.tip.warn("数据已提交，正在处理中！");
//                		return false;
//                	}
                    var postData = $("#J_backForm").serialize();
                   // _InDealWith = true;   
                    $.ajax({
                        url:'/?d=CM&c=CMTransfer&a=getTransfer&orderid='+orderid,
                        data:postData,
                        dataType:"json",
                        type:"post",
                        success:function(data){
                            
                             if(data.success){
                                IM.tip.show(data.msg);
                                IM.dialog.hide();
                                pageList.reflash();
                            }else{
                                IM.tip.warn(data.msg);
                            }
                             
                            //_InDealWith = false;
                        },
                        error:function(q){
                            IM.tip.warn(q.responseText);
                            //_InDealWith = false;
                        }
                    });
                }});
            })
        }
    });
}
 
</script>
{/literal} 