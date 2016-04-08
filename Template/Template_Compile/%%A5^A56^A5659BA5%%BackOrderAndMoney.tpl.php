<?php /* Smarty version 2.6.26, created on 2013-01-07 14:33:10
         compiled from OM/BackOrderAndMoney.tpl */ ?>
<div class="DContInner setPWDComfireCont">
<form id="J_backForm" name="J_backForm">
    <div class="bd">   
		<div class="tf">
        	<label>代理商名称：</label>
            <div class="inp">
            <?php echo $this->_tpl_vars['objOrderInfo']->strAgentName; ?>
</div>
        </div>       
        <div class="tf">
        	<label>订单号：</label>
            <div class="inp"><input type="hidden" id="tbxOrderID" name="tbxOrderID" value="<?php echo $this->_tpl_vars['objOrderInfo']->iOrderId; ?>
"/>
            <?php echo $this->_tpl_vars['objOrderInfo']->strOrderNo; ?>

            </div>
        </div> 
        <div class="tf">
        	<label>款项状态：</label>
            <div class="inp"><?php if ($this->_tpl_vars['objOrderInfo']->iIsCharge == 1): ?>扣款<?php else: ?>冻结<?php endif; ?></div>
        </div>
        <div class="tf">
        	<label>订单金额：</label>
            <div class="inp">预存款：<?php echo $this->_tpl_vars['preDepositsMoney']; ?>
&nbsp; 销奖：<?php echo $this->_tpl_vars['saleRewardMoney']; ?>
</div>
        </div>
        <div class="tf">
        	<label>     
            <em class="require">*</em>退款金额：</label>
            <div class="inp">
                预存款：<input name="tbxPreDepositsMoney" type="text" id="tbxPreDepositsMoney" onkeyup='return FloatNumber(this)' 
                value="<?php echo $this->_tpl_vars['preDepositsMoney']; ?>
" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/>
                &nbsp; 销奖：<input name="tbxSaleRewardMoney" type="text" id="tbxSaleRewardMoney" onkeyup='return FloatNumber(this)' 
                value="<?php echo $this->_tpl_vars['saleRewardMoney']; ?>
" class="inpCommon" style="text-align:right" size="30" maxlength="9" valid="required amount"/>
            </div>
            <span class="info">请输入退款金额</span>
            <span class="err">请输入退款金额</span>
        </div>        
        <div class="tf">
            <label>备 注：</label>                             
            <div class="inp"><textarea name="tbxRemark" id="tbxRemark" cols="40" style="width:320px;height:80px" ></textarea></div>
            <span class="c_info">限200字内</span><span class="ok">&nbsp;</span><span class="err">限200字以内</span>                 
        </div>                                                                                 
    </div>                                                                                      
    <div class="ft">                                                                             
        <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>
        <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>                      
    </div>                                                                                                                              
</form>                                                                                                                                  
</div>