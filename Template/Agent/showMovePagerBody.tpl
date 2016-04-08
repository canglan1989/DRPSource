{foreach from=$arrAgentList item=arrcheckList}
<tr>
    <td title="{$arrcheckList.agent_no}"><div class="ui_table_tdcntr">{$arrcheckList.agent_no}</div></td>
    <td title="{$arrcheckList.agent_name}"><div class="ui_table_tdcntr">{$arrcheckList.agent_name}</div></td>      
    <td title="{$arrcheckList.agent_reg_area_full_name}"><div class="ui_table_tdcntr">{$arrcheckList.agent_reg_area_full_name}</div></td>                               
    <td ><div class="ui_table_tdcntr">{$arrcheckList.move_type_text}</div></td>
    <td ><div class="ui_table_tdcntr">{$arrcheckList.data_from}</div></td>
    <td ><div class="ui_table_tdcntr">{$arrcheckList.data_to}</div></td>
    <td ><div class="ui_table_tdcntr"> <a onclick="UserDetial({$arrcheckList.create_uid});" href="javascript:;">{$arrcheckList.create_user_name}</a></div></td>
    <td title="{$arrcheckList.create_time}"><div class="ui_table_tdcntr">{$arrcheckList.create_time}</div></td>
</tr>
{/foreach}