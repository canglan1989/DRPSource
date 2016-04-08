{foreach from=$arrayData item=data key=index name=estimate}
  {if $smarty.foreach.estimate.iteration%2==1}
  <tr>
  {/if}
    <td title="{$data.report_date}"><div class="ui_table_tdcntr">{$data.report_date}</div></td>
    <td title="{$data.income_money}"><div class="ui_table_tdcntr">{$data.income_money|string_format:"￥%.2f"}</div></td>
    <td title="{$data.order_count}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a  href="javascript:;" onclick="ShowEstimateDetail('{$data.report_date}')">{$data.order_count}</a>{else}{$data.order_count}{/if}</div></td>
    <td title="{$data.charge_money}"><div class="ui_table_tdcntr">{$data.charge_money|string_format:"￥%.2f"}</div></td>
    <td title="{$data.charge_count}"><div class="ui_table_tdcntr">{if $IsBack == "0"}<a href="javascript:void(0)" onclick="JumpPage('{au d="FM" c="UnitInMoney" a="UnitInMoneyList"}&starttime={$data.report_date}&endtime={$data.report_date}')">{$data.charge_count}</a>{else}{$data.charge_count}{/if}</div></td>
  {if $smarty.foreach.estimate.iteration%2==1 && $smarty.foreach.estimate.last==true}  
    <td title=""><div class="ui_table_tdcntr"></div></td>
    <td title=""><div class="ui_table_tdcntr"></div></td>
    <td title=""><div class="ui_table_tdcntr"></div></td>
    <td title=""><div class="ui_table_tdcntr"></div></td>
    <td title=""><div class="ui_table_tdcntr"></div></td>
  </tr>  
  {elseif $smarty.foreach.estimate.iteration%2==0}  
  </tr>
  {/if}
{/foreach}