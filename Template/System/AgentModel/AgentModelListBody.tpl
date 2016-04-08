{assign var="step" value=0}
{foreach from=$arrayAgentModel item=data key=index}
{if ($step++)%2 == 0}
<tr class="even">{else}
<tr class="odd">{/if}
  <td class="TA_l" title="{$data.agent_no}"><div class="ui_table_tdcntr">{$data.agent_no}</div></td>
  <td  title="{$data.agent_name}"><div class="ui_table_tdcntr" >{$data.agent_name}</div></td>
  <td title=""><div class="ui_table_tdcntr">{$data.product_name}>{$data.product_series}</div></td>
  <td title="{$data.agent_model_name}"><div class="ui_table_tdcntr">{if $data.agent_price_model_id <= 0 }---{else}{$data.agent_model_name}{/if}</div></td>
  <td class="TA_r" title="{$data.agent_price}"><div class="ui_table_tdcntr">{$data.agent_price}</div></td>
  <td  title="{$data.prom_model_name}"><div class="ui_table_tdcntr">{if $data.prom_price_model_id <= 0 }---{else}{$data.prom_model_name}{/if}</div></td>
  <td class="TA_r" title="{$data.prom_price}"><div class="ui_table_tdcntr"> {$data.prom_price} </div></td>
  <td><div class="ui_table_tdcntr">
      <ul class="list_table_operation">
        <li><a m="AgentPactModelQuery" ispurview="true" v="4" href="javascript:;"{if $data.agent_model_id == ""} onclick="modifyAgentModel(0,{$data.agent_id},{$data.product_id})"{else}onclick="modifyAgentModel({$data.agent_model_id},{$data.agent_id},{$data.product_id})"{/if}>设置价格</a></li>
        <!--<li><a m="AgentPactModelQuery" ispurview="true" v="8" href="javascript:;" {if $data.agent_model_id != "" }
        onclick=" IM.account.delOper('/?d=System&c=AgentModelQuery&a=DelModel&id={$data.agent_model_id}',{literal}{{/literal}id:{$data.agent_model_id}{literal}}{/literal},'清除模板',this)">删除模板</a>{else}删除模板{/if}</li>-->
      </ul>
    </div></td>
</tr>
{/foreach}