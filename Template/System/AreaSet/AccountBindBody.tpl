{foreach from=$arrayUser item=data key=index}
<tr class="{sdrclass rIndex=$index}">
  
  
  <td><div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkCheck" value="{$data.account_group_user_id}" id="chk_{$data.account_group_user_id}"/>
  </div></td>
  
  
	<td  style="width:" title="{$data.user_name}"><div class="ui_table_tdcntr">{$data.user_name}</div></td>
    <td  style="width:" title="{$data.e_name}"><div class="ui_table_tdcntr"> <a onclick="UserDetial({$data.user_id})" href="javascript:;" >{$data.e_name}</a> </div></td>
    <td  style="width:" title="{$data.area_group_name}"><div class="ui_table_tdcntr">{$data.area_group_name}</div></td>
    <td style="" title="">
    	<div class="ui_table_tdcntr">
            <ul class="list_table_operation">
            <li><a m="AccountAreaList" v="4" ispurview="true" href="javascript:;" 
                onclick="RemoveBind({$data.account_group_user_id})">移除</a></li>
                {if $account_len ==6}
            <li><a href="javascript:;" onclick="AreaBind({$id},{$data.account_group_user_id})">绑定区域组</a></li>{/if}
            <!--
账号组区域绑定中，如果账号组不是三级，该账号组下面的账户不可以绑定区域组
-->
            </ul>
            
        </div>
    </td>
</tr>
{/foreach}