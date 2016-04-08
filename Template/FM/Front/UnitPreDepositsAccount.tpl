<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<div class="list_link marginBottom10">
    <a class="ui_button" m="UnitPreDepositsAccount" v="4" ispurview="true" 
    onclick="JumpPage('/?d=FM&c=PreDeposits&a=UnitPreDepositsModify')" href="javascript:;" style="margin:0">
    <div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_open"></div>
    <div class="ui_text">提交打款</div></div></a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>网盟预存款账户</h4>
            <a class="ui_button ui_link" onclick="JumpPage('/?d=FM&c=PreDeposits&a=UnitPreDepositsAccount')" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
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
               <th title=""><div class="ui_table_thcntr"><div class="ui_table_thtext">合同号</div></div></th>
               <th title=""><div class="ui_table_thcntr"><div class="ui_table_thtext">合同时间</div></div></th>	       					
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
                <td><div class="ui_table_tdcntr">--</div></td><td><div class="ui_table_tdcntr">--</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=AccountMoneyInOutList&accountType=7&inOutTypes=17,18,24,21,30')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=UnitInMoneyList')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=AccountMoneyInOutList&accountType=7&inOutTypes=15,25,31')">{$data.other_out_money}</a></div></td>
                <td>
                    <div class="ui_table_tdcntr">                                            
                        <ul class="list_table_operation">
                        <li><a class="ui_button" m="PostMoneyDetailList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=FM&c=PayMoney&a=PostMoneyDetailList&cbFrTypes=17');">打款明细</a></li>
                        <!--<li><a class="ui_button" m="OrderPriceList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=UnitInMoneyList')">转款明细</a></li>-->
                        <li><a class="ui_button" m="PreDepositsChange" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=PreDepositsChange&accountType=17,18')">充值记录</a></li>
                        </ul>                                            
                    </div>
                </td>
    		</tr>
        {/foreach}
        {foreach from=$arrayPreDeposits item=data key=index}
            <tr class="odd">
            	<td class="even"><div class="ui_table_tdcntr">预存款：</div></td>
            	<td ><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.agent_pact_id}&agentId={$data.agent_id}')">{$data.pact_no}</a></div></td>
            	<td ><div class="ui_table_tdcntr">{$data.pact_sdate|date_format:"%Y-%m-%d"}<br />{$data.pact_edate|date_format:"%Y-%m-%d"}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=AccountMoneyInOutList&accountType=7&inOutTypes=17,24,21,30')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=UnitInMoneyList')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=AccountMoneyInOutList&accountType=7&inOutTypes=15,25,31')">{$data.other_out_money}</a></div></td>
                <td></td>
    		</tr>
        {/foreach}
        {foreach from=$arraySaleReward item=data key=index}
            <tr>
            	<td class="even"><div class="ui_table_tdcntr">返点转预存款：</div></td>
                <td><div class="ui_table_tdcntr">--</div></td><td><div class="ui_table_tdcntr">--</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=AccountMoneyInOutList&accountType=7&productTypeID={$data.product_type_id}&inOutTypes=18,30')">{$data.in_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.can_use_money}</div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=UnitInMoney&a=UnitInMoneyList&onlyChargePre=0&productTypeID={$data.product_type_id}')">{$data.order_out_money}</a></div></td>
                <td title="" class="TA_r"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PreDeposits&a=AccountMoneyInOutList&accountType=7&productTypeID={$data.product_type_id}&inOutTypes=15,31')">{$data.other_out_money}</a></div></td>
                <td></td>
    		</tr>
        {/foreach}
            <tr><td colspan="8"><div class="list_table_attention">{$strMsg}</div></td></tr>
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