{foreach from=$arrayOrder item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.order_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
    </div></td>
    <td  title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowCustomerCard({$data.customer_id})" href="javascript:;">{$data.customer_name}</a>
    </div></td>
    <td  title="{$data.product_full_name}"><div class="ui_table_tdcntr">
    {$data.product_full_name}
    </div></td>
    <td class="TA_r" title="{$data.act_price}"><div class="ui_table_tdcntr" >{$data.act_price}</div></td>
    <td title=""><div class="ui_table_tdcntr" >
    {if $data.act_price != 0 &&  $data.check_status >= 0}
        {if $data.is_charge > 0}
        <a href="javascript:;" onclick="OrderPriceStatus({$data.order_id})">扣款</a>
        {else}
        <a href="javascript:;" onclick="OrderPriceStatus({$data.order_id})">冻结</a>
        {/if}
    {elseif $data.act_price != 0 &&  $data.check_status == -1}
    未扣款
    {else}
    --
    {/if}    
    </div></td>
    <td title="{$data.order_sdate|date_format:"%Y-%m-%d"} -- {$data.order_edate|date_format:"%Y-%m-%d"}"><div class="ui_table_tdcntr">{$data.order_sdate|date_format:"%Y-%m-%d"}<br/>{$data.order_edate|date_format:"%Y-%m-%d"}</div></td>
    <td><div class="ui_table_tdcntr">{$data.order_type}</div></td>
    <td><div class="ui_table_tdcntr">
    <a onclick="OrderStatusInfo({$data.order_id})" href="javascript:;">{$data.order_status_text}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.effect_sdate|date_format:"%Y-%m-%d"}<br />{$data.effect_edate|date_format:"%Y-%m-%d"}</div></td>
    {if $data.check_status == -2}
        <td title=""><div class="ui_table_tdcntr">--</div></td>
        <td title=""><div class="ui_table_tdcntr">--</div></td>
    {else}   
        <td  title="{$data.post_user_name} {$data.post_e_name}"><div class="ui_table_tdcntr">
        {$data.post_user_name}&nbsp;&nbsp;{$data.post_e_name}
        </div></td>  
        <td title="{$data.post_date}"><div class="ui_table_tdcntr">{$data.post_date}</div></td>
    {/if}
    <td><div class="ui_table_tdcntr">        
            <ul class="list_table_operation">
            {if $data.finance_uid == $financeUid}
                {if $data.check_status < 0}
                {if $data.order_type == '续签'}
                <li><a m="OrderModify" v="4" ispurview="true" href="javascript:;" onclick="CSignOrder('cid={$data.order_id}')">编辑</a></li>
                {else}
                <li><a m="OrderModify" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="OM" c="Order" a="OrderModify"}&id={$data.order_id}')">编辑</a></li>
                {/if}
                {/if}
                {if $data.check_status == -2}
                <li><a m="MyOrderList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('{au d="OM" c="Order" a="DelOrder"}&id={$data.order_id}',{literal}{{/literal}id:{$data.order_id}{literal}}{/literal},'删除订单',this)">删除</a></li>
                {/if}
                {if $data.check_status == 0}
                <!--<li><a m="OrderModify" v="4" ispurview="true" href="javascript:;" onclick="BackOrder(this,{$data.order_id})">退单</a></li>-->
                {/if}
                {if $data.order_type != '退单' && $data.check_status == 1 && $data.order_status == 50}                
                <li><a m="OrderModify" v="4" ispurview="true" href="javascript:;" onclick="CSignOrder('id={$data.order_id}')">续签</a></li>
                {/if}
            {/if}
          </ul>          
        </div>
      </td>
  </tr>
{/foreach}