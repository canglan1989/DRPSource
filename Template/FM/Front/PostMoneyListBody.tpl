{foreach from=$arrayPayMoney item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="JumpPage('/?d=FM&c=PayMoney&a=PayMoneyDetail&id={$data.post_money_id}')">{$data.post_money_no}</a></div></td>
    <td><div class="ui_table_tdcntr">{$data.agent_pact_nos}</div></td>
    <td><div class="ui_table_tdcntr">{$data.product_type_names}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.post_money_amount}</div></td>
    <td><div class="ui_table_tdcntr">{$data.payment_name}&nbsp;{if $data.rp_num != ""}{$data.rp_num}<br/>{/if}{$data.agent_bank_name}</div></td>
    <td><div class="ui_table_tdcntr">
    {if $data.rp_files != ""}
    <a href="javascript:;" onclick="ViewPic('/?d=FM|c=PayMoney|a=ViewImage|id={$data.post_money_id}')">查看</a>
    {else}
    --
    {/if}
    </div></td>
    <td><div class="ui_table_tdcntr">
    {$data.post_money_state_text}
    </div></td>    
    <td><div class="ui_table_tdcntr">{$data.create_user_name}
    <br />{$data.post_date|date_format:"%Y-%m-%d"}</div></td>
    <td title=""><div class="ui_table_tdcntr">{if $data.received_uid > 0}
    {$data.received_time}{else}--{/if}</div></td>   
    <td title=""><div class="ui_table_tdcntr">{if $data.income_uid >0}
    <a href="javascript:;" onClick="ShowInAccountInfo({$data.post_money_id})">{$data.income_time}</a>{else}--{/if}</div></td>    
    <td title="{$data.fii_no}"><div class="ui_table_tdcntr">
    {if $data.fii_id > 0 }
    <a href="javascript:;" onClick="ShowInvoiceIsseuInfo({$data.fii_id})">{$data.fii_no}</a>
    {else}
    --
    {/if}    
    </div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">
    {if $data.fii_id > 0 }
    {$data.f_invoice_money}
    {else}
    --
    {/if}
    </div></td>
    <td title="{$data.f_opentime}"><div class="ui_table_tdcntr">
    {if $data.fii_id > 0 }
    {$data.f_opentime}
    {else}
    --
    {/if}    
    </div></td>
    <td>
        <div class="ui_table_tdcntr">
        	<ul class="list_table_operation">
                {if $data.fii_id > 0 && $data.f_isreceipt == 0  && $data.post_money_state > 0}
            	<li><a m="PostMoneyList" v="32" ispurview="true" href="javascript:;" onClick="ReceiptConfirm({$data.post_money_id})">收据确认</a></li>
                {/if}
                
                {if $data.post_money_state == 0|| $data.post_money_state == -1}
            	<li><a m="PostMoneyModify" v="4" ispurview="true" href="javascript:;" onClick="JumpPage('/?d=FM&c=PayMoney&a=PayMoneyModify&id={$data.post_money_id}')">编辑</a></li>
            	<li><a m="PostMoneyModify" v="8" ispurview="true" href="javascript:;" onClick="IM.account.delOper('/?d=FM&c=PayMoney&a=DelPayMoney&id={$data.post_money_id}',null,'删除打款',this)">删除</a></li>
                {/if}
            </ul>
        </div>
    </td>
</tr>
{/foreach}