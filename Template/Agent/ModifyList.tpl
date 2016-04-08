{foreach from=$arrayData item=arrModifyList}
<tr>
    <td title="{$arrModifyList.agent_no}"><div class="ui_table_tdcntr">{$arrModifyList.agent_no}</div></td>
    <td title="{$arrModifyList.agent_name}"><div class="ui_table_tdcntr">{$arrModifyList.agent_name}</div></td>      
    <td title="{$arrModifyList.area_fullname}"><div class="ui_table_tdcntr">{$arrModifyList.area_fullname}</div></td>                               
    <td title="{$arrModifyList.charge_person}"><div class="ui_table_tdcntr">{$arrModifyList.charge_person}</div></td>
    <td title="{if $arrModifyList.charge_phone neq '' && $arrModifyList.charge_tel eq ''}
    {$arrModifyList.charge_phone}
    {elseif $arrModifyList.charge_tel neq '' && $arrModifyList.charge_phone eq ''}
    {$arrModifyList.charge_tel}
    {elseif $arrModifyList.charge_phone neq '' && $arrModifyList.charge_tel neq ''}
    {$arrModifyList.charge_phone}/{$arrModifyList.charge_tel}
    {/if}"><div class="ui_table_tdcntr">
    {if $arrModifyList.charge_phone neq '' && $arrModifyList.charge_tel eq ''}
    {$arrModifyList.charge_phone}
    {elseif $arrModifyList.charge_tel neq '' && $arrModifyList.charge_phone eq ''}
    {$arrModifyList.charge_tel}
    {elseif $arrModifyList.charge_phone neq '' && $arrModifyList.charge_tel neq ''}
    {$arrModifyList.charge_phone}/{$arrModifyList.charge_tel}
    {/if}
    </div></td>   
    <td title="{$arrModifyList.create_time}{if $arrModifyList.update_time neq '0000-00-00 00:00:00'}/{$arrModifyList.update_time}{/if}"><div class="ui_table_tdcntr">{$arrModifyList.create_time}{if $arrModifyList.update_time neq '0000-00-00 00:00:00'}/{$arrModifyList.update_time}{/if}</div></td>                                 
    <td title="{$arrModifyList.cuname}({$arrModifyList.cname})"><div class="ui_table_tdcntr">
    {$arrModifyList.cuname}
    {if $arrModifyList.cname neq ''}
    ({$arrModifyList.cname})
    {/if}
    </div></td>
    <td title="{$arrModifyList.check_time}"><div class="ui_table_tdcntr">
    {if $arrModifyList.check_time neq '0000-00-00 00:00:00'}
    {$arrModifyList.check_time}
    {/if}
    </div></td>
    <td title="{$arrModifyList.uname}({$arrModifyList.uuname})"><div class="ui_table_tdcntr">{$arrModifyList.uname}({$arrModifyList.uuname})</div></td>
    <td>
        <div class="ui_table_tdcntr">
            
            <ul class="list_table_operation">
                <li><a m="showModifyPager" v="4" ispurview="true" onclick="JumpPage('{au d='Agent' c='Agent' a='showModifyLogList'}&agentId={$arrModifyList.agent_id}');" style="cursor:pointer;">修改记录</a></li>
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}