{foreach from=$arrayData item=arrcheckList key=index}
<tr class="{sdrclass rIndex=$index}">
    <td title="{$arrcheckList.id}"><div class="ui_table_tdcntr">{$arrcheckList.id}</div></td>
    <td title="{$arrcheckList.agent_name}"><div class="ui_table_tdcntr"><a m="AgentList" v="8" ispurview="true" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentinfoAddContact'}&agentId={$arrcheckList.agent_id}&checkStatus={$arrcheckList.is_check}&needCheck=yes&isPact=no');" href="javascript:;">{$arrcheckList.agent_name}</a>   
    </div></td>      
    <td title="{$arrcheckList.oldOwnerName}"><div class="ui_table_tdcntr">{$arrcheckList.oldOwnerName}</div></td>   
    <td title="{$arrcheckList.sharePerson}"><div class="ui_table_tdcntr">{$arrcheckList.sharePerson}</div></td>  
    <td title="{$arrcheckList.newOwnerName}"><div class="ui_table_tdcntr">{$arrcheckList.newOwnerName}</div></td>                                       
    <td title="{$arrcheckList.share_remark}"><div class="ui_table_tdcntr">{$arrcheckList.share_remark}</div></td>
    <td title="{$arrcheckList.shareCreate}"><div class="ui_table_tdcntr">{$arrcheckList.shareCreate}</div></td>
    <td title="{$arrcheckList.share_create_time}"><div class="ui_table_tdcntr">{$arrcheckList.share_create_time}</div></td>
    <td title="{$arrcheckList.check_status}"><div class="ui_table_tdcntr">
      {if $arrcheckList.check_status neq '未审核'}
      <a href="javascript:void(0)" onclick="showCheckPage('{$arrcheckList.id}')">{$arrcheckList.check_status}</a>
      {else}
      {$arrcheckList.check_status}
      {/if}
</div></td>
    <td>
        <div class="ui_table_tdcntr">            
            <ul class="list_table_operation">
                {if $arrcheckList.check_status eq '未审核'}
                <li><a  href="javascript:;" onClick="check({$arrcheckList.id})">审核</a></li>
                {/if}
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}