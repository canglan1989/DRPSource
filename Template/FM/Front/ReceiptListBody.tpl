{foreach from=$arrayInvoice item=data key=index}
  {if $data.invoice_no != "" && $data.f_invoice_state > 0}
  <tr class="{sdrclass rIndex=$index}">
    <td  title=""><div class="ui_table_tdcntr"> 
    {if $data.fr_type == 2}
    增值产品预存款
    {elseif $data.fr_type == 17}
    网盟预存款
    {else}
    保证金
    {/if}   
    </div></td>
    <td><div class="ui_table_tdcntr">{$data.c_contract_no}</div></td>
    <td><div class="ui_table_tdcntr">{$data.invoice_no}</div></td>
    <td  title=""><div class="ui_table_tdcntr">{if $data.f_invoice_state > 0}
    已开票
    {else}
    未开票
    {/if}    
    </div></td>
    <td><div class="ui_table_tdcntr">{$data.open_time}</div></td>    
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.invoice_money}</div></td>
    <td  title=""><div class="ui_table_tdcntr">{$data.f_invoice_title}</div></td>
    <td  title=""><div class="ui_table_tdcntr">{$data.f_remark}</div></td>    
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.fr_rev_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.fr_state == 2 || $data.fr_state == 1}{$data.fr_in_money}{else}--{/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.fr_state == 2}{$data.fr_in_money}{else}--{/if}</div></td>
    <td><div class="ui_table_tdcntr">
    {if $data.fr_state == 0}
    未到账
    {elseif $data.fr_state == 1}
    底单入款
    {elseif $data.fr_state == 2}
    到账
    {elseif $data.fr_state == -1}
    退回
    {elseif $data.fr_state == 3}
    红冲
    {else}
    未知
    {/if}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
        <ul class="list_table_operation">
            {if $data.invoice_bill_id > 0 && $data.f_isreceipt == 0 }
        	<li><a m="ReceiptList" v="32" ispurview="true" href="javascript:;" onClick="ReceiptConfirm({$data.fii_id})">收据确认</a></li>
            {/if}
        	<li><a href="javascript:;" onClick="JumpPage('/?d=FM&c=GuaranteeMoney&a=PayMoneyDetail&id={$data.fr_id}')">款项明细</a></li>
        </ul>
    </div></td>
  </tr>
  {else}
  <tr class="{sdrclass rIndex=$index}">
    <td  title=""><div class="ui_table_tdcntr"> 
    {if $data.fr_type == 2}
    预存款
    {else}
    保证金
    {/if}   
    </div></td>
    <td><div class="ui_table_tdcntr">{$data.c_contract_no}</div></td>
    <td><div class="ui_table_tdcntr">--</div></td>
    <td  title=""><div class="ui_table_tdcntr">{if $data.f_invoice_state > 0}
    已开票
    {else}
    未开票
    {/if}    
    </div></td>
    <td><div class="ui_table_tdcntr">--</div></td>    
    <td class="TA_r"><div class="ui_table_tdcntr">--</div></td>
    <td  title=""><div class="ui_table_tdcntr">{$data.f_invoice_title}</div></td>
    <td  title=""><div class="ui_table_tdcntr"></div></td>    
    <td class="TA_r"><div class="ui_table_tdcntr">{$data.fr_rev_money}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.fr_state == 2 || $data.fr_state == 1}{$data.fr_in_money}{else}--{/if}</div></td>
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.fr_state == 2}{$data.fr_in_money}{else}--{/if}</div></td>
    <td><div class="ui_table_tdcntr">
    {if $data.fr_state == 0}
    未到账
    {elseif $data.fr_state == 1}
    底单入款
    {elseif $data.fr_state == 2}
    到账
    {elseif $data.fr_state == -1}
    退回
    {elseif $data.fr_state == 3}
    红冲
    {else}
    未知
    {/if}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
        <ul class="list_table_operation">
        	<li><a href="javascript:;" onClick="JumpPage('/?d=FM&c=GuaranteeMoney&a=PayMoneyDetail&id={$data.fr_id}')">款项明细</a></li>
        </ul>
    </div></td>
  </tr>
  {/if}
{/foreach}