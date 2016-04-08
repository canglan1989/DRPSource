<?php /* Smarty version 2.6.26, created on 2013-01-22 18:49:10
         compiled from Agent/WorkManagement/VisitNoteInfoDetail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'Agent/WorkManagement/VisitNoteInfoDetail.tpl', 33, false),)), $this); ?>
<div class="DContInner tableFormCont">

    <div class="bd">
        <div class="list_table_main">
            <div class="ui_table ui_table_nohead">
                <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">拜访小记信息</h4></div></div>
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody class="ui_table_bd">
                        <tr class="">
                            <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                            <td width="300"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['AgentInfo']->strAgentName; ?>
</div></td>
                            <td class="even"><div class="ui_table_tdcntr">
                            <?php if ($this->_tpl_vars['AgentInfo']->iAgentId == $this->_tpl_vars['AgentInfo']->strAgentNo): ?>意向等级<?php else: ?>签约产品<?php endif; ?>
                        </div></td>
                    <td><div class="ui_table_tdcntr">
                            <?php if ($this->_tpl_vars['AgentInfo']->iAgentId == $this->_tpl_vars['AgentInfo']->strAgentNo): ?>
                                <?php echo $this->_tpl_vars['NoteInfo']->strAfterlevel; ?>
(<?php echo $this->_tpl_vars['NoteInfo']->strProductName; ?>
)
                            <?php else: ?>
                                <?php echo $this->_tpl_vars['NoteInfo']->strProductName; ?>

                            <?php endif; ?>
                        </div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">被访人</div></td>
                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strVisitor; ?>
</div></td>
                    <td class="even"><div class="ui_table_tdcntr">拜访类型</div></td>
                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strCreateTime; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">联系方式</div></td>
                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strTel; ?>
/<?php echo $this->_tpl_vars['NoteInfo']->strMobile; ?>
</div></td>
                    <td class="even"><div class="ui_table_tdcntr">拜访时间</div></td>
                    <td><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['NoteInfo']->strVisitTimestart)) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
~<?php echo ((is_array($_tmp=$this->_tpl_vars['NoteInfo']->strVisitTimeend)) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">职位</div></td>
                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['ContactInfo']['position']; ?>
</div></td>
                    <td class="even"><div class="ui_table_tdcntr">操作人</div></td>
                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strCreateUserName; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">角色</div></td>
                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['ContactInfo']['role']; ?>
</div></td>
                    <td class="even"><div class="ui_table_tdcntr">操作时间</div></td>
                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strCreateTime; ?>
</div></td>
                </tr>

                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">预计到账信息</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">
                            预计到账金额：<b class="amountStyle"><?php echo $this->_tpl_vars['NoteInfo']->iExpectMoney; ?>
 元</b>; 
                            预计到账类型：<b class="amountStyle"><?php if ($this->_tpl_vars['NoteInfo']->iExpectType == 1): ?>承诺<?php else: ?>备份<?php endif; ?></b>; 
                            预计到账时间：<b class="amountStyle"><?php echo ((is_array($_tmp=$this->_tpl_vars['NoteInfo']->strExpectTime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</b>; 
                            预计达成率：<b class="amountStyle"><?php echo $this->_tpl_vars['NoteInfo']->iChargePercentage; ?>
%</b>;
                        </div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">拜访内容</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strResult; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">拜访计划</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strVisitContent; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">下次拜访时间</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['NoteInfo']->strFollowUpTime)) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</div></td>
                </tr>
            </tbody>
        </table>   
    </div>
</div>
</div>
<div class="ft">
    <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a>
    </div>
</div>
</div>