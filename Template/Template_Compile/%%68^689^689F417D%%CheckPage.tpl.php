<?php /* Smarty version 2.6.26, created on 2012-11-26 14:45:01
         compiled from Agent/WorkManagement/CheckPage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/WorkManagement/CheckPage.tpl', 2, false),)), $this); ?>
    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentCheckPager'), $this);?>
')">代理商资料审核</a><span>&gt;</span><?php echo $this->_tpl_vars['strTitle']; ?>
</div>
        <!--E crumbs-->     
        <form id="J_CheckNoteForm" name="agentAddForm" class="agentAddForm">
        <!--S form_edit-->                  
        <div class="form_edit">
            <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>审查拜访小记</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
            </div>            
            <!--S form_bd-->
            <div class="form_bd">    
            <input type="hidden" id="visitnoteid" name="visitnoteid" value="<?php echo $this->_tpl_vars['arrayData']['0']['visitnoteid']; ?>
" />
                <!--S form_block_bd--> 
                <div class="form_block_bd">
                    <!----------------------------->                    
                    <div class="list_table_main marginBottom10 ">
                        <div class="ui_table ui_table_nohead">
                       		<div class="ui_table_hd"><div class="ui_table_hd_inner">
                     		<h4 class="title"><?php echo $this->_tpl_vars['strTitle']; ?>
</h4></div></div>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">编号</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['visitnoteid']; ?>
</div>
                                                </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">制定人</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['user_name']; ?>
 </div>
                                            </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">预约制定时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['app_create_time']; ?>
</div>
                            </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">小记制定时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['create_time']; ?>
</div>
                            </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['agent_name']; ?>

			
                            </div>
                            </div></td>
                                                <td class="even"><div class="ui_table_tdcntr">拜访主题</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['title']; ?>
</div>
                            </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">需求支持</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['support']; ?>

                            
                            </div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">预约时的意向评级/签约产品</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php if ($this->_tpl_vars['arrayData']['0']['be_product_name'] != ""): ?><?php echo $this->_tpl_vars['arrayData']['0']['be_product_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrayData']['0']['be_inten_level']; ?>
<?php endif; ?>
                            
                            </div></div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">拜访后的意向评级/签约产品</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php if ($this->_tpl_vars['arrayData']['0']['product_name'] != ""): ?><?php echo $this->_tpl_vars['arrayData']['0']['product_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrayData']['0']['afterlevel']; ?>
<?php endif; ?>
                            
                            </div></div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr">被访人</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['visitor']; ?>

                            
                            </div></div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">联系电话</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['mobile']; ?>
/<?php echo $this->_tpl_vars['arrayData']['0']['tel']; ?>

                            
                            </div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">预约时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['sappoint_time']; ?>
/<?php echo $this->_tpl_vars['arrayData']['0']['eappoint_time']; ?>

                            
                            </div></div>
				</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">拜访时间</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['arrayData']['0']['visit_timestart']; ?>
/<?php echo $this->_tpl_vars['arrayData']['0']['visit_timeend']; ?>

                            
                            </div></div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr"></div></td>
                                                <td><div class="ui_table_tdcntr"> <div class="inp">
                            	
                            </div></div>
												</td>
                                            </tr>
                                            
                                        </tbody>
                                   </table>   
                    	</div>
                    </div>  
                </div>
		<!--S form_block_ft-->  
        <?php if ($this->_tpl_vars['is_check'] == 1): ?>
	            <div class="form_block_ft">
	                <div class="agentAuditBlock">
	                    <div class="tf">
	                            <label><em class="require">*</em>审核状态：</label>
	                            <div class="inp">
	                                <div class="ui_comboBox">
	                                    <select name="auditState" id="auditState">
	                                        <!--<option value="请选择审核状态">请选择审核状态</option>
	                                        <option value="0">未审核</option>-->
	                                        <option value="1">审核通过</option>
	                                        <option value="2">审核不通过</option>
	                                    </select>
	                                </div>
	                            </div>
	                    </div>
	                    <div class="tf">
	                            <label>审核信息：</label>
	                            <div class="inp"><textarea name="check_remark" class="" id="check_remark"></textarea></div>
	                    </div>
	                </div>
	                <div class="tf tf_submit">
	                        <label>&nbsp;</label>
	                        <div class="inp">
	                            <div class="ui_button ui_button_confirm"><button type="button" class="ui_button_inner" id="checkAgent">确 认</button></div>
	                            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="PageBack();">取消</a></div>
	                        </div>
	                </div>
	            </div>  
            <?php endif; ?>    
	            <!--E form_block_ft--> 
            </div>
            <!--E form_bd--> 
        </div>
        <!--E form_edit-->
         </form>
<script type="text/javascript">
<?php echo '
$(function(){
	$(\'#checkAgent\').click(function(){
		var visitnoteid = $.trim($(\'#visitnoteid\').val());
		var auditState = $.trim($(\'#auditState\').val());
		var check_remark = $.trim($(\'#check_remark\').val());
		var strData = \'\';
        '; ?>

        var check = <?php echo $this->_tpl_vars['check']; ?>

        <?php echo '
		strData = \'auditState=\'+auditState+\'&check_remark=\'+check_remark+\'&visitnoteid=\'+visitnoteid;
		
		//alert(strData);return false;
		$.ajax({
			type:\'POST\',
			data:strData,
			'; ?>

			url:'<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitNote','a' => 'checksubmit'), $this);?>
',
			<?php echo '
			success:function(data)
			{
				switch(data)
				{
					case \'1\':
						IM.tip.show(\'审核成功！\');
						'; ?>

						var redirectUrl='<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitNote','a' => 'NoteList'), $this);?>
';
                        var redirectUrl2='<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'VisitNote','a' => 'CheckList'), $this);?>
';
						<?php echo '
                        if(check == 0)
                            JumpPage(redirectUrl);
                        else
                            JumpPage(redirectUrl2);
						break;
					case \'2\':
						IM.tip.warn(\'审核失败！\');
						break;
					default:
						IM.tip.warn(\'请不要非法操作！\');
						break;
				}
			}
		});
	});
});
'; ?>

</script>