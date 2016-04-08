<?php /* Smarty version 2.6.26, created on 2013-01-23 10:25:02
         compiled from Agent/GetAgentInfoCard.tpl */ ?>
<div class="bd">
<div class="list_table_main marginBottom10">
<div class="ui_table ui_table_nohead">
    <div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">代理商基本信息</h4></div></div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody class="ui_table_bd">
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strAgentName; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">企业法人</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strLegalPerson; ?>
</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strAreaFullName; ?>
 <?php echo $this->_tpl_vars['arrAgentInfoCard']->strAddress; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strPostcode; ?>
</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strRegAreaFullName; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strDirection; ?>
</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                <td>
                <div class="ui_table_tdcntr"><b class="amountStyle"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strRegCapital; ?>
</b>
                </div>
                </td>
                <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	<?php if ($this->_tpl_vars['arrAgentInfoCard']->strSalesNum == 0): ?>
                            
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strSalesNum == 1): ?>
                    10-50人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strSalesNum == 2): ?>
                    50-100人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strSalesNum == 3): ?>
                    100-300人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strSalesNum == 4): ?>
                    300-600人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strSalesNum == 5): ?>
                    600-1000人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strSalesNum == 6): ?>
                    1000人以上
                    <?php endif; ?>
                </div>
                </td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">营业执照注册号</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strPermitRegNo; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">企业税号</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strRevenueNo; ?>
</div></td>
            </tr>                                                                                        
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">注册时间</div></td>
                <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrAgentInfoCard']->strRegDate != '0000-00-00'): ?><?php echo $this->_tpl_vars['arrAgentInfoCard']->strRegDate; ?>
<?php endif; ?></div></td>
                <td class="even"><div class="ui_table_tdcntr">售前技术人数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	<?php if ($this->_tpl_vars['arrAgentInfoCard']->strTechNum == 0): ?>
                            
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTechNum == 1): ?>
                    1-5人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTechNum == 2): ?>
                    5-25人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTechNum == 3): ?>
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
                	<?php if ($this->_tpl_vars['arrAgentInfoCard']->strCompanyScale == 0): ?>
                            
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCompanyScale == 1): ?>
                    10-50人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCompanyScale == 2): ?>
                    50-100人
                    <?php else: ?>
                    100人以上
                    <?php endif; ?>
                </div>
                </td>
                <td class="even"><div class="ui_table_tdcntr">互联网电话营销人数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	<?php if ($this->_tpl_vars['arrAgentInfoCard']->strTelsalesNum == 0): ?>
                            
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTelsalesNum == 1): ?>
                    10-50人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTelsalesNum == 2): ?>
                    50-100人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTelsalesNum == 3): ?>
                    100-300人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTelsalesNum == 4): ?>
                    300-600人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTelsalesNum == 5): ?>
                    600-1000人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strTelsalesNum == 6): ?>
                    1000人以上
                    <?php endif; ?>
                </div>
                </td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	<?php if ($this->_tpl_vars['arrAgentInfoCard']->strAnnualSales == 0): ?>
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strAnnualSales == 1): ?>
                    50万以下
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strAnnualSales == 2): ?>
                    50-100万
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strAnnualSales == 3): ?>
                    100-500万
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strAnnualSales == 4): ?>
                    500-1000万
                    <?php else: ?>
                    1000万以上
                    <?php endif; ?>
                </div>
                </td>
                <td class="even"><div class="ui_table_tdcntr">企业客户数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	<?php if ($this->_tpl_vars['arrAgentInfoCard']->strCustomerNum == 0): ?>
                            
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCustomerNum == 1): ?>
                    100人以下
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCustomerNum == 2): ?>
                    100-300人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCustomerNum == 3): ?>
                    300-600人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCustomerNum == 4): ?>
                    600-1000人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCustomerNum == 5): ?>
                   1000-1500人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCustomerNum == 6): ?>
                    1500-2000人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strCustomerNum == 7): ?>
                    2000-3000人
                    <?php else: ?>
                    3000人以上
                    <?php endif; ?>
                </div>
                </td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strWebSite; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
                <td>
                <div class="ui_table_tdcntr">
                	<?php if ($this->_tpl_vars['arrAgentInfoCard']->strServiceNum == 0): ?>
                            
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strServiceNum == 1): ?>
                    1-5人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strServiceNum == 2): ?>
                    5-25人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strServiceNum == 3): ?>
                    25-60人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strServiceNum == 4): ?>
                    60-120人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strServiceNum == 5): ?>
                    120-200人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strServiceNum == 6): ?>
                    200-400人
                    <?php elseif ($this->_tpl_vars['arrAgentInfoCard']->strServiceNum == 7): ?>
                    400人以上
                    <?php endif; ?>
                </div>
                </td>
            </tr>
        </tbody>
   </table>   
</div>
</div>
<div class="list_table_main">
<div class="ui_table ui_table_nohead">
    <div class="ui_table_hd"><div class="ui_table_hd_inner">
      <h4 class="title">负责人信息</h4></div></div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody class="ui_table_bd">
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">负责人姓名</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strChargePerson; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">电子邮箱</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strChargeEmail; ?>
</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">手机号</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strChargePhone; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">职务</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strChargePositon; ?>
</div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">固定电话</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strChargeTel; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">QQ</div></td>
                <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['arrAgentInfoCard']->iChargeQq != 0): ?><?php echo $this->_tpl_vars['arrAgentInfoCard']->iChargeQq; ?>
<?php endif; ?></div></td>
            </tr>
            <tr class="">
                <td class="even"><div class="ui_table_tdcntr">传真号码</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strChargeFax; ?>
</div></td>
                <td class="even"><div class="ui_table_tdcntr">MSN</div></td>
                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrAgentInfoCard']->strChargeMsn; ?>
</div></td>
            </tr>
        </tbody>
     </table>
</div>
</div>
</div>