{foreach from=$arrayOrder item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.order_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
    </div></td>
    <td  title="{$data.agent_pact_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.agent_pact_id}&agentId={$data.agent_id}')">{$data.agent_pact_no}</a>
    </div></td>
    <td  title="{$data.agent_name}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no}<br/>
    {$data.agent_name}</a>
    </div></td>
    <td  title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowCustomerCard({$data.customer_id})">
    {$data.customer_name}</a>
    </div></td>
    <td  title="{$data.product_name}"><div class="ui_table_tdcntr">
    {$data.product_name}
    </div></td>
    <td class="TA_r" title="{$data.act_price}"><div class="ui_table_tdcntr" style="text-align:right" ><nobr style="text-align:right" >{$data.act_price}</div></td>
    <td><div class="ui_table_tdcntr">
    <a onclick="OrderStatusInfo({$data.order_id})" href="javascript:;">{$data.order_status_text}</a>
    </div></td>
    {if $data.check_status >= 0 && $data.act_price != 0}
        {if $data.is_charge == 1}
        <td title=""><div class="ui_table_tdcntr">已扣款</div></td>
        {else}
            <td title=""><div class="ui_table_tdcntr">已冻结</div></td>
        {/if}
        <td class="TA_r" title="{$data.pre_deposits_price}"><div class="ui_table_tdcntr">{$data.pre_deposits_price}</div></td>
        <td class="TA_r" title="{$data.sale_reward_price}"><div class="ui_table_tdcntr">{$data.sale_reward_price}</div></td>        
    {else}
        <td title=""><div class="ui_table_tdcntr">未扣款</div></td>
        <td class="TA_r" title=""><div class="ui_table_tdcntr">--</div></td>
        <td class="TA_r" title=""><div class="ui_table_tdcntr">--</div></td>
    {/if}    
    {if $data.check_status >= 0 && $data.act_price != 0 && $data.is_charge == 1}
        <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.pre_deposits_price}</div></td>
        <td title="" class="TA_r"><div class="ui_table_tdcntr">{$data.sale_reward_price}</div></td>    
    {else}
        <td class="TA_r" title=""><div class="ui_table_tdcntr">--</div></td>
        <td class="TA_r" title=""><div class="ui_table_tdcntr">--</div></td>
    {/if}
    <td title=""><div class="ui_table_tdcntr">{$data.back_pre_deposits_price}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.back_sale_reward_price}</div></td>    
    <td title=""><div class="ui_table_tdcntr">{$data.post_date}</div></td>
    <td title=""><div class="ui_table_tdcntr">{if $data.is_charge == 1 && $data.act_price != 0}{$data.charge_date}{else}--{/if}</div></td>
  </tr>
{/foreach}