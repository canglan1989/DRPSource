{foreach item=pactlog from=$arrayData}
<tr class="">
    <td>
    <div class="ui_table_tdcntr">
    	{if $pactlog.pact_type eq 0}
        	未签约
        {elseif $pactlog.pact_type eq 1}    
            新签
        {elseif $pactlog.pact_type eq 2}
            续签
        {elseif $pactlog.pact_type eq 3}
            解除签约
        {elseif $pactlog.pact_type eq 4}
            失效
        {/if}
       {if $pactlog.pact_stage neq ''}({$pactlog.pact_stage}){/if}
    </div>
    </td>
    <td>
    <div class="ui_table_tdcntr">
    	{if $pactlog.pact_status eq 0}
        	未提交
        {elseif $pactlog.pact_status eq 1}
        	流程中
        {elseif $pactlog.pact_status eq 2}
        	已签约
        {elseif $pactlog.pact_status eq 3}
        	已解除签约
        {elseif $pactlog.pact_status eq 3}
        	已失效
        {/if}
    </div>
    </td>
    <td class="TA_r"><div class="ui_table_tdcntr">{if $pactlog.cash_deposit neq '0.00'}￥{$pactlog.cash_deposit}{/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{if $pactlog.pre_deposit neq '0.00'}￥{$pactlog.pre_deposit}{/if}</div></td>
    <td><div class="ui_table_tdcntr">{$pactlog.e_name}</div></td>
    <td><div class="ui_table_tdcntr">{$pactlog.account_name}</div></td>
    <td><div class="ui_table_tdcntr">{$pactlog.check_time}</div></td></td>
</tr>
{/foreach}     
       