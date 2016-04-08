<?php /* Smarty version 2.6.26, created on 2013-01-23 15:19:34
         compiled from Agent/WorkManagement/AddTelVerfity.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'Agent/WorkManagement/AddTelVerfity.tpl', 95, false),array('function', 'au', 'Agent/WorkManagement/AddTelVerfity.tpl', 223, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>电话任务设置</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <div class="form_bd">
        <form id="J_AddTelVerfity" name="J_AddTelVerfity">	
            <!--S form_block_bd--> 
            <div class="form_block_bd">
                <div class="table_attention marginBottom10"><label class="attention">提示：</label>前几次已通过的考核项不能取消</div>
                <div class="tf">
                    <label>代理商名称：</label>
                    <div class="inp"><a href="javascript:void(0)" onclick="IM.agent.getAgentInfoCard('id=<?php echo $this->_tpl_vars['AgentInfo']->iAgentId; ?>
')"><?php echo $this->_tpl_vars['AgentInfo']->strAgentName; ?>
</a></div>
                </div>
                <div>
                    <div class="form_block_left">
                        <?php $_from = $this->_tpl_vars['VertifyListItemLeft']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                            <div class="tf">
                                <label><?php echo $this->_tpl_vars['data']['item_name']; ?>
：</label>
                                <div class="inp">
                                    <input type="checkbox" <?php if ($this->_tpl_vars['data']['checked'] == 1): ?> onclick="return false;" checked <?php endif; ?> class="checkInp" name="item[<?php echo $this->_tpl_vars['data']['item_id']; ?>
]" value="<?php echo $this->_tpl_vars['data']['item_name']; ?>
" /><?php echo $this->_tpl_vars['data']['item_result']; ?>

                                </div>
                            </div>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                    <div class="form_block_right">
                        <?php $_from = $this->_tpl_vars['VertifyListItemRight']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                            <div class="tf">
                                <label><?php echo $this->_tpl_vars['data']['item_name']; ?>
：</label>
                                <div class="inp">
                                    <input type="checkbox" <?php if ($this->_tpl_vars['data']['checked'] == 1): ?> onclick="return false;" checked <?php endif; ?> class="checkInp" name="item[<?php echo $this->_tpl_vars['data']['item_id']; ?>
]" value="<?php echo $this->_tpl_vars['data']['item_name']; ?>
" /><?php echo $this->_tpl_vars['data']['item_result']; ?>

                                </div>
                            </div>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                </div>
                <div class="tf ">
                    <label>录音编号：</label>
                    <div class="inp">
                        <input name="record_no" />
                    </div>
                </div>
                <div class="tf ">
                    <label>质检结果：</label>
                    <div class="inp">
                        <select name="vertify_status" >
                            <option value="1">通过</option>
                            <option value="0">不通过</option>
                        </select>
                    </div>
                </div>
                <div class="tf ">
                    <label>质检情况：</label>
                    <div class="inp">
                        <textarea name="vertify_remark" cols="50" rows="30"></textarea>
                    </div>
                </div>
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">   
                        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">取消</a> </div>
                    </div>
                </div>

                <div class="list_table_main marginBottom10 agentInfoToggle">
                    <div class="ui_table ui_table_nohead">
                        <div class="ui_table_hd"><div class="ui_table_hd_inner">
                                <h4 class="title">联系小记信息</h4>
                            </div></div>
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
                                    <td class="even"><div class="ui_table_tdcntr">联系时间</div></td>
                                    <td><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['NoteInfo']->strVisitTimestart)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
</div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">联系方式</div></td>
                                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strTel; ?>
/<?php echo $this->_tpl_vars['NoteInfo']->strMobile; ?>
</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">预计到账信息</div></td>
                                    <td><div class="ui_table_tdcntr">
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
                                    <td class="even"><div class="ui_table_tdcntr">操作人</div></td>
                                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['UserName']; ?>
</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">行业动态</div></td>
                                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['AgentInfo']->strDynamics; ?>
</div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">操作时间</div></td>
                                    <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strCreateTime; ?>
</div></td>
                                    <td class="even"><div class="ui_table_tdcntr">下次联系时间</div></td>
                                    <td><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['NoteInfo']->strFollowUpTime)) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</div></td>
                                </tr>
                                <tr class="">
                                    <td class="even"><div class="ui_table_tdcntr">联系小记内容</div></td>
                                    <td colspan="3"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['NoteInfo']->strResult; ?>
</div></td>
                                </tr>
                            </tbody>
                        </table>   
                    </div>
                </div>

                <div class="list_table_head">
                    <div class="list_table_head_right">
                        <div class="list_table_head_mid">
                            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 联系人信息</h4>
<!--                            <a onclick="IM.agent.addContactInfo('/?d=Agent&amp;c=Agent&amp;a=showAddContacter','添加联系人信息',362,'no')" href="javascript:;" class="ui_button ui_link"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加联系人</a>-->
                        </div>
                    </div>			           
                </div>

                <div id="ContacterInfo" class="list_table_main marginBottom10">
                    <div id="J_ui_table" class="ui_table">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <thead class="ui_table_hd">
                                <tr class="odd">                                        
                                    <th title="编号">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">编号</div>
                            </div>
                            </th>
                            <th title="联系小记编号">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">联系小记编号</div>
                            </div>
                            </th>
                            <th title="录音编号">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">录音编号</div>
                            </div>
                            </th>
                            <th title="本次质检操作通过的项">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">本次质检操作通过的项</div>
                            </div>
                            </th>
                            <th title="质检结果">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">质检结果</div>
                            </div>
                            </th>
                            <th title="质检评语">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">质检评语</div>
                            </div>
                            </th>
                            <th title="质检人">
                            <div class="ui_table_thcntr ">
                                <div class="ui_table_thtext">质检人</div>
                            </div>
                            </th>
                            <th title="质检操作时间">
                            <div class="ui_table_thcntr">
                                <div class="ui_table_thtext">质检操作时间</div>
                            </div>
                            </th>
                            </tr>
                            </thead>
                            <tbody class="ui_table_bd">
                                <?php $_from = $this->_tpl_vars['VertifyList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                                <tr class="">
                                    <td title="<?php echo $this->_tpl_vars['data']['vertify_id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['vertify_id']; ?>
</div></td>
                                    <td title="<?php echo $this->_tpl_vars['data']['note_id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['note_id']; ?>
</div></td>
                                    <td title="<?php echo $this->_tpl_vars['data']['record_no']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['record_no']; ?>
</div></td>
                                    <td title="<?php echo $this->_tpl_vars['data']['new_item_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['new_item_name']; ?>
</div></td>
                                    <td title="<?php if ($this->_tpl_vars['data']['verfity_status'] == 0): ?>不通过<?php else: ?>通过<?php endif; ?>"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['verfity_status'] == 0): ?>不通过<?php else: ?>通过<?php endif; ?></div></td>
                                    <td title="<?php echo $this->_tpl_vars['data']['vertify_remark']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['vertify_remark']; ?>
</div></td>
                                    <td title="<?php echo $this->_tpl_vars['data']['create_user_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial(<?php echo $this->_tpl_vars['data']['create_uid']; ?>
);"><?php echo $this->_tpl_vars['data']['create_user_name']; ?>
</a></div></td>
                                    <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
                                </tr>   
                                <?php endforeach; else: ?>
                                    <tr  class=""><td colspan="8">无历史数据</td></tr> 
                                <?php endif; unset($_from); ?>
                            </tbody>
                        </table>   
                    </div>
                    <!--E ui_table-->
                </div>

            </div>
            <!--E form_block_bd--> 
        </form>
    </div>
    <!--E form_bd--> 
</div>
<!--E form_edit-->
<script type="text/javascript">
    <?php echo '
//验证代理商数据
new Reg.vf($(\'#J_AddTelVerfity\'),{
        callback:function(data){
	 	if(!IM.IsSending(true)){return false;};
        $.ajax({
                type:\'POST\',
    '; ?>

                data:$('#J_AddTelVerfity').serialize()+"&agentId=<?php echo $this->_tpl_vars['NoteInfo']->iAgentId; ?>
&noteId=<?php echo $this->_tpl_vars['NoteInfo']->iId; ?>
",
                url:'<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitVerify','a' => 'AddTelVerfity'), $this);?>
',
    <?php echo '
		dataType:\'json\',
                success:function(data)
                {
					IM.IsSending(false);
					if(data.success)
					{
						IM.tip.show(data.msg);
						PageBack();
					}
					else
					{
						IM.tip.warn(data.msg);
					}
                }
            });
}});

    '; ?>

</script>