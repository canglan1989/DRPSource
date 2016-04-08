<div class="DContInner">
    <form id="J_shareAgent">
        <div class="form_edit">
            <input  type="hidden" name="agent_id" value="{$agent_id}"/>
            <div class="form_block_bd">
                <div class="tf">
                            <label style="width:180px;">代理商所属账号：</label>
                            <div class="inp">{$agentInfo.user_name}{$agentInfo.e_name}</div>                            
                </div>
                <div class="tf">
                    <label style="width:180px;"><em class="require">*</em>共享账号：</label>
                    <div class="inp"><input type="text" id="shareName" name="shareName" class="subordinateAgent" valid="required companyName"/></div>
                    <span class="info">请输入共享账号</span>
                    <span class="ok">&nbsp;</span><span class="err">请输入共享账号</span>
                    <input id="J_user_id" type="hidden" name="user_id" value=""/>
                </div>
                <div class="tf">
                    <label style="width:180px;"><em class="require">*</em>请选择代理商所属账号：</label>
                    <div class="inp">
                    <select id="accountType" name="accountType">                       
                        <option value="1" selected="selected">新输入的账号2(默认)</option>
                        <option value="2">原所属账号1</option>
                    </select>
                    </div>                    
                </div>
                <div class="tf">
                    <label style="width:180px;">备注：</label>
                    <div class="inp">
                    <input type="text" id="remark" name="remark"  />
                    </div>                    
                </div>
            </div>
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
            <div class="ui_button ui_button_confirm"><button type="submit"  id="moveSubmit" class="ui_button_inner">确 定</button></div>
        </div>
    </form>
</div>
