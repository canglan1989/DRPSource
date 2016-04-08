{foreach from=$arrayData item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td title=""><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title="{$data.customer_name}">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)">{$data.customer_name}</a>
        </div>
    </td>
    <td title=""><div class="ui_table_tdcntr">{if $data.is_visit == 0}电话{else}拜访{/if}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.intention_rating_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{if $data.income_money != '0.000'}{$data.income_money|string_format:'%.2f'}{/if}</div></td>   
    <td title=""><div class="ui_table_tdcntr">{if $data.income_date != '0000-00-00'}{$data.income_date}{/if}</div></td> 
    <td title="{$data.create_user_name}">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="UserDetial({$data.create_uid})">{$data.create_user_name}</a>
        </div>
    </td>
    <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td> 
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.channel_uid})">{$data.e_name}</a></div></td> 
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_name}</a></div></td> 
</tr>
{/foreach}