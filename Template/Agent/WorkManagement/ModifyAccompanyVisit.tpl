<div class="form_edit">
<div class="form_bd">
        <form id="J_AccomModForm">
        <div class="form_block_hd"><h3 class="ui_title">陪访小记信息</h3></div>
        <!--S form_block_bd-->
        <div class="form_block_bd">
            <div class="tf">
                <label>代理商名称：</label>
                <div class="inp">
                    {$arrayData.0.agent_name}
                    <input type="hidden" id="agent_id" value="{$arrayData.0.agent_id}" name="agent_id" />
                    <input type="hidden" id="appoint_id" value="{$appoint_id}" name="appoint_id" />
                    <input type="hidden" id="create_id" value="{$arrayData.0.create_id}" name="create_id" />
                </div>
            </div>
            <div class="tf">
                <label><em class="require">*</em>邀请人：</label>
                <div class="inp"><input valid="required" id="inviter"  name="inviter" value="{$arrayData.0.inviter_name}" /></div>
                <span class="info">请输入邀请人</span><span class="ok">&nbsp;</span><span class="err">请输入邀请人</span>
                <input type="hidden" id="inviter_id" name="inviter_id" />
            </div>
            <div class="tf">
                <label><em class="require">*</em>被访人：</label>
                <div class="inp"><input class="LegalPersonName" type="text" name="visitor" id="visitor" maxlength="10" valid="required" autocomplete="off" tabindex="6" value="{$arrayData.0.visitor}"/></div>
                <span class="info">请输入被访人</span><span class="ok">&nbsp;</span><span class="err">请输入被访人</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>被访人联系电话：</label>
                <div class="inp"><input class="LegalPersonName" type="text" valid="required" name="tel" value="{$arrayData.0.tel}" tabindex="7" id="tel" /></div>
                <span class="info">请输入被访人联系电话</span> <span class="ok">&nbsp;</span><span class="err">请输入被访人联系电话</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>拜访时间：</label>
                <div class="inp">
                    <input id="J_editTimeS" class="inpDate" valid="required" name="s_time" value="{$arrayData.0.s_time}" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('J_editTimeE')).focus()},dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}" type="text"/> 至
                    <input id="J_editTimeE" class="inpDate" valid="required" name="e_time" value="{$arrayData.0.e_time}" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}',dateFmt:'yyyy-MM-dd HH:mm:ss'}{/literal})" type="text"/>
                </div>
                <span class="info">请输入拜访时间</span><span class="ok">&nbsp;</span><span class="err">请输入拜访时间</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>陪访内容：</label>
                <div class="inp">
                    <textarea id="content" name="content" valid="required" >{$arrayData.0.content}</textarea>
                </div>
                <span class="info">请输入陪访内容</span><span class="ok">&nbsp;</span><span class="err">请输入陪访内容</span>
            </div>
            <div class="tf tf_submit">
                <label>&nbsp;</label>
                <div class="inp">
                     <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                    <div class="ui_button ui_button_cancel"><a class="ui_button_inner"  onclick="IM.dialog.hide()"  href="javascript:;">取消</a></div>
                </div>
            </div>
        </div>
        </form>
    </div>
        </div>
    {literal}
<script type="text/javascript">

 $('#inviter').autocomplete('/?d=WorkM&c=AccompanyVisit&a=CompleteInviter&agentId='+{$arrayData.0.agent_id}{literal},{
    max: 15,
    width: 150,
    parse: function (Data) {
        var parsed = [];
        if (Data == "" || Data.length == 0)
            return parsed;
        Data = MM.json(Data);
        var value = Data.value;
        if (value == undefined)
            return parsed;
        for (var i = 0; i < value.length; i++) {
            parsed[parsed.length] = {
                data: value[i],
                value: value[i].id,
                result: value[i].name
            }
        }
        return parsed;
    },
    formatItem: function (item) {
        return "<div id='divUser" + item.id + "'>" + item.name + "</div>";
    }
}).result(function (data, value) {
    _id = value.id;
    _name = value.name;
    $("#inviter_id").val(_id);
    
});

</script>
{/literal}