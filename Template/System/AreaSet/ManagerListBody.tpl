{foreach from=$arrayManager item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td style="width:" title="">
        <div class="ui_table_tdcntr">
            <input class="checkInp" type="checkbox" value="{$data.agroup_manager_id}" name="listid"/>
        </div>
    </td>
    <td  style="width:" title="{$data.user_name}"><div class="ui_table_tdcntr">{$data.user_name}</div></td>
    <td  style="width:" title="{$data.e_name}"><div class="ui_table_tdcntr">{$data.e_name}</div></td>
    <td  style="width:" title="{$data.tel}"><div class="ui_table_tdcntr">{$data.tel}</div></td>
    <td  style="width:" title="{$data.phone}"><div class="ui_table_tdcntr">{$data.phone}</div></td>
    <td  style="width:" title="{$data.agroup_name}"><div class="ui_table_tdcntr">{$data.agroup_name}</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">
        	
            <ul class="list_table_operation">
                <li><a m="AreaManagerList" v="4" ispurview="true" href="javascript:;" onClick="accountGroup('id={$data.agroup_manager_id}');">编辑</a></li>
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}