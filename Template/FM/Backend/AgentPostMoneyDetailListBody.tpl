{foreach from=$arrayData item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.fr_type_text}</div></td>
    <td><div class="ui_table_tdcntr">{$data.fr_no}</div></td>
    <td><div class="ui_table_tdcntr">{$data.c_contract_no}</div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no}</a>
    <br/>{$data.agent_name}</td>
    <td><div class="ui_table_tdcntr">{$data.c_product_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.fr_payment_name}
    {if $data.fr_payment_id != 1}{if $data.fr_rp_num != ""}{$data.fr_rp_num}<br/>{/if}{$data.fr_peer_bank_name}{/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.fr_rp_files != ""}
    <a href="javascript:;" onclick="ViewPic('{$data.fr_rp_files}')">查看</a>
    {else}
    --
    {/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.fr_rev_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.fr_money}</div></td>
    <td><div class="ui_table_tdcntr">{$data.fr_state}</div></td>
    <td><div class="ui_table_tdcntr">{$data.fr_peer_date|date_format:"%Y-%m-%d"}</div></td>
    <td><div class="ui_table_tdcntr">{$data.account_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.post_user_name}/{$data.post_time}</div></td>
</tr>
{/foreach}