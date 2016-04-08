{foreach from=$arrayGroup item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td  style="width:" title="{$data.agroup_name}"><div class="ui_table_tdcntr {if strlen($data.group_no)> 2}indent_2{/if}">{if strlen($data.group_no)==2}<strong>{$data.agroup_name}</strong>{else}{$data.agroup_name}{/if}</div></td>
    <td  style="width:" title="{$data.group_no}"><div class="ui_table_tdcntr">{$data.len_no/2}级</div></td>
    <td  style="width:" title="{$data.area_name}"><div class="ui_table_tdcntr "><a m="AreaGroupManagement" v="2" ispurview="true" href="javascript:;" onclick="ShowArea({$data.agroup_id})">查看地区范围</a></div></td>
    <td  style="width:" title="{$data.group_no}"><div class="ui_table_tdcntr">{$data.agroup_remark}</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">        	
            <ul class="list_table_operation">
                <li><a m="AreaGroupManagement" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=System&c=AreaGroupSet&a=AreaGroupModify&group_no={$data.group_no}&id={$data.agroup_id}')">编辑</a></li>                
                <li><a m="AreaGroupManagement" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('/?d=System&c=AreaGroupSet&a=DelGroup&id={$data.agroup_id}',{literal}{{/literal}id:{$data.agroup_id}{literal}}{/literal},'删除区域',this)">删除</a></li>                
                              
                {if strlen($data.group_no)<=4}
                <li><a m="AreaGroupManagement" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=System&c=AreaGroupSet&a=AreaGroupModify&group_no={$data.group_no}&supid={$data.agroup_id}')">添加下级区域组</a></li>                
                {/if}
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}