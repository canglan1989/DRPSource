<?php /* Smarty version 2.6.26, created on 2013-01-07 15:44:25
         compiled from OM/TransferOrder.tpl */ ?>
<div class="DContInner setPWDComfireCont">
    <form id="J_backForm" name=J_backForm">
        <div class="bd">   
            <div class="tf">
                <label>订单号：</label>
                <div class="inp"><?php echo $this->_tpl_vars['OrderInfo']['order_no']; ?>

                    <input type="hidden" name="from_agent_id" value="<?php echo $this->_tpl_vars['OrderInfo']['agent_id']; ?>
" />
                </div>
            </div>       
            <div class="tf">
                <label>客户名称：</label>
                <div class="inp"><?php echo $this->_tpl_vars['OrderInfo']['customer_name']; ?>
</div>
            </div> 
            <div class="tf">
                <label>客户网盟账号：</label>
                <div class="inp"><?php echo $this->_tpl_vars['OrderInfo']['owner_account_name']; ?>
</div>
            </div>
            <div class="tf">
                <label>所属代理商：</label>
                <div class="inp"><?php echo $this->_tpl_vars['OrderInfo']['agent_name']; ?>
(<?php echo $this->_tpl_vars['OrderInfo']['user_name']; ?>
)</div>
            </div>  
            <div class="tf">
                <label>转入的代理商：</label>
                <div class="inp">
                    <input name="to_agent" id="to_agent" valid="required" />
                    <input type="hidden" name="to_agent_id" id="to_agent_id" value="0" />
                </div>
                <span class="info">请输入需要转入的代理商名称或者主账号名称</span><span class="ok">&nbsp;</span><span class="err">请输入需要转入的代理商名称或者主账号名称</span>    
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
<!--E sidenav_neighbour--> 
