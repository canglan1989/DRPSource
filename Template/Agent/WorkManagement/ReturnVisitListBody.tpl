{foreach from=$arrPageList item=data key=index}
    <tr class="{sdrclass rIndex=$index}">
        <td title="{$data.id}" ><div class="ui_table_tdcntr"><nobr>{$data.id}</nobr></div></td>
        <td title="{$data.e_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.add_user_id})" href="javascript:;">{$data.e_name}</a></div></td>
        <td title="{$data.add_time}" ><div class="ui_table_tdcntr">{$data.add_time}</div></td>
        <td title="{$data.content}"><div class="ui_table_tdcntr"><nobr>{$data.content}</nobr></div></td>
        <td title="{$data.return_time}"><div class="ui_table_tdcntr"><nobr>{$data.return_time}</nobr></div></td>
    </tr>
{/foreach}