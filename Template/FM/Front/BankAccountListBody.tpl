{foreach from=$arrayBankAccount item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td style="width:" title="{$data.bank_name}"><div class="ui_table_tdcntr">{$data.bank_name}</div></td>
    <td style="width:" title="{$data.account_name}"><div class="ui_table_tdcntr">{$data.account_name}</div></td>
    <td style="width:" title="{$data.account_no}"><div class="ui_table_tdcntr">{$data.account_no}</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">
        	
            <ul class="list_table_operation">
                <li><a m="BankAccountList" v="4" ispurview="true" href="javascript:;" onclick="addBankAccount({$data.agent_bank_id})">编辑</a></li>
                {if $data.cant_del != 1}
                <li><a m="BankAccountList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('/?d=FM&c=BankAccount&a=DelBankAccount&id={$data.agent_bank_id}',{literal}{{/literal}id:{$data.agent_bank_id}{literal}}{/literal},'删除产品',this)">删除</a></li>
                {/if}
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}