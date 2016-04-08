{foreach from=$arrayGroup item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td  style="width:" title="{$data.agroup_name}"><div class="ui_table_tdcntr">{$data.agroup_name}</div></td>
    <td  style="width:" title="{$data.area_name}"><div class="ui_table_tdcntr">{$data.area_name}</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">
        	
            <ul class="list_table_operation">
                <li><a m="AreaGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=System&c=AreaSet&a=GroupModify&id={$data.agroup_id}')">编辑</a></li>
                {if $data.cant_del == 1}
				
                {else}
                <li><a m="AreaGroupList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('/?d=System&c=AreaSet&a=DelGroup&id={$data.agroup_id}',{literal}{{/literal}id:{$data.agroup_id}{literal}}{/literal},'删除区域',this)">删除</a></li>
                {/if}
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}