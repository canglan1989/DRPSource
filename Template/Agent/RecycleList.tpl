{foreach from=$arrayData item=arrcheckList}
<tr>
    <td title=""><div class="ui_table_tdcntr"><input class="checkInp" type="checkbox" value="{$arrcheckList.agent_id}" name="listid"></div></td>
    <td title="{$arrcheckList.agent_no}"><div class="ui_table_tdcntr">{$arrcheckList.agent_no}</div></td>
    <td title="{$arrcheckList.agent_name}"><div class="ui_table_tdcntr">{$arrcheckList.agent_name}</div></td>      
    <td title="{$arrcheckList.area_fullname}"><div class="ui_table_tdcntr">{$arrcheckList.area_fullname}</div></td>                               
    <td title="{$arrcheckList.charge_person}"><div class="ui_table_tdcntr">{$arrcheckList.charge_person}</div></td>                    				
    <td title="{if $arrcheckList.charge_phone neq '' && $arrcheckList.charge_tel eq ''}
    {$arrcheckList.charge_phone}
    {elseif $arrcheckList.charge_tel neq '' && $arrcheckList.charge_phone eq ''}
    {$arrcheckList.charge_tel}
    {elseif $arrcheckList.charge_phone neq '' && $arrcheckList.charge_tel neq ''}
    {$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}
    {/if}"><div class="ui_table_tdcntr">
    {if $arrcheckList.charge_phone neq '' && $arrcheckList.charge_tel eq ''}
    {$arrcheckList.charge_phone}
    {elseif $arrcheckList.charge_tel neq '' && $arrcheckList.charge_phone eq ''}
    {$arrcheckList.charge_tel}
    {elseif $arrcheckList.charge_phone neq '' && $arrcheckList.charge_tel neq ''}
    {$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}
    {/if}
    </div></td>                           
    <td title="{$arrcheckList.check_time}"><div class="ui_table_tdcntr">{if $arrcheckList.check_time neq '0000-00-00 00:00:00'}{$arrcheckList.check_time}{/if}</div></td>
    <td title="{$arrcheckList.create_time}/{$arrcheckList.update_time}"><div class="ui_table_tdcntr">{$arrcheckList.create_time}/{$arrcheckList.update_time}</div></td>
    <td>
        <div class="ui_table_tdcntr">
            
            <ul class="list_table_operation">
                <li><a m="showRecyclePager" v="4" ispurview="true" href="javascript:;" onClick="IM.account.delOper('{au d='Agent' c='Agent' a='DelAgent'}','id={$arrcheckList.agent_id}','代理商删除提示',this)">删除</a></li>
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}