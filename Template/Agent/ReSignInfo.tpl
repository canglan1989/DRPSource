
<!--<script type="text/javascript" src="{$JS}calendar/WdatePicker.js" defer="true"></script>
<script type="text/javascript" src="../resource/js/im.js"></script>-->
    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>我的签约<span>&gt;</span>签约信息提交</div>
    <!--E crumbs-->
    <!--S table_filter-->
    <!--    <div class="table_filter marginBottom10">
	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
	    <div class="table_attention">
		    <label>提醒：</label>
		    <span class="ui_link"><a href="javascript:;">未处理：</a>(1)</span>
		    <span class="ui_link"><a href="javascript:;">已签约：</a>(1)</span>
		    <span class="ui_link"><a href="javascript:;">签约失败：</a>(1)</span>
		    <span class="ui_link"><a href="javascript:;">解除签约：</a>(1)</span>
	    </div>
		<div id="J_table_filter_main" class="table_filter_main">
		    <div class="ui_title">单位：</div>
		    <div class="ui_text"><input class="inpCommon" type="text" name="companyName" style="vertical-align:top;"/></div>
		    <div class="ui_title">地区：</div>
		    <div class="ui_comboBox" style="margin-right:5px;"><select class="pri" name="pri"></select></div>
		    <div class="ui_comboBox" style="margin-right:5px;"><select class="city" name="city"></select></div>
		    <div class="ui_comboBox"><select class="area" name="area"></select></div>
		    <div class="ui_title">审核状态：</div>
		    <div class="ui_comboBox"><select name="auditState"><option>全部</option></select></div>
		    <div class="ui_button"><span class="ui_button_left"></span><button type="submit" class="ui_button_inner">搜 索</button></div>
		</div>
	</form>
	</div>-->
    <!--E table_filter-->
    <form id="SignInfo_Form" action="{au d='Agent' c='AgentMove' a='addSignInfo'}" name="SignInfo_Form" class="QYForm" method="post" enctype="multipart/form-data">
	<!--S form_edit-->
	<div class="form_edit">
        <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>提交签约信息</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
		</div>
	    <!--S form_bd-->
	    <div class="form_bd">
		    <div class="form_block_hd">
			<h3 class="ui_title">单位信息</h3>
		    </div>
		    <!--S form_block_bd-->
		    <div class="form_block_bd">
			<div class="blockLeft">
			    <div class="tf">
				<label><em class="require">*</em>公司名称：</label>
				<div class="inp">{$arrAgentSourceInfo.agent_name}</div>
				<input type="hidden" value="{$arrAgentSourceInfo.agent_name}" name="AgentName" />
				<input type="hidden" value="{$arrAgentSourceInfo.agent_id}" name="AgentID">
				<input type="hidden" value="{$arrAgentSourceInfo.check_time}" name="checktime">
				<input type="hidden" value="{$arrAgentSourceInfo.check_uid}" name="checkUid">
			    </div>
			    <div class="tf">
				<label><em class="require">*</em>注册地址：</label>
				<div class="inp">{$area.area_fullname}{$arrAgentSourceInfo.address}</div>
				<input type="hidden" value="{$arrAgentSourceInfo.address}" name="Address" />
				<input type="hidden" value="{$arrAgentSourceInfo.province_id}" name="ProvinceID">
				<input type="hidden" value="{$arrAgentSourceInfo.city_id}" name="CityID">
				<input type="hidden" value="{$arrAgentSourceInfo.area_id}" name="AreaID">
			    </div>
			    <div class="tf">
				<label>邮政编码：</label>
				<div class="inp">{$arrAgentSourceInfo.postcode}</div>
				<input type="hidden" value="{$arrAgentSourceInfo.postcode}" name="Postcode" />
			    </div>
			    <div class="tf">
				<label><em class="require">*</em>法人姓名：</label>
				<div class="inp">{$arrAgentSourceInfo.legal_person}</div>
				<input type="hidden" value="{$arrAgentSourceInfo.legal_person}" name="LegalPerson" />
			    </div>
			    <div class="tf">
				<label><em class="require">*</em>注册资金：</label>
				<div class="inp">
				{if $arrAgentSourceInfo.reg_capital eq 1}10-50万{/if}
			    {if $arrAgentSourceInfo.reg_capital eq 2}50-100万{/if}
			{if $arrAgentSourceInfo.reg_capital eq 3}100-200万{/if}
		    {if $arrAgentSourceInfo.reg_capital eq 4}200-500万{/if}
		{if $arrAgentSourceInfo.reg_capital eq 5}500万以上{/if}
	    </div>
	    <input type="hidden" value="{$arrAgentSourceInfo.reg_capital}" name="RegCapital" />
	</div>
	<div class="tf">
	    <label>公司注册时间：</label>
	    <div class="inp">{$arrAgentSourceInfo.reg_date}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.reg_date}" name="RegDate" />
	</div>
	<div class="tf">
	    <label>公司规模：</label>
	    <div class="inp">
	    {if $arrAgentSourceInfo.reg_capital eq 1}10-50人{/if}
	{if $arrAgentSourceInfo.reg_capital eq 2}50-100人{/if}
    {if $arrAgentSourceInfo.reg_capital eq 3}100人以上{/if}
