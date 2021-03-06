<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>签约管理<span>&gt;</span>部门签约审核<span>&gt;</span>提交签约</div>
<div class="form_edit">
        	<div class="form_hd">
            	<div class="form_hd_left">
            	<div class="form_hd_right">
                	<div class="form_hd_mid">
                    	<h2>提交签约</h2>
                    </div>
                </div>
                </div>                
                <div class="form_hd_oper">
                    <a class="ui_button ui_button_dis" onclick="PageBack();" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
                </div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
            </div>
            <!--S form_bd--> 
            <div class="form_bd">
            	<form id="J_TiJiaoQYForm" action="" name="TiJiaoQYForm" class="TiJiaoQYForm" style="padding-top:10px;">
				<div class="table_attention" style="margin:0 10px 10px;">
					<span class="ui_link">代理商名称：{$arrAgentSourceInfo.agent_name}</span>
				</div>
            	<div class="form_block_hd"><h3 class="ui_title">合同基本信息</h3></div>
                <!--S form_block_bd-->
                <div class="form_block_bd">                	                
                        <div class="tf">
                        	<label><em class="require">*</em>代理的产品：</label>
                            <div class="inp">
                            {$srtProName}
                            <input type="hidden" name="agentpro" id="agentpro" value="{$arrPactInfo.product_id}" />
                            </div>                            
                            <span class="info"></span>
                            <span class="ok">&nbsp;</span><span class="err"></span>                            
                        </div>
                        <div class="tf">                        	
                        	<label><em class="require">*</em>代理地区范围：</label>
                            <div class="inp">                            	                           
                                <!--S agentArea-->
                            	<div class="agentArea agentAreaBlock">
                                	<div class="hd_agentA"><h4>地区范围</h4> <em style="color:#999">(双击可选取)</em></div>
                                    <div class="bd_agentA">
                                    	<div class="areaLeft">
                                        	<h4>可选地区</h4>
                                            <div class="AllArea">
                                            	<ul class="treeview2" id="J_allArea">
                                                {$areaHTML}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="areaMid">                                            
					                   		<div class="ui_button" onclick="IM.setAreaAgent.add('.treeview2')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">添加&gt;&gt;</div></div></div>
					                   		<div class="ui_button ui_button_dis" onclick="IM.setAreaAgent.del('.treeview2')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">&lt;&lt;移除</div></div></div>
                                        </div>
                                        <div class="areaRight">
                                        	<h4>已选择地区</h4>
                                            <div class="AllArea">
                                            <ul id="Selected" class="treeview2">
                                                {$selectAreaHTML}
                                            </ul>
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                                <!--E agentArea--> 
                                 <input type="hidden" valid="required" name="region" value="{$arrPactInfo.area}" id="J_region">
                    		</div>
                            <span class="info">请选择地区范围</span>
							<span class="ok">&nbsp;</span><span class="err">请选择地区范围</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>代理商等级：</label>
                            <div class="inp">
                            	<select name="agent_level" id="agent_level" valid="required agent_level">
                                <option value="0" {if $arrPactInfo.agent_level eq 0} selected {/if}>无等级</option>
                                <option value="1" {if $arrPactInfo.agent_level eq 1} selected {/if}>金牌</option>
                                <option value="2" {if $arrPactInfo.agent_level eq 2} selected {/if}>银牌</option>
                                </select>
                                <input type="hidden" name="agent_name" id="agent_name" value="{$arrAgentSourceInfo.agent_name}" />
                                <input type="hidden" name="agentId" id="agentId" value="{$arrAgentSourceInfo.agent_id}" />
                                <input type="hidden" name="pactId" id="pactId" value="{$arrPactInfo.aid}" />
                                <input type="hidden" name="channelUserId" id="channelUserId" value="{$arrAgentSourceInfo.channel_uid}" />
                            </div>
                            <span class="info">请选择代理商等级</span>
                        	<span class="ok">&nbsp;</span><span class="err">请选择代理商等级</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>合作模式：</label>
                            <div class="inp">
                            	<select id="J_coopModel" name="agent_mode">
                                <option value="0" {if $arrPactInfo.agent_mode eq 0} selected {/if}>渠道代理</option>
                                <option value="1" {if $arrPactInfo.agent_mode eq 1} selected {/if}>渠道商务</option>
                                </select>
                            </div>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>预存款(￥)：</label>
							<label style="display:none">预存款(￥)：</label>
                            <div class="inp"><input type="text" name="pre_deposit" id="pre_deposit" valid="required amount" value="{$arrPactInfo.pre_deposit}"/></div>
							<span class="info">请输入预存款</span>
                        	<span class="ok">&nbsp;</span><span class="err">请输入预存款</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>保证金(￥)：</label>
                            <div class="inp"><input type="text" name="cash_deposit" id="cash_deposit" valid="required amount" value="{$arrPactInfo.cash_deposit}"/></div>
                            <span class="info">请输入保证金</span>
                        	<span class="ok">&nbsp;</span><span class="err">请输入保证金</span>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>合同有效期限：</label>
                            <div class="inp">
                                <input type="hidden" id="sdate" name="sdate" value="{$arrPactInfo.pact_sdate}" />
                                <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'sdate\')}'}{/literal})" name="pact_sdate" class="inpCommon inpDate" id="J_editTimeS1"  valid="required" value="{$arrPactInfo.pact_sdate}"> 至
                                <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS1\')}'}{/literal})" name="pact_edate" class="inpCommon inpDate" id="J_editTimeE1" valid="required" value="{$arrPactInfo.pact_edate}">
                            </div>	
                            <span class="info">请输入合同有效期限</span>
                        	<span class="ok">&nbsp;</span><span class="err">请输入合同有效期限</span>				
                    </div>                                                                        
                </div>
                <!--E form_block_bd-->
                <div class="form_block_hd"><h3 class="ui_title">代理商资质</h3></div>
				<div class="form_block_bd" style="padding-bottom:0;">
                	<div class="tf">
                        <label style="width:120px;"><em class="require">*</em>营业执照：</label>
                        <div class="inp qua_upload">
                            <div class="fileBtn">
                            <input width="50px;" type="file" size="8" name="qualifications" class="qualifications" id="J_upload0">
                            <input type="hidden" id="permitJ_upload0" name="permitJ_upload0" {if $permitOne neq ''} value="{$permitOne}" {/if} {if $permitOne eq ''} valid="required" {/if}/>
                            </div>	
                            <div style="display:block" class="img" id="J_uploadImg0">
                            {if $permitOne neq ''}
                            	<img width="200" src="{$permitOne}">
                            {/if}
                            </div>
                            
                        </div>
                        <span class="info" style="display:inline">支持的格式为JPG、JPEG、GIF、PNG、BMP，文件大小限制为3M</span>
                        <span class="ok">&nbsp;</span><span class="err">请上传营业执照</span>
                    </div>
                    <div class="tf">
                        <label style="width:120px;"><em class="require">*</em>税务登记证：</label>
                        <div class="inp qua_upload">
                            <div class="fileBtn"><input width="50px;" type="file" size="8" name="qualifications" class="qualifications" id="J_upload1">
                            <input type="hidden" id="permitJ_upload1" name="permitJ_upload1" {if $permitTwo neq ''} value="{$permitTwo}" {/if} {if $permitTwo eq ''} valid="required" {/if}/>
                            </div>	
                            <div style="display:block" class="img" id="J_uploadImg1">
                            {if $permitTwo neq ''}
                            	<img width="200" src="{$permitTwo}">
                            {/if}
                            </div>
                            
                        </div>
                        <span class="info">请上传税务登记证</span>
                        <span class="ok">&nbsp;</span><span class="err">请上传税务登记证</span>
                    </div>
                    <div class="tf">
                        <label style="width:120px;"><em class="require">*</em>法人身份证：</label>
                        <div class="inp qua_upload">
                            <div class="fileBtn"><input width="50px;" type="file" size="8" name="qualifications" class="qualifications" id="J_upload2">
                            <input type="hidden" id="permitJ_upload2" name="permitJ_upload2" {if $permitThree neq ''} value="{$permitThree}" {/if} {if $permitThree eq ''} valid="required" {/if}/>
                            </div>	
                            <div style="display:block" class="img" id="J_uploadImg2">
                            {if $permitThree neq ''}
                            	<img width="200" src="{$permitThree}">
                            {/if}
                            </div>
                            
                        </div>
                        <span class="info">请上传法人身份证</span>
                        <span class="ok">&nbsp;</span><span class="err">请上传法人身份证</span>
                    </div>
                    <div class="tf">
                        <label style="width:120px;"><em class="require">*</em>组织机构代码证：</label>
                        <div class="inp qua_upload">
                            <div class="fileBtn"><input width="50px;" type="file" size="8" name="qualifications" class="qualifications" id="J_upload3">
                            <input type="hidden" id="permitJ_upload3" name="permitJ_upload3" {if $permitFour neq ''} value="{$permitFour}" {/if} {if $permitFour eq ''} valid="required" {/if}/>
                            </div>	
                            <div style="display:block" class="img" id="J_uploadImg3">
                            {if $permitFour neq ''}
                            	<img width="200" src="{$permitFour}">
                            {/if}
                            </div>
                            
                        </div>
                        <span class="info">请上传组织机构代码证</span>
                        <span class="ok">&nbsp;</span><span class="err">请上传组织机构代码证</span>
                    </div>
                    <div class="tf">
                        <label style="width:120px;">一般纳税人资格证：</label>
                        <div class="inp qua_upload">
                            <div class="fileBtn"><input width="50px;" type="file" size="8" name="qualifications" class="qualifications" id="J_upload4">
                            <input type="hidden" id="permitJ_upload4" name="permitJ_upload4" {if $permitFive neq ''} value="{$permitFive}" {/if} />
                            </div>	
                            <div style="display:block" class="img" id="J_uploadImg4">
                            {if $permitFive neq ''}
                            	<img width="200" src="{$permitFive}">
                            {/if}
                            </div>
                        </div>
                        <span class="info">一般纳税人资格证</span>
                        <span class="ok">&nbsp;</span><span class="err">一般纳税人资格证</span>
                    </div>
                </div>
                <!------------------------------------------------S 代理商信息--------------------------------------------------->
                <div id="agentInfoMore">
                <div class="form_block_hd"><h3 class="ui_title">代理商信息</h3><a href="javascript:;" onClick="IM.agent.getInfo({literal}{'action':'more'}{/literal})">展开</a></div>
                <div class="form_block_bd" style="padding-bottom:0;">                	
                    <div class="tf">
                        <label><em class="require">*</em>联系地址：</label>
                        <div class="inp">
                            <select id="selProvince" class="pri" name="sign_province_id" tabindex="2"></select>
                            <select id="selCity" class="city" name="sign_city_id" tabindex="3"></select>
                            <select id="selArea" class="area" name="sign_area_id" tabindex="4"></select>
                            <input class="detailAddress" type="text" name="sign_address" id="sign_address" valid="required"  value="{$arrAgentSourceInfo.address}" tabindex="5" onfocus="if(this.value=='请输入详细街道地址')this.value='';this.style['color']='#555555'"/>
                        </div>
                        <span class="info">该联系地址为邮寄地址，请仔细填写</span>
						<span class="ok">&nbsp;</span><span class="err">该联系地址为邮寄地址，请仔细填写</span>
                    </div>
					<div class="tf">
                        <label><em class="require">*</em>邮政编码：</label>
                        <div class="inp"><input class="postcode" name="sign_postcode" id="sign_postcode" valid="required" maxlength="6" tabindex="6" type="text" value="{$arrAgentSourceInfo.postcode}"></div>
                        <span class="info">请填写公司联系地址所在地的邮政编码</span>
                        <span class="ok">&nbsp;</span><span class="err">请填写公司联系地址所在地的邮政编码</span>
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
                            <div class="inp"><input class="LegalPersonName" value="{$arrAgentSourceInfo.permit_reg_no}" type="text" name="sign_permit_reg_no" id="sign_permit_reg_no"  valid=""  tabindex="7"/></div>
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
                            <div class="inp"><input class="LegalPersonName" value="{$arrAgentSourceInfo.revenue_no}" type="text" name="sign_revenue_no" id="sign_revenue_no"  valid=""  tabindex="7"/></div>
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
                </div>                
                
                <div class="form_block_ft">
                	<div class="agentAuditBlock" style="margin:0;">
                        <div class="tf">
                                <label><em class="require">*</em>考察小记：</label>
                                <div class="inp"><textarea id="pact_remark" class="" name="pact_remark" valid="required ">{$arrPactInfo.pact_remark}</textarea></div>
                                <span class="info">请输入考察小记</span>

                                <span class="ok">&nbsp;</span><span class="err">请输入考察小记</span>
                        </div>
                        <div class="tf tf_submit">
                        	<label>&nbsp;</label>
                            <div class="inp">
                            	<input type="hidden" value="0" id="subtype" name="subtype">
                            	<div class="ui_button" style="margin-right:10px;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text"><button type="submit" name="submitNext" style="background:none; color:#fff;" onclick="$('#subtype').val(0);">提交并保存</button></div></div></div>
                                <div class="ui_button" style="margin-right:10px;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text"><button type="submit" name="submit"  style="background:none; color:#fff;" onclick="$('#subtype').val(1);">保 存</button></div></div></div>
                                <div class="ui_button ui_button_dis" onclick="PageBack();"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">取 消</div></div></div>
                            </div>
                    	</div>
                    </div>                    
                </div>
            	</form>
        	</div> 
            <!--E form_bd-->     
        </div>
