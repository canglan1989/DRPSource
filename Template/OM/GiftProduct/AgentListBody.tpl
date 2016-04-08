{foreach from=$arrPageList item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td ><div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkCheck" id="chk_{$data.order_gift_set_id}" value="{$data.agent_id},{$data.order_product_type_id}" />            
    </div></td>
	<td title="{$data.agent_no}"><div class="ui_table_tdcntr">{$data.agent_no}</div></td>
	<td title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
	<td title="{$data.order_product_type_name}"><div class="ui_table_tdcntr">{$data.order_product_type_name}</div></td>
	<td title="{$data.gift_product_name}"><div class="ui_table_tdcntr">{$data.gift_product_name}</div></td>
	<td title="{$data.create_user_name}"><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.create_uid})" href="javascript:;">{$data.create_user_name}</a></div></td>
	<td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
	<td title="">
		<div class="ui_table_tdcntr">
			<nobr>
			<ul class="list_table_operation">
				<li><a m="GiftAgentList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('/?d=OM&c=GiftProduct&a=AddAgentModify&agentID={$data.agent_id}')">编辑</a></li>
				<li><a m="GiftAgentList" v="8" ispurview="true" href="javascript:;" onclick="DelAgent({$data.agent_id},{$data.order_product_type_id})">删除</a></li>
			</ul>
			</nobr>
		</div>
	</td>
</tr>
{/foreach}