<?php /* Smarty version 2.6.26, created on 2012-12-11 17:22:22
         compiled from OM/Back_OrderAuditAllotList.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
        <label>审核状态提醒：</label>
        <span class="ui_link">已分配：(<em><?php echo $this->_tpl_vars['isAllolt']; ?>
</em>)</span>
        <span class="ui_link">未分配：(<em><?php echo $this->_tpl_vars['notAllolt']; ?>
</em>)</span>
        <span class="ui_link">审核通过：(<em><?php echo $this->_tpl_vars['isPass']; ?>
</em>)</span>
        <span class="ui_link">审核未通过：(<em><?php echo $this->_tpl_vars['notPass']; ?>
</em>)</span>
        <span class="ui_link">未审核：(<em><?php echo $this->_tpl_vars['auditting']; ?>
</em>)</span>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
        <div class="ui_title">订单号：</div>
        <div class="ui_text"><input id="tbxOrderNo" type="text" name="tbxOrderNo"  value="" maxlength="30" /></div>        
        <div class="ui_title">代理商：</div>
        <div class="ui_text"><input id="tbxAgentName" type="text" name="tbxAgentName"  value="" maxlength="48" /></div>        
        <div class="ui_title">客户名称：</div>
        <div class="ui_text"><input id="tbxCustomerName" type="text" name="tbxCustomerName" value="" maxlength="48" /></div>       
        <div class="ui_title">提交时间：</div>
        <div class="ui_text">
            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxPostSDate" onClick="WdatePicker(<?php echo '{maxDate:\'#F{$dp.$D(\\\'J_editTimeE\\\')}\'})'; ?>
"/>
            至
            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxPostEDate" onClick="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS\\\')}\'})'; ?>
"/>	
        </div> 
    </div>
    <div class="table_filter_main_row">
        <div class="ui_title">产品：</div>
        <div class="ui_comboBox">
		<select id="cbProductType" name="cbProductType"></select>
		<select id="cbProduct" name="cbProduct"></select>
	</div>        
        <div class="ui_title">任务状态：</div>
        <div class="ui_text">
        <select id="cbAllotState" name="cbAllotState">
        <option value="-100">请选择</option>
        <option value="0">未分配</option>
        <option value="1">已分配</option>
        </select>
        </div> 
        <div class="ui_title">审核状态：</div>
        <div class="ui_text">
        <select id="cbAuditState" name="cbAuditState"></select>
        </div>   
        <div class="ui_title">审核人：</div>
        <div class="ui_text"><input id="tbxAuditUserName" type="text" name="tbxAuditUserName" style="width:100px;" value="" maxlength="10" /></div>
          
        <div class="ui_button ui_button_search">
        <button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button>
        </div>        
    </div>
    </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a class="ui_button" m="Back_OrderAuditAllotList" v="4" ispurview="true" onClick="AlloltAudits()" href="javascript:;" style="margin:0;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_taskDist"></div><div class="ui_text">分配</div></div></a>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
<div class="list_table_head_right">
<div class="list_table_head_mid">
	<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
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
				<th style="width:30px" title="全选/反选">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">
							<input id="chkSelectAll" type="checkbox" class="checkInp" onclick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');"/>
						</div>
                    </div>
                </th>
            	<th title="订单号">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">订单号</div>
                        <div class="ui_table_thsort" sort="sort_order_no"></div>
                    </div>
                </th>
                <th  title="代理商">
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
                <th title="产品">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">产品</div>
                        <div class="ui_table_thsort" sort="sort_convert(sys_product_type.product_type_name using gb2312),convert(sys_product.product_series using gb2312)"></div>
                    </div>
                </th>
                <th style="width:80px;" title="订单类型">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">订单类型</div>
                    </div>
                </th>
                <th style="width:80px;" title="提交时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">提交时间</div>
                    </div>
                </th>
                <th style="width:70px;" title="审核人">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">审核人</div>
                    </div>
                </th>
                <th style="width:80px;" title="审核状态">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">审核状态</div>
                    </div>
                </th>
                <th style="width:70px;" title="分配人">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">分配人</div>
                    </div>
                </th>
                <th style="width:80px;" title="分配时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">分配时间</div>
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
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>  
<?php echo ' 
<script language="javascript" type="text/javascript">
var _InDealWith = false;
 $(function(){
    $GetProduct.Init("cbProductType", "cbProduct", true,"",ProductGroups.ValueIncrease);
    cbDataBind.AuditStatus("cbAuditState");
	'; ?>

	pageList.strUrl = "<?php echo $this->_tpl_vars['OrderAuditAllotListBody']; ?>
"; 
	<?php echo '
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.first();
 }
  
 function AlloltAudits()
 {
    var chkOrderID = document.getElementsByName("listid");
    var orderIDs = "";
	for(var i = 0;i < chkOrderID.length;i++)
	{
		if(chkOrderID[i].checked && chkOrderID[i].disabled == false)
        {
			orderIDs += "," + chkOrderID[i].value;
        }
	}
    
        
	if(orderIDs.length > 1)
        orderIDs = orderIDs.substring(1, orderIDs.length);
    else
    {
        IM.tip.warn("请选择订单！");
        return ;
    }
    AlloltAudit(orderIDs,-100,"");
 }
 
 function AlloltAudit(orderIDs,oldAuditerID,oldAuditerName)
 {
    var isAllolt = oldAuditerName.length> 0 ? false:true;    
    if (oldAuditerID == undefined || oldAuditerID == null) {
        oldAuditerID = -100;
    }    
    if (oldAuditerName == undefined || oldAuditerName == null) {
        oldAuditerName = "";
    }
        
    IM.dialog.show({
			width: 550,
			title: (isAllolt==true ? "分配审核" : "转移审核"),
			html: \'<div class="loading">数据加载中...</div>\',
            start: function(){
                MM.get("/?d=OM&c=Back_Order&a=GetAlloltOrderPage&orderIDs="+orderIDs+"&oldAuditerName="+oldAuditerName,{},
                function(backHTML){
                    $(\'.DCont\').html(backHTML);                    
                        
        	    $(\'#accountName\').autocomplete(\'/?d=System&c=User&a=AutoUserJson&exceptUid=\'+oldAuditerID, {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
        		max: 8, //只显示5行
        		width: 200, //下拉列表的宽
        		parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
        		    /*
                    {"value":[{"id":"100","name":"\\u9a6c\\u6b63\\u6770"},
                    {"id":"200","name":"\\u9ebb\\u5409"},{"id":"300","name":"Marshane"}]}
                    */
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
            			    result: value[i].name
            			}
        		    }
        
        		    return parsed;
        		},
        		formatItem: function (item) {//内部方法生成列表
        		    //_id=item.id;
        		    return "<div id=\'divUser"+item.id+"\' >" + item.name + \'</div>\';
        		}
        	    }).result(function (data,value) {//执行模糊匹配
                    _id = value.id;
        			$(\'#tbxAccountID\').val("-100");
        			var val = $(this).val();
        			if (val != \'\') 
        			{
        			    $(\'#tbxAccountID\').val(_id);
        			}
        	    });           
                        
                    new Reg.vf($(\'#J_handleAudit\'),{callback:function(formData){
                        
                		//数据已提交，正在处理标识
                		if (_InDealWith) 
                		{
                			IM.tip.warn("数据已提交，正在处理中！");
                			return false;
                		}
                        var fData = $(\'#J_handleAudit\').serialize();
        _InDealWith = true;
                            MM.ajax({
                                url:"/?d=OM&c=Back_Order&a=AlloltAudits",
                                data:fData,//POST提交
                                success:function(backData){
                                    
                                    if(parseInt(backData) == 0){
                                        IM.dialog.hide();
                                        IM.tip.show((isAllolt==true ? "分配成功！" : "转移成功！"));
                                        $DOM("chkSelectAll").checked = false;
        _InDealWith = false;
                                        pageList.reflash();
                                    }else{
                                        IM.tip.warn(backData);
        _InDealWith = false;
                                    }
                                }
                            })
                    }});
                });
            }
    });
 }
 
 function ChangeAudit(orderID,oldAuditerID,oldAuditerName)
 {
    AlloltAudit(orderID,oldAuditerID,encodeURIComponent(oldAuditerName));
 }

</script>
'; ?>
 