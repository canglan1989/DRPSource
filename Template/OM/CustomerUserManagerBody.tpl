{foreach from=$arrayOrder item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.order_no}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
    </div></td>
    <td  title="{$data.agent_name}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_name}</a>
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
    {$data.login_user_create_time|date_format:"%Y-%m-%d"}
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.login_state ==1}
    <span style="color:#028100;">正常</span>
    {else}
    <span style="color:#EE5F00;">关闭</span>
    {/if}
    </div></td>
    <td><div class="ui_table_tdcntr">        
          {if $data.single_info_id > 0}  
            <ul class="list_table_operation">          
                {if $data.login_state ==1}
                <li><a m="CustomerUserManager" v="16" ispurview="true" href="javascript:;" onclick="LockCustomerUser({$data.single_info_id})">停用账户</a></li>
                {else}
                <li><a m="CustomerUserManager" v="16" ispurview="true" href="javascript:;" onclick="OpenCustomerUser({$data.single_info_id})">开启账户</a></li>
                {/if}
               <!--<li><a href="javascript:;" onclick="ResetPwd({$data.single_info_id})">重置密码</a></li>-->                
            </ul>
          {/if}
        </div>
      </td>
  </tr>
{/foreach}