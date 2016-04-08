<?php /* Smarty version 2.6.26, created on 2013-03-12 11:00:18
         compiled from Agent/SignCheck.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/SignCheck.tpl', 150, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置当前位置：代理商管理<span>&gt;</span>签约管理<span>&gt;</span>部门签约审核</div>
<!--E crumbs-->   
<div class="form_edit">
<form id="J_agentAuditForm" class="agentAuditForm" enctype="multipart/form-data" method="post" name="agentAuditForm" action="">
<div class="form_hd">
    <ul>
        <li class="cur">
            <a href="javascript:;"><div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>签约审核</h2></div></div></div></a>
        </li>
    </ul>
    <div class="form_hd_oper">
            <a class="ui_button ui_button_dis" onclick="PageBack();" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
    </div>
</div>
<!--S form_bd-->
<div class="form_bd">
    <div class="form_block_bd">           
        <!---------------------------------------------->            
            <!--S list_table_main-->
            <div class="list_table_main marginBottom10">
                <div class="ui_table ui_table_nohead">
                            <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">合同基本信息</h4></div></div>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                               <tbody class="ui_table_bd ">
                                    <tr class="">
                                        <td class="even"><div class="ui_table_tdcntr">代理商的产品</div></td>
                                        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPact']['product_type_name']; ?>
</div></td>
                                        <td class="even"><div class="ui_table_tdcntr">代理商等级</div></td>
                                        <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrPact']['agent_level'] == 0): ?>无等级<?php elseif ($this->_tpl_vars['arrPact']['agent_level'] == 1): ?>金牌<?php else: ?>银牌<?php endif; ?></div></td>
                                    </tr>
                                    <tr class="">
                                        <td class="even"><div class="ui_table_tdcntr">代理地区范围</div></td>
                                        <td>
                                        <div class="ui_table_tdcntr"  style="line-height:20px; overflow-y:auto; max-height:200px;">
                                        	<?php $_from = $this->_tpl_vars['arrAreaName']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['areaName']):
?>
                                            	<?php echo $this->_tpl_vars['areaName']; ?>
<br />
                                            <?php endforeach; endif; unset($_from); ?>
                                        </div>
                                        </td>
                                        <td class="even"><div class="ui_table_tdcntr">合作模式</div></td>
                                        <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrPact']['agent_mode'] == 0): ?>渠道代理<?php elseif ($this->_tpl_vars['arrPact']['agent_mode'] == 1): ?>渠道商务<?php endif; ?></div></td>
                                    </tr>
                                    <tr class="">
                                        <td class="even"><div class="ui_table_tdcntr">保证金</div></td>
                                        <td><div class="ui_table_tdcntr"><b class="amountStyle"><?php echo $this->_tpl_vars['arrPact']['cash_deposit']; ?>
元</b></div></td>
                                        <td class="even"><div class="ui_table_tdcntr">预存款</div></td>
                                        <td><div class="ui_table_tdcntr"><b class="amountStyle"><?php if ($this->_tpl_vars['arrPact']['pre_deposit'] != '0.00'): ?><?php echo $this->_tpl_vars['arrPact']['pre_deposit']; ?>
元<?php endif; ?></b></div></td>
                                    </tr>
                                    <tr class="">
                                        <td class="even"><div class="ui_table_tdcntr">合同有效期限</div></td>
                                        <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPact']['pact_sdate']; ?>
至<?php echo $this->_tpl_vars['arrPact']['pact_edate']; ?>
</div></td>
                                        <td class="even"><div class="ui_table_tdcntr">提交人/提交时间</div></td>
                                        <td><div class="ui_table_tdcntr"><a href="javascript:;" onclick="UserDetial(<?php echo $this->_tpl_vars['arrPact']['user_id']; ?>
);"><?php echo $this->_tpl_vars['arrPact']['user_name']; ?>
(<?php echo $this->_tpl_vars['arrPact']['e_name']; ?>
)</a>&nbsp;&nbsp;<?php echo $this->_tpl_vars['arrPact']['create_time']; ?>
</div></td>
                                    </tr>
                                    <!--<tr class="">
                                        <td class="even"><div class="ui_table_tdcntr">提交人</div></td>
                                        <td><div class="ui_table_tdcntr"><a href="javascript:;">王五psho3022</a></div></td>
                                        <td class="even"><div class="ui_table_tdcntr">提交时间</div></td>
                                        <td><div class="ui_table_tdcntr"></div></td>
                                    </tr>-->
                                </tbody>
                           </table>   
                </div>
                <!--E ui_table-->
            </div>
            <!--E list_table_main-->
            
            <div class="list_table_main marginBottom10">
              <div class="ui_table ui_table_nohead">
                <div class="ui_table_hd">
                                    <div class="ui_table_hd_inner">
                                        <h4 class="title">签约考察小记</h4>
                                    </div>
                          </div>
                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                             <tbody class="ui_table_bd ">
                                  <tr class="">
                                      <td class="even"><div class="ui_table_tdcntr">考察小记</div></td>
                                      <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrPact']['pact_remark']; ?>
</div></td>
                                  </tr>
                              </tbody>
                         </table>   
                </div>
                <!--E ui_table-->
            </div>
            
            
            <!--S list_table_main-->
            <div class="list_table_main marginBottom10">
                <div class="ui_table ui_table_nohead">
                            <div class="ui_table_hd">
                                    <div class="ui_table_hd_inner">
                                        <h4 class="title">代理商资质</h4>
                                    </div>
                            </div>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                               <tbody class="ui_table_bd ">
                                    <tr class="">
                                        <td class="even"><div class="ui_table_tdcntr">营业执照</div></td>
                                        <td><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['arrAllPermit']['0'] != ""): ?><a href="/FrontFile/upload/<?php echo $this->_tpl_vars['arrBasicInfo']->iAgentId; ?>
/<?php echo $this->_tpl_vars['arrAllPermit']['0']; ?>
" target="_blank">点击查看</a>
                                        <?php else: ?>未上传
                                        <?php endif; ?>
                                        </div></td>
                                        <td class="even"><div class="ui_table_tdcntr">一般纳税人资格证书</div></td>
                                        <td><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['arrAllPermit']['4'] != ""): ?><a href="/FrontFile/upload/<?php echo $this->_tpl_vars['arrBasicInfo']->iAgentId; ?>
/<?php echo $this->_tpl_vars['arrAllPermit']['4']; ?>
" target="_blank">点击查看</a>
                                        <?php else: ?>未上传
                                        <?php endif; ?>
                                        </div></td>
                                    </tr>
                                    <tr class="">
                                        <td class="even"><div class="ui_table_tdcntr">税务登记证</div></td>
                                        <td><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['arrAllPermit']['1'] != ""): ?>
                                        <a href="/FrontFile/upload/<?php echo $this->_tpl_vars['arrBasicInfo']->iAgentId; ?>
/<?php echo $this->_tpl_vars['arrAllPermit']['1']; ?>
" target="_blank">点击查看</a>
                                        <?php else: ?>未上传
                                        <?php endif; ?>
                                        </div></td>
                                        <td class="even"><div class="ui_table_tdcntr">法人身份证</div></td>
                                        <td><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['arrAllPermit']['2'] != ""): ?>
                                        <a href="/FrontFile/upload/<?php echo $this->_tpl_vars['arrBasicInfo']->iAgentId; ?>
/<?php echo $this->_tpl_vars['arrAllPermit']['2']; ?>
" target="_blank">点击查看</a>
                                        <?php else: ?>未上传
                                        <?php endif; ?>
                                        </div></td>
                                    </tr>
                                    <tr class="">
                                        <td class="even"><div class="ui_table_tdcntr">组织机构代码证</div></td>
                                        <td><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['arrAllPermit']['3'] != ""): ?>
                                        <a href="/FrontFile/upload/<?php echo $this->_tpl_vars['arrBasicInfo']->iAgentId; ?>
/<?php echo $this->_tpl_vars['arrAllPermit']['3']; ?>
" target="_blank">点击查看</a>
                                        <?php else: ?>未上传
                                        <?php endif; ?>
                                        </div></td>
                                        <td class="even"><div class="ui_table_tdcntr"></div></td>
                                        <td><div class="ui_table_tdcntr"></div></td>
                                    </tr>
                                </tbody>
                           </table>   
                </div>
                <!--E ui_table-->
            </div>
            <!--E list_table_main-->
            
                <div class="list_table_main marginBottom10">
                    <div class="ui_table ui_table_nohead">
                            <div class="ui_table_hd"><div class="ui_table_hd_inner">
                                <!--<a class="ui_button ui_link" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'EditShow'), $this);?>
&agentId=<?php echo $this->_tpl_vars['arrBasicInfo']->iAgentId; ?>
&checkStatus=<?php echo $this->_tpl_vars['arrBasicInfo']->iIsCheck; ?>
&needCheck=yes&fromType=4')"><span class="ui_icon ui_icon_edit">&nbsp;</span>修改信息</a>-->
                                <h4 class="title">代理商基本信息</h4>
                            </div></div>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                   <tbody class="ui_table_bd">
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                                            <td><div class="ui_table_tdcntr">
                                            <?php if ($this->_tpl_vars['arrNewInfo']['agent_name'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['agent_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strAgentName; ?>
 <?php endif; ?>
                                            </div></td>
                                            <td class="even"><div class="ui_table_tdcntr">企业法人</div></td>
                                            <td><div class="ui_table_tdcntr">                                      
                                            <?php if ($this->_tpl_vars['arrNewInfo']['legal_person'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['legal_person']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strLegalPerson; ?>
<?php endif; ?>
                                            </div></td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
                                            <td><div class="ui_table_tdcntr">
                                            <?php echo $this->_tpl_vars['arrBasicInfo']->strAreaFullName; ?>
 <?php echo $this->_tpl_vars['arrBasicInfo']->strAddress; ?>

                                            </div></td>
                                            <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrNewInfo']['postcode'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['postcode']; ?>
 <?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strPostcode; ?>
<?php endif; ?></div></td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
                                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrBasicInfo']->strRegAreaFullName; ?>
</div></td>
                                            <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrBasicInfo']->strDirection; ?>
</div></td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
						<b class="amountStyle"><?php if ($this->_tpl_vars['arrNewInfo']['reg_capital'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['reg_capital']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strRegCapital; ?>
<?php endif; ?></b>
                                            </div>
                                            </td>
                                            <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
                                            <?php if ($this->_tpl_vars['arrBasicInfo']->strSalesNum == 0): ?>
                            
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strSalesNum == 1): ?>
                                            10-50人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strSalesNum == 2): ?>
                                            50-100人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strSalesNum == 3): ?>
                                            100-300人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strSalesNum == 4): ?>
                                            300-600人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strSalesNum == 5): ?>
                                            600-1000人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strSalesNum == 6): ?>
                                            1000人以上
                                            <?php endif; ?>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">营业执照注册号</div></td>
                                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrNewInfo']['permit_reg_no'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['permit_reg_no']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strPermitRegNo; ?>
<?php endif; ?></div></td>
                                            <td class="even"><div class="ui_table_tdcntr">企业税号</div></td>
                                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrNewInfo']['revenue_no'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['revenue_no']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strRevenueNo; ?>
<?php endif; ?></div></td>
                                        </tr>                                                                                        
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">注册时间</div></td>
                                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrBasicInfo']->strRegDate == '0000-00-00'): ?><?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strRegDate; ?>
<?php endif; ?></div></td>
                                            <td class="even"><div class="ui_table_tdcntr">售前技术人数</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
                                            <?php if ($this->_tpl_vars['arrBasicInfo']->strTechNum == 0): ?>
                            
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTechNum == 1): ?>
                                            1-5人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTechNum == 2): ?>
                                            5-25人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTechNum == 3): ?>
                                            25-60人
                                            <?php else: ?>
                                            60人以上
                                            <?php endif; ?>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
                                            <?php if ($this->_tpl_vars['arrBasicInfo']->strCompanyScale == 0): ?>
                            
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strCompanyScale == 1): ?>
                                            10-50人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strCompanyScale == 2): ?>
                                            50-100人
                                            <?php else: ?>
                                            100人以上
                                            <?php endif; ?>
                                            </div>
                                            </td>
                                            <td class="even"><div class="ui_table_tdcntr">互联网电话营销人数</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
                                            <?php if ($this->_tpl_vars['arrBasicInfo']->strTelsalesNum == 0): ?>
                            
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTelsalesNum == 1): ?>
                                            10-50人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTelsalesNum == 2): ?>
                                            50-100人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTelsalesNum == 3): ?>
                                            100-300人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTelsalesNum == 4): ?>
                                            300-600人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTelsalesNum == 5): ?>
                                            600-1000人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strTelsalesNum == 6): ?>
                                            1000人以上
                                            <?php endif; ?>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
                                            <?php if ($this->_tpl_vars['arrBasicInfo']->strAnnualSales == 0): ?>
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strAnnualSales == 1): ?>
                                            50万以下
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strAnnualSales == 2): ?>
                                            50-100万
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strAnnualSales == 3): ?>
                                            100-500万
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strAnnualSales == 4): ?>
                                            500-1000万
                                            <?php else: ?>
                                            1000万以上
                                            <?php endif; ?>
                                            </div>
                                            </td>
                                            <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
                                            <?php if ($this->_tpl_vars['arrBasicInfo']->strServiceNum == 0): ?>
                            
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strServiceNum == 1): ?>
                                            1-5人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strServiceNum == 2): ?>
                                            5-25人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strServiceNum == 3): ?>
                                            25-60人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strServiceNum == 4): ?>
                                            60-120人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strServiceNum == 5): ?>
                                            120-200人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strServiceNum == 6): ?>
                                            200-400人
                                            <?php elseif ($this->_tpl_vars['arrBasicInfo']->strServiceNum == 7): ?>
                                            400人以上
                                            <?php endif; ?>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrBasicInfo']->strWebSite; ?>
</div></td>
                                            <td class="even"><div class="ui_table_tdcntr">营业执照</div></td>
                                            <td>
                                            <div class="ui_table_tdcntr">
                                            	<div class="inp qua_upload">
                                                <?php if ($this->_tpl_vars['arrBasicInfo']->strPermitPicture != ''): ?>
                                                    <?php echo $this->_tpl_vars['arrBasicInfo']->strPermitName; ?>
 
                                                        <a href="<?php echo $this->_tpl_vars['arrBasicInfo']->strPermitPicture; ?>
" target="_blank">查看</a>
                                                    
                                                <?php endif; ?>
                                                </div>
                                            </div>
                                            </td>
                                        </tr>
                                        <!--<tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">意向产品</div></td>
                                            <td><div class="ui_table_tdcntr"></div></td>
                                            <td class="even"><div class="ui_table_tdcntr"></div></td>
                                            <td><div class="ui_table_tdcntr"></div></td>
                                        </tr>-->
                                    </tbody>
                               </table>   
                    </div>
                </div>
                <div class="list_table_main">
                    <div class="ui_table ui_table_nohead">
                                <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">负责人信息</h4></div></div>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                   <tbody class="ui_table_bd">
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">负责人</div></td>
                                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrNewInfo']['charge_person'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['charge_person']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strChargePerson; ?>
<?php endif; ?></div></td>
                                            <td class="even"><div class="ui_table_tdcntr">职务</div></td>
                                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrBasicInfo']->strChargePositon; ?>
</div></td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrNewInfo']['charge_phone'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['charge_phone']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strChargePhone; ?>
<?php endif; ?></div></td>
                                            <td class="even"><div class="ui_table_tdcntr">MSN</div></td>
                                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrBasicInfo']->strChargeMsn; ?>
</div></td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrNewInfo']['charge_tel'] != ''): ?><?php echo $this->_tpl_vars['arrNewInfo']['charge_tel']; ?>
<?php else: ?><?php echo $this->_tpl_vars['arrBasicInfo']->strChargeTel; ?>
<?php endif; ?></div></td>
                                            <td class="even"><div class="ui_table_tdcntr">QQ</div></td>
                                            <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrBasicInfo']->iChargeQq != 0): ?><?php echo $this->_tpl_vars['arrBasicInfo']->iChargeQq; ?>
<?php endif; ?></div></td>
                                        </tr>
                                        <tr class="">
                                            <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrBasicInfo']->strChargeFax; ?>
</div></td>
                                            <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
                                            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrBasicInfo']->strChargeEmail; ?>
</div></td>
                                        </tr>
                                    </tbody>
                               </table>   
                    </div>
                </div>
            <!----------------------------------------------------------------------------->                    	
            </div>
            <!--<div class="form_block_hd">
                <h3 class="ui_title">框架合同状态：审核中</h3>
		<!--
                <a class="ui_button ui_link marginBottom10" href="javascript:;"><div class="ui_text" onClick="IM.Toggle('.agentInfoToggle',this,'显示框架合同业务流程▼','收起框架合同业务流程▲')">显示框架合同业务流程▼</div></a>
		
            </div>-->
            <!--<div class="form_block_bd agentInfoToggle">                         
                <div class="table_attention table_flow_attention marginBottom10">
                            <span class="ui_link">提交人：小五</span>
                            <span class="ui_link">所属部门：渠道</span>
                            <span class="ui_link">提交时间：2011-02-20 20:20:20</span>
                        </div>
                        <div class="list_table_main">
                            <div class="ui_table" id="J_ui_table">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <thead class="ui_table_hd">
                                            <tr class="">
                                                <th style="width:70px"><div class="ui_table_thcntr"><div class="ui_table_thtext">审核步骤</div></div></th>
                                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">操作人</div></div></th>
                                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">所属部门</div></div></th>
                                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">审核结果</div></div></th>
                                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">审核时间</div></div></th>
                                                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">审核备注</div></div></th>
                                            </tr>
                                        </thead>
                                        <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td><div class="ui_table_tdcntr">1</div></td>
                                                <td><div class="ui_table_tdcntr"><a href="javascript:;" >王五</a></div></td>
                                                <td><div class="ui_table_tdcntr">渠道</div></td>
                                                <td><div class="ui_table_tdcntr">已审核</div></td>
                                                <td><div class="ui_table_tdcntr">2010-10-10 10:10:10</div></td>
                                                <td><div class="ui_table_tdcntr">信息无误</div></td>
                                            </tr>
                                            <tr class="odd">
                                                <td><div class="ui_table_tdcntr">2</div></td>
                                                <td><div class="ui_table_tdcntr"><a href="javascript:;" >王五</a></div></td>
                                                <td><div class="ui_table_tdcntr">渠道</div></td>
                                                <td><div class="ui_table_tdcntr">已审核</div></td>
                                                <td><div class="ui_table_tdcntr">2010-10-10 10:10:10</div></td>
                                                <td><div class="ui_table_tdcntr">信息无误</div></td>
                                            </tr>
                                        </tbody>
                                    </table>   
                                </div>
                            </div>
                        </div>
                
                <!--S form_block_ft-->  
            <div class="form_block_ft">
                    <div class="agentAuditBlock" style="margin:0;">
                        <div class="tf">
                                <label style="width:130px;"><em class="require">*</em>审核备注：</label>
                                <div class="inp"><textarea name="check_remark" class="" id="check_remark" valid="businessPosition"></textarea></div>
                        </div>
                        <div class="tf">
                            <label style="width:130px;">&nbsp;</label>
                            <div class="inp">
                            	<input type="hidden" name="checkStatus" id="checkStatus" value="0" />
                                <input type="hidden" name="pactId" id="pactId" value="<?php echo $this->_tpl_vars['arrPact']['aid']; ?>
" />
                                <input type="hidden" name="agentId" id="agentId" value="<?php echo $this->_tpl_vars['arrPact']['agent_id']; ?>
" />
                                <input type="hidden" name="checkStep" id="checkStep" value="<?php echo $this->_tpl_vars['checkStep']; ?>
" />
                                <input type="hidden" name="pactType" id="pactType" value="<?php echo $this->_tpl_vars['pactType']; ?>
" />
                                <div class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text"><button type="submit" name="pass" id="passChcek" onclick="$('#checkStatus').val(1);"> 通 过 </button></div></div></div>
                                <div class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">
                                	<button type="submit" name="nopass" id="noPassCheck" onclick="$('#checkStatus').val(2);"> 不通过 </button>
                                </div></div></div>
                                <a href="javascript:;" onClick="JumpPage('/?d=FM&c=ContractCheck&a=ContractCheckPager')" class="ui_button ui_button_dis"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text"> 取 消 </div></div></a>
                            </div>
                        </div>
                    </div>
            </div>
            <!--E form_block_ft-->
                
            </div>
            
        <!--E form_bd-->
     </form>
     </div>
<script type="text/javascript">
<?php echo '
new Reg.vf($(\'#J_agentAuditForm\'),{callback:function(data){   
	if($.trim($(\'#check_remark\').val()) == \'\'){IM.tip.warn(\'审核备注不能为空！\');return false;}	
	$.ajax({
		type:\'POST\',
		url:\'/?d=Agent&c=AgentMove&a=signCheck\',
		data:$(\'#J_agentAuditForm\').serialize(),
		dataType:\'json\',
		success:function(data)
		{
			if(data.success == true)
			{
				IM.tip.show(data.msg);
				//JumpPage(data.url);
                PageBack();
			}
			else
			{
				IM.tip.show(data.msg);
				return false;
			}
		}
	});
}});
'; ?>
 
</script>