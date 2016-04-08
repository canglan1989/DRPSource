{foreach from=$arrayInvoice item=data key=index}
<tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{if $data.invoice_bill_id > 0 && $data.f_isreceipt != 0 }{$data.invoice_no}{else}--{/if}</div></td>
    <td><div class="ui_table_tdcntr">{$data.fii_no}</div></td>
    <td><div class="ui_table_tdcntr">{$data.apply_time}</div></td>
    <td><div class="ui_table_tdcntr">{$data.c_product_name}</div></td>    
    <td  title=""><div class="ui_table_tdcntr">{$data.f_invoice_title}</div></td>
    <td  title=""><div class="ui_table_tdcntr">{$data.invoice_type_name}</div></td>     
    <td class="TA_r"><div class="ui_table_tdcntr">{if $data.invoice_bill_id > 0}{$data.invoice_money}{else}--{/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.f_invoice_state > 0}
    已开票
    {else}
    未开票
    {/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.invoice_bill_id > 0}{$data.open_time}{else}--{/if}</div></td>
    <td><div class="ui_table_tdcntr">{if $data.invoice_bill_id > 0}{$data.open_remark}{else}--{/if}</div></td>
    <td><div class="ui_table_tdcntr">
        <ul class="list_table_operation">
            {if $data.invoice_bill_id > 0  && $data.f_isreceipt == 0 }
        	<li><a m="MakeInvoiceList" v="32" ispurview="true" href="javascript:;" onClick="InvoiceConfirm({$data.invoice_bill_id})">发票确认</a></li>
            {/if}
        </ul>
    </div></td>
</tr>
{/foreach}