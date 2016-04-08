<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>工作管理<span>&gt;</span>{$strTitle}</div>
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <div class="form_bd">
        <form id="J_appForm" name="J_appForm">
        <!--S form_block_bd-->
        <div class="form_block_bd">
            <div class="tf">
                <label>代理商名称：</label>
                <div class="inp"><a href="javascript:;" onclick="IM.agent.getAgentInfoCard('id={$objVisitAccompanyInfo->iAgentId}')">{$objVisitAccompanyInfo->strAgentName}</a>
                    <input type="hidden" id="tbxID" value="{$objVisitAccompanyInfo->iId}" name="tbxID" />
                </div>
            </div>
            <div class="tf">
                <label>邀请人：</label>
                <div class="inp"><a onclick="UserDetial({$objVisitAccompanyInfo->iInvaitedUid})" href="javascript:;">{$objVisitAccompanyInfo->strInvaitedUserName}</a></div>
            </div>
            <div class="tf">
                <label>被访人：</label>
                <div class="inp">{$objVisitAccompanyInfo->strVisitor}</div>
            </div>
            <div class="tf">
                <label>被访人联系电话：</label>
                <div class="inp">{$objVisitAccompanyInfo->strTel}</div>
            </div>
            <div class="tf">
                <label>陪访时间：</label>
                <div class="inp">{$objVisitAccompanyInfo->strSTime|date_format:'%Y-%m-%d %H:%M'} -- {$objVisitAccompanyInfo->strETime|date_format:'%H:%M'}
                </div>
            </div>
            <div class="tf">
                <label>陪访内容：</label>
                <div class="inp" style="width:680px;">
                {$objVisitAccompanyInfo->strContent}
                </div>
            </div>
                <div class="tf ">
                    <label>质检位置：</label>
                    <div class="inp">
                         <input name="tbxAddress" id="tbxAddress" value="" type="text" style="width:300px" maxlength="200" />
                    </div>
                </div>
                <div class="tf ">
                    <label><em class="require">*</em>质检结果：</label>
                    <div class="inp">
                        <select id="cbVertifyStatus" name="cbVertifyStatus" >
                            <option value="1">通过</option>
                            <option value="-1">不通过</option>
                        </select>
                    </div>
                </div>
                <div class="tf ">
                    <label>质检情况：</label>
                    <div class="inp">
                        <textarea id="tbxCheckDetail" name="tbxCheckDetail" cols="50" rows="30" style="width:500px;height:100px" ></textarea>
                    </div>
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
new Reg.vf($('#J_appForm'),{
    callback:function(data){
        if(!IM.IsSending(true)){return false;};
        MM.ajax({
            url:'/?d=WorkM&c=AccompanyVisit&a=AccompanyVisitVerifyModifySubmit',
            data:$("#J_appForm").serialize(),
            success:function(q){
                
                IM.IsSending(false);
                if(parseInt(q) == 0){
                    IM.tip.show("质检成功！");
                    PageBack();
                }else{
                    IM.tip.warn(q);
                }
            }
        });
    }
});

</script>
{/literal}