</div>
<input type="hidden" value="{$arrAgentSourceInfo.reg_capital}" name="CompanyScale" />
</div>
</div>
<div class="blockRight">
    <div class="tf">
	<label>公司销售：</label>
	<div class="inp">
	{if $arrAgentSourceInfo.sales_num eq 1}10-50人{/if}
    {if $arrAgentSourceInfo.sales_num eq 2}50-100人{/if}
{if $arrAgentSourceInfo.sales_num eq 3}100人以上{/if}
</div>
<input type="hidden" value="{$arrAgentSourceInfo.sales_num}" name="SalesNum" />
</div>
<div class="tf">
    <label>电话营销：</label>
    <div class="inp">
    {if $arrAgentSourceInfo.telsales_num eq 1}10-50人{/if}
{if $arrAgentSourceInfo.telsales_num eq 2}50-100人{/if}
{if $arrAgentSourceInfo.telsales_num eq 3}100人以上{/if}
</div>
<input type="hidden" value="{$arrAgentSourceInfo.telsales_num}" name="TelsalesNum" />
</div>
<div class="tf">
    <label>售前技术：</label>
    <div class="inp">
    {if $arrAgentSourceInfo.tech_num eq 1}5-5人{/if}
{if $arrAgentSourceInfo.tech_num eq 2}5-25人{/if}
{if $arrAgentSourceInfo.tech_num eq 3}25-60人{/if}
{if $arrAgentSourceInfo.tech_num eq 4}60人以上{/if}
</div>
<input type="hidden" value="{$arrAgentSourceInfo.tech_num}" name="TechNum" />
</div>
<div class="tf">
    <label>客服：</label>
    <div class="inp">
    {if $arrAgentSourceInfo.service_num eq 1}5-5人{/if}
{if $arrAgentSourceInfo.service_num eq 2}5-25人{/if}
{if $arrAgentSourceInfo.service_num eq 3}25-60人{/if}
{if $arrAgentSourceInfo.service_num eq 4}60人以上{/if}
</div>
<input type="hidden" value="{$arrAgentSourceInfo.service_num}" name="ServiceNum" />
</div>
<div class="tf">
    <label>企业客户：</label>
    <div class="inp">
    {if $arrAgentSourceInfo.customer_num eq 1}500人以下{/if}
{if $arrAgentSourceInfo.customer_num eq 2}500-2000人{/if}
{if $arrAgentSourceInfo.customer_num eq 3}2000人以上{/if}
</div>
<input type="hidden" value="{$arrAgentSourceInfo.strCustomerNum}" name="CustomerNum" />
</div>
<div class="tf">
    <label>年销售额：</label>
    <div class="inp">
    {if $arrAgentSourceInfo.annual_sales eq 1}50万以下{/if}
{if $arrAgentSourceInfo.annual_sales eq 2}50-100万{/if}
{if $arrAgentSourceInfo.annual_sales eq 3}100-200万{/if}
{if $arrAgentSourceInfo.annual_sales eq 4}200-500万{/if}
{if $arrAgentSourceInfo.annual_sales eq 5}1000万以上{/if}
</div>
<input type="hidden" value="{$arrAgentSourceInfo.annual_sales}" name="AnnualSales" />
</div>
<div class="tf">
    <label>企业方向：</label>
    <div class="inp">{$arrAgentSourceInfo.direction}</div>
    <input type="hidden" value="{$arrAgentSourceInfo.direction}" name="Direction" />
