<div class="DContInner">
    <form id="J_customerMove">
        <div class="form_edit">
            <div class="form_block_hd"><h3 class="ui_title">原渠道经理信息</h3></div>
            <div class="form_block_bd">                
                    <div class="side_l">
                        <div class="tf">
                            <label style="width:150px;">原渠道经理信息：</label>
                            <div class="inp">{$arrFromManage.agent_channel_user_name}</div>
                            <input type="hidden" name=agentid[] value="{$arrFromManage.agent_id}">
                            <input type="hidden" name=fromid[] value="{$arrFromManage.channel_uid}">
                        </div>
                    </div>                                   
            </div>
            <div class="form_block_hd"><h3 class="ui_title">请选择需转入的代理商信息</h3></div>
            <div class="form_block_bd">
                <div class="tf">
                    <label style="width:180px;"><em class="require">*</em>转入的渠道经理账号：</label>
                    <div class="inp"><input type="text" id="channelName" name="channelName" class="subordinateAgent" valid="required companyName"/></div>
                    <span class="info">请输入渠道经理账号商</span>
                    <span class="ok">&nbsp;</span><span class="err">请输入渠道经理账号</span>
                    <input id="J_user_id" type="hidden" name="user_id" value=""/>
                </div>
            </div>
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
            <div class="ui_button ui_button_confirm"><button type="button" onclick="IM.dialog.ok()" id="moveSubmit" class="ui_button_inner">确 定</button></div>
        </div>
    </form>
</div>
