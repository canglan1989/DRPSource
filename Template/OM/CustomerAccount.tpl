<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
    <div class="table_filter_main_row">
        <div class="ui_title">订单号：</div>
        <div class="ui_text"><input id="tbxOrderNo" type="text" name="tbxOrderNo"  value="" maxlength="30" /></div>
        
        <div class="ui_title">客户ID：</div>
        <div class="ui_text"><input id="tbxCustomerNo" type="text" name="tbxCustomerNo"  value="" maxlength="20" /></div>
            
        <div class="ui_title">客户名称：</div>
        <div class="ui_text"><input id="tbxCustomerName" type="text" name="tbxCustomerName"  value="" maxlength="48" /></div>
            
        <div class="ui_title">产品：</div>
        <div class="ui_comboBox"><select id="cbProductType" name="cbProductType"></select>
		<select id="cbProduct" name="cbProduct"></select></div>
   
    </div>
    <div class="table_filter_main_row">       
        <div class="ui_title">账号名：</div>
        <div class="ui_text"><input id="tbxAccountName" class="inpCommon" type="text" name="tbxAccountName"  value="" maxlength="48" /></div>
            
        <div class="ui_title">账号状态：</div>
        <div class="ui_text">
        <select id="cbAccountState" name="cbAccountState">
        <option value="-100">请选择</option>
        <option value="1">正常</option>
        <option value="0">关闭</option>
        </select>
        </div>      
        <div class="ui_title">开通时间：</div>
        <div class="ui_text">
            <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxAddSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
            至
            <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxAddEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
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
                <th  title="客户ID">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">客户ID</div>
                    </div>
                </th>
                <th  title="客户名称">
                	<div class="ui_table_thcntr">
                    	<div class="ui_table_thtext">客户名称</div>
                        <div class="ui_table_thsort" sort="sort_convert(om_order.customer_name using gb2312)"></div>
                    </div>
                </th>
                <th title="产品">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">产品</div>
                        <div class="ui_table_thsort" sort="sort_convert(sys_product.product_name using gb2312),convert(sys_product.product_series using gb2312)"></div>
                    </div>
                </th>
                <th style="width:100px;" title="账号名">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">账号名</div>
                    </div>
                </th>
                <th style="width:100px;" title="账号密码">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">账号密码</div>
                    </div>
                </th>
                <th style="width:100px;" title="联系人姓名">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">联系人姓名</div>
                    </div>
                </th>
                <th style="width:100px;" title="联系电话">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">联系电话</div>
                    </div>
                </th>
                <th style="width:80px;" title="账号状态">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">账号状态</div>
                    </div>
                </th>
                <th  title="开通时间">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">开通时间</div>
                    </div>
                </th>
                <th title="有效期">
                	<div class="ui_table_thcntr ">
                    	<div class="ui_table_thtext">有效期</div>
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
    $GetProduct.Init("cbProductType", "cbProduct", true);
	{/literal}
	pageList.strUrl = "{$CustomerAccountBody}"; 
	{literal}
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = '&'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 
</script>
{/literal} 