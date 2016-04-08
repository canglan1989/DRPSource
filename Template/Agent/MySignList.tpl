{foreach from=$arrayData item=arr}
    <tr class="">
        <td><div class="ui_table_tdcntr">{$arr.agent_no}</div></td>
        <td class="TA_l" title="{$arr.cur_agent_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$arr.agent_id}')">{$arr.cur_agent_name}</a></div></td>
        <td class="TA_l"><div class="ui_table_tdcntr">{$arr.area_fullname}</div></td>
        <td title="{$arr.product_type_name}"><div class="ui_table_tdcntr">{$arr.product_type_name}</div></td>
        <td><div class="ui_table_tdcntr">{if $arr.product_mode eq 0}渠道代理{else}渠道商务{/if}</div></td>
        <td><div class="ui_table_tdcntr">{if $arr.agent_level eq 0}无等级{elseif $arr.agent_level eq 1}金牌{else}银牌{/if}</div></td>
        <td><div class="ui_table_tdcntr">{$arr.pact_sdate}至{$arr.pact_edate}</div></td>                       
        <td>
        <div class="ui_table_tdcntr">
        {$arr.pact_number}
        </div>
        </td>
        <td>
        <div class="ui_table_tdcntr">
        {if $arr.pact_type eq 0}
        未签约
        {elseif $arr.pact_type eq 1}
        {$arr.pact_stage}(新签)
        {elseif $arr.pact_type eq 2}
        {$arr.pact_stage}(续签)
        {elseif $arr.pact_type eq 3}
        解除签约
        {elseif $arr.pact_type eq 4}
        {$arr.pact_stage}(已失效)
        {elseif $arr.pact_edate le $smarty.now|date_format:"%Y-%m-%d"}
        {$arr.pact_stage}(已失效)
        {/if}
        </div>
        </td>
        <td>
        <div class="ui_table_tdcntr">
        {if $arr.pact_status eq 0}
        未提交
        {elseif $arr.pact_status eq 1}
        <a onclick="IM.agent.getSubmittedBy('{au d=Agent c=AgentMove a=showPactCheckInfoCard}&aid={$arr.aid}','','审核状态',900)" href="javascript:;">流程中</a>
        {elseif $arr.pact_status eq 4 || $arr.pact_edate < $smarty.now|date_format:"%Y-%m-%d"}
        已失效
        {elseif $arr.pact_status eq 2}
        已签约
        {elseif $arr.pact_status eq 3}
        已解除签约
        {elseif $arr.pact_status eq 5}
        保存
        {elseif $arr.pact_status eq 6}
        审核退回
        {/if}
        </div>
        </td>
        <td title="{$arr.e_name}{$arr.user_name}"><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$arr.create_uid});">{$arr.e_name}{$arr.user_name}</a></div></td>
        <td><div class="ui_table_tdcntr">{$arr.create_time}</div></td>                        
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    {if $arr.pact_status eq 0 || $arr.pact_status eq 5 || $arr.pact_status eq 6}
                        <li><a m="mySigned" v="4" ispurview="true" href="javascript:;" onclick="{if $arr.pact_type eq 2}JumpPage('{au d=Agent c=AgentMove a=EditRenewalInfo}{else}JumpPage('{au d=Agent c=AgentMove a=EditSignInfo}{/if}&pactId={$arr.aid}&agentId={$arr.agent_id}');">编辑</a></li>
                    {elseif $arr.pact_status eq 4 || $arr.pact_edate le $smarty.now|date_format:"%Y-%m-%d"}
                    	<li><a m="mySigned" v="128" ispurview="true" href="javascript:;" onclick="JumpPage('{au d=Agent c=AgentMove a=singleSignDetail}&pactId={$arr.aid}&agentId={$arr.agent_id}&pactType={$arr.pact_type}&pactStatus={$arr.pact_status}');">签约详情</a></li>
                    {else}
                    
                        {if $arr.post_money_id > 0}
                            {if $arr.post_money_state == 0}
                            <li><a m="mySigned" v="32" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PayMoney&a=PayMoneyModify&agentID={$arr.agent_id}&id={$arr.post_money_id}')">编辑打款</a></li>
                            {/if}
                            <li><a m="mySigned" v="64" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PayMoney&a=SignedPayMoneyDetail&id={$arr.post_money_id}')">打款明细</a></li>
                        {else}
                            {if $arr.pact_status eq 2}
                            <li><a m="mySigned" v="32" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PayMoney&a=PayMoneyModify&agentID={$arr.agent_id}')">提交打款</a></li>
                            <li><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PayMoney&a=PactMoneyInAccountList&productID={$arr.product_id}&agentNo={$arr.agent_no}');">款项状态</a></li>
                            {/if}
                        {/if}
                        {if $arr.pact_type == 1 || $arr.pact_type == 2}
                        <li><a m="mySigned" v="256" ispurview="true" href="javascript:;" onclick="RemoveSign({$arr.aid},'{$arr.pact_number}{$arr.pact_stage}','{$arr.cur_agent_name}')">解除签约</a></li>
                        {/if}
                        <li><a m="mySigned" v="128" ispurview="true" href="javascript:;" onclick="JumpPage('{au d=Agent c=AgentMove a=singleSignDetail}&pactId={$arr.aid}&agentId={$arr.agent_id}&pactType={$arr.pact_type}&pactStatus={$arr.pact_status}');">签约详情</a></li>
                        <!--<li><a m="mySigned" v="256" ispurview="true" href="javascript:;" onclick="IM.agent.addReplenish('/?d=Agent&c=AgentReplenish&a=Replenish&agentId={$arr.agent_id}&pactId={$arr.aid}&strAgent={$arr.cur_agent_name|escape:'url'}&strPactNo={$arr.pact_number|escape:'url'}','代理商合同补签',{$arr.agent_id},{$arr.aid});">补签</a></li>-->
                    {/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}