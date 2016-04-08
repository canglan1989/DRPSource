{foreach from=$arrayData item=arrcheckList}
{if $arrcheckList.operate_type eq 2 && $arrcheckList.is_check eq 2}
{else}
<tr>
    <!--<td title=""><div class="ui_table_tdcntr">
    	<input class="checkInp" type="checkbox" name="listid" value="{$arrcheckList.aid}"/></div>
    </td>-->
    <td title="{$arrcheckList.agent_no}"><div class="ui_table_tdcntr">{$arrcheckList.agent_no}</div></td>
    <td title="{$arrcheckList.agent_name}"><div class="ui_table_tdcntr">{$arrcheckList.agent_name}</div></td>      
    <td title="{$arrcheckList.area_fullname}"><div class="ui_table_tdcntr">{$arrcheckList.area_fullname}</div>                    
    <td title="{$arrcheckList.charge_person}"><div class="ui_table_tdcntr">{$arrcheckList.charge_person}</div></td>              				
    <td title="{if $arrcheckList.charge_phone neq '' && $arrcheckList.charge_tel eq ''}
    {$arrcheckList.charge_phone}
    {elseif $arrcheckList.charge_tel neq '' && $arrcheckList.charge_phone eq ''}
    {$arrcheckList.charge_tel}
    {elseif $arrcheckList.charge_phone neq '' && $arrcheckList.charge_tel neq ''}
    {$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}
    {/if}">
    <div class="ui_table_tdcntr">    
    {if $arrcheckList.charge_phone neq '' && $arrcheckList.charge_tel eq ''}
    {$arrcheckList.charge_phone}
    {elseif $arrcheckList.charge_tel neq '' && $arrcheckList.charge_phone eq ''}
    {$arrcheckList.charge_tel}
    {elseif $arrcheckList.charge_phone neq '' && $arrcheckList.charge_tel neq ''}
    {$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}
    {/if}    
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{$arrcheckList.agent_check_user_name}</div></td>                                    
    <td>
        <div class="ui_table_tdcntr">
            
            {if $arrcheckList.check_type eq 0}
            企业新增
            {elseif $arrcheckList.check_type eq 1}
            企业修改
            {elseif $arrcheckList.check_type eq 2}
            企业删除
            {/if}
            
        </div>
    </td>
    <td><div class="ui_table_tdcntr"><a onclick="UserDetial({$arrcheckList.create_uid});" href="javascript:;">{$arrcheckList.agent_create_user_name}</a></div></td>
    <td><div class="ui_table_tdcntr">{$arrcheckList.create_time}</div></td>
    <td>
        <div class="ui_table_tdcntr">            
            <ul class="list_table_operation">
                <li><a m="AgentCheckList" v="4" ispurview="true" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentDetail'}&agentId={$arrcheckList.agent_id}&operaType={$arrcheckList.operate_type}&checkId={$arrcheckList.aid}');" style="cursor:pointer;">审核</a></li>
            </ul>            
        </div>
    </td>
</tr>
{/if}
{/foreach}
