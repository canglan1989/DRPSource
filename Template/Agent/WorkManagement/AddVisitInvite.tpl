<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}<span>&gt;</span>拜访预约管理</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>拜访预约管理</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <div class="form_bd">
        <form id="J_VisitInviteAdd" name="J_VisitInviteAdd">	
            <!--S form_block_bd--> 
            <div class="form_block_bd">
                <div class="tf">
                    <label>代理商名称：</label>
                    <div class="inp">{$AgentName}</div>
                    </div>
                    <div class="tf ">
                        <label>{if $HasPect == 0}网盟意向等级{else}签约产品{/if}：</label>
                        <div class="inp">{if empty($IntentionRating)}未指定意向等级{else}{$IntentionRating}{/if}</div>
                    </div>
                    <div class="tf">
                        <label><em class="require">*</em>被访人：</label>
                        <div class="inp">
                            <input name="visitor" id="visitor" valid="required customerName" class="" value="{$Visitor}" tabindex="1" />
                            <input name="contactid" id="contactid" type="hidden" value="{$ContactId}" />
                            <input type="checkbox" class="checkInp" value="0" name="ischarge" id="ischarge" {if $IsCharge == 0}checked="checked"{/if} />是负责人
                        </div>
                        <span class="info">请填写被访人</span>
                        <span class="ok">&nbsp;</span><span class="err">被访人不得为空或格式错误</span>
                    </div>
                    
                    <div class="tf tf2">
                        <label><em class="require">*</em>手机：</label>
                        <div class="inp"><input  name="mobile" value="{$Mobile}"  id="mobile"  tabindex="3" valid="mPhone" /></div>
                        <span class="info">请填写手机</span>
                        <span class="ok">&nbsp;</span><span class="err">手机格式错误</span>
                    </div>
                        <div class="tf tf2">
                        <label><em class="require">*</em>固定电话：</label>
                        <div class="inp">
                            <input  name="telphone" id="telphone" value="{$Tel}" valid="fPhone" tabindex="2"/>
                        </div>
                        <span class="info">请填写固定电话，格式：0571-88888888</span>
                        <span class="ok">&nbsp;</span><span class="err">固定电话格式:0571-88888888</span>
                    </div>
                    <div class="tf">
                        <label>预约日期：</label>
                        <div class="inp">
                            <input type="text" class="inpDate" id="appointtime" name="appointtime" value="{$appointtime|date_format:'%Y-%m-%d %H:%M'}" onclick="WdatePicker({literal}{minDate:'%y-%M-%d 23:59',isShowClear:false,dateFmt:'yyyy-MM-dd HH:mm'}{/literal})" tabindex="4" />至
                           <input type="text" class="inpDate " id="appointtime_end" name="appointtime_end" value="{$appointtime|date_format:' %H:%M'}" onclick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'appointtime\')}',maxDate:'23:59',isShowClear:false,dateFmt:'HH:mm'}{/literal})"  />
                        </div>
                    </div>
                    <div class="tf">
                        <label>拜访计划：</label>
                        <div class="inp">
                            <textarea name="title" cols="40" tabindex="5" >{$title}</textarea>
                        </div>
                    </div>
                <!--E form_block_bd-->
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">   
                        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">取消</a> </div>
                    </div>
                </div>
            </div>
            <!--E form_block_bd--> 
        </form>
    </div>
    <!--E form_bd--> 
</div>
<!--E form_edit-->
<script type="text/javascript">
    var IntenLevel = '{$IntentionRating}';
    var HasPect = '{$HasPect}';
    var AppointId = '{$AppointId}';
    var AgentId = '{$AgentID}';
    var oldNoteId = '{$oldNoteId}';
        $('#visitor').autocomplete('/?d=WorkM&c=TelWork&a=getContactInfoJson&agentid='+ AgentId,
        {literal}
     {                                                             //页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 15, //只显示15行
                width: 150, //下拉列表的宽
                parse: function (Data) {//q 返回的数据 JSON 格式，在这里解析成列表         
                    var parsed = [];
                    if (Data == "" || Data.length == 0)
                        return parsed;
                    //alert(backData);
                    Data = MM.json(Data);
                    var value = Data.value;
                    //alert(value);
                    if (value == undefined)
                        return parsed;

                    for (var i = 0; i < value.length; i++) {
                        parsed[parsed.length] = {
                            data: value[i],
                            value: value[i].aid,
                            result: value[i].contact_name
                        }
                    }
                    return parsed;
                },
                formatItem: function (item) {//内部方法生成列表
                    //_id=item.id;
                    return "<div id='divUser" + item.aid + "'>" + item.contact_name + "</div>";
                }
            }).result(function (data, value) {//执行模糊匹配
                $("#visitor").val(value.contact_name);
                $("#telphone").val(value.tel);
                $("#mobile").val(value.mobile);
                $("#contactid").val(value.aid);
                 if(value.isCharge == 0){
                     $("#ischarge").attr('checked',true);
                }else{
                    $("#ischarge").attr('checked',false);
                }
            });
        
//验证代理商数据
new Reg.vf($('#J_VisitInviteAdd'),{
        callback:function(data){
	 	if(!IM.IsSending(true)){return false;};
        $.ajax({
                type:'POST',
                data:$('#J_VisitInviteAdd').serialize()+'&agentid='+AgentId+'&intenlevel='+IntenLevel+'&appointid='+AppointId+'&hasPect='+HasPect+'&oldNoteId='+oldNoteId,
                url:'/?d=WorkM&c=VisitAppoint&a=AddVisitInvite',
		dataType:'json',
                success:function(data)
                {
					IM.IsSending(false);
					if(data.success)
					{
						IM.tip.show(data.msg);
						PageBack();
					}
					else
					{
						IM.tip.warn(data.msg);
					}
                }
            });
}});

    {/literal}
</script>