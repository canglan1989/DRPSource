<?php /* Smarty version 2.6.26, created on 2013-01-07 15:44:30
         compiled from TM/EMail/WebMakeProcess.tpl */ ?>
<div class="bd">
    
    <div class="list_table_main">
        <div class="ui_table ui_table_nohead">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <thead class="ui_table_hd">
                    <tr>
                        <th><div class="ui_table_thcntr"><div class="ui_table_thtext">步骤</div></div></th>
                <th style="width:130px"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作人</div></div></th>
                <th style="width:140px"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作时间</div></div></th>
                <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作结果</div></div></th>
                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">备注</div></div></th>
                </tr>
                </thead>
                <tbody class="ui_table_bd" id="ListContent">
                    <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
                        <tr>
                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['main_step_name']; ?>
</div></td>
                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['ope_name']; ?>
</div></td>
                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arr']['ope_time'] <> "0000-00-00 00:00:00"): ?><?php echo $this->_tpl_vars['arr']['ope_time']; ?>
<?php endif; ?></div></td>
                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['result']; ?>
</div></td>
                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arr']['remark']; ?>
</div></td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                </tbody>
            </table> 
        </div>
    </div>
        <?php echo $this->_tpl_vars['backhtml']; ?>
              
</div>