{foreach from=$arrayData item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td title=""><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title="{$data.customer_name}">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showDetailFront"}&customer_id={$data.customer_id}')">{$data.customer_name}</a>
        </div>
    </td>
    <td title=""><div class="ui_table_tdcntr">{if $data.is_visit == 0}联系小记{else}拜访小记{/if}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.intention_rating_name}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{if $data.income_money != '0.000'}{$data.income_money}{/if}</div></td>   
    <td title=""><div class="ui_table_tdcntr">{if $data.income_date != '0000-00-00'}{$data.income_date}{/if}</div></td> 
    <td title="{$data.create_user_name}">
        <div class="ui_table_tdcntr">
            <a href="javascript:;" onclick="UserDetial({$data.create_uid})">{$data.create_user_name}</a>
        </div>
    </td>
    <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td> 
</tr>
{/foreach}