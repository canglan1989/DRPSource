{foreach from=$arrayAgentModel item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
  <td class="TA_l" title="{$data.agent_no}"><div class="ui_table_tdcntr">{$data.agent_no}</div></td>
  <td title="{$data.agent_name}"><div class="ui_table_tdcntr" >{$data.agent_name}</div></td>  
  <td title="{$data.model_remark}"><div class="ui_table_tdcntr">{$data.model_remark}</div></td>
  <td><div class="ui_table_tdcntr">
      <ul class="list_table_operation">
        <li><a m="UnitSaleRewardModelList" ispurview="true" v="4" href="javascript:;" 
        onclick="JumpPage('/?d=System&c=AgentModelQuery&a=UnitSaleRewardModelModify&agentID={$data.agent_id}')">设置返点比例</a></li>
      </ul>
    </div>
  </td>
</tr>
{/foreach}