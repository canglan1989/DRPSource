<?php /* Smarty version 2.6.26, created on 2012-12-18 17:30:36
         compiled from Agent/WorkManagement/ShowAddReturnVisit.tpl */ ?>
<div class="DContInner setPWDComfireCont">
    <form id="J_addVisitRecord">
        <input type="hidden" value='<?php echo $this->_tpl_vars['id']; ?>
' name='id'/>
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>回访时间：</label>
                <div class="inp"><input type="text" name="visitTime" class="inpDate" valid="required" tabindex="1" value="<?php echo $this->_tpl_vars['ReturnInfo']['return_time']; ?>
" onfocus="WdatePicker(<?php echo '{dateFmt:\'yyyy-MM-dd HH:mm:ss\'}'; ?>
)"></div>
                <span class="info">请输入回访时间</span><span class="err">请输入回访时间</span>
            </div>
            <div class="tf">

                <label><em class="require">*</em>回访内容：</label>
                <div class="inp"><textarea valid="required" cols="30" name="visitContent"><?php echo $this->_tpl_vars['ReturnInfo']['content']; ?>
</textarea></div>
                <span class="info">请输入回访内容</span><span class="err">请输入回访内容</span>
            </div>
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>
        </div>
    </form>
</div>