</div>
</div>
<div class="tf">
    <label>资质上传：</label>
    <div class="inp qua_upload">
	{if $permit.permit_name neq ""}
	    <span>{$permit.permit_name}.{$permit.file_ext}<a href="javascript:;" onClick="IM.Toggle('.qua_upload .img',this,'查看','收起')">查看</a></span>
	    <span class="img">
		<img src="{$permit.file_path}"/>
	    </span>
	{else}
	    <span>还未上传资质</span>
	{/if}
    </div>
</div>
</div>
<!--E form_block_bd-->

<!--S form_block_hd-->
<div class="form_block_hd">
    <h3 class="ui_title">负责人信息</h3>
</div>
<!--E form_block_hd-->
<!--S form_block_bd-->
<div class="form_block_bd">
    <div class="blockLeft">
	<div class="tf">
	    <label><em class="require">*</em>负责人：</label>
	    <div class="inp">{$arrAgentSourceInfo.charge_person}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.charge_person}" name="ChargePerson">
	</div>
	<div class="tf">
	    <label><em class="require">*</em>手机号：</label>
	    <div class="inp">{$arrAgentSourceInfo.charge_phone}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.charge_phone}" name="ChargePhone" />
	</div>
	<div class="tf">
	    <label>固定电话：</label>
	    <div class="inp">{$arrAgentSourceInfo.charge_tel}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.charge_tel}" name="ChargeTel" />
	</div>
	<div class="tf">
	    <label>传真号码：</label>
	    <div class="inp">{$arrAgentSourceInfo.charge_fax}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.charge_fax}" name="ChagreFax" />
	</div>
    </div>
    <div class="blockRight">
	<div class="tf">
	    <label>电子邮件：</label>
	    <div class="inp">{$arrAgentSourceInfo.charge_email}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.charge_email}" name="ChargeEmail" />
	</div>
	<div class="tf">
	    <label>职务：</label>
	    <div class="inp">{$arrAgentSourceInfo.charge_positon}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.charge_positon}" name="ChargePositon" />
	</div>
	<div class="tf">
	    <label>MSN：</label>
	    <div class="inp">{$arrAgentSourceInfo.charge_msn}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.charge_msn}" name="ChargeMsn" />
	</div>
	<div class="tf">
	    <label>QQ：</label>
	    <div class="inp">{if $arrAgentSourceInfo.charge_qq eq 0}{else}{$arrAgentSourceInfo.charge_qq}{/if}</div>
	    <input type="hidden" value="{$arrAgentSourceInfo.charge_qq}" name="ChargeQq" />
	</div>
    </div>
</div>
<!--E form_block_bd-->
<div class="form_block_hd">
    <h3 class="ui_title">签约信息</h3>
