<?php /* Smarty version 2.6.26, created on 2013-01-07 15:44:30
         compiled from TM/BackOrderInfo.tpl */ ?>
<?php if (! empty ( $this->_tpl_vars['BackInfo'] )): ?>
<div class="list_table_main" style="margin-top: 15px;">
        <div class="ui_table ui_table_nohead">
            <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">退单信息</h4></div></div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                              <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['BackInfo']['agent_name']; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">订单号</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['BackInfo']['source_bill_no']; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">款项状态</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['BackInfo']['back_type']; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">订单金额</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">预存款：<?php echo $this->_tpl_vars['BackInfo']['freeze_predepositis_money']; ?>
 销奖：<?php echo $this->_tpl_vars['BackInfo']['freeze_salereward_money']; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">退款金额</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr">预存款：<?php echo $this->_tpl_vars['BackInfo']['backed_predepositis_money']; ?>
 销奖：<?php echo $this->_tpl_vars['BackInfo']['backed_salereward_money']; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">退款操作备注</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['BackInfo']['remark']; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">退款操作人</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['BackInfo']['create_user']; ?>
</div></td>
                </tr>
                <tr class="">
                    <td class="even"><div class="ui_table_tdcntr">退款时间</div></td>
                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['BackInfo']['create_time']; ?>
</div></td>
                </tr>
            </table> 
        </div>
    </div>
<?php endif; ?>