<script>
{literal}
(function(){
		var J_allArea=$(".treeview2");
		J_allArea.treeview2();
		J_allArea.unbind('click').bind('click',function(e){
            var target=MM.E(e).target;
	        if(target.tagName=='A'){
	            $(target).parents(".treeview2").find('a').removeClass('cur');
				$(target).toggleClass('cur');
	        }
		}).unbind('dblclick').bind('dblclick',function(e){
			var target=MM.E(e).target;
			if(target.tagName=='A') IM.setAreaAgent.add('.treeview2',target);
		});
})();
/**
*获取代理商更多信息
*/
IM.agent.getInfo=function(data){
	data=data||{};
	{/literal}
	var agentId = '{$arrAgentSourceInfo.agent_id}';
	{literal}	
	MM.get('/?d=Agent&c=AgentMove&a=getAgentMore&agentId='+agentId,data,function(q){
		$('#agentInfoMore').html(q);
		/**
		*重新绑定 提交签约 表单事件
		*/
		addTiJiaoQYFormEventListener();
	});
}
/**
*绑定 提交签约 表单事件
*/
addTiJiaoQYFormEventListener();

//验证预存款 保证金
IM.AmountHandler($('#pre_deposit')[0]);
IM.AmountHandler($('#cash_deposit')[0]);