</div>
<!--S form_block_bd-->
<div class="form_block_bd">
    <div class="tf">
	<label><em class="require">*</em>代理的产品：</label>
	<div class="inp">
	    <select class="agentPro" name="agentProID">
		{foreach from=$arrProductType item=type}
		    <option value="{$type.aid}">{$type.product_type_name}
		    {/foreach}
	    </select>
	</div>
    </div>
    <div class="tf">
	<label><em class="require">*</em>代理等级：</label>
	<div class="inp">
	    <select class="agentLevel" name="agentLevel">
		<option value="0">无等级</option>
		<option value="1">金牌</option>
		<option value="2">银牌</option>
	    </select>
	</div>
    </div>
    <div class="tf">	
	<label><em class="require">*</em>地区范围：</label>
	<div class="inp">
	    <div id="agentAreaResult" class="agentAreaResult"></div>
	    <div class="ui_button areaTrigger_button"><div class="ui_button_left"></div><button type="button" class="ui_button_inner" onclick="IM.area.toggle(this)">选择地区</button></div>
	    <!--S agentArea-->
	    <div class="agentArea agentAreaBlock">
		<div class="hd_agentA"><h4>地区范围</h4><a href="javascript:;" onclick="IM.area.hide(this)">关闭</a></div>
		<div class="bd_agentA">
		    <div class="areaLeft">
			<h4>可选地区</h4>
			<div class="AllArea">
			    <ul id="J_allArea" class="treeview">
				{$areaHTML}
			    </ul>
			</div>
		    </div>
		    <div class="areaMid">
	                   <div class="ui_button" onclick="IM.area.addArea('#J_allArea','.SelectArea')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">添加&gt;&gt;</div></div></div>
	                   <div class="ui_button ui_button_dis" onclick="IM.area.moveArea('.SelectArea','#J_allArea')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">&lt;&lt;移除</div></div></div>

		    </div>
		    <div class="areaRight">
			<h4>已选择地区</h4>
			<select class="SelectArea" ondblclick="IM.area.moveArea('.SelectArea','#J_allArea')" size="15" name="SelectArea"></select>
		    </div>
		</div>
		<div class="ft_agentA">
					<div class="ui_button" onclick="IM.area.okArea(this)" style="margin-right:10px;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">确定</div></div></div>
		                        <div class="ui_button ui_button_dis" onclick="IM.area.hide(this)"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">取消</div></div></div>   
		</div>
	    </div>
	    <!--E agentArea-->
	    <input id="J_region" type="hidden" value="" name="region" valid="required"/>
	</div>
	<span class="info">请选择地区范围</span>
	<span class="ok">&nbsp;</span><span class="err">请选择地区范围</span>
    </div>
    <div class="tf">
	<label><em class="require">*</em>营业执照：</label>
	<div class="inp qua_upload">
	    <div class="fileBtn">
			<input width="50px;" type="file" size="8" name="营业执照"  class="qualifications">
			<input type="hidden" id="permitJ_upload_agent" name="permitJ_upload_agent" valid="required"/>
	    </div>
	</div>
	<span class="c_info">请上传营业执照。支持的格式为JPG、JPEG、GIF、PNG、BMP，文件大小限制为3M</span>
	<span class="ok">&nbsp;</span><span class="err">请上传营业执照。支持的格式为JPG、JPEG、GIF、PNG、BMP，文件大小限制为3M</span>
    </div>
    <div class="tf">
	<label>纳税人资格证书：</label>
	<div class="inp qua_upload">
	    <span class="fileBtn">
			<input width="50px;" type="file" size="8" name="纳税人资格证书" valid="" class="qualifications">
	    </span>
	</div>
    </div>
    <div class="tf">
	<label>税务登记证：</label>
	<div class="inp qua_upload">
	    <span class="fileBtn">
		<input width="50px;" type="file" size="8" name="税务登记证" valid="" class="qualifications">
	    </span>
	</div>
    </div>
    <div class="tf">
	<label>法人身份证：</label>
	<div class="inp qua_upload">
	    <span class="fileBtn">
		<input width="50px;" type="file" size="8" name="法人身份证" valid="" class="qualifications">
	    </span>
	</div>
    </div>
    <div class="tf">
	<label><em class="require">*</em>合同有效期限：</label>
	<div class="inp">
	    <input id="J_editTimeS" class="inpCommon inpDate" valid="required" name="pact_sdate" onclick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'})" type="text"> 至
	    <input id="J_editTimeE" class="inpCommon inpDate" valid="required" name="pact_edate" onclick="WdatePicker({minDate:'#F{$dp.$D(\'J_editTimeS\')}'})" type="text">{/literal}
	</div>
	<span class="info">请输入合同有效期限</span>
	<span class="ok">&nbsp;</span><span class="err">请输入合同有效期限</span>
    </div>
</div>
<!--E form_block_bd-->

<!--S form_block_hd-->
<div class="form_block_hd">
    <h3 class="ui_title">单位基本信息</h3>
