{foreach from=$arrayUser item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td  title="{$data.e_name}"><div class="ui_table_tdcntr" ><a onclick="UserDetial({$data.user_id})" href="javascript:;">{$data.e_name}</a></div></td>
    <td title="{$data.e_workno}"><div class="ui_table_tdcntr">{$data.e_workno}</div></td>
    <td  title="{$data.dept_fullname}"><div class="ui_table_tdcntr">{$data.dept_fullname}</div></td>
    <td  title=""><div class="ui_table_tdcntr">{if $data.last_login_time == "2000-01-01 00:00:00"}--{else}{$data.last_login_time}{/if}</div></td>
    <td  title="{$data.post_name}"><div class="ui_table_tdcntr">{$data.post_name}</div></td>
    <td><div class="ui_table_tdcntr">
    {if $data.e_status == 0}聘用
    {elseif $data.e_status == -11}已流失
    {elseif $data.e_status == -10}已辞退
    {elseif $data.e_status == -9}已离职
    {elseif $data.e_status == -1}离职中
    {elseif $data.e_status == 1}实习
    {elseif $data.e_status == 2}见习
    {elseif $data.e_status == 3}外派
    {elseif $data.e_status == 4}停薪留职
    {elseif $data.e_status == 5}试用
    {else}聘用
    {/if}
    </div></td>
    <td><div class="ui_table_tdcntr" id="divStatu{$data.user_id}">{if $data.is_lock == 1}<span style="color:#EE5F00;">是</span>{else}<span style="color:#028100;">否</span>{/if}</div></td>
    <td><div class="ui_table_tdcntr">
    
    <ul class="list_table_operation">
        <li><a m="UserList" ispurview="true" v="4" href="javascript:;" onclick="LockUser(this,{$data.user_id})">{if $data.is_lock == 1}启用{else}停用{/if}</a></li>
        <li><a m="UserRightList" ispurview="true" v="2" href="javascript:;" onclick="JumpPage('/?d=System&c=User&a=UserRightList&id={$data.user_id}')">权限</a></li>
      </ul>
      
      </div>
      </td>
  </tr>
{/foreach}