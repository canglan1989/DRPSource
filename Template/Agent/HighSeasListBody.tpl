{foreach from=$arrayData item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td title=""><div class="ui_table_tdcntr">
    <input class="checkInp" type="checkbox" name="listid" value="{$data.agent_id}"/></div></td>
    <td  title="{$data.agent_no}"><div class="ui_table_tdcntr">
    <a onclick="ShowAgentCard({$data.agent_id})" href="javascript:;">{$data.agent_no}</a></div></td>
    <td  title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td  title="{$data.intention_level}"><div class="ui_table_tdcntr">{$data.intention_level}</div></td>   
    <td title="{$data.industry_text}"><div class="ui_table_tdcntr">{$data.industry_text}</div></td>   
    <td  title="{$data.agent_reg_area_full_name}"><div class="ui_table_tdcntr">{$data.agent_reg_area_full_name}</div></td>
    <td  title="{$data.communicate_number}"><div class="ui_table_tdcntr">{$data.communicate_number}</div></td>
    <td  title="{$data.train_number}"><div class="ui_table_tdcntr">{$data.train_number}</div></td>   
    <td title="{$data.charge_phone}/{$data.charge_tel}"><div class="ui_table_tdcntr">{$data.charge_phone}/{$data.charge_tel}</div></td> 
    <td  title="{if $data.last_contact_id > 0}{$data.last_time}({$data.last_type_text}){else}--{/if}"><div class="ui_table_tdcntr">{if $data.last_contact_id > 0}{$data.last_time}({$data.last_type_text}){else}--{/if}</div></td>
    <td  title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td  title="{$data.in_sea_time}"><div class="ui_table_tdcntr">{$data.in_sea_time}</div></td>
    <td><div class="ui_table_tdcntr">        
          <ul class="list_table_operation">
                <li><a m="HighSeasList" v="4" ispurview="true" href="javascript:;" onclick="GetAgent({$data.agent_id})">拉取</a></li>
          </ul>
        </div>
      </td>
  </tr>
{/foreach}