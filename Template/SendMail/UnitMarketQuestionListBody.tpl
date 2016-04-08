{foreach from=$arrayData item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="ShowAgentCard({$data.object_id})">{$data.object_name}</a></td>
    <td><div class="ui_table_tdcntr">{$data.mail_from}</div></td>
    <td><div class="ui_table_tdcntr">{$data.mail_to}</div></td>
    <td><div class="ui_table_tdcntr">{$data.send_time}</div></td>
    <td><div class="ui_table_tdcntr">{$data.send_result}</div></td>
    <td><div class="ui_table_tdcntr">{$data.create_user_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.create_time}</div></td>
</tr>
{/foreach}