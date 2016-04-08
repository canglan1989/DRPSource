{foreach from=$arrayData item=arr key=index}
<tr class="{sdrclass rIndex=$index}">
        <td title=""><div class="ui_table_tdcntr">
        <input class="checkInp" type="checkbox" name="listid" value="{$arr.aid}"/></div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.agent_no}</div></td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$arr.agent_id}')">{$arr.cur_agent_name}</a></div></td>
        <td title=""><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('{au d=Agent c=AgentMove a=singleSignDetail}&pactId={$arr.aid}&agentId={$arr.agent_id}');">{$arr.pact_number}</a></div></td>
        <td><div class="ui_table_tdcntr">{$arr.export_pact_type}</div> </td>
        <td title="" class="TA_l"><div class="ui_table_tdcntr">{$arr.agent_reg_area_full_name}</div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.pact_product_name}</div></td>
        <td><div class="ui_table_tdcntr">{$arr.agent_type_text}</div></td>
        <td><div class="ui_table_tdcntr">{$arr.export_agent_level}</div></td>
        <td title=""><div class="ui_table_tdcntr">{$arr.pact_sdate}至{$arr.pact_edate}</div></td>
        <td><div class="ui_table_tdcntr">{$arr.export_pact_status}</div></td>
        <td><div class="ui_table_tdcntr"><a onclick="IM.agent.getSubmittedBy('{au d=Agent c=AgentMove a=showPactCheckInfoCard}&aid={$arr.aid}','','审核状态',900)" href="javascript:;">{$arr.export_liucheng_status}</a></div></td>
        <td><div class="ui_table_tdcntr">{$arr.money_received}</div></td>
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arr.channel_uid});">{$arr.agent_channel_user_name}</a></div></td>
        <td><div class="ui_table_tdcntr">{$arr.account_name}</div></td>
        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arr.create_uid});">{$arr.create_user_name}</a></div></td>
        <td><div class="ui_table_tdcntr">{$arr.create_time}</div></td>   
        <td> <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a m="SignDetail" v="16" ispurview="true" href="javascript:;" onclick="JumpPage('{au d=Agent c=AgentMove a=EachsignDetialPager}&aid={$arr.aid}&agentId={$arr.agent_id}');">签约记录</a></li>
                    {if $arr.pact_status eq 2}
                            <li><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PayMoney&a=PactMoneyInAccountList&productID={$arr.product_id}&agentNo={$arr.agent_no}');">款项到帐状态</a></li>
                    {/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}