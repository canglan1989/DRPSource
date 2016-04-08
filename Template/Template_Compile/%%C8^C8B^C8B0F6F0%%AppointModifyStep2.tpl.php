<?php /* Smarty version 2.6.26, created on 2012-11-26 14:48:19
         compiled from Agent/WorkManagement/AppointModifyStep2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/WorkManagement/AppointModifyStep2.tpl', 1, false),)), $this); ?>
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitAppoint','a' => 'AppointList'), $this);?>
')" href="javascript:";>拜访预约管理</a><span>&gt;</span>添加拜访预约</div>
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>添加拜访预约</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <div class="form_bd">
        <form id="J_appAddForm">
        <div class="form_block_hd"><h3 class="ui_title">预约信息</h3></div>
        <!--S form_block_bd-->
        <div class="form_block_bd">
            <div class="tf">
                <label>代理商名称：</label>
                <div class="inp">
                    <?php echo $this->_tpl_vars['arrayData']['0']['agent_name']; ?>

                    <input type="hidden" id="agent_id" value="<?php echo $this->_tpl_vars['agentId']; ?>
" name="agent_id" />
                    <input type="hidden" id="appoint_id" value="<?php echo $this->_tpl_vars['appoint_id']; ?>
" name="appoint_id" />
                    <input type="hidden" id="create_id" value="<?php echo $this->_tpl_vars['arrayData']['0']['create_id']; ?>
" name="create_id" />
                </div>
            </div>
            <div class="tf">
                <label>意向评级/签约产品：</label>
                <div class="inp"><?php echo $this->_tpl_vars['ContactType']; ?>
<input type="hidden" id="product_or_level" value="<?php echo $this->_tpl_vars['ContactType']; ?>
" name="product_or_level" /></div>
            </div>
            <div class="tf">
                <label><em class="require">*</em>拜访主题：</label>
                <div class="inp"><input class="LegalPersonName" type="text" name="title"  valid="required" tabindex="7" id="title" value="<?php echo $this->_tpl_vars['arrayData']['0']['title']; ?>
"/></div>
                <span class="info">请输入拜访主题</span> <span class="ok">&nbsp;</span><span class="err">请输入拜访主题</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>被访人：</label>
                <div class="inp"><input class="LegalPersonName" type="text" name="visitor" id="visitor" maxlength="10" valid="required" autocomplete="off" tabindex="6" value="<?php echo $this->_tpl_vars['arrayData']['0']['visitor']; ?>
"/></div>
                <span class="info">请输入被访人</span><span class="ok">&nbsp;</span><span class="err">请输入被访人</span>
            </div>
            <div class="tf">
                <label>手机：</label>
                <div class="inp"><input class="LegalPersonName" type="text" name="mobile" valid="mPhone" tabindex="7" id="mobile" value="<?php echo $this->_tpl_vars['arrayData']['0']['mobile']; ?>
"/></div>
                <span class="info" style="display:inline">固定电话与手机号一项必填</span><span class="err">请输入正确手机号</span>
            </div>
            <div class="tf">
                <label>固定电话：</label>
                <div class="inp"><input class="LegalPersonName" type="text" name="tel" valid="fPhone" tabindex="7" id="tel" value="<?php echo $this->_tpl_vars['arrayData']['0']['tel']; ?>
"/></div>
                <span class="info">固话格式:0571-8888888</span><span class="err">请输入正确固定电话号</span>
            </div>
            <div class="tf">
                <label><em class="require">*</em>预约时间：</label>
                <div class="inp">
                    <input id="J_editTimeS" class="inpDate" name="app_timeb" value="<?php echo $this->_tpl_vars['arrayData']['0']['sappoint_time']; ?>
" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'J_editTimeE\')).focus()},dateFmt:\'yyyy-MM-dd HH:mm:ss\',maxDate:\'#F{$dp.$D(\\\'J_editTimeE\\\')}\'})'; ?>
" type="text"/> 至
                    <input id="J_editTimeE" class="inpDate" name="app_timee" value="<?php echo $this->_tpl_vars['arrayData']['0']['eappoint_time']; ?>
" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS\\\')}\',dateFmt:\'yyyy-MM-dd HH:mm:ss\'}'; ?>
)" type="text"/>
                </div>
                <span class="info">请输入预约时间</span><span class="ok">&nbsp;</span><span class="err">请输入预约时间</span>
            </div>
            <div class="tf tf_submit">
                <label>&nbsp;</label>
                <div class="inp">
                    <?php if ($this->_tpl_vars['appoint_id'] <= 0): ?>
                    <div class="ui_button">
                    <div class="ui_button_left"></div>
                    <button class="ui_button_inner" type="button" onclick="JumpPage('/?d=WorkM&c=VisitAppoint&a=AppointModifyStep1')">上一步</button>
                    </div>
                    <?php endif; ?>
                    <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                    <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">取消</a></div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<?php echo '
<script type="text/javascript">
new Reg.vf($(\'#J_appAddForm\'),{
    callback:function(data){
        if(!IM.IsSending(true)){return false;};
        MM.ajax({
            url:\'/?d=WorkM&c=VisitAppoint&a=AppointModifySubmit\',
            data:data,
            success:function(q){
                if(IM.checkPhone()){IM.tip.warn(\'手机或固话必填一项\');return false;}
                IM.IsSending(false);
                q=MM.json(q);
                if(q.success){
                    IM.tip.show(q.msg);
                    '; ?>

                    JumpPage("/?d=WorkM&c=VisitAppoint&a=AppointList");
                <?php echo '
                }else{
                    IM.tip.warn(q.msg);
                }
            }
        });
    }
});
'; ?>

 $('#visitor').autocomplete('/?d=WorkM&c=VisitAppoint&a=CompleteVisitorInfo&agentId='+<?php echo $this->_tpl_vars['agentId']; ?>
<?php echo ',{
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
        return "<div id=\'divUser" + item.id + "\'>" + item.name + "</div>";
    }
}).result(function (data, value) {
    _id = value.id;
    _name = value.name;
    $("#mobile").val(_id);
    var val = $(this).val();
    if (val != \'\')
        GetTel(_name);
});
function GetTel(_name){
    var agent_id = $("#agent_id").val();
    var tel = $PostData("/?d=WorkM&c=VisitAppoint&a=GetTel","contact_name="+_name+"&agent_id="+agent_id);
    $("#tel").val(tel);
}
</script>
'; ?>