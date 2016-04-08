<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>工作管理<span>&gt;</span>添加陪访小记</div>
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>添加陪访小记</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <div class="form_bd">
        <form id="J_appAddForm" name="J_appAddForm">
        <!--S form_block_bd-->
        <div class="form_block_bd">
            <div class="tf">
                <label>代理商名称：</label>
                <div class="inp">{$objVisitAccompanyInfo->strAgentName}
                    <input type="hidden" id="tbxAgentID" value="{$objVisitAccompanyInfo->iAgentId}" name="tbxAgentID" />
                    <input type="hidden" id="tbxID" value="{$objVisitAccompanyInfo->iId}" name="tbxID" />
                </div>
            </div>
            <div class="tf">
                <label><em class="require">*</em>邀请人：</label>
                <div class="inp"><input valid="required" id="tbxInvaitedUserName"  name="tbxInvaitedUserName" value="{$objVisitAccompanyInfo->strInvaitedUserName}" autocomplete="off" maxlength="30" /></div>
                <span class="info">请输入邀请人</span><span class="ok">&nbsp;</span><span class="err">请输入邀请人</span>
                <input type="hidden" id="tbxInvaitedUserID" name="tbxInvaitedUserID" value="{$objVisitAccompanyInfo->iInvaitedUid}" />
            </div>
            <div class="tf">
                <label><em class="require">*</em>被访人：</label>
                <div class="inp"><input class="LegalPersonName" type="text" name="tbxVisitor" id="tbxVisitor" maxlength="10" valid="required" value="{$objVisitAccompanyInfo->strVisitor}"/></div>
                <span class="info">请输入被访人</span><span class="ok">&nbsp;</span><span class="err">请输入被访人</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>被访人联系电话：</label>
                <div class="inp"><input class="LegalPersonName" type="text" valid="required" name="tbxTel" value="{$objVisitAccompanyInfo->strTel}" maxlength="20" id="tbxTel" /></div>
                <span class="info">请输入被访人联系电话</span> <span class="ok">&nbsp;</span><span class="err">请输入被访人联系电话</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>陪访时间：</label>
                <div class="inp">
                    <input type="text" id="tbxSTime" valid="required" class="inpDate" name="tbxSTime" value="{$objVisitAccompanyInfo->strSTime|date_format:'%Y-%m-%d %H:%M'}" {literal}onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>{/literal}
                    -- 
                    <input type="text" valid="required" id="tbxETime" class="inpCommon inpDate" name="tbxETime" value="{$objVisitAccompanyInfo->strETime|date_format:'%H:%M'}" {literal}onfocus="WdatePicker({dateFmt:'HH:mm',minDate:'#F{$dp.$D(\'tbxSTime\')}'})"/>{/literal}
                    </div>
                <span class="info">请输入陪访时间</span><span class="ok">&nbsp;</span><span class="err">请输入陪访时间</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>陪访内容：</label>
                <div class="inp">
                    <textarea id="tbxContent" name="tbxContent" valid="required" style="width:550px;height:100px" >{$objVisitAccompanyInfo->strContent}</textarea>
                </div>
                <span class="info">请输入陪访内容</span><span class="ok">&nbsp;</span><span class="err">请输入陪访内容</span>
            </div>
            <div class="tf tf_submit">
                <label>&nbsp;</label>
                <div class="inp">
                    <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                    <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">返回</a></div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
{literal}
<script language="javascript" type="text/javascript">
new Reg.vf($('#J_appAddForm'),{
    callback:function(data){
        if(!IM.IsSending(true)){return false;};
        MM.ajax({
            url:'/?d=WorkM&c=AccompanyVisit&a=AccompanyVisitSubmit',
            data:$("#J_appAddForm").serialize(),
            success:function(q){
                
                IM.IsSending(false);
                if(parseInt(q) == 0){
                    if($("#tbxID").val() > 0)
                        IM.tip.show("编辑成功！");
                    else
                        IM.tip.show("添加成功！");
                    JumpPage("/?d=WorkM&c=AccompanyVisit&a=AccompanyVisitList");
                }else{
                    IM.tip.warn(q);
                }
            }
        });
    }
});

 $('#tbxInvaitedUserName').autocomplete('/?d=WorkM&c=AccompanyVisit&a=CompleteInviter&agentId='+$("#tbxAgentID").val(),{
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
    $("#tbxInvaitedUserID").val(_id);
    
});

</script>
{/literal}