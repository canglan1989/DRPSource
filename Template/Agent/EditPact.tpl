    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商签约管理<span>&gt;</span>我的签约<span>&gt;</span>签约审核</div>
    <div class="form_edit">
        <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>提交签约信息</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
        </div>
        
	<!--S form_bd-->
	<div class="form_bd">
		<!--S viewAgentInfo-->
		<form id="editPact_Form" action="" name="editPact_Form" class="QYForm" method="post" enctype="multipart/form-data">
		    <div class="form_block_hd"><h3 class="ui_title">单位信息</h3></div>
		    <!--S form_block_bd-->
		    <div class="form_block_bd">
			<div class="blockLeft">
			    <div class="tf">
				<label><em class="require">*</em>公司名称：</label>
				<div class="inp">{$arrAgentInfo.agent_name}</div>
				<input type="hidden" value="{$arrAgentInfo.agent_name}" name="AgentName" />
				<input type="hidden" value="{$arrAgentInfo.agent_id}" name="AgentID">
			    </div>
			    <div class="tf">
				<label><em class="require">*</em>注册地址：</label>
				<div class="inp">{$arrAgentInfo.address}</div>
				<input type="hidden" value="{$arrAgentInfo.address}" name="Address" />
				<input type="hidden" value="{$arrAgentInfo.province_id}" name="ProvinceID">
				<input type="hidden" value="{$arrAgentInfo.city_id}" name="CityID">
				<input type="hidden" value="{$arrAgentInfo.area_id}" name="AreaID">
			    </div>
			    <div class="tf">
				<label>邮政编码：</label>
				<div class="inp">{$arrAgentInfo.postcode}</div>
				<input type="hidden" value="{$arrAgentInfo.postcode}" name="Postcode" />
			    </div>
			    <div class="tf">
				<label><em class="require">*</em>法人姓名：</label>
				<div class="inp">{$arrAgentInfo.legal_person}</div>
				<input type="hidden" value="{$arrAgentInfo.legal_person}" name="LegalPerson" />
			    </div>
			    <div class="tf">
				<label><em class="require">*</em>注册资金：</label>
				<div class="inp">
                        {if $arrAgentInfo.reg_capital eq 1}10-50万{/if}
                        {if $arrAgentInfo.reg_capital eq 2}50-100万{/if}
                    {if $arrAgentInfo.reg_capital eq 3}100-200万{/if}
                    {if $arrAgentInfo.reg_capital eq 4}200-500万{/if}
                {if $arrAgentInfo.reg_capital eq 5}500万以上{/if}
                </div>
	    		<input type="hidden" value="{$arrAgentInfo.reg_capital}" name="RegCapital" />
        		</div>
                <div class="tf">
                <label>公司注册时间：</label>
                <div class="inp">{$arrAgentInfo.reg_date}</div>
                <input type="hidden" value="{$arrAgentInfo.reg_date}" name="RegDate" />
            </div>
            <div class="tf">
                <label>公司规模：</label>
                <div class="inp">
                {if $arrAgentInfo.company_scale eq 1}10-50人{/if}
            {if $arrAgentInfo.company_scale eq 2}50-100人{/if}
            {if $arrAgentInfo.company_scale eq 3}100人以上{/if}
        </div>
        <input type="hidden" value="{$arrAgentInfo.strCompanyScale}" name="CompanyScale" />
        </div>
        </div>
        <div class="blockRight">
            <div class="tf">
            <label>公司销售：</label>
            <div class="inp">
            {if $arrAgentInfo.sales_num eq 1}10-50人{/if}
            {if $arrAgentInfo.sales_num eq 2}50-100人{/if}
        {if $arrAgentInfo.sales_num eq 3}100人以上{/if}
        </div>
        <input type="hidden" value="{$arrAgentInfo.sales_num}" name="SalesNum" />
        </div>
        <div class="tf">
            <label>电话营销：</label>
            <div class="inp">
            {if $arrAgentInfo.telsales_num eq 1}10-50人{/if}
        {if $arrAgentInfo.telsales_num eq 2}50-100人{/if}
        {if $arrAgentInfo.telsales_num eq 3}100人以上{/if}
        </div>
        <input type="hidden" value="{$arrAgentInfo.telsales_num}" name="TelsalesNum" />
        </div>
        <div class="tf">
            <label>售前技术：</label>
            <div class="inp">
            {if $arrAgentInfo.tech_num eq 1}5-5人{/if}
        {if $arrAgentInfo.tech_num eq 2}5-25人{/if}
        {if $arrAgentInfo.tech_num eq 3}25-60人{/if}
        {if $arrAgentInfo.tech_num eq 4}60人以上{/if}
        </div>
        <input type="hidden" value="{$arrAgentInfo.tech_num}" name="TechNum" />
        </div>
        <div class="tf">
            <label>客服：</label>
            <div class="inp">
            {if $arrAgentInfo.service_num eq 1}5-5人{/if}
        {if $arrAgentInfo.service_num eq 2}5-25人{/if}
        {if $arrAgentInfo.service_num eq 3}25-60人{/if}
        {if $arrAgentInfo.service_num eq 4}60人以上{/if}
        </div>
        <input type="hidden" value="{$arrAgentInfo.service_num}" name="ServiceNum" />
        </div>
        <div class="tf">
            <label>企业客户：</label>
            <div class="inp">
            {if $arrAgentInfo.customer_num eq 1}500人以下{/if}
        {if $arrAgentInfo.customer_num eq 2}500-2000人{/if}
        {if $arrAgentInfo.customer_num eq 3}2000人以上{/if}
        </div>
        <input type="hidden" value="{$arrAgentInfo.strCustomerNum}" name="CustomerNum" />
        </div>
        <div class="tf">
            <label>年销售额：</label>
            <div class="inp">
            {if $arrAgentInfo.annual_sales eq 1}50万以下{/if}
        {if $arrAgentInfo.annual_sales eq 2}50-100万{/if}
        {if $arrAgentInfo.annual_sales eq 3}100-200万{/if}
        {if $arrAgentInfo.annual_sales eq 4}200-500万{/if}
        {if $arrAgentInfo.annual_sales eq 5}1000万以上{/if}
        </div>
        <input type="hidden" value="{$arrAgentInfo.annual_sales}" name="AnnualSales" />
        </div>
        <div class="tf">
            <label>企业方向：</label>
            <div class="inp">{$arrAgentInfo.direction}</div>
            <input type="hidden" value="{$arrAgentInfo.direction}" name="Direction" />
        </div>
        </div>
        <div class="tf">
            <label>资质上传：</label>
            <div class="inp qua_upload">
            <span>{$permit.permit_name}.{$permit.file_ext}<a href="javascript:;" onClick="IM.Toggle('.qua_upload .img',this,'查看','收起')">查看</a></span>
            <span class="img">
                <img src="{$permit.file_path}.{$permit.file_ext}"/>
            </span>
            </div>
        </div>
        </div>
        <!--E form_block_bd-->
    
    <!--S form_block_hd-->
    <div class="form_block_hd"><h3 class="ui_title">负责人信息</h3></div>
    <!--E form_block_hd-->
    <!--S form_block_bd-->
    <div class="form_block_bd">
        <div class="blockLeft">
        <div class="tf">
            <label><em class="require">*</em>负责人：</label>
            <div class="inp">{$arrAgentInfo.charge_person}</div>
            <input type="hidden" value="{$arrAgentInfo.charge_person}" name="ChargePerson">
        </div>
        <div class="tf">
            <label><em class="require">*</em>手机号：</label>
            <div class="inp">{$arrAgentInfo.charge_phone}</div>
            <input type="hidden" value="{$arrAgentInfo.charge_phone}" name="ChargePhone" />
        </div>
        <div class="tf">
            <label>固定电话：</label>
            <div class="inp">{$arrAgentInfo.charge_tel}</div>
            <input type="hidden" value="{$arrAgentInfo.charge_tel}" name="ChargeTel" />
        </div>
        <div class="tf">
            <label>传真号码：</label>
            <div class="inp">{$arrAgentInfo.charge_fax}</div>
            <input type="hidden" value="{$arrAgentInfo.charge_fax}" name="ChagreFax" />
        </div>
        </div>
        <div class="blockRight">
        <div class="tf">
            <label>电子邮件：</label>
            <div class="inp">{$arrAgentInfo.charge_email}</div>
            <input type="hidden" value="{$arrAgentInfo.charge_email}" name="ChargeEmail" />
        </div>
        <div class="tf">
            <label>职务：</label>
            <div class="inp">{$arrAgentInfo.charge_positon}</div>
            <input type="hidden" value="{$arrAgentInfo.charge_positon}" name="ChargePositon" />
        </div>
        <div class="tf">
            <label>MSN：</label>
            <div class="inp">{$arrAgentInfo.charge_msn}</div>
            <input type="hidden" value="{$arrAgentInfo.charge_msn}" name="ChargeMsn" />
        </div>
        <div class="tf">
            <label>QQ：</label>
            <div class="inp">{$arrAgentInfo.charge_qq}</div>
            <input type="hidden" value="{if $arrAgentInfo.charge_qq eq 0}{else}{$arrAgentInfo.charge_qq}{/if}" name="ChargeQq" />
        </div>
        </div>
    </div>
    <!--E form_block_bd-->


