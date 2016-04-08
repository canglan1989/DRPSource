{foreach from=$arrayInvoice item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title=""><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=FM&c=Invoice&a=InvoiceDetail&id={$data.fii_id}')">{$data.fii_no}</a>
    </div></td>
    <td  title=""><div class="ui_table_tdcntr">{$data.create_time|date_format:"%Y-%m-%d"}</div></td>
    <td  title=""><div class="ui_table_tdcntr">{$data.c_product_name}</div></td>
    <td  title=""><div class="ui_table_tdcntr">{$data.f_invoice_title}</div></td>
    <td><div class="ui_table_tdcntr">{$data.invoice_type_name}</div></td>
    <td class="TA_r" title=""><div class="ui_table_tdcntr">{$data.f_invoice_apply_money}</div></td>    
    <td class="TA_r" title=""><div class="ui_table_tdcntr">
    {if $data.f_invoice_state <= 0}--{else}<a href="javascript:;" onclick="JumpPage('/?d=FM&c=Invoice&a=MakeInvoiceList&strInvoiceVerNo={$data.fii_no}')">{$data.f_invoice_money}</a>{/if}
    <td title=""><div class="ui_table_tdcntr">
    {if $data.f_invoice_state == 0}
    未开票
    {elseif $data.f_invoice_state == 1}
    部分开票
    {elseif $data.f_invoice_state == 2}
    已开票
    {elseif $data.f_invoice_state == -1}
    退回
    {else}
    未知
    {/if}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.f_invoice_state <= 0}--{else}{$data.f_opentime|date_format:"%Y-%m-%d"}{/if}
    </div></td>
  </tr>
{/foreach}