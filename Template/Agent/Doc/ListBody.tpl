{foreach from=$arrayData item=data key=index}
<tr class="{sdrclass rIndex=$index}">
<td  title=""><div class="ui_table_tdcntr">
<a href="javascript:;" onclick="DownLoad('{$data.file_path}','{$data.file_name}')">{$data.file_name}</a>
</div></td>
<td  title=""><div class="ui_table_tdcntr">
<a href="javascript:;" onclick="ShowAgentCard({$data.agent_id})">{$data.agent_no} {$data.agent_name}</a>
</div></td>
<td title=""><div class="ui_table_tdcntr">{$data.file_type_text}</div></td>
<td title=""><div class="ui_table_tdcntr">{$data.author}</div></td>
<td title=""><div class="ui_table_tdcntr">
<a onclick="UserDetial({$data.create_uid});" href="javascript:;">{$data.create_user_name}</a>
</div></td>
<td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>
<td title=""><div class="ui_table_tdcntr">
<ul class="list_table_operation">
<li>
{if $data.file_type != 3}
{literal}<a onclick="IM.account.delOper('/?d=Agent&c=AgentDoc&a=Delete',{{/literal}filePath:'{$data.file_path}'{literal}},'删除文件',this)" href="javascript:;" ispurview="true" m="AgentDocList" v="8">删除</a>{/literal}
{/if}
</li>
</ul>
</div></td>
</tr>
{/foreach}