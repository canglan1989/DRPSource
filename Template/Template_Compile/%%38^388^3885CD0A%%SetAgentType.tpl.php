<?php /* Smarty version 2.6.26, created on 2012-12-24 16:39:34
         compiled from Agent/SetAgentType.tpl */ ?>
<div class="DContInner">
<form id="J_agentType">
<div class="form_edit">
<div class="form_block_bd">
<input type="hidden" id="agent_id" name="agent_id" value="<?php echo $this->_tpl_vars['agent_id']; ?>
" />
<input type="radio" name="agent_type" value="1" class="checkInp" style="margin-left:20px;"/>核心
<input type="radio" name="agent_type" value="2" class="checkInp" style="margin-left:20px;"/>非核心
</div>
<div class="ft">
<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
<div class="ui_button ui_button_confirm"><button type="button" class="ui_button_inner" onclick="IM.dialog.ok()">确 定</button></div>
</div></div>
</form>
</div>