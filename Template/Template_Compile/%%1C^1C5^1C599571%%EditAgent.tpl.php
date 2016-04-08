<?php /* Smarty version 2.6.26, created on 2012-12-20 16:55:53
         compiled from Agent/EditAgent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/EditAgent.tpl', 2, false),)), $this); ?>
    	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentPager'), $this);?>
')">资料库</a><span>&gt;</span>编辑代理商信息</div>
        <!--E crumbs-->  
        <form id="J_agentEditForm" name="J_agentEditForm" class="agentAddForm">   
        <!--S form_edit-->                  
        <div class="form_edit">
            <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2><?php echo $this->_tpl_vars['strTitle']; ?>
</h2></div></div></div>
            <span class="declare">“<em class="require">*</em>”为必填信息</span>
        </div>
            <!--S form_bd--> 
            <div class="form_bd">            
            	<div class="form_block_hd"><h3 class="ui_title">企业信息</h3></div>
                <!--S form_block_bd-->
                <div class="form_block_bd">
                		<div class="tf">
                        	<label><em class="require">*</em>代理商名称：</label>
                            <div class="inp"><input name="agent_name" type="text" class="companyName" id="agent_name" tabindex="1" value="<?php echo $this->_tpl_vars['objAgentDetail']->strAgentName; ?>
"  valid="required" onblur="IsExistSameName(this)"/>
                            <input type="hidden" id="needCheck" name="needCheck" value="<?php echo $this->_tpl_vars['needCheck']; ?>
" />
                            <input type="hidden" id="checkStatus" name="checkStatus" value="<?php echo $this->_tpl_vars['checkStatus']; ?>
" />
                            </div>
                            <span class="info">请按照营业执照上的名称填写</span>
                            <span class="ok">&nbsp;</span><span class="err">请按照营业执照上的名称填写</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>联系地址：</label>
                            <div class="inp">
                                <select id="selProvince" class="pri" name="province_id" tabindex="2">
                                	<option value="1">浙江省</option>
                                </select>
                                <select id="selCity" class="city" name="city_id" tabindex="3">
                                	<option value="3301">杭州城市</option>
                                </select>
                                <select id="selArea" class="area" name="area_id" tabindex="4">
                                	<option value="338">建德市</option>
                                </select>
                                <input class="detailAddress" type="text" name="address" valid="required"  value="<?php echo $this->_tpl_vars['objAgentDetail']->strAddress; ?>
" tabindex="5" onfocus="if(this.value=='请输入详细街道地址')this.value='';this.style['color']='#555555'" id="address"/>
                            </div>
                            <span class="info">该联系地址为邮寄地址，请仔细填写</span>
                            <span class="ok">&nbsp;</span><span class="err">该联系地址为邮寄地址，请仔细填写</span>
                        </div>
                        
                        <div class="tf">
                        <label><em class="require">*</em>注册地区：</label>
                        <div class="inp">
                            <select id="regProvince" class="pri" name="reg_province_id" tabindex="2"></select>
                            <select id="regCity" class="city" name="reg_city_id" tabindex="3"></select>
                            <select id="regArea" class="area" name="reg_area_id" tabindex="4"></select>
                        </div>
                        </div>
		    <div class="tf">
			<label>邮政编码：</label>
                            <div class="inp"><input class="postcode" type="text" name="postcode" valid="postcode" maxlength="6" tabindex="6" value="<?php echo $this->_tpl_vars['objAgentDetail']->strPostcode; ?>
"/></div>
                            <span class="info">请填写公司联系地址所在地的邮政编码</span>
                            <span class="ok">&nbsp;</span><span class="err">请填写公司联系地址所在地的邮政编码</span>
                        </div>
                        <div class="tf tf2">
			<label><em class="require">*</em>所属行业：</label>
			<div class="inp">
                            <select name="industry"  tabindex="8" id="company_scale">
                            	<option value="1" <?php if ($this->_tpl_vars['objAgentDetail']->iIndustry == 1): ?>selected="selected"<?php endif; ?>>IT硬件</option>
				<option value="2" <?php if ($this->_tpl_vars['objAgentDetail']->iIndustry == 2): ?>selected="selected"<?php endif; ?>>传媒</option>
                                <option value="3" <?php if ($this->_tpl_vars['objAgentDetail']->iIndustry == 3): ?>selected="selected"<?php endif; ?>>网络</option>
                                <option value="4" <?php if ($this->_tpl_vars['objAgentDetail']->iIndustry == 4): ?>selected="selected"<?php endif; ?>>广告</option>
                                <option value="5" <?php if ($this->_tpl_vars['objAgentDetail']->iIndustry == 5): ?>selected="selected"<?php endif; ?>>其他</option>
                            </select>
			</div>
		    </div>
                        <div class="tf">
                        	<label>法人姓名：</label>
                            <div class="inp"><input class="LegalPersonName" type="text" name="legal_person"  valid="LegalPersonName"  tabindex="7" id="legal_person" value="<?php echo $this->_tpl_vars['objAgentDetail']->strLegalPerson; ?>
"/></div>
                            <span class="info">请按照营业执照上的名称填写</span>
                            <span class="ok">&nbsp;</span><span class="err">请按照营业执照上的名称填写</span>
                        </div>
                        <div class="tf">
                        	<label>注册资金：</label>
                            <div class="inp">
                            <input type="text" id="reg_capital" name="reg_capital" value="<?php echo $this->_tpl_vars['objAgentDetail']->strRegCapital; ?>
"/>
                            </div>
                        </div>
                        <div class="tf">
                        	<label>公司注册时间：</label>
                            <div class="inp"><input type="text" class="registeredTime inpDate" name="reg_date" onClick="WdatePicker()" id="reg_date" value="<?php if ($this->_tpl_vars['objAgentDetail']->strRegDate == 0000 -00 -00): ?><?php else: ?><?php echo $this->_tpl_vars['objAgentDetail']->strRegDate; ?>
<?php endif; ?>"/></div>
                        </div>
		    <div class="tf">
			<label>公司规模：</label>
                            <div class="inp">
                            <select name="company_scale"  tabindex="8" id="company_scale">
                            	<option value="0" <?php if ($this->_tpl_vars['objAgentDetail']->strCompanyScale == 0): ?>selected="selected"<?php endif; ?>>请选择</option>
                            	<option value="1" <?php if ($this->_tpl_vars['objAgentDetail']->strCompanyScale == 1): ?>selected="selected"<?php endif; ?>>10-50人</option>
                                <option value="2" <?php if ($this->_tpl_vars['objAgentDetail']->strCompanyScale == 2): ?>selected="selected"<?php endif; ?>>50-100人</option>
                                <option value="3" <?php if ($this->_tpl_vars['objAgentDetail']->strCompanyScale == 3): ?>selected="selected"<?php endif; ?>>100人以上</option>
                            </select>
                            </div>
                        </div>
		    <div class="tf">
			<label>公司销售人数：</label>
                            <div class="inp">
                            <select name="sales_num"  tabindex="8" id="sales_num">
                            	<option value="0" <?php if ($this->_tpl_vars['objAgentDetail']->strSalesNum == 0): ?>selected="selected"<?php endif; ?>>请选择</option>
                            	<option value="1" <?php if ($this->_tpl_vars['objAgentDetail']->strSalesNum == 1): ?>selected="selected"<?php endif; ?>>10-50人</option>
                                <option value="2" <?php if ($this->_tpl_vars['objAgentDetail']->strSalesNum == 2): ?>selected="selected"<?php endif; ?>>50-100人</option>
                                <option value="3" <?php if ($this->_tpl_vars['objAgentDetail']->strSalesNum == 3): ?>selected="selected"<?php endif; ?>>100-300人</option>
                                <option value="4" <?php if ($this->_tpl_vars['objAgentDetail']->strSalesNum == 4): ?>selected="selected"<?php endif; ?>>300-600人</option>
                                <option value="5" <?php if ($this->_tpl_vars['objAgentDetail']->strSalesNum == 5): ?>selected="selected"<?php endif; ?>>600-1000人</option>
                                <option value="6" <?php if ($this->_tpl_vars['objAgentDetail']->strSalesNum == 6): ?>selected="selected"<?php endif; ?>>1000人以上</option>
                            </select>
                            </div>
                        </div>
		   
                       
                        <div class="tf">
                        	<label>客服人数：</label>
                            <div class="inp">
                            <select name="service_num"  tabindex="8" id="service_num">
                            	<option value="0" <?php if ($this->_tpl_vars['objAgentDetail']->strServiceNum == 0): ?>selected="selected"<?php endif; ?>>请选择</option>
                            	<option value="1" <?php if ($this->_tpl_vars['objAgentDetail']->strServiceNum == 1): ?>selected="selected"<?php endif; ?>>1-5人</option>
                                <option value="2" <?php if ($this->_tpl_vars['objAgentDetail']->strServiceNum == 2): ?>selected="selected"<?php endif; ?>>5-25人</option>
                                <option value="3" <?php if ($this->_tpl_vars['objAgentDetail']->strServiceNum == 3): ?>selected="selected"<?php endif; ?>>25-60人</option>
                                <option value="4" <?php if ($this->_tpl_vars['objAgentDetail']->strServiceNum == 4): ?>selected="selected"<?php endif; ?>>60-120人</option>
                                <option value="5" <?php if ($this->_tpl_vars['objAgentDetail']->strServiceNum == 5): ?>selected="selected"<?php endif; ?>>120-200人</option>
                                <option value="6" <?php if ($this->_tpl_vars['objAgentDetail']->strServiceNum == 6): ?>selected="selected"<?php endif; ?>>200-400人</option>
                                <option value="7" <?php if ($this->_tpl_vars['objAgentDetail']->strServiceNum == 7): ?>selected="selected"<?php endif; ?>>400人以上</option>
                            </select>
                            </div>
                        </div>
		    <div class="tf">
			<label>企业客户数：</label>
                            <div class="inp">
                            <select name="customer_num"  tabindex="8" id="customer_num">
                            	<option value="0" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 0): ?>selected="selected"<?php endif; ?>>请选择</option>
                            	<option value="1" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 1): ?>selected="selected"<?php endif; ?>>100人以下</option>
                                <option value="2" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 2): ?>selected="selected"<?php endif; ?>>100-300人</option>
                                <option value="3" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 3): ?>selected="selected"<?php endif; ?>>300-600人</option>
                                <option value="4" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 4): ?>selected="selected"<?php endif; ?>>600-1000人</option>
                                <option value="5" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 5): ?>selected="selected"<?php endif; ?>>1000-1500人</option>
                                <option value="6" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 6): ?>selected="selected"<?php endif; ?>>1500-2000人</option>
                                <option value="7" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 7): ?>selected="selected"<?php endif; ?>>2000-3000人</option>
                                <option value="8" <?php if ($this->_tpl_vars['objAgentDetail']->strCustomerNum == 8): ?>selected="selected"<?php endif; ?>>3000人以上</option>
                            </select>
                            </div>
                        </div>
		    <div class="tf">
			<label>年销售额：</label>
                            <div class="inp">
                            <select class="turnoverYear" name="annual_sales"  tabindex="8" id="annual_sales">
                            	<option value="0" <?php if ($this->_tpl_vars['objAgentDetail']->strAnnualSales == 0): ?>selected="selected"<?php endif; ?>>请选择</option>
                            	<option value="1" <?php if ($this->_tpl_vars['objAgentDetail']->strAnnualSales == 1): ?>selected="selected"<?php endif; ?>>50万以下</option>
                                <option value="2" <?php if ($this->_tpl_vars['objAgentDetail']->strAnnualSales == 2): ?>selected="selected"<?php endif; ?>>50-100万</option>
                                <option value="3" <?php if ($this->_tpl_vars['objAgentDetail']->strAnnualSales == 3): ?>selected="selected"<?php endif; ?>>100-500万</option>
                                <option value="4" <?php if ($this->_tpl_vars['objAgentDetail']->strAnnualSales == 4): ?>selected="selected"<?php endif; ?>>500-1000万</option>
                                <option value="5" <?php if ($this->_tpl_vars['objAgentDetail']->strAnnualSales == 5): ?>selected="selected"<?php endif; ?>>1000万以上</option>
                            </select>
                            </div>
                        </div>
                        
            <div class="tf">
			<label>公司网站：</label>
                        <div class="inp">http://<input type="text" valid="url" name="website" id="website" value="<?php echo $this->_tpl_vars['objAgentDetail']->strWebSite; ?>
"/></div>
                        <span class="info">请输入有效网址 如:www.abc.com</span>
                        <span class="ok">&nbsp;</span><span class="err">请输入有效网址</span>
                        </div>
                        <div class="tf">
                        <label>营业执照注册号：</label>
                            <div class="inp"><input  type="text" valid="" name="permit_reg_no" id="permit_reg_no" value="<?php echo $this->_tpl_vars['objAgentDetail']->strPermitRegNo; ?>
"/></div>
                            <span class="info">请输入营业执照注册号</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入营业执照注册号</span>
                            </div>
             
                        <div class="tf">
                        <label>企业税号：</label>
                            <div class="inp"><input  type="text" valid="" name="revenue_no" id="revenue_no" value="<?php echo $this->_tpl_vars['objAgentDetail']->strRevenueNo; ?>
"/></div>
                            <span class="info"></span>
                            <span class="ok">&nbsp;</span><span class="err"></span>
                            </div>
		    <div class="tf">
			<label>经营范围：</label>
                            <div class="inp">
                            	<textarea name="direction" cols="50" id="direction"><?php echo $this->_tpl_vars['objAgentDetail']->strDirection; ?>
</textarea>
                            </div>
                        </div>
                        
                </div>
                <!--E form_block_bd-->
                
                <!--S form_block_hd--> 
                <div class="form_block_hd"><h3 class="ui_title">联系人信息</h3></div>
                <!--E form_block_hd--> 
                <!--S form_block_bd--> 
                <div class="form_block_bd">

                <div class="form_block_left">
                		<div class="tf">
                        	<label><em class="require">*</em>负责人姓名：</label>
                            <div class="inp"><input class="principalName" type="text" name="charge_person"   valid="required principalName" id="charge_person" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargePerson; ?>
"/></div>
                            <span class="info"></span>
                            <span class="ok">&nbsp;</span><span class="err">请如实填写</span>
                        </div>
                        <div class="tf">
                        <label><em class="require">*</em>职务：</label>
                            <div class="inp"><input class="office" type="text" name="charge_positon" id="charge_positon" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargePositon; ?>
"/></div>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>手机号：</label>
                            <div class="inp"><input class="mPhone" type="text" valid="mPhone" name="charge_phone"  id="charge_phone" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargePhone; ?>
"/></div>
                            <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
							<span class="err">请输入正确手机号</span>
                        </div>
                        <div class="tf">
                        	<label>固定电话：</label>
                            <div class="inp"><input class="fPhone" type="text" name="charge_tel"   valid="fPhone" id="charge_tel" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargeTel; ?>
"/></div>
                            <span class="info">固话格式:0571-8888888</span>
							<span class="err">请输入正确固定电话号</span>
                        </div>
                        <div class="tf">
                            <label>微博：</label>
                            <div class="inp"><input class="twitter" type="text" name="charge_twitter" id="charge_twitter" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargeTwitter; ?>
"/></div>
                            <span class="info" style="display:inline">多个微博请以","隔开</span>
                        </div>
                     </div>
                     <div class="form_block_right">
                        <div class="tf">
                        	<label>传真号码：</label>
                            <div class="inp"><input class="faxPhone" type="text" name="charge_fax" valid="faxPhone" id="charge_fax" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargeFax; ?>
"/></div>
                            <span class="info">请输入正确传真号码&nbsp;&nbsp;格式:0571-8888888</span>
                            <span class="err">格式:0571-8888888</span>
                        </div>
                <div class="tf">
                <label>电子邮箱：</label>
                            <div class="inp"><input class="email" type="text" name="charge_email"  valid="email" id="charge_email" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargeEmail; ?>
"/></div>
                            <span class="info">请输入正确邮箱</span>
                            <span class="err">请输入正确邮箱</span>
                        </div>
                        <div class="tf">
                        	<label>QQ：</label>
                            <div class="inp"><input class="QQ" type="text" name="charge_qq" id="charge_qq" value="<?php if ($this->_tpl_vars['objAgentDetail']->iChargeQq == 0): ?><?php else: ?><?php echo $this->_tpl_vars['objAgentDetail']->iChargeQq; ?>
<?php endif; ?>"/></div>
                        </div>
                        <div class="tf">
                        	<label>MSN：</label>
                            <div class="inp"><input class="MSN" type="text" name="charge_msn" id="charge_msn" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargeMsn; ?>
"/></div>
                        </div>
                        <div class="tf">
                        <label>备注：</label>
                        <div class="inp"><input class="charge_mark" type="text" name="charge_mark" id="charge_mark" value="<?php echo $this->_tpl_vars['objAgentDetail']->strChargeMark; ?>
"/></div>
                        </div>
                    </div>
                        <div class="tf tf_submit">
                        	<label>&nbsp;</label>
                            <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $this->_tpl_vars['objAgentDetail']->iAgentId; ?>
" />
                            <div class="inp">   
                                <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" id="EditAgent">确 认</button></div>
                                <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="PageBack();">返回</a></div>
                            </div>
                        </div>
                 </div>
                <!--E form_block_bd-->                 
            </div>
            <!--E form_bd--> 
        </div>
        <!--E form_edit-->
        </form> 
<script type="text/javascript">
<?php echo '
var _InDealWith = false;
$(function(){
	//绑定省市区联动菜单
	'; ?>

	var province_id = <?php echo $this->_tpl_vars['objAgentDetail']->iProvinceId; ?>
;
	var city_id = <?php echo $this->_tpl_vars['objAgentDetail']->iCityId; ?>
;
	var area_id = <?php echo $this->_tpl_vars['objAgentDetail']->iAreaId; ?>
;
	var reg_province_id = <?php echo $this->_tpl_vars['objAgentDetail']->iRegProvinceId; ?>
;
	var reg_city_id = <?php echo $this->_tpl_vars['objAgentDetail']->iRegCityId; ?>
;
	var reg_area_id = <?php echo $this->_tpl_vars['objAgentDetail']->iRegAreaId; ?>
;
	<?php echo '
	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:false,area_id:area_id,city_id:city_id,province_id:province_id});
	$("#regProvince").BindProvince({selCityID:"regCity",selAreaID:"regArea",iAddPleaseSelect:false,area_id:reg_area_id,city_id:reg_city_id,province_id:reg_province_id});
	new Reg.vf($(\'#J_agentEditForm\'),{extValid:{},callback:function(data){
	   
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
		if(IM.checkPhone()){IM.tip.warn(\'手机或固话必填一项\');return false;}
		if(!IM.IsSending(true)){return false;};
        _InDealWith = true;
		$.ajax({
			type:\'POST\',
			data:$(\'#J_agentEditForm\').serialize(),
			'; ?>

			url:'<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'EditAgent'), $this);?>
',
			<?php echo '
			success:function(data)
			{			 
			IM.IsSending(false);
                    _InDealWith = false; 
				switch(data)
				{
					case \'1\':
						IM.tip.show(\'代理商信息编辑成功！\');
						'; ?>

						var redirectUrl ='<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showChannelPager'), $this);?>
';
						<?php echo '
                        //JumpPage(redirectUrl);
                        PageBack();
						break;
					case \'2\':
						IM.tip.warn(\'代理商名称不能为空！\');
						break;
					case \'3\':
						IM.tip.warn(\'单位注册地址不能为空！\');
						break;
					case \'4\':
						IM.tip.warn(\'邮政编码不能为空！\');
						break;
					case \'5\':
						IM.tip.warn(\'法人姓名不能为空！\');
						break;
					case \'6\':
						IM.tip.warn(\'请选择注册资金！\');
						break;
					case \'7\':
						IM.tip.warn(\'企业负责人不能为空！\');
						break;
					case \'8\':
						IM.tip.warn(\'负责人手机号码不能为空！\');
						break;
					case \'9\':
						IM.tip.warn(\'负责人固定电话不能为空！\');
						break;
					case \'10\':
						IM.tip.warn(\'负责人电子邮件不能为空！\');
						break;
					case \'11\':
						IM.tip.warn(\'代理商信息编辑失败！\');
						break;
					case \'12\':
						IM.tip.warn(\'省份不能为空！\');
						break;
					case \'13\':
						IM.tip.warn(\'城市不能为空！\');
						break;
					case \'14\':
						IM.tip.warn(\'地区不能为空！\');
						break;
					case \'15\':
						IM.tip.warn(\'手机号码与固定电话请任意填一个！\');
						break;
					case \'16\':
						IM.tip.warn(\'请输入一个合法的网站地址！\');
						break;
					case \'17\':
						IM.tip.warn(\'该代理商名称已经存在，请检查！\');
						break;
					case \'18\':
						IM.tip.warn(\'该代理商名称已经签约，基础信息不允许修改！\');
						break;
					case \'19\':
						IM.tip.warn(\'注册省份不能为空！\');
						break;	
					case \'20\':
						IM.tip.warn(\'注册城市不能为空！\');
						break;
					case \'21\':
						IM.tip.warn(\'注册地区不能为空！\');
						break;
					case \'22\':
						IM.tip.warn(\'该代理商正在审核流程中，请先执行审核操作！\');
						break;
					case \'23\':
                                                IM.tip.warn(\'请先绑定业务战区！\');
                                                break;
					case \'24\':
                                                IM.tip.warn(\'你无权添加该区域下的代理商！\');
                                                break;
                                        case \'25\':
                                                IM.tip.warn(\'联系人职务不能为空！\');
                                                break;
					default:
                                                IM.tip.warn(data);          
						//IM.tip.warn(\'非法请求！\');
						break;
				}
			}
		});
	}});
});
//代理商资质上传
new IM.upload({id:\'J_upload0\',noticeId:\'J_uploadImg0\','; ?>
 url: '<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'FileUpload'), $this);?>
&uploadDir=<?php echo $this->_tpl_vars['objAgentDetail']->iAgentId; ?>
'<?php echo '});

function IsExistSameName(obj)
{
    var strName = obj.value;
    strName.replace(/ /g,"");
    if(strName != "")
    {
'; ?>

        var id = <?php echo $this->_tpl_vars['objAgentDetail']->iAgentId; ?>
;
<?php echo '
        var iExist = $PostData("/?d=Agent&c=Agent&a=IsExistSameName","id="+id+"&strName="+encodeURIComponent(strName));
        if(iExist > 0)
            IM.tip.warn("该代理商名称已经存在！");
    }
}
'; ?>

</script>