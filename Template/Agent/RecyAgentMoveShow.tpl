<div class="DContInner customerMoveCont">
    <form id="J_customerMove" action="" name="customerMoveForm" class="customerMoveForm">
	<input type="hidden" value="{$ids}" name="agentIDS">
	<div class="hd"><h4>原渠道经理信息</h4></div>
	<div class="bd">
	    {foreach from=$arrFromManage item=value}
		<div class="side_l">
		    <div class="tf">
			<label>原渠道经理名称：</label>
			<div class="inp">{$value.e_name}</div>
			<input type="hidden" name=agentid[] value="{$value.agent_id}">
			<input type="hidden" name=fromid[] value="{$value.channel_uid}">
		    </div>
		</div>
		<div class="side_r">
		    <div class="tf">
			<label style="width:130px;">原渠道经理主账号：</label>
			<div class="inp">{$value.user_name}</div>
		    </div>
		</div>   
	    {/foreach}
	</div>
	<div class="hd"><h4>请选择需转入的代理商信息</h4></div>
	<div class="bd">
	    <div class="tf">
		<label style="width:130px;"><em class="require">*</em>转入的渠道经理账号：</label>
		<div class="inp">
		    <select name="toUserID">
			{foreach from=$arrToManage item=value}
			    <option value="{$value.user_id}">{$value.e_name}({$value.user_name})
			    {/foreach}
		    </select>
		</div>
		<span class="info">请输入渠道经理账号商</span>
		<span class="ok">&nbsp;</span><span class="err">请输入渠道经理账号</span>
	    </div>
	</div>
    <div class="ft">
    	<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
     	<div class="ui_button ui_button_confirm"><button type="button" onclick="IM.dialog.ok()" id="moveSubmit" class="ui_button_inner">确 定</button></div>	 	
    </div>
    </form>
</div>