<div class="form_block_hd"><h3 class="ui_title">签约信息</h3></div>
<!--S form_block_bd-->
<div class="form_block_bd">
    <div class="tf">
	<label><em class="require">*</em>代理的产品：</label>
	<div class="inp">
	    <select class="agentPro" name="agentProID">
		{foreach from=$arrProductType item=type}
		    <option value="{$type.aid}" {if $type.aid eq $objAgentPactInfo->strProductId}selected{/if}>{$type.product_type_name}
		    {/foreach}
	    </select>
	</div>
    </div>
    <div class="tf">
	<label><em class="require">*</em>代理等级：</label>
	<div class="inp">
	    <div class="inp">
		<select class="agentLevel" name="agentLevel">
		    <option value="0" {if $objAgentPactInfo->strAgentLevel eq 0}selected{/if}>无等级</option>
		    <option value="1" {if $objAgentPactInfo->strAgentLevel eq 1}selected{/if}>金牌</option>
		    <option value="2" {if $objAgentPactInfo->strAgentLevel eq 2}selected{/if}>银牌</option>
		</select>
	    </div>
	</div>
    </div>
    <div class="tf">
	<input id="J_region" type="hidden" value="" name="region" valid=""/>
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
				{$allArea}
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
	</div>
	<span class="info">请选择地区范围</span>
	<span class="ok">&nbsp;</span><span class="err">请选择地区范围</span>
    </div>
    <div class="tf">
	<label><em class="require">*</em>代理商资质：</label>
	{foreach from=$arrAgentPermit item=value}
	    <div id="J_qua_upload{$value.aid}" class="inp qua_upload">
		<span>{$value.permit_name}.{$value.file_ext} <a href="javascript:;" onClick="IM.Toggle('#J_qua_upload{$value.aid} .img',this,'查看','收起')">查看</a></span>
		<span class="img">
		    <img src="{$value.file_path}.{$value.file_ext}" width="300" />
		</span>
	    </div>
	{/foreach}
    </div>
    <div class="tf">
	<label><em class="require">*</em>合同有效期限：</label>
	<div class="inp">
	    <input value="{$objAgentPactInfo->strPactSdate}" id="J_editTimeS" class="inpCommon inpDate" valid="required" name="pact_sdate" onclick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}{/literal} )" type="text"> 至
	    <input value="{$objAgentPactInfo->strPactEdate}" id="J_editTimeE" class="inpCommon inpDate" valid="required" name="pact_edate" onclick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}{/literal})" type="text">
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
	<div class="inp">{$arrAgentInfo.agent_name}</div>
    </div>
    <div class="tf">
	<label><em class="require">*</em>地区：</label>
	<div class="inp">
	    <select id="selProvince" class="pri" name="pri" tabindex="2" disabled></select>
	    <select id="selCity" class="city" name="city" tabindex="3" disabled></select>
	    <select id="selArea" class="area" name="area" tabindex="4" disabled></select>
	    <input class="detailAddress" type="text" name="address" value="{$arrAgentInfo.address}" tabindex="5" id="address" readonly/>
	</div>
    </div>
    <div class="tf">
	<label>邮政编码：</label>
	<div class="inp">{$arrAgentInfo.postcode}</div>
    </div>
    <div class="tf">
	<label><em class="require">*</em>法人姓名：</label>
	<div class="inp">{$arrAgentInfo.legal_person}</div>
    </div>
    <div class="tf">
	<label><em class="require">*</em>注册资金：</label>
	<div class="inp">
	{if $arrAgentInfo.reg_capital eq 1}10-50万{/if}
	{if $arrAgentInfo.reg_capital eq 2}50-100万{/if}
	{if $arrAgentInfo.reg_capital eq 3}100-200万{/if}
	{if $arrAgentInfo.reg_capital eq 4}200-500万{/if}
	{if $arrAgentInfo.reg_capital eq 5}500万以上{/if}
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
	    <input type="hidden" value="0" id="subtype" name="subtype">
	    <input type="hidden" value="{$objAgentPactInfo->iAid}" id="subtype" name="pactID">
	    <input type="hidden" value="{$objAgentPactInfo->strCheckTime}" name="checktime">
	    <input type="hidden" value="{$objAgentPactInfo->strCreateTime}" name="createtime">
	    <input type="hidden" value="{$objAgentPactInfo->iCheckUid}" name="checkUid">
	    <input type="hidden" value="{$objAgentPactInfo->iCreateUid}" name="createUid">
        
	    <div class="ui_button ui_button_large"><span class="ui_button_left"></span><button type="button" id="editSignInfo" class="ui_button_inner">保存</button></div>
	    <div class="ui_button ui_button_large"><span class="ui_button_left"></span><button type="button" id="submitSignInfo" class="ui_button_inner" onclick="$('#subtype').val(1)">提交</button></div>
	    <div class="ui_button ui_button_no ui_button_large_no">
		<span class="ui_button_left"></span>
		<a class="ui_button_inner" href="javascript:;" onClick="history.back();">取消</a>
	    </div>
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
new Reg.vf($('#J_QYForm'),{extValid:{}});

