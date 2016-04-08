<?php /* Smarty version 2.6.26, created on 2013-01-23 10:13:46
         compiled from Agent/WorkManagement/IncomeInfoFromNote.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'Agent/WorkManagement/IncomeInfoFromNote.tpl', 19, false),array('modifier', 'string_format', 'Agent/WorkManagement/IncomeInfoFromNote.tpl', 23, false),)), $this); ?>
<div class="DContInner setPWDComfireCont">
    <div class="bd">  
        <div class="tf">
            <label>代理商名称：</label>
            <div class="inp"><?php echo $this->_tpl_vars['AgentInfo']->strAgentName; ?>
</div>
        </div>
        <div class="tf">
            <label><?php if ($this->_tpl_vars['NoteInfo']->iContactType == 0): ?>意向等级<?php else: ?>签约产品<?php endif; ?>：</label>
            <div class="inp">
                <?php if ($this->_tpl_vars['NoteInfo']->iContactType == 0): ?>
                    <?php echo $this->_tpl_vars['NoteInfo']->strAfterlevel; ?>

                <?php else: ?>
                    <?php echo $this->_tpl_vars['NoteInfo']->strProductName; ?>

                <?php endif; ?>
            </div>
        </div>
        <div class="tf">
            <label>预计到账时间：</label>
            <div class="inp"><?php echo ((is_array($_tmp=$this->_tpl_vars['NoteInfo']->strExpectTime)) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</div>
        </div>
        <div class="tf">
            <label>预计到账金额：</label>
            <div class="inp"><?php echo ((is_array($_tmp=$this->_tpl_vars['NoteInfo']->iExpectMoney)) ? $this->_run_mod_handler('string_format', true, $_tmp, '%.2f') : smarty_modifier_string_format($_tmp, '%.2f')); ?>
 元</div>
        </div>
        <div class="tf">
            <label>预计到账类型：</label>
            <div class="inp"><?php if ($this->_tpl_vars['NoteInfo']->iExpectType == 1): ?>承诺<?php else: ?>备份<?php endif; ?></div>
        </div>
        <div class="tf">
            <label>预计达成率：</label>
            <div class="inp"><?php echo $this->_tpl_vars['NoteInfo']->iChargePercentage; ?>
 %</div>
        </div>
        <div class="tf">
            <label>操作人：</label>
            <div class="inp"><?php echo $this->_tpl_vars['NoteInfo']->strCreateUserName; ?>
</div>
        </div>
        <div class="tf">
            <label>操作时间：</label>
            <div class="inp"><?php echo $this->_tpl_vars['NoteInfo']->strCreateTime; ?>
</div>
        </div>
        <div class="tf_submit">		
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
        </div>
    </div>
</div>
