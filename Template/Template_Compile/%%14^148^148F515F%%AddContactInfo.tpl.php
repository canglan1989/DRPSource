<?php /* Smarty version 2.6.26, created on 2013-01-28 10:55:43
         compiled from Agent/AddContactInfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/AddContactInfo.tpl', 17, false),array('modifier', 'truncate', 'Agent/AddContactInfo.tpl', 327, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('/?d=Agent&c=Agent&a=showChannelPager')">我的渠道</a><span>&gt;</span>代理商信息</div>
<!--E crumbs--> 
<!--S form_edit-->
<div class="form_edit">
  <div class="form_hd">
    <ul>
      <li class="cur">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>代理商信息</h2>
            </div>
          </div>
        </div>
      </li>
      <li> <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentDetailInfo'), $this);?>
&agentId=<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>联系信息</h2>
            </div>
          </div>
        </div>
        </a> </li>
      <?php if ($this->_tpl_vars['objAgentInfo']->iAgentId != $this->_tpl_vars['objAgentInfo']->strAgentNo): ?>
      <li> <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentDoc','a' => 'Detail'), $this);?>
&id=<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>附件信息</h2>
            </div>
          </div>
        </div>
        </a> </li>
        <?php endif; ?>
    </ul>
    <div class="form_hd_oper"> <a class="ui_button ui_button_dis" onclick="PageBack();" href="javascript:;">
      <div class="ui_button_left"></div>
      <div class="ui_button_inner">
        <div class="ui_icon ui_icon_return"></div>
        <div class="ui_text">返回</div>
      </div>
      </a> <?php if ($this->_tpl_vars['objAgentInfo']->iIsCheck == 1 && $this->_tpl_vars['showbutton'] == 1): ?> <a class="ui_button" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'showSignInfo'), $this);?>
&agentId=<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
&fromType=1&isPact=<?php echo $this->_tpl_vars['isPact']; ?>
');" style="cursor:pointer;">
      <div class="ui_button_left"></div>
      <div class="ui_button_inner">
        <div class="ui_icon ui_icon_submitAudit"></div>
        <div class="ui_text">提交补签</div>
      </div>
      </a> <?php endif; ?>
      <?php if (! ( $this->_tpl_vars['addNum'] != 0 && $this->_tpl_vars['objAgentInfo']->iIsCheck == 2 )): ?> <a class="ui_button" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentMove','a' => 'showSignInfo'), $this);?>
&agentId=<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
&fromType=1&isPact=<?php echo $this->_tpl_vars['isPact']; ?>
');" style="cursor:pointer;">
      <div class="ui_button_left"></div>
      <div class="ui_button_inner">
        <div class="ui_icon ui_icon_submitAudit"></div>
        <div class="ui_text">提交签约</div>
      </div>
      </a> <?php endif; ?> </div>
  </div>
</div>
<!--S form_bd-->
<div class="form_bd"> 
  <!--S form_block_bd-->
  <div class="form_block_bd"> <?php if ($this->_tpl_vars['isPact'] == 'yes'): ?> 
    <!--        	
				<a class="ui_button ui_link" href="javascript:;" style="margin-bottom:5px;"><div class="ui_text" onClick="IM.Toggle('.agentInfoToggle',this,'查看代理商信息▼','收起代理商信息▲')">查看代理商信息▼</div></a>
				--> 
    <?php endif; ?> 
    <!--E list_link-->
    <div class="list_table_main marginBottom10 agentInfoToggle">
      <div class="ui_table ui_table_nohead">
        <div class="ui_table_hd">
          <div class="ui_table_hd_inner"> 
           <?php if ($this->_tpl_vars['isPact'] == 'no'): ?>
               <a class="ui_button ui_link" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showModifyPager'), $this);?>
&agentId=<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
&checkStatus=<?php echo $this->_tpl_vars['objAgentInfo']->iIsCheck; ?>
&needCheck=<?php echo $this->_tpl_vars['needCheck']; ?>
&fromType=1')">资料修改记录</a> 
               <a class="ui_button ui_link" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'EditShow'), $this);?>
&agentId=<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
&checkStatus=<?php echo $this->_tpl_vars['objAgentInfo']->iIsCheck; ?>
&needCheck=<?php echo $this->_tpl_vars['needCheck']; ?>
&fromType=1')"><span class="ui_icon ui_icon_edit">&nbsp;</span>修改代理商资料</a> 
           <?php endif; ?>
            <h4 class="title">代理商基本信息</h4>
            <span style = "margin-left:10px;"> 创建时间：<?php echo $this->_tpl_vars['create_time']; ?>
</span> </div>
        </div>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody class="ui_table_bd">
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">代理商名称</div></td>
              <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['objAgentInfo']->strAgentName; ?>
</div></td>
              <td class="even"><div class="ui_table_tdcntr">注册资金</div></td>
              <td><div class="ui_table_tdcntr"> <b class="amountStyle"><?php echo $this->_tpl_vars['objAgentInfo']->strRegCapital; ?>
</b> </div></td>
              <td class="even"><div class="ui_table_tdcntr">客服人数</div></td>
              <td><div class="ui_table_tdcntr"> <?php if ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 0): ?>
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
                  <?php endif; ?> </div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">联系地址</div></td>
              <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['objAgentInfo']->strAreaFullName; ?>
><?php echo $this->_tpl_vars['objAgentInfo']->strAddress; ?>
</div></td>
              <td class="even"><div class="ui_table_tdcntr">注册日期</div></td>
              <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['objAgentInfo']->strRegDate == '0000-00-00'): ?><?php else: ?><?php echo $this->_tpl_vars['objAgentInfo']->strRegDate; ?>
<?php endif; ?></div></td>
              <td class="even"><div class="ui_table_tdcntr">企业客户数</div></td>
              <td><div class="ui_table_tdcntr"> <?php if ($this->_tpl_vars['objAgentInfo']->strCustomerNum == 0): ?>
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
                  3000人以上   
                  <?php endif; ?> </div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">注册地址</div></td>
              <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['objAgentInfo']->strRegAreaFullName; ?>
</div></td>
              <td class="even"><div class="ui_table_tdcntr">营业执照号</div></td>
              <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['objAgentInfo']->strPermitRegNo; ?>
</div></td>
              <td class="even"><div class="ui_table_tdcntr">年销售额</div></td>
              <td><div class="ui_table_tdcntr"> <?php if ($this->_tpl_vars['objAgentInfo']->strAnnualSales == 0): ?>
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
                  <?php endif; ?> </div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">邮政编码</div></td>
              <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['objAgentInfo']->strPostcode; ?>
</div></td>
              <td class="even"><div class="ui_table_tdcntr">企业税号</div></td>
              <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['objAgentInfo']->strRevenueNo; ?>
</div></td>
              <td class="even"><div class="ui_table_tdcntr">公司网址</div></td>
              <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['objAgentInfo']->strWebSite; ?>
</div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">所属行业</div></td>
              <td><div class="ui_table_tdcntr"> <?php if ($this->_tpl_vars['objAgentInfo']->iIndustry == 1): ?>
                  IT硬件
                  <?php elseif ($this->_tpl_vars['objAgentInfo']->iIndustry == 2): ?>
                  传媒
                  <?php elseif ($this->_tpl_vars['objAgentInfo']->iIndustry == 3): ?>
                  网络
                  <?php elseif ($this->_tpl_vars['objAgentInfo']->iIndustry == 4): ?>
                  广告
                  <?php elseif ($this->_tpl_vars['objAgentInfo']->iIndustry == 5): ?>
                  其他
                  <?php endif; ?> </div></td>
              <td class="even"><div class="ui_table_tdcntr">公司规模</div></td>
              <td><div class="ui_table_tdcntr"> <?php if ($this->_tpl_vars['objAgentInfo']->strCompanyScale == 0): ?>
                  <?php elseif ($this->_tpl_vars['objAgentInfo']->strCompanyScale == 1): ?>
                  10-50人
                  <?php elseif ($this->_tpl_vars['objAgentInfo']->strCompanyScale == 2): ?>
                  50-100人
                  <?php else: ?>
                  100人以上
                  <?php endif; ?> </div></td>
              <td class="even" rowspan = "2"><div class="ui_table_tdcntr">经营范围</div></td>
              <td rowspan = "2"><div class="ui_table_tdcntr"> <?php echo $this->_tpl_vars['objAgentInfo']->strDirection; ?>
 </div></td>
            </tr>
            <tr class="">
              <td class="even"><div class="ui_table_tdcntr">企业法人</div></td>
              <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['objAgentInfo']->strLegalPerson; ?>
</div></td>
              <td class="even"><div class="ui_table_tdcntr">公司销售人数</div></td>
              <td><div class="ui_table_tdcntr"> <?php if ($this->_tpl_vars['objAgentInfo']->strSalesNum == 0): ?>
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
                  <?php endif; ?> </div></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?php if ($this->_tpl_vars['objAgentInfo']->iAgentId != $this->_tpl_vars['objAgentInfo']->strAgentNo): ?> 
    <!--S list_table_main-->
    <div class="list_table_main marginBottom10">
      <div class="ui_table ui_table_nohead">
        <div class="ui_table_hd">
          <div class="ui_table_hd_inner">
            <h4 class="title">合同基本信息</h4>
          </div>
        </div>
        <?php $_from = $this->_tpl_vars['arrAllPact']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrPact']):
?>
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
              <td><div class="ui_table_tdcntr" style="line-height:20px; overflow-y:auto; max-height:200px;"> <?php $_from = $this->_tpl_vars['arrPact']['areaName']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['strArea']):
?>
                  <?php if ($this->_tpl_vars['key'] % 2 == 0): ?><br />
                  <?php endif; ?><?php echo $this->_tpl_vars['strArea']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php endforeach; endif; unset($_from); ?> </div></td>
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
          </tbody>
        </table>
        <?php endforeach; endif; unset($_from); ?> </div>
      <!--E ui_table--> 
    </div>
    <!--E list_table_main-->    
    <?php endif; ?> 
    <!--S list_table_head-->
    <div class="list_table_head">
      <div class="list_table_head_right">
        <div class="list_table_head_mid">
          <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 联系人信息</h4>
          <a class="ui_button ui_link" href="javascript:;"   onClick="IM.agent.addContactInfo('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAddContacter'), $this);?>
','添加联系人信息','<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
','<?php echo $this->_tpl_vars['isPact']; ?>
')"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加联系人</a> </div>
      </div>
    </div>
    <!--E list_table_head--> 
    <!--S list_table_main-->
    <div class="list_table_main marginBottom10" id="ContacterInfo">
      <div class="ui_table" id="J_ui_table">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <thead class="ui_table_hd">
            <tr class="">
              <th style="width:100px;" title="姓名"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">姓名</div>
                </div>
              </th>
              <th style="width:80px;" title="职务"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">职务</div>
                </div>
              </th>
              <th style="width:120px;" title="手机号码"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">手机号码</div>
                </div>
              </th>
              <th style="width:120px;" title="固定电话"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">固定电话</div>
                </div>
              </th>
              <th style="width:120px;" title="微博"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">微博</div>
                </div>
              </th>
              <th style="width:120px;" title="传真号码"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">传真号码</div>
                </div>
              </th>
              <th title="电子邮箱"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">电子邮箱</div>
                </div>
              </th>
              <th style="width:120px;" title="QQ"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">QQ</div>
                </div>
              </th>
              <th style="width:120px;" title="MSN"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">MSN</div>
                </div>
              </th>
              <th title="备注"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">备注</div>
                </div>
              </th>
              <th style="width:120px;" title="操作"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">操作</div>
                </div>
              </th>
            </tr>
          </thead>
          <tbody class="ui_table_bd">
          
          <?php $_from = $this->_tpl_vars['arrAllContacter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Contacter']):
?>
          <tr class="">
            <td title="<?php echo $this->_tpl_vars['Contacter']['contact_name']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:;" onClick="IM.agent.getContactInfo(<?php echo '{'; ?>
'id':<?php echo $this->_tpl_vars['Contacter']['aid']; ?>
<?php echo '}'; ?>
)"> <?php if ($this->_tpl_vars['Contacter']['isCharge'] == 0): ?> <?php echo $this->_tpl_vars['Contacter']['contact_name']; ?>
(是负责人)
                <?php else: ?><?php echo $this->_tpl_vars['Contacter']['contact_name']; ?>

                <?php endif; ?></a></div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['position']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['Contacter']['position']; ?>
</div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['mobile']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['Contacter']['mobile']; ?>
 </div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['Contacter']['tel']; ?>
</div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['Contacter']['twitter']; ?>
</div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['fax']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['Contacter']['fax']; ?>
</div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['email']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['Contacter']['email']; ?>
</div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['tel']; ?>
"><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['Contacter']['qq'] != 0): ?><?php echo $this->_tpl_vars['Contacter']['qq']; ?>
<?php endif; ?></div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['Contacter']['msn']; ?>
</div></td>
            <td title="<?php echo $this->_tpl_vars['Contacter']['remark']; ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['Contacter']['remark'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '18', "...") : smarty_modifier_truncate($_tmp, '18', "...")); ?>
</div></td>
            <td><div class="ui_table_tdcntr">
                <ul class="list_table_operation">
                  <li><a onClick="IM.agent.addContactInfo('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAddContacter'), $this);?>
&id=<?php echo $this->_tpl_vars['Contacter']['aid']; ?>
','编辑联系人信息','<?php echo $this->_tpl_vars['objAgentInfo']->iAgentId; ?>
','<?php echo $this->_tpl_vars['isPact']; ?>
')" href="javascript:;">编辑</a></li>
                  <?php if ($this->_tpl_vars['Contacter']['isCharge'] == 1): ?>
                  <li><a onclick="IM.account.delOper('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'DelContacter'), $this);?>
',<?php echo '{'; ?>
'listid':<?php echo $this->_tpl_vars['Contacter']['aid']; ?>
<?php echo '}'; ?>
,'删除联系人',this)" href="javascript:;">删除</a></li>
                  <?php endif; ?>
                </ul>
              </div></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
            </tbody>
          
        </table>
      </div>
      <!--E ui_table--> 
    </div>
    <!--E list_table_main--> 
    
  </div>
</div>
<script language="javascript" type="text/javascript">
<?php echo '
new Reg.vf($(\'#J_newLXXiaoJi\'),{callback:function(data){
	if(IM.checkPhone()){IM.tip.warn(\'手机或固话必填一项\');return false;}
	if(!IM.IsSending(true)){return false;};
		$.ajax({
			type:\'POST\',
			data:$(\'#J_newLXXiaoJi\').serialize(),
			'; ?>

			url:'<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'AddContactInfo'), $this);?>
',
			<?php echo '
			success:function(data){
			IM.IsSending(false);
				switch(data)
				{
					case \'1\':
						IM.tip.show(\'代理商联系小记添加成功！\');
						window.location.reload();
						break;
					case \'2\':
						IM.tip.warn(\'非法参数，请检查！\');
						break;
					case \'3\':
						IM.tip.warn(\'联系人信息不能为空！\');
						break;
					case \'4\':
						IM.tip.warn(\'手机号码不能为空！\');
						break;
					default:
						IM.tip.warn(\'代理商联系小记添加失败！\');
						break;
				}
			}
		});
	}
});
function showAddContactInfo(agent_id,isPact){
    IM.dialog.show({
            width:650,
            height:null,
            title:\'添加联系小记\',
            html:IM.STATIC.LOADING,
            start:function(){
                $(\'.DCont\').html($PostData("/?d=Agent&c=Agent&a=showAddContactInfo&agent_id="+agent_id+"&isPact="+isPact));
            }
         })
}
'; ?>

</script>