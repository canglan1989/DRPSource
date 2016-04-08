{foreach from=$arrayData item=data key=index}
  <tr>
    
    <td title="{$data.user_name}"><div class="ui_table_tdcntr" ><a onclick = "UserDetial({$data.user_id})" href="javascript:;" >{$data.user_name}</a></div></td>
    <td title="{$data.valid_count}"><div class="ui_table_tdcntr">{if $IsBack == 0}<a href="javascript:;" onclick="ShowValidDetail({$data.user_id},1)">{$data.valid_count}</a>{else}{$data.valid_count}{/if}</div></td>
    <td title="{$data.invalid_count}"><div class="ui_table_tdcntr">{if $IsBack == 0}<a href="javascript:;" onclick="ShowValidDetail({$data.user_id},2)">{$data.invalid_count}</a>{else}{$data.invalid_count}{/if}</div></td>
    <td title="{$data.record_count}"><div class="ui_table_tdcntr">{if $IsBack == 0}<a href="javascript:;" onclick="ShowValidDetail({$data.user_id},3)">{$data.record_count}</a>{else}{$data.record_count}{/if}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.valid_rate*100|string_format:"%2.2f"|cat:"%"}</div></td>
    <td title="{$data.visit_count}"><div class="ui_table_tdcntr">{if $IsBack == 0}<a href="javascript:;" onclick="ShowVisitDetail({$data.user_id})">{$data.visit_count}</a>{else}{$data.visit_count}{/if}</div></td>
    
  </tr>
{/foreach}