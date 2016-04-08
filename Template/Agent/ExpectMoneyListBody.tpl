{foreach from=$arrayData item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td ><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no}</a></div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>   
    <td ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.channel_uid});" href="javascript:;">{$data.agent_channel_user_name}</a></div></td>
    <td ><div class="ui_table_tdcntr">{$data.account_name}</div></td>
    <td ><div class="ui_table_tdcntr">{$data.inten_level}</div></td>
    <td class="TA_r" ><div class="ui_table_tdcntr">{$data.expect_money}</div></td>
    <td ><div class="ui_table_tdcntr">{$data.expect_time}</div></td>                                 
    <td ><div class="ui_table_tdcntr">{$data.expect_type_text}</div></td>
    <td class="TA_r" ><div class="ui_table_tdcntr">{$data.charge_percentage}</div></td>
    <td ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.create_uid});" href="javascript:;">{$data.create_user_name}</a></div></td>
    <td ><div class="ui_table_tdcntr">{$data.create_time}</div></td>
</tr>
{/foreach}