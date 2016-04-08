<?php /* Smarty version 2.6.26, created on 2013-01-07 14:30:23
         compiled from CM/CheckManage/showAddCheck.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/CheckManage/showAddCheck.tpl', 20, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->     
<form id="J_agentAddForm" action="" name="agentAddForm" class="agentAddForm" method="post" enctype="multipart/form-data">
    <!--S form_edit-->
    <div class="form_edit">
        <div class="form_hd">
            <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2><?php if ($this->_tpl_vars['CheckType'] == '2'): ?>修改客户审核<?php else: ?>新增客户审核<?php endif; ?></h2></div></div></div>
        </div>            
        <div class="form_bd">
            <div class="form_block_bd">
                <?php if ($this->_tpl_vars['CheckType'] == '2'): ?><div class="table_attention marginBottom10"><label class="attention">提示：</label>客户信息如果有误请勾选 <input type="checkbox" checked="checked" class="checkInp" style="vertical-align:middle">，黄色区域为修改前的信息 </div><?php else: ?>
                    <div class="table_attention marginBottom10"><label class="attention">提示：</label>添加审核不通过，则该客户不会入代理商个人客户库</div>
                <?php endif; ?>
                <div class="list_table_main marginBottom10 ">
                    <div class="ui_table ui_table_nohead">
                        <div class="ui_table_hd">
                            <div class="ui_table_hd_inner">
                                <!--调好了在上
                           <a class="ui_button ui_link" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showVerifyModifyBack'), $this);?>
&customer_id=<?php echo $this->_tpl_vars['customer_id']; ?>
')"><span class="ui_icon ui_icon_edit">&nbsp;</span>编辑11</a>
                                -->
                                <h4 class="title">企业信息</h4>
                            </div>
                        </div>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody class="ui_table_bd">
                                <tr>
                                    <td class="even"><div class="ui_table_tdcntr">客户名</div></td>
                                    <td>
                                        <div class="ui_table_tdcntr" id="customer_name" >
                                            <div class="inp">
                                                <?php echo $this->_tpl_vars['CustomerInfo']['customer_name']; ?>

                                            </div>
                                            <?php if (isset ( $this->_tpl_vars['CustomerInfo']['customer_name_old'] )): ?>
                                            <div class="inp_add">
                                                <input name="customer_name" id="customer_name" class="checkInp" value="<?php echo $this->_tpl_vars['CustomerInfo']['customer_name_old']; ?>
" type="checkbox" />
                                                <em><?php echo $this->_tpl_vars['CustomerInfo']['customer_name_old']; ?>
</em>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="even"><div class="ui_table_tdcntr">地区</div></td>
                                    <td><div class="ui_table_tdcntr" id="area_id"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['area_name']; ?>
</div></div></td>
                                        </tr>
                                        <tr>
                                            <td class="even"><div class="ui_table_tdcntr">行业</div></td>
                                            <td><div class="ui_table_tdcntr" id="industry_id"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['industry_name']; ?>
</div></div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">经营模式</div></td>
                                                    <td><div class="ui_table_tdcntr" id="business_model"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['business_model']; ?>
</div></div></td>
                                                </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">主营业务</div></td>
                                                <td><div class="ui_table_tdcntr" id="main_business"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['main_business']; ?>
</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">主要市场</div></td>
                                                <td><div class="ui_table_tdcntr" id="major_markets"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['major_markets']; ?>
</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">公司简介</div></td>
                                                <td><div class="ui_table_tdcntr" id="company_profile"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['company_profile']; ?>
</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
                                                <td><div class="ui_table_tdcntr" id="company_scope"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['company_scope']; ?>
</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">注册状态</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_status"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['reg_status']; ?>
</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册时间</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_date"><div class="inp"><?php if ($this->_tpl_vars['CustomerInfo']['reg_date'] != '0000-00-00'): ?><?php echo $this->_tpl_vars['CustomerInfo']['reg_date']; ?>
<?php endif; ?></div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                                                <td><div class="ui_table_tdcntr" id="website"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['website']; ?>
</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_place"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['reg_full_place']; ?>
</div></div></td>

                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                                                <td><div class="ui_table_tdcntr" id="postcode"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['postcode']; ?>
</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">客户来源</div></td>
                                                <td><div class="ui_table_tdcntr" id="customer_from"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['customer_from']; ?>
</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">网络推广情况</div></td>
                                                <td><div class="ui_table_tdcntr" id="net_extension_about"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['net_extension_about']; ?>
</div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                                <td><div class="ui_table_tdcntr" id="business_scope"><div class="inp"><?php echo $this->_tpl_vars['CustomerInfo']['business_scope']; ?>
</div></div></td>
                                            </tr>
                                            <tr>
                                                <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                                                <td><div class="ui_table_tdcntr" id="annual_sales"><div class="inp"><b class="amountStyle"><?php echo $this->_tpl_vars['CustomerInfo']['annual_sales']; ?>
</b></div></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                                <td><div class="ui_table_tdcntr" id="reg_capital"><div class="inp"><b class="amountStyle"><?php echo $this->_tpl_vars['CustomerInfo']['reg_capital']; ?>
</b></div></div></td>
                                            </tr>
                                            </tbody>
                                        </table>   
                                    </div>
                                </div>                  
                               <?php if ($this->_tpl_vars['CheckType'] == 1): ?>
                                <div class="list_table_main ">
                                    <div class="ui_table ui_table_nohead">
                                        <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">负责人信息</h4></div></div>
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody class="ui_table_bd">
                                                <tr>
                                                    <td class="even"><div class="ui_table_tdcntr">姓名</div></td>
                                                    <td><div class="ui_table_tdcntr" id="contact_name"><div class="inp"><?php echo $this->_tpl_vars['ContantInfo']->strContactName; ?>
</div> 
                                                        </div>
                                                    </td>
                                                    <td class="even"><div class="ui_table_tdcntr">性别</div></td>
                                                    <td><div class="ui_table_tdcntr" id="contact_sex"><div class="inp"><?php if ($this->_tpl_vars['ContantInfo']->iContactSex == 0): ?>
                                                                男
                                                                <?php elseif ($this->_tpl_vars['contact_sex'] == 1): ?>
                                                                    女
                                                                    <?php endif; ?></div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_mobile"><div class="inp"><?php echo $this->_tpl_vars['ContantInfo']->strContactMobile; ?>
</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_tel"><div class="inp"><?php echo $this->_tpl_vars['ContantInfo']->strContactTel; ?>
</div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_fax"><div class="inp"><?php echo $this->_tpl_vars['ContantInfo']->strContactFax; ?>
</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_email"><div class="inp"><?php echo $this->_tpl_vars['ContantInfo']->strContactEmail; ?>
</div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="even"><div class="ui_table_tdcntr">职位</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_position"><div class="inp"><?php echo $this->_tpl_vars['ContantInfo']->strContactPosition; ?>
</div></div></td>
                                                            <td class="even"><div class="ui_table_tdcntr">备注</div></td>
                                                            <td><div class="ui_table_tdcntr" id="contact_remark"><div class="inp"><?php echo $this->_tpl_vars['ContantInfo']->strContactRemark; ?>
</div></div></td>

                                                        </tr>
                                                    </tbody>
                                                </table>   
                                            </div>
                                        </div>                                   
                                    </div>
                                        <?php endif; ?>
                                    <!--E form_block_bd-->     
                                    <!--S form_block_ft-->
                                    <div class="form_block_ft">
                                        <div class="agentAuditBlock">
                                            <div class="tf">
                                                <label>审核状态：</label>
                                                <div class="inp">
                                                    <div class="ui_comboBox">
                                                        <select name="check_status" id="check_status">
                                                            <option value="1">审核通过</option>
                                                            <option value="-1">审核不通过</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tf">
                                                <label>审核备注：</label>
                                                <div class="inp"><textarea id="check_remark" name="check_remark" class=""></textarea></div>
                                            </div>
                                        </div>
                                        <div class="tf tf_submit">
                                            <label>&nbsp;</label>
                                            <div class="inp">
                                                <div class="ui_button ui_button_confirm"><button id="btnSave" type="submit" class="ui_button_inner">确 认</button></div>
                                                <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="PageBack()">取消</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--E form_block_ft-->
                                </div>
                                <!--E form_bd-->

                            </div>
                            <!--E form_edit-->
                        </form>
                        <script type="text/javascript">
<?php if ($this->_tpl_vars['CheckType'] == '2'): ?>
    var SubmitUrl = '<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMVerify','a' => 'EditCheckInfo'), $this);?>
&logid=<?php echo $_GET['aid']; ?>
';
 <?php else: ?>
      var SubmitUrl = '<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMVerify','a' => 'AddCheckInfo'), $this);?>
&logid=<?php echo $_GET['aid']; ?>
';
     <?php endif; ?>

<?php echo '
//显示被修改的信息
$(function(){
    new Reg.vf($(\'#J_agentAddForm\'),{isEncode:false,
                        callback:function(formdata){////formdata 表单提交数据 对象数组格式
                	var formValues = $(\'#J_agentAddForm\').serialize();                
                 	$.ajax({
	                        type: "POST",
	                        dataType: "json",
	                        url: SubmitUrl,
	                        data: formValues,
	                        success: function (q) {
					if(q.success){
						IM.tip.show(q.msg);
                                                PageBack();
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
//    $("#check_status").change(function(){
//        var checked=$(this).val()=="-1"?true:false;
//        $("form input:checkbox").each(function(){
//            this.checked=checked;
//        });
//    });
});
                            '; ?>

                        </script>