/**
*提交签约 表单事件处理
*/
var _InDealWith = false;
function addTiJiaoQYFormEventListener(){
	new Reg.vf($('#J_TiJiaoQYForm'),{
	extValid:{
		agent_level:function(){return MM.getVal(MM.G('agent_level')).text!='无等级'}
	},
	callback:function(formdata){////formdata 表单提交数据 对象数组格式
    	//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
        
		if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
		if($('#agent_level').val()==0)
		{
			IM.tip.warn('请选择代理商等级！');return false;
		}
        
        var sign_direction = document.getElementById("sign_direction");
        if(sign_direction != undefined || sign_direction != null)
        {
            if(sign_direction.value == "")
            {
                IM.tip.warn('请填写经营范围！');return false;
            }
            
            if(document.getElementById("sign_company_scale").value == "0")
            {
                IM.tip.warn('请选择公司规模！');return false;
            }
            
            if(document.getElementById("sign_sales_num").value == "0")
            {
                IM.tip.warn('请选择公司销售人数！');return false;
            }
            
            if(document.getElementById("sign_customer_num").value == "0")
            {
                IM.tip.warn('请选择企业客户数！');return false;
            }
            
            if(document.getElementById("sign_telsales_num").value == "0")
            {
                IM.tip.warn('请选择互联网电话营销人数！');return false;
            }
            
            if(document.getElementById("sign_annual_sales").value == "0")
            {
                IM.tip.warn('请选择年销售额！');return false;
            }            
        }
        
		var signData = $('#J_TiJiaoQYForm').serialize();
		var productIds = $.trim($('#agentpro').val());
		if(productIds == '')
		{
			IM.tip.warn('请选择代理产品！');
			return false;
		}
        _InDealWith = true;
		MM.ajax({
			url:'/?d=Agent&c=AgentMove&a=editRenewal',
			data:signData+'&product_id='+productIds,
			success:function(q){
				q=MM.json(q);
				if(q.success){
					JumpPage('/?d=Agent&c=AgentMove&a=MySignIndex');
					IM.dialog.hide();
					IM.tip.show(q.msg);
                    _InDealWith = false;				
				}else{
					IM.tip.warn(q.msg);
                    _InDealWith = false;
				}
			}
		});
	}});
}

