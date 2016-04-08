{if $action eq 'more'}
<div class="form_block_hd"><h3 class="ui_title">公司信息</h3><a href="javascript:;" onClick="IM.agent.getInfo({literal}{'action':'less'}{/literal})">收起</a></div>
                <!--S form_block_bd--> 
                <div class="form_block_bd">                      
                        <div class="tf">
                        	<label><em class="require">*</em>联系地址：</label>
                            <div class="inp">
                            <select id="selProvince" class="pri" name="sign_province_id" tabindex="2"></select>
                            <select id="selCity" class="city" name="sign_city_id" tabindex="3"></select>
                            <select id="selArea" class="area" name="sign_area_id" tabindex="4"></select>
                                <input class="detailAddress" type="text" name="sign_address" valid="required"  value="{$arrAgentSourceInfo.address}" tabindex="5" style="vertical-align:top" onfocus="if(this.value=='请输入详细街道地址')this.value='';this.style['color']='#555555'"/>
                            </div>
                            <span class="info">该联系地址为邮寄地址，请仔细填写</span>
                            <span class="ok">&nbsp;</span><span class="err">该联系地址为邮寄地址，请仔细填写</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>邮政编码：</label>
                            <div class="inp"><input class="postcode" type="text" id="sign_postcode" name="sign_postcode" valid="required" maxlength="6" tabindex="6" value="{$arrAgentSourceInfo.postcode}"/></div>
                            <span class="info">请填写公司联系地址所在地的邮政编码</span>
                            <span class="ok">&nbsp;</span><span class="err">请填写公司联系地址所在地的邮政编码</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>注册地区：</label>
                            <div class="inp">
                            <select id="sign_reg_province_id" class="pri" id="sign_reg_province_id" name="sign_reg_province_id" tabindex="2"></select>
                            <select id="sign_reg_city_id" class="city" name="sign_reg_city_id" tabindex="3"></select>
                            <select id="sign_reg_area_id" class="area" name="sign_reg_area_id" tabindex="4" valid="required"></select>
                            </div>
                            <span class="info">请选择注册地区</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择注册地区</span>
						</div>
                        <div class="tf">
                        	<label><em class="require">*</em>法人姓名：</label>
                            <div class="inp"><input valid="required" name="sign_legal_person" id="sign_legal_person" type="text" value="{$arrAgentSourceInfo.legal_person}"/></div>
                            <span class="info">请输入法人姓名</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入法人姓名</span>
						</div>  
                        <div class="tf">
                        	<label><em class="require">*</em>注册资金：</label>
                            <div class="inp">
                            <input valid="required" type="text" name="sign_reg_capital" id="sign_reg_capital" value="{$arrAgentSourceInfo.reg_capital}" />
                            </div>
                            <span class="info">请输入注册资金</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入注册资金</span>
						</div> 
                        <div class="tf">
                        	<label><em class="require">*</em>经营范围：</label>
                            <div class="inp"><textarea cols="50" id="sign_direction" name="sign_direction" valid="required">{$arrAgentSourceInfo.direction}</textarea></div>							
                            <span class="info">限制100字以内</span>
                            <span class="ok">&nbsp;</span><span class="err">限制100字以内</span>
                        </div>
                        <div class="tf">
                        	<label>营业执照注册号：</label>
                            <div class="inp"><input class="LegalPersonName" type="text" name="sign_permit_reg_no" tabindex="7" value="{$arrAgentSourceInfo.permit_reg_no}"/></div>
                            <!--<span class="info">请输入营业执照注册号</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入营业执照注册号</span>-->
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>法人身份证号：</label>
                            <div class="inp"><input class="LegalPersonName" value="{$arrAgentSourceInfo.legal_person_ID}" type="text" name="sign_legal_person_ID" id="sign_legal_person_ID"  valid="required"  tabindex="7"/></div>
                            <span class="info">请输入法人身份证号</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入法人身份证号</span>
						</div>
                        
                        <div class="tf">
                        	<label>企业税号：</label>
                            <div class="inp"><input class="LegalPersonName" type="text" name="sign_revenue_no" tabindex="7" value="{$arrAgentSourceInfo.revenue_no}"/></div>
                            <!--<span class="info">请输入企业税号</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入企业税号</span>-->
                        </div>                                                
                        <div class="tf">
                        	<label><em class="require">*</em>公司规模：</label>
                            <div class="inp">
	                            <select name="sign_company_scale" id="sign_company_scale" valid="required sign_company_scale" tabindex="8">
	                            <option value="0" {if $arrAgentSourceInfo.company_scale eq 0}selected="selected"{/if}>请选择</option>
	                            <option value="1" {if $arrAgentSourceInfo.company_scale eq 1}selected="selected"{/if}>10-50人</option>
	                            <option value="2" {if $arrAgentSourceInfo.company_scale eq 2}selected="selected"{/if}>50-100人</option>
	                            <option value="3" {if $arrAgentSourceInfo.company_scale eq 3}selected="selected"{/if}>100人以上</option>
	                            </select>
                            </div>
                            <span class="info">请选择公司规模</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择公司规模</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>公司销售人数：</label>
                            <div class="inp">
	                            <select name="sign_sales_num" id="sign_sales_num" valid="required sign_sales_num"  tabindex="8">
	                            <option value="0" {if $arrAgentSourceInfo.sales_num eq 0}selected="selected"{/if}>请选择</option>
	                            <option value="1" {if $arrAgentSourceInfo.sales_num eq 1}selected="selected"{/if}>10-50人</option>
	                            <option value="2" {if $arrAgentSourceInfo.sales_num eq 2}selected="selected"{/if}>50-100人</option>
	                            <option value="3" {if $arrAgentSourceInfo.sales_num eq 3}selected="selected"{/if}>100-300人</option>
	                            <option value="4" {if $arrAgentSourceInfo.sales_num eq 4}selected="selected"{/if}>300-600人</option>
	                            <option value="5" {if $arrAgentSourceInfo.sales_num eq 5}selected="selected"{/if}>600-1000人</option>
	                            <option value="6" {if $arrAgentSourceInfo.sales_num eq 6}selected="selected"{/if}>1000人以上</option>
	                            </select>
                            </div>
                            <span class="info">请选择公司销售人数</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择公司销售人数</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>企业客户数：</label>
                            <div class="inp">
	                            <select name="sign_customer_num" id="sign_customer_num" valid="required sign_customer_num"  tabindex="8">
	                            <option value="0" {if $arrAgentSourceInfo.customer_num eq 0}selected="selected"{/if}>请选择</option>
	                            <option value="1" {if $arrAgentSourceInfo.customer_num eq 1}selected="selected"{/if}>100人以下</option>
	                            <option value="2" {if $arrAgentSourceInfo.customer_num eq 2}selected="selected"{/if}>100-300人</option>
	                            <option value="3" {if $arrAgentSourceInfo.customer_num eq 3}selected="selected"{/if}>300-600人</option>
	                            <option value="4" {if $arrAgentSourceInfo.customer_num eq 4}selected="selected"{/if}>600-1000人</option>
	                            <option value="5" {if $arrAgentSourceInfo.customer_num eq 5}selected="selected"{/if}>1000-1500人</option>
	                            <option value="6" {if $arrAgentSourceInfo.customer_num eq 6}selected="selected"{/if}>1500-2000人</option>
	                            <option value="7" {if $arrAgentSourceInfo.customer_num eq 7}selected="selected"{/if}>2000-3000人</option>
	                            <option value="8" {if $arrAgentSourceInfo.customer_num eq 8}selected="selected"{/if}>3000人以上</option>
	                            </select>
                            </div>
                            <span class="info">请选择企业客户数</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择企业客户数</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>互联网电话营销：</label>
                            <div class="inp">
                            <select name="sign_telsales_num" id="sign_telsales_num" valid="required sign_telsales_num"  tabindex="8">
                            <option value="0" {if $arrAgentSourceInfo.telsales_num eq 0}selected="selected"{/if}>请选择</option>
                            <option value="1" {if $arrAgentSourceInfo.telsales_num eq 1}selected="selected"{/if}>10-50人</option>
                            <option value="2" {if $arrAgentSourceInfo.telsales_num eq 2}selected="selected"{/if}>50-100人</option>
                            <option value="3" {if $arrAgentSourceInfo.telsales_num eq 3}selected="selected"{/if}>100-300人</option>
                            <option value="4" {if $arrAgentSourceInfo.telsales_num eq 4}selected="selected"{/if}>300-600人</option>
                            <option value="5" {if $arrAgentSourceInfo.telsales_num eq 5}selected="selected"{/if}>600-1000人</option>
                            <option value="6" {if $arrAgentSourceInfo.telsales_num eq 6}selected="selected"{/if}>1000人以上</option>
                            </select>
                            </div>
                            <span class="info">请选择互联网电话营销</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择互联网电话营销</span>
                        </div>
                        <div class="tf">
                        	<label>客服人数：</label>
                            <div class="inp">
                            <select name="sign_service_num"  tabindex="8">
                            <option value="0" {if $arrAgentSourceInfo.service_num eq 0}selected="selected"{/if}>请选择</option>
                            <option value="1" {if $arrAgentSourceInfo.service_num eq 1}selected="selected"{/if}>1-5人</option>
                            <option value="2" {if $arrAgentSourceInfo.service_num eq 2}selected="selected"{/if}>5-25人</option>
                            <option value="3" {if $arrAgentSourceInfo.service_num eq 3}selected="selected"{/if}>25-60人</option>
                            <option value="4" {if $arrAgentSourceInfo.service_num eq 4}selected="selected"{/if}>60-120人</option>
                            <option value="5" {if $arrAgentSourceInfo.service_num eq 5}selected="selected"{/if}>120-200人</option>
                            <option value="6" {if $arrAgentSourceInfo.service_num eq 6}selected="selected"{/if}>200-400人</option>
                            <option value="7" {if $arrAgentSourceInfo.service_num eq 7}selected="selected"{/if}>400人以上</option>
                            </select>
                            </div>
                        </div>
                        <div class="tf">
                        	<label>售前技术支持：</label>
                            <div class="inp">
                            <select name="sign_tech_num"  tabindex="8">
                            <option value="0" {if $arrAgentSourceInfo.tech_num eq 0}selected="selected"{/if}>请选择</option>
                            <option value="1" {if $arrAgentSourceInfo.tech_num eq 1}selected="selected"{/if}>1-5人</option>
                            <option value="2" {if $arrAgentSourceInfo.tech_num eq 2}selected="selected"{/if}>5-25人</option>
                            <option value="3" {if $arrAgentSourceInfo.tech_num eq 3}selected="selected"{/if}>25-60人</option>
                            <option value="4" {if $arrAgentSourceInfo.tech_num eq 4}selected="selected"{/if}>60人以上</option>
                            </select>
                            </div>
                        </div>
                        
                        <div class="tf">
                        	<label><em class="require">*</em>年销售额：</label>
                            <div class="inp">
                            <select class="turnoverYear" name="sign_annual_sales" id="sign_annual_sales" valid="required sign_annual_sales" tabindex="8">
                            <option value="0" {if $arrAgentSourceInfo.annual_sales eq 0}selected="selected"{/if}>请选择</option>
                            <option value="1" {if $arrAgentSourceInfo.annual_sales eq 1}selected="selected"{/if}>50万以下</option>
                            <option value="2" {if $arrAgentSourceInfo.annual_sales eq 2}selected="selected"{/if}>50-100万</option>
                            <option value="3" {if $arrAgentSourceInfo.annual_sales eq 3}selected="selected"{/if}>100-500万</option>
                            <option value="4" {if $arrAgentSourceInfo.annual_sales eq 4}selected="selected"{/if}>500-1000万</option>
                            <option value="5" {if $arrAgentSourceInfo.annual_sales eq 5}selected="selected"{/if}>1000万以上</option>
                            </select>
                            </div>
                            <span class="info">请选择年销售额</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择年销售额</span>
                        </div>                                                                                             
                        
                        <div class="tf">
                        	<label>资质上传：</label>
                            <div class="inp qua_upload">
                            	<span class="fileBtn">
                                	<input id="J_upload_agent" name="qualifications"  type="file" size="8" width="50px;"/>
                                	<input type="hidden" id="permitJ_upload_agent" name="permitJ_upload_agent"/>
                                </span>			
                                <div id="J_uploadImg_agent" class="img">
                                {if $arrPermit.file_path neq ''}
                                	<img width="200" src="{$arrPermit.file_path}.{$arrPermit.file_ext}">
                                {/if}
                                </div>						
                            </div>
                            <span class="c_info">请上传营业执照。支持的格式为JPG、JPEG、GIF、PNG、BMP，文件大小限制为3M</span>
                            <span class="ok">&nbsp;</span><span class="err">请上传营业执照。支持的格式为JPG、JPEG、GIF、PNG、BMP，文件大小限制为3M</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>注册时间：</label>
                            <div class="inp"><input type="text" class="registeredTime inpDate" name="sign_reg_date" onfocus="WdatePicker()" value="{if $arrAgentSourceInfo.reg_date neq '0000-00-00'}{$arrAgentSourceInfo.reg_date}{/if}" valid="required"/></div>
                            <span class="info">请输入单位注册时间</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入单位注册时间</span>
                        </div>
                        <div class="tf">
                            <label><em class="require">*</em>公司网站：</label>
                            <div class="inp">http://<input type="text" id="website" name="sign_website" valid="required url" value="{$arrAgentSourceInfo.website}"></div>
                                    <span class="info">请输入有效网址 如:www.abc.com</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入有效网址</span>
                         </div>
                </div>
                <!--E form_block_bd-->
                
                <!--S form_block_hd--> 
                <div class="form_block_hd">
                	<h3 class="ui_title">单位负责人基本信息</h3>                    
                </div>
                <!--E form_block_hd--> 
                <!--S form_block_bd--> 
                <div class="form_block_bd" style="padding-bottom:0;">
                		<div class="tf">
                        	<label><em class="require">*</em>负责人姓名：</label>
                            <div class="inp"><input class="principalName" type="text" name="sign_charge_person"  valid="required" value="{$arrAgentSourceInfo.charge_person}"/></div>
                            <span class="info"></span>
                            <span class="ok">&nbsp;</span><span class="err">请如实填写</span>
                        </div>                        
                        <div class="tf">
                        	<label><em class="require">*</em>手机号：</label>
                            <div class="inp"><input class="mPhone" type="text" name="sign_charge_phone" valid="" value="{$arrAgentSourceInfo.charge_phone}"/></div>
                            <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
							<span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
                        </div>
                        <div class="tf">
                        	<label>固定电话：</label>
                            <div class="inp"><input class="fPhone" type="text" name="sign_charge_tel" valid="fPhone" value="{$arrAgentSourceInfo.charge_tel}"/></div>
                            <span class="info" style="display: none;">固话格式:0571-8888888</span>
							<span class="ok">&nbsp;</span><span class="err" style="display: none;">请输入正确固定电话号</span>
                        </div>                        
                        <div class="tf">
                        	<label>传真号码：</label>
                            <div class="inp"><input class="faxPhone" type="text" name="sign_charge_fax" valid="faxPhone" value="{$arrAgentSourceInfo.charge_fax}"/></div>
                            <span class="info">格式：0571-88888888</span>
                            <span class="err">请输入正确传真号码</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>电子邮箱：</label>
                            <div class="inp"><input class="email" type="text" id="sign_charge_email" name="sign_charge_email" valid="required" value="{$arrAgentSourceInfo.charge_email}"/></div>
                            <span class="info">请输入正确邮箱</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入正确邮箱</span>
                        </div>                        
                        <div class="tf">
                        <label><em class="require">*</em>职务：</label>
                            <div class="inp"><input name="sign_charge_positon" type="text" class="office" valid="required"  id="sign_charge_positon" value="{$arrAgentSourceInfo.charge_position}"/></div>
                            <span class="ok">&nbsp;</span><span class="err">请如实填写职务</span>
                        </div>
                        <div class="tf">
                        	<label>MSN：</label>
                            <div class="inp"><input class="MSN" type="text" name="sign_charge_msn" value="{$arrAgentSourceInfo.msn}"/></div>
                        </div>
                        <div class="tf">
                        	<label>QQ：</label>
                            <div class="inp"><input class="QQ" type="text" name="sign_charge_qq" value="{if $arrAgentSourceInfo.charge_qq neq 0}{$arrAgentSourceInfo.charge_qq}{/if}"/></div>
                        </div>                                                
                 </div>
                <!--E form_block_bd--> 

