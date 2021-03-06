<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：
财务管理<span>&gt;</span>款项账户管理<span>&gt;</span><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_PreDepositsAccountList')">代理商预存款账户明细</a><span>&gt;</span>{$strAgentName} 预存款账户</div>
<div class="table_filter marginBottom10">
    <form id="tableFilterForm" name="tableFilterForm" method="post" action="">
    <div class="table_filter_main" id="J_table_filter_main">
        <div class="table_filter_main_row">           
           <div class="ui_title">产品：</div>
            <div class="ui_comboBox" style="margin-right:5px;"><select id="cbProductType" name="cbProductType">
           <option value="-100"></option>
           {foreach from=$arrayProduct item=data key=index}
           <option value="{$data.product_type_id}">{$data.product_type_name}</option>
           {/foreach}            
            </select></div>          
            <div class="ui_button ui_button_search"><button onclick="QueryData()" type="button" class="ui_button_inner">搜 索</button></div>
        </div>
    </div>
    </form>
</div>
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strAgentName} 预存款账户</h4>
            <a class="ui_button ui_link" onclick="QueryData()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
        </div>
    </div>			           
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main marginBottom10">
    <div class="ui_table ui_table_nohead">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">           
    	<thead class="ui_table_hd">
            <tr class="">
               <th title="" style="width:120px;"></th>   
               <th title=""><div class="ui_table_thcntr"><div class="ui_table_thtext">产品</div></div></th>             					
               <th class="TA_r" title="所有的打款金额或转移到该预存款账户的金额"><div class="ui_table_thcntr"><div class="ui_table_thtext">充值总额(元)</div></div></th>
               <th class="TA_r" title="可用余额"><div class="ui_table_thcntr"><div class="ui_table_thtext">可用余额(元)</div></div></th>
               <th class="TA_r" title="冻结金额"><div class="ui_table_thcntr"><div class="ui_table_thtext">冻结金额(元)</div></div></th>
               <th class="TA_r" title="提交订单所扣除的总额"><div class="ui_table_thcntr"><div class="ui_table_thtext">消费总额(元)</div></div></th>
               <th class="TA_r" title="其他的支出"><div class="ui_table_thcntr"><div class="ui_table_thtext">其他支出(元)</div></div></th>
           </tr>
       </thead>             	
    	<tbody class="ui_table_bd">
        {foreach from=$arrayMoney item=data key=index}
    		<tr>
            	<td class="even"><div class="ui_table_tdcntr"></div></td>
            	<td ><div class="ui_table_tdcntr">--</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&agentNo={$agentNo}&accountType=2&inOutTypes=2,6,24')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=FM_Order&a=Back_OrderPriceList&agentNo={$agentNo}&priceStatus=1')">{$data.lock_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=FM_Order&a=Back_OrderPriceList&agentNo={$agentNo}&priceStatus=2')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&agentNo={$agentNo}&accountType=2&inOutTypes=15,16,25')">{$data.other_out_money}</a></div></td>
    		</tr>
        {/foreach}
        {foreach from=$arrayPreDeposits item=data key=index}
            <tr class="odd">
            	<td class="even"><div class="ui_table_tdcntr">预存款：</div></td>
            	<td ><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&agentNo={$agentNo}&productTypeID={$data.product_type_id}&accountType=2&inOutTypes=2,24')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=FM_Order&a=Back_OrderPriceList&agentNo={$agentNo}&productTypeID={$data.product_type_id}&priceStatus=1')">{$data.lock_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=FM_Order&a=Back_OrderPriceList&agentNo={$agentNo}&productTypeID={$data.product_type_id}&priceStatus=2')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&agentNo={$agentNo}&productTypeID={$data.product_type_id}&accountType=2&inOutTypes=15,16,25')">{$data.other_out_money}</a></div></td>
    		</tr>
        {/foreach}
        {foreach from=$arraySaleReward item=data key=index}
            <tr>
            	<td class="even"><div class="ui_table_tdcntr">销奖转预存款：</div></td>
            	<td ><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&agentNo={$agentNo}&accountType=2&productTypeID={$data.product_type_id}&inOutTypes=6')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=FM_Order&a=Back_OrderPriceList&agentNo={$agentNo}&priceStatus=1&onlyChargePre=0&productTypeID={$data.product_type_id}')">{$data.lock_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=FM_Order&a=Back_OrderPriceList&agentNo={$agentNo}&priceStatus=2&onlyChargePre=0&productTypeID={$data.product_type_id}')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&agentNo={$agentNo}&accountType=2&productTypeID={$data.product_type_id}&inOutTypes=15,16')">{$data.other_out_money}</a></div></td>
    		</tr>
        {/foreach}
            <tr><td colspan="7"><div class="list_table_attention">{$strPactInfo}</div></td></tr>
    	</tbody>
    </table>
    </div>
    <!--E ui_table-->
</div>
<!--E list_table_main-->

{literal}
<script language="javascript" type="text/javascript">
$(function(){
    $.setPurview();   
	{/literal}
    var productTypeID = parseInt({$productTypeID});
	{literal}
    
    if(productTypeID > 0)
        $("#cbProductType").val(productTypeID);
    
});

function QueryData()
{
    {/literal}
    var agentID = parseInt({$agentID});
	{literal}
    JumpPage("/?d=FM&c=PreDeposits&a=AgentPreDepositsAccount&agentID="+agentID+"&productTypeID="+$("#cbProductType").val());
}

</script>
{/literal}