/**
*合作模式 change处理
*/
(function(){
	var coopModel=MM.G('J_coopModel'),
		parentTF=coopModel.parentNode.parentNode;
		nextTF=MM.next(parentTF),
		labels=nextTF.getElementsByTagName('label'),
		input=nextTF.getElementsByTagName('input')[0];
	MM.EA(coopModel,'change',function(e){
		var target=MM.E(e).target;
		if(target.tagName=='SELECT'){
			var value=MM.getVal(target).value;
			if(value==0){
				MM.show(labels[0]);
				MM.hide(labels[1]);
				MM.A(input,'valid','required amount');
			}else if(value==1){
				MM.show(labels[1]);
				MM.hide(labels[0]);
				MM.A(input,'valid','amount');
				$(nextTF).find('span').hide();
			}
		}
		addTiJiaoQYFormEventListener();
	});
})();

$("#selProvince").BindProvince({{/literal}selCityID:"selCity",selAreaID:"selArea",province_id:"{$arrAgentSourceInfo.province_id}",city_id:"{$arrAgentSourceInfo.city_id}",area_id:"{$arrAgentSourceInfo.area_id}",iAddPleaseSelect:false{literal}});
//代理商注册地区
$("#sign_reg_province_id").BindProvince({{/literal}selCityID:"sign_reg_city_id",selAreaID:"sign_reg_area_id",province_id:"{$arrAgentSourceInfo.reg_province_id}",city_id:"{$arrAgentSourceInfo.reg_city_id}",area_id:"{$arrAgentSourceInfo.reg_area_id}",iAddPleaseSelect:false{literal}});
//代理商资质上传
new IM.upload({id:'J_upload0',noticeId:'J_uploadImg0',{/literal} url: '{au d="Agent" c="Agent" a="FileUpload"}&uploadDir={$arrAgentSourceInfo.agent_id}'{literal}});
new IM.upload({id:'J_upload1',noticeId:'J_uploadImg1',{/literal} url: '{au d="Agent" c="Agent" a="FileUpload"}&uploadDir={$arrAgentSourceInfo.agent_id}'{literal}});
new IM.upload({id:'J_upload2',noticeId:'J_uploadImg2',{/literal} url: '{au d="Agent" c="Agent" a="FileUpload"}&uploadDir={$arrAgentSourceInfo.agent_id}'{literal}});
new IM.upload({id:'J_upload3',noticeId:'J_uploadImg3',{/literal} url: '{au d="Agent" c="Agent" a="FileUpload"}&uploadDir={$arrAgentSourceInfo.agent_id}'{literal}});
new IM.upload({id:'J_upload4',noticeId:'J_uploadImg4',{/literal} url: '{au d="Agent" c="Agent" a="FileUpload"}&uploadDir={$arrAgentSourceInfo.agent_id}'{literal}});
{/literal}
</script>