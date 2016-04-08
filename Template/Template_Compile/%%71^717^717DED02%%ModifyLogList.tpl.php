<?php /* Smarty version 2.6.26, created on 2012-11-12 10:21:58
         compiled from Agent/ModifyLogList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'Agent/ModifyLogList.tpl', 386, false),)), $this); ?>
﻿<?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrModifyLogList']):
?>
<tr class="">
    <td>
<div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['agent_name'] != ''): ?>
        代理商名称：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['agent_name']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['address'] != ''): ?>
        注册地址：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['address']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['reg_date'] != ''): ?>
        注册日期：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['reg_date']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['legal_person'] != ''): ?>
        企业法人：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['legal_person']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['postcode'] != ''): ?>
        邮政编码：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['postcode']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['direction'] != ''): ?>
        业务方向：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['direction']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['website'] != ''): ?>
        网站地址：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['website']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['charge_person'] != ''): ?>
        企业负责人：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['charge_person']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['charge_phone'] != ''): ?>
        负责人手机：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['charge_phone']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['charge_tel'] != ''): ?>
        负责人电话：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['charge_tel']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['charge_email'] != ''): ?>
        电子邮件：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['charge_email']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['charge_fax'] != ''): ?>
        负责人传真：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['charge_fax']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['charge_positon'] != ''): ?>
        负责人职务：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['charge_positon']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['charge_qq'] != ''): ?>
        负责人QQ：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['charge_qq']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['charge_msn'] != ''): ?>
        负责人MSN：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['charge_msn']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['permit_reg_no'] != ''): ?>
        营业执照注册号：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['permit_reg_no']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['revenue_no'] != ''): ?>
        企业税号：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['revenue_no']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['legal_person_ID'] != ''): ?>
        法人身份证号：<?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['legal_person_ID']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['reg_capital'] != ''): ?>
        注册资金：
        <?php echo $this->_tpl_vars['arrModifyLogList']['old_values']['reg_capital']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['company_scale'] != ''): ?>
        公司规模：
        <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['company_scale'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['company_scale'] == 1): ?>
        10-50人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['company_scale'] == 2): ?>
        50-100人
        <?php else: ?>
        100人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['sales_num'] != ''): ?>
        公司销售人数：
        <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['sales_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['sales_num'] == 1): ?>
        10-50人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['sales_num'] == 2): ?>
        50-100人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['sales_num'] == 3): ?>
        100-300人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['sales_num'] == 4): ?>
        300-600人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['sales_num'] == 5): ?>
        600-1000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['sales_num'] == 6): ?>
        1000人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['telsales_num'] != ''): ?>
        电话营销：
        <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['telsales_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['telsales_num'] == 1): ?>
        10-50人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['telsales_num'] == 2): ?>
        50-100人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['telsales_num'] == 3): ?>
        100-300人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['telsales_num'] == 4): ?>
        300-600人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['telsales_num'] == 5): ?>
        600-1000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['telsales_num'] == 6): ?>
		1000人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['tech_num'] != ''): ?>
        售前技术支持：
        <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['tech_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['tech_num'] == 1): ?>
        1-5人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['tech_num'] == 2): ?>
        5-25人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['tech_num'] == 3): ?>
        25-60人
        <?php else: ?>
        60人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] != ''): ?>
        客服人数：
        <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] == 1): ?>
        1-5人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] == 2): ?>
        5-25人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] == 3): ?>
        25-60人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] == 4): ?>
        60-120人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] == 5): ?>
        120-200人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] == 6): ?>
        200-400人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['service_num'] == 7): ?>
        400人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] != ''): ?>
        企业客户数：
        <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 1): ?>
        500人以下
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 2): ?>
        100-300人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 3): ?>
        300-600人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 4): ?>
        600-1000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 5): ?>
        1000-1500人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 6): ?>
        1500-2000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 7): ?>
        2000-3000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['customer_num'] == 8): ?>
		3000以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['annual_sales'] != ''): ?>
        年销售额：
        <?php if ($this->_tpl_vars['arrModifyLogList']['old_values']['annual_sales'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['annual_sales'] == 1): ?>
        50万以下
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['annual_sales'] == 2): ?>
        50-100万
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['annual_sales'] == 3): ?>
        100-500万
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['old_values']['annual_sales'] == 4): ?>
        500-1000万
        <?php else: ?>
        1000万以上
        <?php endif; ?><br />
    <?php endif; ?>
</div>
    </td>
    <td>
<div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['agent_name'] != ''): ?>
    	代理商名称：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['agent_name']; ?>
<br />
	<?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['address'] != ''): ?>
        注册地址：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['address']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['reg_date'] != ''): ?>
        注册日期：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['reg_date']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['legal_person'] != ''): ?>
        企业法人：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['legal_person']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['postcode'] != ''): ?>
        邮政编码：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['postcode']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['direction'] != ''): ?>
        业务方向：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['direction']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['website'] != ''): ?>
        网站地址：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['website']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['charge_person'] != ''): ?>
        企业负责人：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['charge_person']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['charge_phone'] != ''): ?>
        负责人手机：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['charge_phone']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['charge_tel'] != ''): ?>
        负责人电话：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['charge_tel']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['charge_email'] != ''): ?>
        电子邮件：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['charge_email']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['charge_fax'] != ''): ?>
        负责人传真：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['charge_fax']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['charge_positon'] != ''): ?>
        负责人职务：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['charge_positon']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['charge_qq'] != ''): ?>
        负责人QQ：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['charge_qq']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['charge_msn'] != ''): ?>
        负责人MSN：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['charge_msn']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['permit_reg_no'] != ''): ?>
        营业执照注册号：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['permit_reg_no']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['revenue_no'] != ''): ?>
        企业税号：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['revenue_no']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['legal_person_ID'] != ''): ?>
        法人身份证号：<?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['legal_person_ID']; ?>
<br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['reg_capital'] != ''): ?>
        注册资金：
        <?php echo $this->_tpl_vars['arrModifyLogList']['new_values']['reg_capital']; ?>

        <br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['company_scale'] != ''): ?>
        公司规模：
        <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['company_scale'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['company_scale'] == 1): ?>
        10-50人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['company_scale'] == 2): ?>
        50-100人
        <?php else: ?>
        100人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['sales_num'] != ''): ?>
        公司销售人数：
        <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['sales_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['sales_num'] == 1): ?>
        10-50人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['sales_num'] == 2): ?>
        50-100人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['sales_num'] == 3): ?>
        100-300人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['sales_num'] == 4): ?>
        300-600人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['sales_num'] == 5): ?>
        600-1000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['sales_num'] == 6): ?>
        1000人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['telsales_num'] != ''): ?>
        电话营销：
        <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['telsales_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['telsales_num'] == 1): ?>
        10-50人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['telsales_num'] == 2): ?>
        50-100人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['telsales_num'] == 3): ?>
        100-300人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['telsales_num'] == 4): ?>
        300-600人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['telsales_num'] == 5): ?>
        600-1000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['telsales_num'] == 6): ?>
		1000人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['tech_num'] != ''): ?>
        售前技术支持：
        <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['tech_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['tech_num'] == 1): ?>
        1-5人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['tech_num'] == 2): ?>
        5-25人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['tech_num'] == 3): ?>
        25-60人
        <?php else: ?>
        60人以上
        <?php endif; ?><br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] != ''): ?>
        客服人数：
        <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] == 1): ?>
        1-5人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] == 2): ?>
        5-25人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] == 3): ?>
        25-60人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] == 4): ?>
        60-120人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] == 5): ?>
        120-200人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] == 6): ?>
        200-400人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['service_num'] == 7): ?>
        400人以上
        <?php endif; ?><br />
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] != ''): ?>
        企业客户数：
        <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 1): ?>
        500人以下
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 2): ?>
        100-300人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 3): ?>
        300-600人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 4): ?>
        600-1000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 5): ?>
        1000-1500人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 6): ?>
        1500-2000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 7): ?>
        2000-3000人
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['customer_num'] == 8): ?>
		3000以上
        <?php endif; ?><br />
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['annual_sales'] != ''): ?>
        年销售额：
        <?php if ($this->_tpl_vars['arrModifyLogList']['new_values']['annual_sales'] == 0): ?>
        
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['annual_sales'] == 1): ?>
        50万以下
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['annual_sales'] == 2): ?>
        50-100万
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['annual_sales'] == 3): ?>
        100-500万
        <?php elseif ($this->_tpl_vars['arrModifyLogList']['new_values']['annual_sales'] == 4): ?>
        500-1000万
        <?php else: ?>
        1000万以上
        <?php endif; ?><br />
    <?php endif; ?>
</div>
    </td>      
    <td title="<?php echo $this->_tpl_vars['arrModifyLogList']['create_e_name']; ?>
(<?php echo $this->_tpl_vars['arrModifyLogList']['create_user_name']; ?>
)"><div class="ui_table_tdcntr">
            <?php if (! empty ( $this->_tpl_vars['arrModifyLogList']['create_e_name'] )): ?>
            <?php echo $this->_tpl_vars['arrModifyLogList']['create_e_name']; ?>
(<?php echo $this->_tpl_vars['arrModifyLogList']['create_user_name']; ?>
)
            <?php endif; ?>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrModifyLogList']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['arrModifyLogList']['create_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['arrModifyLogList']['check_e_name']; ?>
(<?php echo $this->_tpl_vars['arrModifyLogList']['check_user_name']; ?>
)"><div class="ui_table_tdcntr">
            <?php if (! empty ( $this->_tpl_vars['arrModifyLogList']['check_e_name'] )): ?>
    <?php echo $this->_tpl_vars['arrModifyLogList']['check_e_name']; ?>
(<?php echo $this->_tpl_vars['arrModifyLogList']['check_user_name']; ?>
)
    <?php endif; ?>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrModifyLogList']['check_time']; ?>
"><div class="ui_table_tdcntr">
    <?php if ($this->_tpl_vars['arrModifyLogList']['check_time'] != '0000-00-00 00:00:00'): ?>
    <?php echo $this->_tpl_vars['arrModifyLogList']['check_time']; ?>

    <?php endif; ?>
    </div></td>
    <td title="<?php echo $this->_tpl_vars['arrModifyLogList']['check_remark']; ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrModifyLogList']['check_remark'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '8', "...") : smarty_modifier_truncate($_tmp, '8', "...")); ?>

    </div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>