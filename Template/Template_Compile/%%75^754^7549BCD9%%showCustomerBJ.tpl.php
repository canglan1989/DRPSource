<?php /* Smarty version 2.6.26, created on 2013-01-11 11:31:27
         compiled from CM/showCustomerBJ.tpl */ ?>
<div class="bd">					
<div class="list_table_main marginBottom10">
                        <div class="ui_table ui_table_nohead">					
						<div class="ui_table_hd"><div class="ui_table_hd_inner"><h4 class="title">客户基本信息</h4></div></div>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                       <tbody class="ui_table_bd">
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">客户名称</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['customer_name']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">意向产品</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['interProduct']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">详细地址</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['province_name']; ?>
-><?php echo $this->_tpl_vars['city_name']; ?>
-><?php echo $this->_tpl_vars['area_name']; ?>
:<?php echo $this->_tpl_vars['address']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">行业</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['industry_fullname']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">经营模式</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['business_model']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">主营业务</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['main_business']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">主要市场</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['major_markets']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">公司简介</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['company_profile']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">规模(人数)</div></td>
                                                <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['company_scope'] != ""): ?><?php echo $this->_tpl_vars['company_scope']; ?>
 人<?php endif; ?></div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册状态</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['reg_status']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">注册日期</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['reg_date']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['website']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <!--
                                                <td class="even"><div class="ui_table_tdcntr">详细地址</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['province_name']; ?>
-><?php echo $this->_tpl_vars['city_name']; ?>
-><?php echo $this->_tpl_vars['area_name']; ?>
:<?php echo $this->_tpl_vars['address']; ?>
</div></td>
                                                -->
                                                <td class="even"><div class="ui_table_tdcntr">邮编</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['postcode']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">注册地区</div></td>
                                                <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['reg_place'] != -1): ?><?php echo $this->_tpl_vars['reg_place']; ?>
<?php endif; ?></div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">客户来源</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['customer_from']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">网络推广情况</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['net_extension_about']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">经营范围</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['business_scope']; ?>
</div></td>
                                                 <td class="even"><div class="ui_table_tdcntr">年营业额</div></td>
                                                <td><div class="ui_table_tdcntr"><b class="amountStyle"><?php if ($this->_tpl_vars['annual_sales'] != ""): ?><?php echo $this->_tpl_vars['annual_sales']; ?>
 万元<?php endif; ?></b></div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
                                                <td><div class="ui_table_tdcntr"><b class="amountStyle"><?php if ($this->_tpl_vars['reg_capital'] != ""): ?><?php echo $this->_tpl_vars['reg_capital']; ?>
 万元<?php endif; ?></b></div></td>
                                                
                                            </tr>
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
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['contact_name']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">职位</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['contact_position']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">手机</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['contact_mobile']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">固话</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['contact_tel']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">性别</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['contact_sex_name']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">邮箱</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['contact_email']; ?>
</div></td>
                                            </tr>
                                            <tr class="">
                                                <td class="even"><div class="ui_table_tdcntr">传真</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['contact_fax']; ?>
</div></td>
                                                <td class="even"><div class="ui_table_tdcntr">备注</div></td>
                                                <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['contact_remark']; ?>
</div></td>
                                            </tr>
                                        </tbody>
                                   </table>   
                        </div>
                    </div>
                    </div>