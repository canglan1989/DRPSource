{foreach from=$arrayData item=data key=index}
  <tr>
    <td title="{$data.user_name}"><div class="ui_table_tdcntr" ><a onclick = "UserDetial({$data.user_id})" href="javascript:;" >{$data.user_name}</a></div></td>
    
    <td title="{$data.rating_1}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowValidDetail({$data.user_id},1)">{$data.rating_1}</a>{else}{$data.rating_1}{/if}</div></td>
    <td title="{$data.rating_2}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowValidDetail({$data.user_id},2)">{$data.rating_2}</a>{else}{$data.rating_2}{/if}</div></td>
    <td title="{$data.rating_3}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowValidDetail({$data.user_id},3)">{$data.rating_3}</a>{else}{$data.rating_3}{/if}</div></td>
    <td title="{$data.rating_4}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowValidDetail({$data.user_id},4)">{$data.rating_4}</a>{else}{$data.rating_4}{/if}</div></td>
    <td title="{$data.rating_5}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowValidDetail({$data.user_id},5)">{$data.rating_5}</a>{else}{$data.rating_5}{/if}</div></td>
    <td title="{$data.rating_6}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowValidDetail({$data.user_id},6)">{$data.rating_6}</a>{else}{$data.rating_6}{/if}</div></td>
    <td title="{$data.rating_7}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowValidDetail({$data.user_id},7)">{$data.rating_7}</a>{else}{$data.rating_7}{/if}</div></td>
    
    <td title="{$data.income_money}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowEstimateDetail({$data.user_id})">{$data.income_money}</a>{else}{$data.income_money}{/if}</div></td>
    <td title="{$data.order_count}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowEstimateDetail({$data.user_id})">{$data.order_count}</a>{else}{$data.order_count}{/if}</div></td>
    <td title="{$data.charge_money}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a href="javascript:void(0)" onclick="GoUnitInMoneyList('{$data.user_name}')">{$data.charge_money}</a>{else}{$data.charge_money}{/if}</div></td>
    <td title="{$data.charge_count}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a href="javascript:void(0)" onclick="GoUnitInMoneyList('{$data.user_name}')">{$data.charge_count}</a>{else}{$data.charge_count}{/if}</div></td>
    
  </tr>
{/foreach}