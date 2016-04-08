{foreach from=$arrayData item=data key=index}
    <tr class="{sdrclass rIndex=$index}">
        <td title="{$data.agent_no} {$data.agent_name}" ><div class="ui_table_tdcntr"><a href="javascript:void(0);" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_no}</a><br />{$data.agent_name}</div></td>
        <td title="{$data.intertion_product}" ><div class="ui_table_tdcntr">
                                        {if $data.contact_type == 0 && $data.afterlevel <= 'B+'}
                                                <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote({$data.id})" >{$data.intertion_product}</a>
                                            {else}
                                            {$data.intertion_product}
                                        {/if}
            </div></td>
            <td title="{$data.visit_type}" ><div class="ui_table_tdcntr">
                    {$data.visit_type}</div></td>
        <td title="{$data.visitor}" ><div class="ui_table_tdcntr">{$data.visitor}</div></td>
        <td title="{$data.tel}/{$data.mobile}" ><div class="ui_table_tdcntr">{$data.mobile}{if !empty($data.mobile) && !empty($data.tel) }<br />{/if}{$data.tel}</div></td>
        <td title="{$data.visit_timestart|date_format:"%Y-%m-%d %H:%M"}~{$data.visit_timeend|date_format:"%H:%M"}" ><div class="ui_table_tdcntr">{$data.visit_timestart|date_format:"%Y-%m-%d %H:%M"}~{$data.visit_timeend|date_format:"%H:%M"}</div></td>
        <td title="{$data.user_name} {$data.e_name}" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.create_uid})">{$data.user_name} {$data.e_name}</a></div></td>
        <td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>
        <td title="{$data.visit_content}" ><div class="ui_table_tdcntr">{$data.visit_content|truncate:'12':'……'}</div></td>
        <td title="{$data.result}" ><div class="ui_table_tdcntr">{$data.result|truncate:'46':'……'}</div></td>
        <td title="{$data.verfity_status}" ><div class="ui_table_tdcntr">
                {$data.verfity_status}
            </div></td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    {if $data.is_vertifyed == 0}
                        <li><a href="javascript:void(0);" m="VisitManagementCheck" v="4" ispurview="true" onclick="JumpPage('{au d="WorkM" c="VisitVerify" a="showAddVisitVerfity"}&noteid={$data.id}')">质检</a></li>
                        <li><a href="javascript:void(0);" m="VisitManagementCheck" v="16" ispurview="true" onclick="FlagNoteUnVertify({$data.id})">不质检</a></li>
                    {elseif $data.is_vertifyed == 1}
                        <li><a href="javascript:void(0);" m="VisitManagementCheck" v="8" ispurview="true" onclick="JumpPage('{au d="WorkM" c="VisitVerify" a="showAddVisitInstruction"}&noteid={$data.id}')">批示</a></li>
                        <li><a href="javascript:void(0);" m="VisitManagementCheck" v="32" ispurview="true" onclick="FlagReviewVertify({$data.id})">审阅</a></li>
                    {/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}