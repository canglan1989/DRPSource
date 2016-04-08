<?php /* Smarty version 2.6.26, created on 2012-12-18 17:37:10
         compiled from OM/AlloltAudit.tpl */ ?>
<div class="DContInner setPWDComfireCont">
    <form name="handleAuditForm" action="" id="J_handleAudit">
        <div class="bd">
        	<div class="tf" <?php if ($this->_tpl_vars['isChange'] == 0): ?> style="display:none" <?php endif; ?>>                                    
                <label>原审核账号：</label>                             
                <div class="inp"><?php echo $this->_tpl_vars['oldAuditerName']; ?>
</div>                 
            </div>                                       
            <div class="tf">                                    
                <label><em class="require">*</em>
                <input type="hidden"  value="<?php echo $this->_tpl_vars['orderIDs']; ?>
" id="tbxOrders" name="tbxOrders"/>审核账号：</label>                             
                <div class="inp">
                <input type="hidden"  value="-100" id="tbxAccountID" name="tbxAccountID"/>
                <input type="text" valid="required" style="width:200px;" maxlength="20" id="accountName" name="accountName"/></div>
                <span class="info">请输入审核账号</span><span class="ok">&nbsp;</span><span class="err">请输入审核账号</span>                 
            </div>                                       
            <div class="tf">                                    
                <label>备注：</label>                             
                <div class="inp"><textarea name="tbxRemark" cols="40" id="tbxRemark" valid="tbxRemark" onblur="ClearText(this,100)"></textarea></div>
                <span class="info">限制100字以内</span><span class="ok">&nbsp;</span><span class="err">限制100字以内</span>                 
            </div>                                                                                 
        </div>                                                                                    
        <div class="ft">     	    
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="IM.dialog.hide()">取 消</a></div>                                                                        
            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>           
        </div>                                                                                                                              
    </form>                                                                                                                                  
</div>