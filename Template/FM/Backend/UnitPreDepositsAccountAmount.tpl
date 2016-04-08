<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
            <a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=UnitPreDepositAccountAmount')" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
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
               <th class="TA_r" title="所有的打款金额或转移到该预存款账户的金额"><div class="ui_table_thcntr"><div class="ui_table_thtext">充值总额(元)</div></div></th>
               <th class="TA_r" title="可用余额"><div class="ui_table_thcntr"><div class="ui_table_thtext">可用余额(元)</div></div></th>
               <th class="TA_r" title="提交订单所扣除的总额"><div class="ui_table_thcntr"><div class="ui_table_thtext">消费总额(元)</div></div></th>
               <th class="TA_r" title="其他的支出"><div class="ui_table_thcntr"><div class="ui_table_thtext">其他支出(元)</div></div></th>
               <th class="TA_c" title="" style="width:300px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>
           </tr>
       </thead>             	
    	<tbody class="ui_table_bd">
        {foreach from=$arrayMoney item=data key=index}
    		<tr>
            	<td class="even"><div class="ui_table_tdcntr"></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&productTypeID={$data.product_type_id}&inOutTypes=17,18,24')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=Back_UnitInMoneyList')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&productTypeID={$data.product_type_id}&inOutTypes=15,16,25')">{$data.other_out_money}</a></div></td>
                <td>
                    <div class="ui_table_tdcntr">                                            
                        <ul class="list_table_operation">
                        <li><a class="ui_button" m="MoneyInAccountList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=FM&c=InMoney&a=MoneyInAccountList&accountType=17');">收款明细</a></li>
                        <!--<li><a class="ui_button" m="Back_OrderPriceList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=Back_UnitInMoneyList')">订单款项明细</a></li>-->
                        <li><a class="ui_button" m="Back_AccountMoneyInOutList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&inOutType=1')">充值记录</a></li>
                        </ul>
                    </div>
                </td>
    		</tr>
        {/foreach}
        {foreach from=$arrayPreDeposits item=data key=index}
            <tr class="odd">
            	<td class="even"><div class="ui_table_tdcntr">预存款：</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&productTypeID={$data.product_type_id}&inOutTypes=17,24')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=Back_UnitInMoneyList')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&productTypeID={$data.product_type_id}&inOutTypes=15,16,25')">{$data.other_out_money}</a></div></td>
                <td></td>
    		</tr>
        {/foreach}
        {foreach from=$arraySaleReward item=data key=index}
            <tr>
            	<td class="even"><div class="ui_table_tdcntr">返点转预存款：</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&productTypeID={$data.product_type_id}&inOutTypes=18,24')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=Back_UnitInMoneyList&onlyChargePre=0')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutList&accountType=7&productTypeID={$data.product_type_id}&inOutTypes=15,16,25')">{$data.other_out_money}</a></div></td>
                <td></td>
    		</tr>
        {/foreach}
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
});
 
</script>
{/literal}