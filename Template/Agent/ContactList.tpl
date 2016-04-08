{foreach from=$arrContactList item=ContactList}
<tr class="">
    <td title="{$ContactList.user_name}({$ContactList.e_name})" style="width:"><div class="ui_table_tdcntr">{$ContactList.user_name}({$ContactList.e_name})</div></td>
    <td title="{$ContactList.contact_name}" style="width:"><div class="ui_table_tdcntr">{$ContactList.contact_name}</div></td>
    <td title="{$ContactList.mobile}({$ContactList.tel})" style="width:"><div class="ui_table_tdcntr">{$ContactList.mobile}{if $ContactList.tel neq ''}({$ContactList.tel}){/if}</div></td>
    <td title="{$ContactList.contact_time}" style="width:"><div class="ui_table_tdcntr">{$ContactList.contact_time}</div></td>
    <td title="{$ContactList.remark}" style="width:"><div class="ui_table_tdcntr">{$ContactList.remark|truncate:"50":"..."}</div></td>
    <td title="{$ContactList.leval}" style="width:"><div class="ui_table_tdcntr">{$ContactList.leval}</div></td>
</tr>
{/foreach}