{foreach from=$arrayPayMoney item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{if $data.fr_type != 2}网盟预存款{else}增值产品{/if}</div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=GuaranteeMoney&a=PayMoneyDetail&id={$data.fr_id}')">{$data.fr_no}</a></div></td>
    <td><div class="ui_table_tdcntr">{$data.c_product_name}</div></td>
    <td><div class="ui_table_tdcntr"><a onclick="JumpPage('/?d=Agent&c=AgentMove&a=singleSignDetail&pactId={$data.c_contract_id}&agentId={$data.fr_object_id}')" href="javascript:;">{$data.c_contract_no}</a>
    <br />{$data.pact_sdate|date_format:"%Y-%m-%d"}--{$data.pact_edate|date_format:"%Y-%m-%d"}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.fr_rev_money}</div></td>
    <td><div class="ui_table_tdcntr">{$data.fr_payment_name}
     {if $data.fr_payment_id != 1}{if $data.fr_rp_num != ""}{$data.fr_rp_num}<br/>{/if}{$data.fr_peer_bank_name}{/if}</div></td>    
    <td><div class="ui_table_tdcntr">{$data.create_user_name}
    <br />{$data.fr_peer_date|date_format:"%Y-%m-%d"}</div></td>
    <td><div class="ui_table_tdcntr">    
    {if $data.fr_rp_files != ""}
    <a href="javascript:;" onclick="ViewPic('/?d=FM|c=PayMoney|a=ViewImage|id={$data.fr_id}')">查看</a>
    {else}
    --
    {/if}
    </div></td>
    <td><div class="ui_table_tdcntr">   
    {if $SYS_EVN == 2} 
        {if $data.fr_state == 0}
        未到账
        {elseif $data.fr_state == 1}
        底单入款
        {elseif $data.fr_state == 2}
        到账
        {elseif $data.fr_state == -1}
        款项信息退回
        {elseif $data.fr_state == 3}
        红冲
        {else}
        未知
        {/if}
    {else}
        {if $data.fr_state > 0}
        <a href="javascript:;" onclick="Test_OpenReceipt({$data.fr_id},'{$data.fr_rev_money}')">开收据</a>
        {/if}
        {if $data.fr_state == 0}
        <a href="javascript:;" onclick="TestCheck({$data.fr_id})">未到账</a>
        {elseif $data.fr_state == 1}
        <a href="javascript:;" onclick="TestCheck1({$data.fr_id})">底单入款</a>
        {elseif $data.fr_state == 2}
        到账
        {elseif $data.fr_state == -1}
        款项信息退回
        {elseif $data.fr_state == 3}
        红冲
        {else}
        未知
        {/if}
    {/if}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{if $data.fr_state >= 2}{$data.received_time}{else}--{/if}</div></td>
    <td title=""><div class="ui_table_tdcntr">{if $data.income_uid >0}<a href="javascript:;" onClick="ShowInAccountInfo({$data.fr_id})">{$data.income_time}</a>{else}--{/if}</div></td>
    <td><div class="ui_table_tdcntr">
    {if $data.invoice_bill_id > 0 }
    <a href="javascript:;" onClick="ShowInvoiceIsseuInfo({$data.invoice_bill_id})">{$data.invoice_no}</a>
    {else}
    --
    {/if} 
    </div></td>
    <td>
        <div class="ui_table_tdcntr">
        	<ul class="list_table_operation">
                {if $data.invoice_bill_id > 0 && $data.receipt_state == 0 && $data.fr_state > 0}
            	<li><a m="ReceiptList" v="32" ispurview="true" href="javascript:;" onClick="ReceiptConfirm({$data.invoice_bill_id})">收据确认</a></li>
                {/if}
                {if $data.fr_state == 0 || $data.fr_state == -1}
            	<li><a m="PreDepositsList" v="4" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PreDeposits&a={if $data.fr_type != 2}Unit{/if}PreDepositsModify&id={$data.fr_id}')">编辑</a></li>
                {/if}
                {if $data.fr_state == -1}
            	<li><a m="PreDepositsList" v="8" ispurview="true" href="javascript:;" onClick="IM.account.delOper('/?d=FM&c=PreDeposits&a=DelPreDeposits&id={$data.fr_id}',null,'删除预存款打款',this)">删除</a></li>
                {/if}
            </ul>
        </div>
    </td>
</tr>
{/foreach}