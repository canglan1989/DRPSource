<?php /* Smarty version 2.6.26, created on 2013-01-11 11:30:20
         compiled from Agent/showAgentDetail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/showAgentDetail.tpl', 2, false),)), $this); ?>
    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentCheckPager'), $this);?>
')">代理商资料审核</a><span>&gt;</span><?php echo $this->_tpl_vars['strTitle']; ?>
</div>
        <!--E crumbs-->     
        <form id="J_agentAddForm" name="agentAddForm" class="agentAddForm">
        <!--S form_edit-->                  
        <div class="form_edit">
            <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2><?php echo $this->_tpl_vars['strTitle']; ?>
</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
            </div>            
            <!--S form_bd-->
            <div class="form_bd">  
		<div class="form_block_bd" style="padding-bottom:0;"> 
                <div class="table_attention">
                    <label class="attention">提示：</label>客户信息如果有误请勾选 <input type="checkbox" checked="checked" class="checkInp" style="vertical-align:middle">，黄色区域为修改前的信息 
                </div>       
		</div>   
            <input type="hidden" id="agentId" name="agentId" value="<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
" />
            <input type="hidden" id="operate_type" name="operate_type" value="<?php echo $this->_tpl_vars['objAgentInfo']->iOperateType; ?>
" />
            <input type="hidden" id="checkId" name="checkId" value="<?php echo $this->_tpl_vars['checkId']; ?>
" />
                <!--S form_block_bd--> 
                <div class="form_block_bd">
                    <!----------------------------->                    
                    <div class="list_table_main marginBottom10 ">
                        <div class="ui_table ui_table_nohead">
                       		<div class="ui_table_hd"><div class="ui_table_hd_inner">
<!--                       		<a class="ui_button ui_link" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'EditShow'), $this);?>
&agentId=<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
&needCheck=no&fromType=3');" style="cursor:pointer;"><span class="ui_icon ui_icon_edit">&nbsp;</span>编辑</a>-->
                       		<h4 class="title">企业信息</h4></div></div>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strAgentName; ?>
</div>
                            <?php if ($this->_tpl_vars['arrOld']['agent_name'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_agent_name" id="chk_agent_name" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['agent_name']; ?>
">
                            <em><?php echo $this->_tpl_vars['arrOld']['agent_name']; ?>
</em>
                            </div>
                            <?php endif; ?></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strAreaFullName; ?>
><?php echo $this->_tpl_vars['objAgentInfo']->strAddress; ?>
 </div>
                            <?php if ($this->_tpl_vars['arrOld']['address'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_address" id="chk_address" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['address']; ?>
">
                            <em><?php echo $this->_tpl_vars['arrOld']['address']; ?>
</em>
                            </div>
                            <?php endif; ?></div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strPostcode; ?>
</div>
                            <?php if ($this->_tpl_vars['arrOld']['postcode'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_postcode" id="chk_postcode" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['postcode']; ?>
">
                            <em><?php echo $this->_tpl_vars['arrOld']['postcode']; ?>
</em>
                            </div>
                            <?php endif; ?></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">法人姓名</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strLegalPerson; ?>
</div>
                            <?php if ($this->_tpl_vars['arrOld']['legal_person'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_legal_person" id="chk_legal_person" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['legal_person']; ?>
">
                            <em><?php echo $this->_tpl_vars['arrOld']['legal_person']; ?>
</em>
                            </div>
                            <?php endif; ?></div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                                                    <b class="amountStyle"><?php echo $this->_tpl_vars['objAgentInfo']->strRegCapital; ?>
</b>
                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['reg_capital'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_reg_capital" id="chk_reg_capital" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['reg_capital']; ?>
">
                            <em>
                                <b class="amountStyle"><?php echo $this->_tpl_vars['arrOld']['reg_capital']; ?>
</b>
                            </em>
                            </div>
                            <?php endif; ?>
                            </div>
                            </td>
                                       <td class="even"><div class="ui_table_tdcntr">公司注册时间</div></td>
                                       <td><div class="ui_table_tdcntr"><div class="inp"><?php if ($this->_tpl_vars['objAgentInfo']->strRegDate != '0000-00-00'): ?><?php echo $this->_tpl_vars['objAgentInfo']->strRegDate; ?>
<?php endif; ?></div>
                            <?php if ($this->_tpl_vars['arrOld']['reg_date'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_reg_date" id="chk_reg_date" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['reg_date']; ?>
">
                            <em><?php echo $this->_tpl_vars['arrOld']['reg_date']; ?>
</em>
                            </div>
                            <?php endif; ?>
                            </div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            <?php if ($this->_tpl_vars['objAgentInfo']->strCompanyScale == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCompanyScale == 1): ?>
                            10-50人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCompanyScale == 2): ?>
                            50-100人
                            <?php else: ?>
                            100人以上
                            <?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['company_scale'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_company_scale" id="chk_company_scale" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['company_scale']; ?>
">
                            <em>
                            <?php if ($this->_tpl_vars['arrOld']['company_scale'] == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['arrOld']['company_scale'] == 1): ?>
                            10-50人
                            <?php elseif ($this->_tpl_vars['arrOld']['company_scale'] == 2): ?>
                            50-100人
                            <?php else: ?>
                            100人以上
                            <?php endif; ?>
                            </em>
                            </div>
                            <?php endif; ?></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            <?php if ($this->_tpl_vars['objAgentInfo']->strSalesNum == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strSalesNum == 1): ?>
                            10-50人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strSalesNum == 2): ?>
                            50-100人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strSalesNum == 3): ?>
                            100-300人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strSalesNum == 4): ?>
                            300-600人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strSalesNum == 5): ?>
                            600-1000人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strSalesNum == 6): ?>
                            1000人以上
                            <?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['sales_num'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_sales_num" id="chk_sales_num" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['sales_num']; ?>
">
                            <em>
                            <?php if ($this->_tpl_vars['arrOld']['sales_num'] == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['arrOld']['sales_num'] == 1): ?>
                            10-50人
                            <?php elseif ($this->_tpl_vars['arrOld']['sales_num'] == 2): ?>
                            50-100人
                            <?php elseif ($this->_tpl_vars['arrOld']['sales_num'] == 3): ?>
                            100-300人
                            <?php elseif ($this->_tpl_vars['arrOld']['sales_num'] == 4): ?>
                            300-600人
                            <?php elseif ($this->_tpl_vars['arrOld']['sales_num'] == 5): ?>
                            600-1000人
                            <?php elseif ($this->_tpl_vars['arrOld']['sales_num'] == 6): ?>
                            1000人以上
                            <?php endif; ?>
                            </em>
                            </div>
                            <?php endif; ?></div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">互联网电话营销人数</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            <?php if ($this->_tpl_vars['objAgentInfo']->strTelsalesNum == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTelsalesNum == 1): ?>
                            10-50人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTelsalesNum == 2): ?>
                            50-100人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTelsalesNum == 3): ?>
                            100-300人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTelsalesNum == 4): ?>
                            300-600人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTelsalesNum == 5): ?>
                            600-1000人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTelsalesNum == 6): ?>
                            1000人以上
                            <?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['telsales_num'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_telsales_num" id="chk_telsales_num" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['telsales_num']; ?>
">
                            <em>
                            <?php if ($this->_tpl_vars['arrOld']['telsales_num'] == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['arrOld']['telsales_num'] == 1): ?>
                            10-50人
                            <?php elseif ($this->_tpl_vars['arrOld']['telsales_num'] == 2): ?>
                            50-100人
                            <?php elseif ($this->_tpl_vars['arrOld']['telsales_num'] == 3): ?>
                            100-300人
                            <?php elseif ($this->_tpl_vars['arrOld']['telsales_num'] == 4): ?>
                            300-600人
                            <?php elseif ($this->_tpl_vars['arrOld']['telsales_num'] == 5): ?>
                            600-1000人
                            <?php elseif ($this->_tpl_vars['arrOld']['telsales_num'] == 6): ?>
                            1000人以上
                            <?php endif; ?>
                            </em>
                            </div>
                            <?php endif; ?></div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr">售前技术支持</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            <?php if ($this->_tpl_vars['objAgentInfo']->strTechNum == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTechNum == 1): ?>
                            1-5人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTechNum == 2): ?>
                            5-25人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strTechNum == 3): ?>
                            25-60人
                            <?php else: ?>
                            60人以上
                            <?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['tech_num'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_tech_num" id="chk_tech_num" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['tech_num']; ?>
">
                            <em>
                            <?php if ($this->_tpl_vars['arrOld']['tech_num'] == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['arrOld']['tech_num'] == 1): ?>
                             1-5人
                            <?php elseif ($this->_tpl_vars['arrOld']['tech_num'] == 2): ?>
                            5-25人
                            <?php elseif ($this->_tpl_vars['arrOld']['tech_num'] == 3): ?>
                            25-60人
                            <?php else: ?>
                            60人以上
                            <?php endif; ?>
                            </em>
                            </div>
                            <?php endif; ?></div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            <?php if ($this->_tpl_vars['objAgentInfo']->strServiceNum == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strServiceNum == 1): ?>
                            1-5人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strServiceNum == 2): ?>
                            5-25人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strServiceNum == 3): ?>
                            25-60人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strServiceNum == 4): ?>
                            60-120人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strServiceNum == 5): ?>
                            120-200人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strServiceNum == 6): ?>
                            200-400人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strServiceNum == 7): ?>
                            400人以上
                            <?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['service_num'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_service_num" id="chk_service_num" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['service_num']; ?>
">
                            <em>
                            <?php if ($this->_tpl_vars['arrOld']['service_num'] == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['arrOld']['service_num'] == 1): ?>
                             1-5人
                            <?php elseif ($this->_tpl_vars['arrOld']['service_num'] == 2): ?>
                            5-25人
                            <?php elseif ($this->_tpl_vars['arrOld']['service_num'] == 3): ?>
                            25-60人
                            <?php elseif ($this->_tpl_vars['arrOld']['service_num'] == 4): ?>
                            60-120人
                            <?php elseif ($this->_tpl_vars['arrOld']['service_num'] == 5): ?>
                            120-200人
                            <?php elseif ($this->_tpl_vars['arrOld']['service_num'] == 6): ?>
                            200-400人
                            <?php elseif ($this->_tpl_vars['arrOld']['service_num'] == 7): ?>
                            400人以上
                            <?php endif; ?>
                            </em>
                            </div>
                            <?php endif; ?></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">企业客户数</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            <?php if ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 0): ?>
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 1): ?>
                            100人以下
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 2): ?>
                            100-300人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 3): ?>
                            300-600人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 4): ?>
                            600-1000人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 5): ?>
                            1000-1500人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 6): ?>
                            1500-2000人
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 7): ?>
                            2000-3000人
                            <?php else: ?>
                            3000以上
                            <?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['customer_num'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_customer_num" id="chk_customer_num" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['customer_num']; ?>
">
                            <em>
                            <?php if ($this->_tpl_vars['arrOld']['customer_num'] == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['arrOld']['customer_num'] == 1): ?>
                            100人以下
                            <?php elseif ($this->_tpl_vars['arrOld']['customer_num'] == 2): ?>
                            100-300人
                            <?php elseif ($this->_tpl_vars['arrOld']['customer_num'] == 3): ?>
                            300-600人
                            <?php elseif ($this->_tpl_vars['arrOld']['customer_num'] == 4): ?>
                            600-1000人
                            <?php elseif ($this->_tpl_vars['arrOld']['customer_num'] == 5): ?>
                            1000-1500人
                            <?php elseif ($this->_tpl_vars['arrOld']['customer_num'] == 6): ?>
                            1500-2000人
                            <?php elseif ($this->_tpl_vars['arrOld']['customer_num'] == 7): ?>
                            2000-3000人
                            <?php else: ?>
                            3000以上
                            <?php endif; ?>
                            </em>
                            </div>
                            <?php endif; ?></div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            <?php if ($this->_tpl_vars['objAgentInfo']->strAnnualSales == 0): ?>
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strAnnualSales == 1): ?>
                            50万以下
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strAnnualSales == 2): ?>
                            50-100万
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strAnnualSales == 3): ?>
                            100-500万
                            <?php elseif ($this->_tpl_vars['objAgentInfo']->strAnnualSales == 4): ?>
                            500-1000万
                            <?php else: ?>
                            1000万以上
                            <?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['annual_sales'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_annual_sales" id="chk_annual_sales" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['annual_sales']; ?>
">
                            <em>
                            <?php if ($this->_tpl_vars['arrOld']['annual_sales'] == 0): ?>
                            
                            <?php elseif ($this->_tpl_vars['arrOld']['annual_sales'] == 1): ?>
                            50万以下
                            <?php elseif ($this->_tpl_vars['arrOld']['annual_sales'] == 2): ?>
                            50-100万
                            <?php elseif ($this->_tpl_vars['arrOld']['annual_sales'] == 3): ?>
                            100-500万
                            <?php elseif ($this->_tpl_vars['arrOld']['annual_sales'] == 4): ?>
                            500-1000万
                            <?php else: ?>
                            1000万以上
                            <?php endif; ?>
                            </em>
                            </div>
                            <?php endif; ?></div>
												</td>
                                                <td class="even"><div class="ui_table_tdcntr">网站地址</div></td>
                                                <td><div class="ui_table_tdcntr"> <div class="inp">
                            	<?php echo $this->_tpl_vars['objAgentInfo']->strWebSite; ?>

                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['website'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_website" id="chk_website" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['website']; ?>
">
                            <em><?php echo $this->_tpl_vars['arrOld']['website']; ?>
</em>
                            </div>
                            <?php endif; ?></div>
												</td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                                <td><div class="ui_table_tdcntr"><div class="inp">
                            	<?php echo $this->_tpl_vars['objAgentInfo']->strDirection; ?>

                            </div>
                            <?php if ($this->_tpl_vars['arrOld']['direction'] != ''): ?>
                            <div class="inp_add">
                            <input type="checkbox" name="chk_direction" id="chk_direction" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['direction']; ?>
">
                            <em><?php echo $this->_tpl_vars['arrOld']['direction']; ?>
</em>
                            </div>
                            <?php endif; ?></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">资质上传</div></td>
                                                <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['objAgentInfo']->strPermitPicture != ''): ?>
                                 <?php echo $this->_tpl_vars['objAgentInfo']->strPermitName; ?>
 
                                	<a href="<?php echo $this->_tpl_vars['objAgentInfo']->strPermitPicture; ?>
" target="_blank">查看</a>
                                <?php endif; ?> </div>
						</td>
                                            </tr>
                                        </tbody>
                                   </table>   
                    	</div>
                    </div>
                    <!------------------------------------>
                    <div class="list_table_main">
                            <div class="ui_table ui_table_nohead">
                                <div class="ui_table_hd"><div class="ui_table_hd_inner">                       		
                                <h4 class="title">联系人信息</h4></div></div>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                           <tbody class="ui_table_bd">
                                                <tr class="">
                                                    <td class="even"><div class="ui_table_tdcntr">负责人姓名</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strChargePerson; ?>
</div>
                                <?php if ($this->_tpl_vars['arrOld']['charge_person'] != ''): ?>
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_person" id="chk_charge_person" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['charge_person']; ?>
">
                                <em><?php echo $this->_tpl_vars['arrOld']['charge_person']; ?>
</em>
                                </div>
                                <?php endif; ?></div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strChargePhone; ?>
</div>
                                <?php if ($this->_tpl_vars['arrOld']['charge_phone'] != ''): ?>
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_phone" id="chk_charge_phone" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['charge_phone']; ?>
">
                                <em><?php echo $this->_tpl_vars['arrOld']['charge_phone']; ?>
</em>
                                </div>
                                <?php endif; ?></div></td>
                                                </tr>
                                                <tr class="">
                                                    <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strChargeTel; ?>
</div>
                                <?php if ($this->_tpl_vars['arrOld']['charge_tel'] != ''): ?>
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_tel" id="chk_charge_tel" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['charge_tel']; ?>
">
                                <em><?php echo $this->_tpl_vars['arrOld']['charge_tel']; ?>
</em>
                                </div>
                                <?php endif; ?></div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strChargeFax; ?>
</div> 
                                <?php if ($this->_tpl_vars['arrOld']['charge_fax'] != ''): ?>
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_fax" id="chk_charge_fax" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['charge_fax']; ?>
">
                                <em><?php echo $this->_tpl_vars['arrOld']['charge_fax']; ?>
</em>
                                </div>
                                <?php endif; ?></div></td>
                                                </tr>
                                                <tr class="">
                                                    <td class="even"><div class="ui_table_tdcntr">电子邮件</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strChargeEmail; ?>
</div>
                                <?php if ($this->_tpl_vars['arrOld']['charge_email'] != ''): ?>
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_email" id="chk_charge_email" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['charge_email']; ?>
">
                                <em><?php echo $this->_tpl_vars['arrOld']['charge_email']; ?>
</em>
                                </div>
                                <?php endif; ?></div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">QQ</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp"><?php if ($this->_tpl_vars['objAgentInfo']->iChargeQq == 0): ?><?php else: ?><?php echo $this->_tpl_vars['objAgentInfo']->iChargeQq; ?>
<?php endif; ?></div>
                                <?php if ($this->_tpl_vars['arrOld']['charge_qq'] != ''): ?>
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_qq" id="chk_charge_qq" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['charge_qq']; ?>
">
                                <em><?php echo $this->_tpl_vars['arrOld']['charge_qq']; ?>
</em>
                                </div>
                                <?php endif; ?></div></td>
                                                </tr>
                                                <tr class="">
                                                    <td class="even"><div class="ui_table_tdcntr">MSN</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strChargeMsn; ?>
</div>
                                <?php if ($this->_tpl_vars['arrOld']['charge_msn'] != ''): ?>
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_msn" id="chk_charge_msn" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['charge_msn']; ?>
">
                                <em><?php echo $this->_tpl_vars['arrOld']['charge_msn']; ?>
</em>
                                </div>
                                <?php endif; ?></div></td>
                                                    <td class="even"><div class="ui_table_tdcntr">职务</div></td>
                                                    <td><div class="ui_table_tdcntr"><div class="inp"><?php echo $this->_tpl_vars['objAgentInfo']->strChargePositon; ?>
</div>
                                <?php if ($this->_tpl_vars['arrOld']['charge_positon'] != ''): ?>
                                <div class="inp_add">
                                <input type="checkbox" name="chk_charge_positon" id="chk_charge_positon" class="checkInp" value="<?php echo $this->_tpl_vars['arrOld']['charge_positon']; ?>
">
                                <em><?php echo $this->_tpl_vars['arrOld']['charge_positon']; ?>
</em>
                                </div>
                                <?php endif; ?></div></td>
                                                </tr>
                                            </tbody>
                                       </table> 
                            </div>
                    </div>
                	<!------------------------------------>      
                </div>
		<!--S form_block_ft-->  
	            <div class="form_block_ft">
	                <div class="agentAuditBlock">
	                    <div class="tf">
	                            <label>审核状态：</label>
	                            <div class="inp">
	                                <div class="ui_comboBox">
	                                    <select name="auditState" id="auditState">
	                                        <!--<option value="请选择审核状态">请选择审核状态</option>
	                                        <option value="0">未审核</option>-->
	                                        <option value="1"><?php if ($this->_tpl_vars['operaType'] == 2): ?>彻底删除<?php else: ?>审核通过<?php endif; ?></option>
	                                        <option value="2"><?php if ($this->_tpl_vars['operaType'] == 2): ?>放入回收库<?php else: ?>审核不通过<?php endif; ?></option>
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
	            <!--E form_block_ft--> 
            </div>
            <!--E form_bd--> 
        </div>
        <!--E form_edit-->
         </form>
<script language="javascript" type="text/javascript">
<?php echo '
$(function(){
	$(\'#checkAgent\').click(function(){
		var agentId = $.trim($(\'#agentId\').val());
		var checkId = $.trim($(\'#checkId\').val());
		var operateType = $(\'#operate_type\').val();
		var auditState = $.trim($(\'#auditState\').val());
		var check_remark = $.trim($(\'#check_remark\').val());
		var objVal = \'\';
		$(\'input[type="checkbox"][name^="chk_"]:checked\').each(function(){
			objVal += $(this).attr(\'name\')+\'=\'+$(this).attr(\'value\')+\'&\';
		});
		var objVal = objVal.slice(0,-1);
		var strData = \'\';
		if(objVal!=\'\')
		{
			strData = \'auditState=\'+auditState+\'&check_remark=\'+check_remark+\'&agentId=\'+agentId+\'&operate_type=\'+operateType+\'&checkId=\'+checkId+\'&\'+objVal;
		}
		else
		{
			strData = \'auditState=\'+auditState+\'&check_remark=\'+check_remark+\'&agentId=\'+agentId+\'&operate_type=\'+operateType+\'&checkId=\'+checkId;
		}
		//alert(strData);return false;
		$.ajax({
			type:\'POST\',
			data:strData,
			'; ?>

			url:'<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'checkAgent'), $this);?>
',
			<?php echo '
			success:function(data)
			{
				switch(data)
				{
					case \'1\':
						IM.tip.show(\'审核成功！\');
                        PageBack();
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