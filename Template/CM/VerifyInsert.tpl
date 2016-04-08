<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a id="titleFirstLevel" href="javascript:;" onclick="JumpPage('{au d="CM" c="CMInfo" a="showBackInfoList"}')">客户管理</a><span>&gt;</span></span>{$strTitle}客户</div>
<!--E crumbs-->
<!--S form_edit-->
<div class="form_edit">
	<div class="form_hd">
		<div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
		<span class="declare">"<em class="require">*</em>"为必填信息</span>
	</div>
<!--
  	<div class="form_addition">
        <div class="form_addition_inner">
          <div class="ui_title">代理商修改类型为：</div>
          <div class="ui_text">资料{$strTitle}</div>
        </div>
	</div>
-->
	<!--S form_bd-->
	<div class="form_bd">
    <form id="J_customerAddForm" action="" name="customerAddForm" class="customerAddForm" method="post" enctype="multipart/form-data">
    <input id="customer_id" name="customer_id" type="hidden" value="{$customer_id}"/>
      <div class="form_block_hd"><h3 class="ui_title">企业信息</h3></div>
      <!--S form_block_bd-->
      <div class="form_block_bd">
        <div class="tf">
          <label><em class="require">*</em>客户名：</label>
          <div class="inp">
            <input value="{$customer_name}" class="customerName" type="text" id="customer_name" name="customer_name" valid="required" tabindex="1"/>
          </div>
          <span class="info">非个人客户请按营业执照上的名称填写，个人客户按身份证上的姓名填写</span>
          <span class="ok">&nbsp;</span><span class="err">非个人客户请按营业执照上的名称填写，个人客户按身份证上的姓名填写</span>
        </div>
        <div class="tf">
          <label><em class="require">*</em>地区：</label>
          <div class="inp">
            <select id="selProvince" name="selProvince" class="pri" name="selProvince" tabindex="2" ></select>
            <select id="selCity" class="city" name="selCity" tabindex="3" ></select>
            <select id="area_id" class="area" name="area_id" tabindex="4" ></select>
            <input value="{$address}" class="detailAddress" type="text" id="address" name="address" valid="required detailAddress"  value="请输入详细街道地址" tabindex="5" onfocus="if(this.value=='请输入详细街道地址')this.value='';this.style['color']='#555555'"/>
          </div>
          <span class="info">该联系地址为邮寄地址，请仔细填写</span> <span class="ok">&nbsp;</span><span class="err">该联系地址为邮寄地址，请仔细填写</span> </div>
        <div class="tf">
          <label><em class="require">*</em>行业：</label>
          <div class="inp">
            <select class="industry" id="industry_pid" name="industry_pid"  tabindex="6" ></select>
            <select class="industrySegmentation" id="industry_id" name="industry_id" tabindex="7" valid="required industry"></select>
          </div>
          <span class="info">请选择行业</span> <span class="ok">&nbsp;</span><span class="err">请选择行业</span> </div>
        <div class="tf">
          <label>主营业务：</label>
          <div class="inp">
            <input value="{$main_business}" type="text" class="mainBusiness" id="main_business" name="main_business"/>
          </div>
        </div>
        <div class="tf">
          <label>主要市场：</label>
          <div class="inp">
            <input value="{$major_markets}" type="text" class="mainMarket" id="major_markets" name="major_markets"/>
          </div>
        </div>
        <div class="tf">
          <label>公司简介：</label>
          <div class="inp">
            <textarea class="companyProfile" id="company_profile" name="company_profile" cols="50" valid="company_profile">{$company_profile}</textarea>
          </div>
		<span class="info">请输入公司简介，最多200个文字</span> <span class="ok">&nbsp;</span><span class="err">请输入公司简介，最多200个文字</span>
        </div>
        <div class="tf">
          <label>公司规模：</label>
          <div class="inp">
            <input value="{$company_scope}" type="text" class="mainBusiness" id="company_scope" name="company_scope"/>
          </div>
        </div>
        <div class="tf">
          <label>注册状态：</label>
          <div class="inp">
            <select id="reg_status" name="reg_status">
            </select>
          </div>
        </div>
       
       
        <div class="tf">
          <label>公司注册时间：</label>
          <div class="inp">
            <input value="{$reg_date}" type="text" class="registeredTime inpDate" id="reg_date" name="reg_date" onClick="WdatePicker()"/>
          </div>
        </div>
       
      
       
        <div class="tf">
          <label>公司网址：</label>
          <div class="inp">http://
            <input value="{$website}" type="text" class="website" id="website" name="website" valid="url"/>
          </div>
                  <span class="info">请输入有效网址 如:www.abc.com</span>
 		          <span class="ok">&nbsp;</span><span class="err">请输入有效网址</span>
        </div>
     <div class="tf">
          <label>邮政编码：</label>
          <div class="inp">
            <input value="{$postcode}" class="postcode" type="text" id="postcode" name="postcode" valid="postcode" />
          </div>
          <span class="info">请填写公司联系地址所在地的邮政编码</span>
          <span class="ok">&nbsp;</span><span class="err">请填写公司联系地址所在地的邮政编码</span> </div>
        <div class="tf">
          <label>客户来源：</label>
          <div class="inp">
            <select class="customer_from" id="customer_from" name="customer_from">
            </select>
          </div>
        </div>
        <div class="tf">
          <label><em class="require">*</em>经营模式：</label>
          <div class="inp"><select class="businessModel" id="business_model" name="business_model" valid="required businessModel"></select></div>
          <span class="info">请选择经营模式</span>
 		  <span class="ok">&nbsp;</span><span class="err">请选择经营模式</span>
        </div>
        <div class="tf">
          <label>网络推广情况：</label>
          <div class="inp">
            <input value="{$net_extension_about}" type="text" class="netExtensionAbout" id="net_extension_about" name="net_extension_about"/>
          </div>
        </div>
        <div class="tf">
          <label>经营范围：</label>
          <div class="inp">
            <input value="{$business_scope}" type="text" class="businessScope" id="business_scope" name="business_scope"/>
          </div>
        </div>
        <div class="tf">
          <label>年销售额：</label>
          <div class="inp">
            <input value="{$annual_sales}" type="text" class="mainBusiness" id="annual_sales" name="annual_sales"/>
            </div>
        </div>
        <div class="tf">
          <label>注册资金：</label>
          <div class="inp">
            <input value="{$reg_capital}" type="text" class="mainBusiness" id="reg_capital" name="reg_capital"/>
          </div>
        </div>
        <div class="tf">
          <label>注册地址：</label>
          <div class="inp">
            <input value="{$reg_place}" type="text" class="registeredAddress" id="reg_place" name="reg_place"/>
          </div>
        </div>
      </div>
      <!--E form_block_bd-->
      <!--S form_block_hd-->
      <div class="form_block_hd"><h3 class="ui_title">负责人信息</h3></div>
      <!--E form_block_hd-->
      <!--S form_block_bd-->
      <div class="form_block_bd">
        <div class="tf">
          <label><em class="require">*</em>姓名：</label>
          <div class="inp">
            <input value="{$contact_name}" class="principalName" type="text" id="contact_name" name="contact_name"  valid="required principalName"/>
          </div>
          <span class="info">该联系人信息为负责人联系信息</span>
          <span class="ok">&nbsp;</span><span class="err">请如实填写</span>

          </div>
        <div class="tf">
          <label>性别：</label>
          <div class="inp"> 
              <select id="contact_sex" name="contact_sex">
                  <option value="0">男</option>
                  <option value="1">女</option>
              </select>
          </div>
        </div>        
        <div class="tf">
          <label><em class="require">*</em>手机号：</label>
          <div class="inp">
            <input value="{$contact_mobile}" class="mPhone" type="text" id="contact_tel"  name="contact_mobile"  valid="mPhone"/>
          </div>
          <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
			<span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
	</div>
	<div class="tf">
          <label>固定电话：</label>
          <div class="inp">
            <input value="{$contact_tel}" class="fPhone" type="text" id="contact_mobile"  name="contact_tel"   valid="fPhone"/>
          </div>
          <span class="info"> 固话格式:0571-8888888</span>
	  <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号 </span>
	 </div>
        <div class="tf">
          <label>电子邮箱：</label>
          <div class="inp">
            <input value="{$contact_email}" class="email" type="text" id="contact_email" name="contact_email" valid="email"/>
          </div>
          <span class="info">请输入正确邮箱</span> <span class="ok">&nbsp;</span><span class="err">请输入正确邮箱</span></div>
        <div class="tf">
          <label>职位：</label>
          <div class="inp">
            <input value="{$contact_position}" class="office" type="text" id="contact_position" name="contact_position"/>
          </div>
        </div>
        <div class="tf">
          <label>网络意识：</label>
          <div class="inp">
            <select class="contact_net_awareness" id="contact_net_awareness" name="contact_net_awareness">
            </select>
          </div>
        </div>
        <div class="tf">
          <label>传真号码：</label>
          <div class="inp">
            <input value="{$contact_fax}" class="faxPhone" type="text" id="contact_fax" name="contact_fax" valid="faxPhone"/>
          </div>
          <span class="info">格式:0571-8888888</span> <span class="ok">&nbsp;</span><span class="err">请输入正确传真号码</span> </div>
        <div class="tf">
          <label>重要程度：</label>
          <div class="inp">
            <select class="contact_importance" id="contact_importance" name="contact_importance">
            </select>
          </div>
        </div>
        <div class="tf">
          <label>备注：</label>
          <div class="inp">
            <textarea class="comment" id="contact_remark" name="contact_remark" cols="50" >{$contact_remark}</textarea>
          </div>
        </div>
        <div class="tf" style="display:none;">
          <label>提交审核：</label>
          <input id="isChecked" name="isChecked" type="checkbox" checked="checked" value="1" />
        </div>
        <div class="tf tf_submit">
          <label>&nbsp;</label>
          <div class="inp">
            <div class="ui_button ui_button_confirm"> <button id="btnSave" type="submit" class="ui_button_inner">保 存</button></div>
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="JumpPage('{au d="CM" c="CMVerify" a="showVerifyList"}')">返回</a> </div>
          </div>
        </div>
      </div>
      <!--E form_block_bd-->
    </form>
  </div>
  <!--E form_bd-->
