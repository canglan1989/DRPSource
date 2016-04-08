<?php /* Smarty version 2.6.26, created on 2012-12-17 14:22:55
         compiled from Agent/RemoveSignModify.tpl */ ?>
<div class="DContInner setPWDComfireCont">
<form id="J_backForm" name="J_backForm">
    <div class="bd">   
		<div class="tf">
        	<label>代理商名称：</label>
            <div class="inp">
            <input type="hidden" id="tbxPactID" name="tbxPactID" value="<?php echo $this->_tpl_vars['pactID']; ?>
"/>
            <?php echo $this->_tpl_vars['agentName']; ?>
</div>
        </div>       
        <div class="tf">
        	<label>合同号：</label>
            <div class="inp">
            <?php echo $this->_tpl_vars['pactNo']; ?>

            </div>
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