{elseif $action eq 'less'}


		<div class="form_block_hd"><h3 class="ui_title">代理商信息</h3><a href="javascript:;" onClick="IM.agent.getInfo({literal}{'action':'more'}{/literal})">展开</a></div>
		<div class="form_block_bd" style="padding-bottom:0;">                	
                    <div class="tf">
                        <label><em class="require">*</em>联系地址：</label>
                        <div class="inp">
                            <select id="selProvince" class="pri" name="sign_province_id" tabindex="2"></select>
                            <select id="selCity" class="city" name="sign_city_id" tabindex="3"></select>
                            <select id="selArea" class="area" name="sign_area_id" tabindex="4"></select>
                            <input class="detailAddress" type="text" name="sign_address" id="sign_address" valid="required"  value="{$arrAgentSourceInfo.address}" tabindex="5" onfocus="if(this.value=='请输入详细街道地址')this.value='';this.style['color']='#555555'" />
                        </div>
                        <span class="info">请输入详细街道地址</span>
						<span class="ok">&nbsp;</span><span class="err">请输入详细街道地址</span>
                    </div>
					<div class="tf">
                        <label><em class="require">*</em>邮政编码：</label>
                        <div class="inp"><input class="postcode" name="sign_postcode" id="sign_postcode" valid="required" maxlength="6" tabindex="6" type="text" value="{$arrAgentSourceInfo.postcode}"></div>
                        <span class="info">请填写公司联系地址所在地的邮政编码</span>
                        <span class="ok">&nbsp;</span><span class="err">请正确输入邮政编码</span>
					</div>
                    <div class="tf">
                        	<label><em class="require">*</em>注册地区：</label>
                            <div class="inp">
                            <select id="sign_reg_province_id" class="pri" name="sign_reg_province_id" tabindex="2"></select>
                            <select id="sign_reg_city_id" class="city" name="sign_reg_city_id" tabindex="3"></select>
                            <select id="sign_reg_area_id" class="area" name="sign_reg_area_id" tabindex="4" valid="required"></select>
                            </div>
                            <span class="info">请选择注册地区</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择注册地区</span>
					</div>
					<div class="tf">
                        	<label><em class="require">*</em>法人姓名：</label>
                            <div class="inp"><input valid="required" name="sign_legal_person" id="sign_legal_person" type="text" value="{$arrAgentSourceInfo.legal_person}"/></div>
                            <span class="info">请输入法人姓名</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入法人姓名</span>
					</div>
					<div class="tf">
                        	<label><em class="require">*</em>注册资金：</label>
                            <div class="inp">
                            <input valid="required" type="text" name="sign_reg_capital" id="sign_reg_capital" value="{$arrAgentSourceInfo.reg_capital}" />
                            </div>
                            <span class="info">请输入注册资金</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入注册资金</span>
					</div> 
                    <div class="tf">
                        	<label>营业执照注册号：</label>
                            <div class="inp"><input class="LegalPersonName" value="{$arrAgentSourceInfo.permit_reg_no}" type="text" name="sign_permit_reg_no" id="sign_permit_reg_no" tabindex="7"/></div>
                            <!--<span class="info">请输入营业执照注册号</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入营业执照注册号</span>-->
					</div>
                    <div class="tf">
                        	<label><em class="require">*</em>法人身份证号：</label>
                            <div class="inp"><input class="LegalPersonName" value="{$arrAgentSourceInfo.legal_person_ID}" type="text" name="sign_legal_person_ID" id="sign_legal_person_ID"  valid="required"  tabindex="7"/></div>
                            <span class="info">请输入法人身份证号</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入法人身份证号</span>
					</div>
					<div class="tf">
                        	<label>企业税号：</label>
                            <div class="inp"><input class="LegalPersonName" value="{$arrAgentSourceInfo.revenue_no}" type="text" name="sign_revenue_no" id="sign_revenue_no" tabindex="7"/></div>
                            <!--<span class="info">请输入企业税号</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入企业税号</span>-->
					</div>
                    <div class="tf">
                        	<label><em class="require">*</em>负责人姓名：</label>
                            <div class="inp"><input class="principalName" type="text" name="sign_charge_person" id="sign_charge_person" valid="required" value="{$arrAgentSourceInfo.charge_person}"/></div>
                            <span class="info">请如实填写</span>
                            <span class="ok">&nbsp;</span><span class="err">请如实填写</span>
					</div>                        
					<div class="tf">
                        	<label><em class="require">*</em>手机号：</label>
                            <div class="inp"><input class="mPhone" type="text" name="sign_charge_phone" id="sign_charge_phone" valid="mPhone" value="{$arrAgentSourceInfo.charge_phone}"/></div>
                            <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
							<span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
					</div>
					<div class="tf">
                        	<label><em class="require">*</em>固定电话：</label>
                            <div class="inp"><input class="fPhone" type="text" name="sign_charge_tel" id="sign_charge_tel" valid="fPhone" value="{$arrAgentSourceInfo.charge_tel}"/></div>
                            <span class="info" style="display: none;">固话格式:0571-8888888</span>
							<span class="ok">&nbsp;</span><span class="err" style="display: none;">请输入正确固定电话号</span>
					</div> 
                </div>
                <!--E form_block_bd-->
{/if}

<script type="text/javascript">
{literal}
$("#selProvince").BindProvince({{/literal}selCityID:"selCity",selAreaID:"selArea",province_id:"{$arrAgentSourceInfo.province_id}",city_id:"{$arrAgentSourceInfo.city_id}",area_id:"{$arrAgentSourceInfo.area_id}",iAddPleaseSelect:false{literal}});

//代理商注册地区
$("#sign_reg_province_id").BindProvince({{/literal}selCityID:"sign_reg_city_id",selAreaID:"sign_reg_area_id",province_id:"{$arrAgentSourceInfo.reg_province_id}",city_id:"{$arrAgentSourceInfo.reg_city_id}",area_id:"{$arrAgentSourceInfo.reg_area_id}",iAddPleaseSelect:false{literal}});
new IM.upload({id:'J_upload_agent',noticeId:'J_uploadImg_agent',{/literal} url: '{au d="Agent" c="Agent" a="FileUpload"}'{literal}});
{/literal}
</script>