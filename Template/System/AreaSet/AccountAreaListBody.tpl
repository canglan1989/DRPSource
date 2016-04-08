
{foreach from=$arrayGroup item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td  style="width:" title="{$data.account_no}"><div class="ui_table_tdcntr ">{$data.account_no}</div></td>
    <td  style="width:" title="{$data.account_name}"><div class="ui_table_tdcntr {if strlen($data.account_no)> 2}indent_2{/if}">{if strlen($data.account_no)==2}<strong>{$data.account_name}</strong>{else}{$data.account_name}{/if}{if $data.is_system==1}<span style="color:red">（该账号组不可删除）</span>{/if}</div></td>
    <td  style="width:" title="{$data.account_name}"><div class="ui_table_tdcntr"> {$data.user_name}</div></td>
    <td  style="width:" title="{$data.account_no}"><div class="ui_table_tdcntr">{$data.account_group_level}级</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">
            <ul class="list_table_operation">
                <li><a m="AccountAreaList" v="4" ispurview="true" href="javascript:;" 
                onclick="ModifyAccountGroup({$data.account_group_id},0)">编辑</a></li>
                {if $data.account_group_level< 3}
                <li><a m="AccountAreaList" v="4" ispurview="true" href="javascript:;" 
                onclick="ModifyAccountGroup(0,{$data.account_group_id})">添加下级</a></li>
                {/if}
                
{if $data.have_sub != 1 && $data.is_system != 1 }
                <li><a m="AccountAreaList" v="8" ispurview="true" href="javascript:;" 
                onclick="IM.account.delOper('/?d=System&c=AccountArea&a=DelAccountGroup&id={$data.account_group_id}',{literal}{{/literal}
                id:{$data.account_group_id}{literal}}{/literal},'删除账号组',this)">删除</a></li>
{/if}
                <li><a href="javascript:;" onclick="JumpPage('/?d=System&c=AccountArea&a=AccountBindList&id={$data.account_group_id}')">绑定账号</a></li>
                
     
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}