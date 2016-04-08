{foreach from=$arrayData item=data key=index}
<tr>
    <td><div class="ui_table_tdcntr">{$data.customer_name}</div></td>                                
    <td><div class="ui_table_tdcntr">{$data.industry_fullname}</div></td>                               
    <td><div class="ui_table_tdcntr">{$data.area_fullname}</div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$data.from_user_id})">{$data.from_user_name}</a></div></td>
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$data.to_user_id})">{$data.to_user_name}</a></div></td>                                    
    <td><div class="ui_table_tdcntr">{$data.create_time}</div></td>                                    
    <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial({$data.create_uid})">{$data.create_user_name}</a></div></td>
</tr>
{/foreach}