</div>
<!--E form_block_hd-->
<!--S form_block_bd-->
<div class="form_block_bd">
    <div class="tf">
	<label><em class="require">*</em>公司名称：</label>
	<div class="inp"><input class="companyName" type="text" name="companyName"   value="{$arrAgentSourceInfo.agent_name}" readonly/></div>
	<span class="info">请正确输入公司名</span>
	<span class="ok">&nbsp;</span><span class="err">请正确输入公司名</span>
    </div>
    <div class="tf">
	<label><em class="require">*</em>地区：</label>
	<div class="inp">
	    <select id="selProvince" class="pri" name="pri" tabindex="2" disabled ></select>
	    <select id="selCity" class="city" name="city" tabindex="3" disabled ></select>
	    <select id="selArea" class="area" name="area" tabindex="4" disabled ></select>
	    <input class="detailAddress" type="text" name="detailAddress" valid="required detailAddress"  value="{$arrAgentSourceInfo.address}" tabindex="5" onfocus="if(this.value=='请输入详细街道地址')this.value='';this.style['color']='#555555'" readonly/>
	</div>
	<span class="info">请输入详细街道地址</span>
	<span class="ok">&nbsp;</span><span class="err">请输入详细街道地址</span>
    </div>
    <div class="tf">
	<label>邮政编码：</label>
	<div class="inp"><input class="postcode" type="text" name="postcode" valid="postcode" value="{$arrAgentSourceInfo.postcode}" /></div>
	<span class="info"></span>
	<span class="ok">&nbsp;</span><span class="err"></span>
    </div>
    <div class="tf">
	<label><em class="require">*</em>法人姓名：</label>
	<div class="inp"><input class="LegalPersonName" type="text" name="LegalPersonName"  valid="required LegalPersonName"  tabindex="7" value="{$arrAgentSourceInfo.legal_person}" readonly/></div>
	<span class="info">请按照营业执照上的名称填写</span>
	<span class="ok">&nbsp;</span><span class="err">请按照营业执照上的名称填写</span>
    </div>
    <div class="tf">
	<label><em class="require">*</em>注册资金：</label>
	<div class="inp">
	    <select name="registeredCapital"  tabindex="8" disabled>
		<option {if $arrAgentSourceInfo.strRegCapital eq 1}select{/if}>10-50万</option>
		<option {if $arrAgentSourceInfo.strRegCapital eq 2}select{/if}>50-100万</option>
		<option {if $arrAgentSourceInfo.strRegCapital eq 3}select{/if}>100-200万</option>
		<option {if $arrAgentSourceInfo.strRegCapital eq 4}select{/if}>200-500万</option>
		<option {if $arrAgentSourceInfo.strRegCapital eq 5}select{/if}>500万以上</option>
	    </select>
	</div>
    </div>
</div>
<!--E form_block_bd-->
<!--S form_block_ft-->
<div class="form_block_ft">
    <div class="agentAuditBlock">
	<div class="tf">
	    <label>考察小记：</label>
	    <div class="inp"><textarea name="pact_remark" class="" valid="businessPosition"></textarea></div>
	    <span class="info">限制100字以内</span>
	    <span class="ok">&nbsp;</span><span class="err">限制100字以内</span>
	</div>
    </div>
    <div class="tf tf_submit">
	<label>&nbsp;</label>
	<div class="inp">
	    <div class="ui_button ui_button_confirm"><button type="submit" id="addSignInfo" class="ui_button_inner" >提交</button></div>
	    <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="PageBack()">取消</a></div>
	</div>
    </div>
</div>
<!--E form_block_ft-->
</form>
</div>
<!--E form_bd-->
</div>
<!--E form_edit-->
{literal}
    <script type="text/javascript">

    new Reg.vf($('#SignInfo_Form'),{extValid:{}});

    (function(){
    //    {/literal}
	/*===========================================*/
	    setTimeout(function(){
		    var J_allArea=$("#J_allArea");
		    J_allArea.treeview();
		    J_allArea.live('click',function(e){
				var target=MM.E(e).target;
				if(target.tagName=='A'){
				    $("#J_allArea a").removeClass('cur');
				    $(target).addClass('cur');
				}
		    }).live('dblclick',function(e){
			    var target=MM.E(e).target;
			    if(target.tagName=='A')
			    IM.area.addArea('#J_allArea','.SelectArea')
		    });
	    },500);
    })();

    $("#selProvince").BindProvince({{/literal}selCityID:"selCity",selAreaID:"selArea",province_id:"{$arrAgentSourceInfo.province_id}",city_id:"{$arrAgentSourceInfo.city_id}",area_id:"{$arrAgentSourceInfo.area_id}",iAddPleaseSelect:false{literal}});
    </script>
{/literal}