</div>
 <script language="javascript" type="text/javascript">
var area_id="{$area_id}";//地区
var city_id="{$city_id}";//城市
var province_id="{$province_id}";//省市
var industry_id="{$industry_id}";//行业ID
var industry_pid="{$industry_pid}";//父行业ID
var business_model="{$business_model}";//经营模式
var reg_status="{$reg_status}";//注册状态
var contact_sex="{$contact_sex}";//性别
var contact_importance="{$contact_importance}";//重要程度
var customer_from="{$customer_from}";//客户来源
var contact_net_awareness="{$contact_net_awareness}";//网络意识
{literal}
$(function(){
    var backUrl=$.getUrlParamValue("backUrl")||"showBackInfoList";
    if(backUrl!="showBackInfoList")
    {
        $("#titleFirstLevel").html("客户关系管理");
    }

    $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:false,area_id:area_id,city_id:city_id,province_id:province_id,iAddPleaseSelect:true});
    $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",industry_pid:industry_pid,industry_id:industry_id,iAddPleaseSelect:true});
    $("#reg_status").BindConstData("注册状态",reg_status);
    $("#customer_from").BindConstData("客户来源",customer_from);
    $("#business_model").BindConstData("经营模式",business_model);
    $("#contact_net_awareness").BindConstData("网络意识",contact_net_awareness);
    $("#contact_importance").BindConstData("重要程度",contact_importance);
    $("#contact_sex").val(contact_sex);
    /**
     * 表单验证
     */
    new Reg.vf($('#J_customerAddForm'),{
        extValid:{
            detailAddress:function(e){
                return (MM.getVal(MM.G('selProvince')).text!='省份')&&(MM.getVal(MM.G('selCity')).text!='市')&&(MM.getVal(MM.G('area_id')).text!='区/县')&&e!='请输入详细街道地址' && /\w|[^\x00-\xff]|(-|_|\.)/.test(e)
            },
            industry:function(e){
                return MM.getVal(MM.G('industry_pid')).text!='一级分类' && MM.getVal(MM.G('industry_id')).text!='二级分类'
            },
            businessModel:function(e){
                return (MM.getVal(MM.G('business_model')).text!='请选择')
            },
            company_profile:function(e){
            	return e.length<200
            }
        },
        callback:function(){
            if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
            var mode="add";
            if(industry_id)
            {//修改模式
                mode="modify";
            }
            modeParam=$.getUrlParamValue("mode");
            if(modeParam)
            {
                mode="import";
            }
            $.ajax({
                type:'POST',
                dataType: "text",
                url:$.currentBasePathGet() + "?c=CMInfo&d=CM&a=" + mode,
                data:$('#J_customerAddForm').serialize(),
                success:function(data)
                {
                    if($.trim(data) == 1)
                    {
                                IM.tip.show('保存成功！');
                                JumpPage("/?c=CMVerify&d=CM&a=showVerifyList");
                    }
                    else
                    {
                        IM.tip.warn($.trim(data));
                    }
                }
            });
    }});
    if(backUrl!="showBackInfoList")//只有前台需要自动匹配
    {
        $('#customer_name').autocomplete('/?d=CM&c=CMInfo&a=getCustomerName_ID', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                        max: 5, //只显示5行
                        width: 160, //下拉列表的宽
                        parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
                            var parsed = [];
                            if(backData == "" || backData.length == 0)
                                return parsed;                                
                            backData = MM.json(backData);
                            var value = backData.value;
                            if(value == undefined)
                                 return parsed;
                            for (var i = 0; i < value.length; i++) {
                                parsed[parsed.length] = {
                                    data: value[i],
                                    value: value[i].id,
                                    result: value[i].name
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return '<div>' + item.no +"("+item.name +")"+ '</div>';
                        }
                    }).result(function (data,value) {//执行模糊匹配
                        var eID = value.id;
                        JumpPage("/?d=CM&c=CMInfo&a=showModifyFront&customer_id="+eID+"&mode=import&backUrl="+$.getUrlParamValue("backUrl"));//导入客户到自己账户下，非添加或修改
        		    });
    }
});
{/literal}
</script>         
          
          
