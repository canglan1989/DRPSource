{foreach from=$arrayData item=data key=index}
    <tr class="{sdrclass rIndex=$index}">
        <td title="{$data.agent_no} {$data.agent_name}" ><div class="ui_table_tdcntr"><a href="javascript:void(0);" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_no}</a><br />{$data.agent_name}</div></td>
        <td title="{$data.afterlevel}({$data.product_name})" ><div class="ui_table_tdcntr">
                    {if $data.afterlevel <= 'B+'}
                        <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote({$data.id})" >{$data.afterlevel}</a>
                    {else}
                        {$data.afterlevel}
                    {/if}
            </div></td>
        <td title="{$data.visitor}" ><div class="ui_table_tdcntr">{$data.visitor}</div></td>
        <td title="{$data.tel}/{$data.mobile}" ><div class="ui_table_tdcntr">{$data.mobile}{if !empty($data.mobile) && !empty($data.tel)}<br />{/if}{$data.tel}</div></td>
        <td title="{$data.visit_timestart|date_format:"%Y-%m-%d %H:%M"}" ><div class="ui_table_tdcntr">{$data.visit_timestart|date_format:"%Y-%m-%d %H:%M"}</div></td>
        <td title="{$data.user_name} {$data.e_name}" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.create_uid})">{$data.user_name} {$data.e_name}</a></div></td>
        <td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>
        <td title="{$data.result}" ><div class="ui_table_tdcntr">{$data.result|truncate:'46':'……'}</div></td>
        <td title="{$data.dynamics}" ><div class="ui_table_tdcntr">{$data.dynamics|truncate:'16':'……'}</div></td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a href="javascript:void(0);" m="TelVerify" v="4" ispurview="true" onclick="JumpPage('{au d="WorkM" c="VisitVerify" a="showAddTelVerfity"}&noteid={$data.id}')">质检</a></li>
                    <li><a href="javascript:void(0);" m="TelVerify" v="8" ispurview="true" onclick="FlagNoteUnVertify({$data.id})">不质检</a></li>
                </ul>
            </div>
        </td>
    </tr>
{/foreach}