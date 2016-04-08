{foreach from=$arrayData item=data key=index}
    <tr class="{sdrclass rIndex=$index}">
        <td title="{$data.appoint_id}" ><div class="ui_table_tdcntr"><nobr>{$data.appoint_id}</nobr></div></td>
        <td title="{$data.agent_name}" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard('id={$data.agent_id}')">{$data.agent_name}</a></div></td>
        <td title="{$data.intertion_product}" ><div class="ui_table_tdcntr">
                    {$data.intertion_product}
            </div></td>
        <td title="{$data.visitor}" ><div class="ui_table_tdcntr">{$data.visitor}</div></td>
        <td title="{$data.position}" ><div class="ui_table_tdcntr">{$data.position}</div></td>
        <td title="{$data.role}" ><div class="ui_table_tdcntr">{$data.role}</div></td>
        <td title="{$data.mobile}/{$data.tel}" ><div class="ui_table_tdcntr">{$data.mobile}{if !empty($data.mobile) && !empty($data.tel)}<br />{/if}{$data.tel}</div></td>
        <td title="{$data.sappoint_time_cn}" ><div class="ui_table_tdcntr">{$data.sappoint_time_cn}</div></td>
        <td title="{$data.title}" ><div class="ui_table_tdcntr">{$data.title|truncate:"33":"……"}</div></td>
        <td title="{$data.create_user_name}" ><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.create_id});">{$data.create_user_name}</a></div></td>
        <td title="{$data.create_time|date_format:'%Y-%m-%d %H:%M'}" ><div class="ui_table_tdcntr">{$data.create_time|date_format:'%Y-%m-%d %H:%M'}</div></td>
        <td title="{$data.check_status_cn}" ><div class="ui_table_tdcntr">
                {if $data.check_status == 0 }
                    {$data.check_status_cn}
                    {else}
                        <a href="javascript:void(0)" onclick="CheckDetail({$data.appoint_id})">{$data.check_status_cn}</a>
                        {/if}
                
            </div></td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    {if $data.note == 0}
                    {if $data.check_status == 1}
                        <li><a href="javascript:void(0);" m="VisitAppoint" v="32" ispurview="true" onclick="JumpPage('{au d="WorkM" c="VisitAppoint" a="showAddVisitNote"}&appid={$data.appoint_id}')">生成小记</a></li>	
                    {else}
                        {if $UserID == $data.create_id}
                    <li><a href="javascript:void(0);" m="VisitAppoint" v="4" ispurview="true" onclick="JumpPage('{au d="WorkM" c="VisitAppoint" a="showAddVisitInvite"}&appointid={$data.appoint_id}')">编辑</a></li>	
                    <li><a href="javascript:void(0);" m="VisitAppoint" v="8" ispurview="true" onclick="delTask({$data.appoint_id})">删除</a></li>
                    {/if}
                        {if $data.check_status == 0}
                    <li><a href="javascript:void(0);" m="VisitAppoint" v="16" ispurview="true" onclick="JumpPage('{au d="WorkM" c="TelWork" a="showCheckVisitInvite"}&appid={$data.appoint_id}')">审核</a></li>        
                        {/if}
                    {/if}
                    {/if}
                </ul>
            </div>
        </td>
    </tr>
{/foreach}