{foreach from=$arrayData item=data key=index}
    <tr class="">
        <td title="">
            <div class="ui_table_tdcntr"><input type="checkbox" value="65" name="listid" class="checkInp"></div>
        </td>
        <td title="{$data.net_u_name}">
            <div class="ui_table_tdcntr">{$data.net_u_name}</div>
        </td>
        <td class="TA_l" title="{$data.agent_name}">
            <div class="ui_table_tdcntr"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard({literal}{{/literal}id:{$data.agent_id}{literal}}{/literal})">{$data.agent_name}</a></div>
        </td>
        <td title="{$data.agent_id}">
            <div class="ui_table_tdcntr">{$data.agent_id}</div>
        </td>
        <td title="{$data.account_state}">
            <div class="ui_table_tdcntr">{$data.account_state}</div>
        </td>
        <td title="{$data.bind_time}">
            <div class="ui_table_tdcntr">{$data.bind_time}</div>
        </td>
        <td title="{$data.bind_user_name}">
            <div class="ui_table_tdcntr">{$data.bind_user_name}</div>
        </td>
        <td>
            <div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                    <li><a href="javascript:;" onclick="IM.agent.getSubmittedBy('../chunk/editWYaccount.php',{literal}{}{/literal},'编辑帐号',400)">
                            编辑</a></li>
                    <li><a href="javascript:;" onclick="IM.agent.getSubmittedBy('../chunk/midifyPwd.php',{literal}{}{/literal},'密码修改',400)">
                            密码修改</a></li>
                    <li><a href="">取消绑定</a></li>
                    <li><a href="javascript:;" onclick="IM.agent.getSubmittedBy('../chunk/bindWYaccount.php',{literal}{}{/literal},'绑定帐号',400)">
                            绑定</a></li>
                    <li><a href="">删除</a></li>
                </ul>
            </div>
        </td>
    </tr>
{/foreach}