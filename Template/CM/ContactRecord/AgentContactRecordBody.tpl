{foreach from=$arrayData item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowCustomerCard({$data.customer_id})">{$data.customer_name}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{if $data.is_visit == "0"}联系小记{else}拜访小记{/if}</div></td>  
    <td title=""><div class="ui_table_tdcntr">{$data.intention_rating_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.contact_name}</div></td>   
    <td title=""><div class="ui_table_tdcntr">{$data.contact_tel}<br/>
    {$data.contact_mobile}</div></td>
    <td title=""><div class="ui_table_tdcntr">
            {if $data.is_visit == "0"}
                {$data.contact_time|date_format:"%Y-%m-%d %H:%M"}
            {else}
                {$data.contact_time|date_format:"%Y-%m-%d %H:%M"} - {$data.contact_e_time|date_format:"%H:%M"}
            {/if}
    </div></td>    
    <td title=""><div class="ui_table_tdcntr">{$data.create_user_name}</div></td> 
    <td title=""><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="GetRecordDetail({$data.recode_id})">{$data.contact_recode|truncate:"60":"..."}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.revisit_uid > 0}
    <a href="javascript:;" onclick="ShowRevisitCard({$data.recode_id})">已回访</a>
    {else}
    还未回访
    {/if}
    </div></td> 
    <td title=""><div class="ui_table_tdcntr">{$data.revisit_user_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{if $data.revisit_time != '2000-01-01 00:00:00'}{$data.revisit_time}{/if}</div></td>    
    <td title=""><div class="ui_table_tdcntr">{if $data.not_valid_contact_id > 0}否{else}是{/if}</div></td> 
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.channel_uid})">{$data.user_name}{$data.e_name}</a></div></td> 
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard({literal}{{/literal}'id':{$data.agent_id}{literal}}{/literal})">{$data.agent_name}</a></div></td> 
</tr>
{/foreach}