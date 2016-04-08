{foreach from=$arrayOrder item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.order_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
    </div></td>
    <td  title="{$data.customer_no}"><div class="ui_table_tdcntr">
    <a onclick="ShowCustomerCard({$data.customer_id})" href="javascript:;">{$data.customer_no}</a>
    </div></td>
    <td  title="{$data.customer_name}"><div class="ui_table_tdcntr">    
    {$data.customer_name}
    </div></td>
    <td  title="{$data.product_name}"><div class="ui_table_tdcntr">
    {$data.product_name}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {$data.login_name}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {$data.login_pwd}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {$data.contact_name}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {$data.contact_mobile}{if $data.contact_tel != ""}{if $data.contact_mobile != ""}/{/if}
    {$data.contact_tel}{/if}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.login_state ==1}    
    <span style="color:#028100;">正常</span>
    {else}
    <span style="color:#EE5F00;">关闭</span>
    {/if}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {$data.login_user_create_time|date_format:"%Y-%m-%d"}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {$data.effect_sdate|date_format:"%Y-%m-%d"}<br />{$data.effect_edate|date_format:"%Y-%m-%d"}
    </div></td>
  </tr>
{/foreach}