$("#selProvince").BindProvince({{/literal}selCityID:"selCity",selAreaID:"selArea",province_id:"{$arrAgentInfo.province_id}",city_id:"{$arrAgentInfo.city_id}",area_id:"{$arrAgentInfo.area_id}",iAddPleaseSelect:false{literal}});

$("#editSignInfo").click(function(){
    $.ajax({
	url:{/literal}'{au d=Agent c=AgentMove a=submitEdit}'{literal},
	data:$("#editPact_Form").serialize(),
	type:"post",
	success:function(data){
	    if(data==1)
	    {
		IM.tip.show("修改成功");      
            PageBack();
	    }
	    else
		IM.tip.show("修改失败");
	}
    });
});

$("#submitSignInfo").click(function(){
    $.ajax({
	url:{/literal}'{au d=Agent c=AgentMove a=submitEdit}'{literal},
	data:$("#editPact_Form").serialize(),
	type:"post",
	success:function(data){
	    if(data==1)
	    {
		IM.tip.show("提交成功");
            PageBack();
	    }
	    else
		IM.tip.show("提交失败");
	}
    });
});

(function(){
    {/literal}
    var strGroupAreaJson = "{$strRegion}";
    {literal}
    if(strGroupAreaJson.length > 1)
    {
        var areaJson = eval("("+strGroupAreaJson+")");
       	var strHtml = "";
        var jsonObjLength = areaJson.length;
        var areaIDs = "";
        var areaID = "";
        var selectAreaObj = $(".SelectArea")[0];

        for (var i = 0; i < jsonObjLength; i++) {
            strHtml += "<div class='agentAreaResultWrap'><div class='agentAreaResultItem'><em>"+areaJson[i].fullName+"</em>";
            strHtml += "<a class='resultClose' onclick='IM.area.hideAreaResult(this)' rel='";
            areaID = (areaJson[i].dataType == "province" ? "p_" :(areaJson[i].dataType == "city" ? "c_" : "a_"))+areaJson[i].id;

            strHtml += areaID+"' href='javascript:;'>关闭</a></div></div>";
            areaIDs += ","+areaID;

            selectAreaObj[i] = new Option(areaJson[i].fullName,areaID);
        }
        areaIDs = areaIDs.substring(1);

        $("#J_region").val(areaIDs);
        $("#agentAreaResult").html(strHtml);
    }

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
</script>
{/literal}