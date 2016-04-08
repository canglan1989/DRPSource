<?php
header("Content-type: text/html; charset=utf-8");
require __DIR__ . '/../Action/Common/Session.php';
$CSS = "/FrontFile/CSS/";
$JS = "/FrontFile/JS/";
if(!defined("SYS_CONFIG"))
{
    //读取配置文件
    $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}

$state = "http://drp.com/";
$sys_evn = $arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
settype($sys_evn,"integer");        
if($sys_evn == 1)
    $state = "http://192.168.25.211:83/";
else if($sys_evn == 0)
    $state = "http://drp.com/";
else
    $state = "http://drp.dpanshi.com/";
    

$objSession = new Session($arrSysConfig['SESSION']['RAW_SESSION_NAME']);
if ($objSession->get($arrSysConfig['SESSION_INFO']['USER_ID']) === false) {
    $objSession->set($arrSysConfig['SESSION_INFO']['USER_ID'],$arrSysConfig['GUEST_UID']);
}           
    
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="IE=7" http-equiv="X-UA-Compatible"/>
<title>盘石全国渠道中心</title>
<!--<link href="http://10.0.91.3/drp/resource/css/gw-common.css" type="text/css" rel="stylesheet"/>-->
<!--<link href="http://drp.dpanshi.com/FrontFile/CSS/gw-common.css" type="text/css" rel="stylesheet"/>-->
<link href="http://drp.dpanshi.com/FrontFile/CSS/gw-common.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo $JS?>drp.base.js" ></script>
<script type="text/javascript" src="<?php echo $JS?>drp.imp.js" ></script>
<script type="text/javascript" src="<?php echo $JS?>HistoryManager.js"></script>
<script type="text/javascript" src="<?php echo $JS?>GetDept.js" defer="true"></script>
<script type="text/javascript" src="<?php echo $JS?>drpCommon.js" defer="true"></script>
<script type="text/javascript" src="<?php echo $JS?>calendar/WdatePicker.js" defer="true"></script>
<script type="text/javascript" src="<?php echo $JS?>JSFrameWork/ps_frame_all.js" ></script>
<script type="text/javascript" src="<?php echo $JS?>CommonBusiness.js" ></script>
</head>
<body style=' background: url("") '>
<!--S content-->
<div id="content2">
<div class="agentRegArea">
<div class="agentRegCont">
<form class="agentAddForm" name="agentAddForm" id="J_agentAddForm"	method="post">
<div class="form_block_hd">
<h3 class="ui_title">企业信息</h3>
</div>
<!--S form_block_bd-->
<div class="form_block_bd">

<div class="tf">
    <label><em class="require">*</em>代理商名称：</label>
    <div class="inp">
        <input type="text" id="agent_name" tabindex="1"	valid="required companyName" name="agent_name" class="companyName"/>
        <input	type="hidden" value="0" name="isCheck" id="isCheck"/>
    </div>
    <span class="info">请按照营业执照上的名称填写</span> 
    <span class="ok">&nbsp;</span>
    <span class="err">请按照营业执照上的名称填写</span>
</div>
<div class="tf">
    <label><em class="require">*</em>联系地址：</label>
    <div class="inp">
        <select tabindex="2" name="pri" class="pri"	id="selProvince"></select> 
        <select tabindex="3" name="city" class="city" id="selCity">	</select> 
        <select tabindex="4" name="area" class="area" id="selArea"></select> 
    <input type="text" id="address"	onfocus="if(this.value=='请输入详细街道地址')this.value='';this.style['color']='#555555'" tabindex="5" value="请输入详细街道地址" valid="required detailAddress" name="address" class="detailAddress"/>
    </div>
    <span class="info">该联系地址为邮寄地址，请仔细填写</span> 
    <span class="ok">&nbsp;</span>
    <span	class="err">该联系地址为邮寄地址，请仔细填写</span>
</div>

<div class="tf">
    <label><em class="require">*</em>注册地区：</label>
    <div class="inp">
        <select tabindex="2" name="regPri" class="pri" id="regProvince" ></select> 
        <select tabindex="3" name="regCity" class="city" id="regCity" ></select> 
        <select valid="regArea" tabindex="4" name="regArea"	class="area" id="regArea"></select>
    </div>
            <span class="info">请选择注册地区</span> <span class="ok">&nbsp;</span>
            <span	class="err">请选择注册地区</span>
</div>
<div class="tf"><label>邮政编码：</label>
    <div class="inp">
        <input type="text" tabindex="6" maxlength="6"	valid="postcode" name="postcode" class="postcode"/>
    </div>
    <span class="info">请填写公司联系地址所在地的邮政编码</span> <span class="ok">&nbsp;</span>
    <span	class="err">请填写公司联系地址所在地的邮政编码</span>
</div>
<div class="tf"><label>法人姓名：</label>

    <div class="inp">
        <input type="text" id="legal_person" tabindex="7"	valid="LegalPersonName" name="legal_person" class="LegalPersonName"/>
    </div>
    <span class="info">请按照营业执照上的名称填写</span> <span class="ok">&nbsp;</span>
    <span	class="err">请按照营业执照上的名称填写</span>
</div>
<div class="tf"><label>注册资金：</label>
<div class="inp">
    <input type="text" name="reg_capital" id="reg_capital"/>
</div>
    <span class="info">请选择注册资金</span> 
    <span class="ok">&nbsp;</span>
    <span class="err">请选择注册资金</span>
</div>
<div class="tf"><label>注册时间：</label>

<div class="inp">
    <input type="text" id="reg_date" onclick="WdatePicker()" name="reg_date" class="registeredTime inpDate"/>
</div>
</div>
<div class="tf"><label>公司规模：</label>
    <div class="inp">
        <select id="company_scale" tabindex="8" name="company_scale">
        	<option value="0">请选择</option>
        	<option value="1">10-50人</option>
        	<option value="2">50-100人</option>
        	<option value="3">100人以上</option>
        </select>
    </div>
</div>
<div class="tf"><label>公司销售人数：</label>
<div class="inp">
    <select id="sales_num" tabindex="8" name="sales_num">
    	<option value="0">请选择</option>
    	<option value="1">10-50人</option>
    	<option value="2">50-100人</option>
    	<option value="3">100人以上</option>
    </select>
</div>
</div>
<div class="tf"><label>互联网电话营销：</label>
<div class="inp"><select id="telsales_num" tabindex="8"
	name="telsales_num">
	<option value="0">请选择</option>
	<option value="1">10-50人</option>
	<option value="2">50-100人</option>
	<option value="3">100人以上</option>
</select></div>
</div>
<div class="tf"><label>售前技术支持：</label>

<div class="inp"><select id="tech_num" tabindex="8" name="tech_num">
	<option value="0">请选择</option>
	<option value="1">1-5人</option>
	<option value="2">5-25人</option>
	<option value="3">25-60人</option>
	<option value="4">60人以上</option>

</select></div>
</div>
<div class="tf"><label>客服人数：</label>
<div class="inp"><select id="service_num" tabindex="8"
	name="service_num">
	<option value="0">请选择</option>

	<option value="1">1-5人</option>
	<option value="2">5-25人</option>
	<option value="3">25-60人</option>
	<option value="4">60人以上</option>
</select></div>
</div>

<div class="tf"><label>企业客户数：</label>
<div class="inp"><select id="customer_num" tabindex="8"
	name="customer_num">
	<option value="0">请选择</option>
	<option value="1">500人以下</option>
	<option value="2">500-2000人</option>

	<option value="3">2000人以上</option>
</select></div>
</div>
<div class="tf"><label>年销售额：</label>
<div class="inp"><select id="annual_sales" tabindex="8"
	name="annual_sales" class="turnoverYear">

	<option value="0">请选择</option>
	<option value="1">50万以下</option>
	<option value="2">50-100万</option>
	<option value="3">100-500万</option>
	<option value="4">500-1000万</option>
	<option value="5">1000万以上</option>

</select></div>
</div>
<div class="tf"><label>公司网站：</label>
<div class="inp">http://<input type="text" id="website" name="website" valid=""/></div>
<span class="info">请输入有效网址 如:www.abc.com</span> <span class="ok">&nbsp;</span>
<span	class="err">请输入有效网址</span></div>
<div class="tf"><label>营业执照注册号：</label>
<div class="inp"><input type="text" id="permitRegNo" name="permitRegNo"	valid=""/></div>
<span class="info">请输入营业执照注册号</span> <span class="ok">&nbsp;</span>
<span class="err">请输入营业执照注册号</span></div>
<div class="tf"><label>企业税号：</label>
<div class="inp"><input type="text" id="revenueNo" name="revenueNo"	valid=""/></div>
<span class="info">请输入企业税号</span> <span class="ok">&nbsp;</span>
<span	class="err">请输入企业税号</span></div>

<div class="tf"><label>经营范围：</label>
<div class="inp"><textarea valid="businessPosition" id="direction"	cols="50" name="direction"></textarea></div>
<span class="info">限制100字以内</span> <span class="ok">&nbsp;</span>
<span class="err">限制100字以内</span></div>
<div class="tf"><label>资质上传：</label>
<div class="inp qua_upload"><span class="fileBtn"> 
    <input width="50px;" type="file" size="8" name="qualifications" class="qualifications" id="J_upload0"/> 
    <input type="hidden" name="permitJ_upload0"	id="permitJ_upload0"/> </span>
<div style="display: none" class="img" id="J_uploadImg0"></div>
</div>
    <span class="c_info">支持的格式为JPG、JPEG、GIF、PNG、BMP，文件大小限制为3M</span> 
    <span class="ok">&nbsp;</span><span class="err">请上传资质</span></div>
</div>
<!--E form_block_bd--> <!--S form_block_hd-->
<div class="form_block_hd">
<h3 class="ui_title">联系人信息</h3>
</div>
<!--E form_block_hd--> <!--S form_block_bd-->
<div class="form_block_bd">

<div class="tf"><label><em class="require">*</em>负责人姓名：</label>
<div class="inp">
    <input type="text" id="charge_person"	valid="required principalName" name="charge_person"	class="principalName"/>
</div>
<span class="info"></span> <span class="ok">&nbsp;</span><span	class="err">请如实填写</span></div>
<div class="tf"><label>职务：</label>
<div class="inp">
    <input type="text" id="charge_positon"	name="charge_positon" class="office"/>
</div>
</div>
<div class="tf"><label><em class="require">*</em>固定电话：</label>
    <div class="inp">
        <input type="text" id="charge_tel"	valid="fPhone" name="charge_tel" class="fPhone"/>
    </div>
<span class="info">固话格式:0571-8888888</span> <span class="err">请输入正确固定电话号</span>
</div>
<div class="tf"><label>手机号码：</label>
    <div class="inp">
        <input type="text" id="charge_phone" name="charge_phone" valid="mPhone" class="fPhone"/>
    </div>
<span class="info">固话格式:0571-8888888</span> <span class="err">请输入正确固定电话号</span>
</div>
<div class="tf"><label>传真号码：</label>
    <div class="inp">
        <input type="text" id="charge_fax" valid="faxPhone"	name="charge_fax" class="faxPhone"/>
    </div>
    <span class="info">格式:0571-8888888</span> <span class="err">请输入正确传真号码</span>

</div>
<div class="tf"><label>电子邮箱：</label>
    <div class="inp">
        <input type="text" id="charge_email" name="charge_email" class="email"/>
    </div>
    <span class="info">请输入正确邮箱</span> <span class="err">请输入正确邮箱</span>
</div>

<div class="tf"><label>QQ：</label>
<div class="inp">
    <input type="text" id="charge_qq" name="charge_qq"	class="QQ"/>
</div>
</div>
<div class="tf"><label>MSN：</label>
<div class="inp">
    <input type="text" id="charge_msn" name="charge_msn" class="MSN"/>
</div>
</div>

<div class="tf tf_submit"><label>&nbsp;</label>
<div class="inp">
<button class="submit" onclick="SubmitData()" type="button">确认</button>

</div>
</div>
</div>
<!--E form_block_bd-->
</form>

</div>
</div>
</div>
<!--E content-->
<script type="text/javascript">
$(function(){
	//绑定省市区联动菜单
	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});	
    $("#regProvince").BindProvince({selCityID:"regCity",selAreaID:"regArea",iAddPleaseSelect:true});
});
new IM.upload({id:'J_upload0',noticeId:'J_uploadImg0', url: '/?d=Agent&c=Agent&a=FileUpload'});
function SubmitData()
{
    $.ajax({
        async: false, //true 异步 默认true
        type: "POST",
        url: "<?php echo $state?>WebService/AgentRegister.php?submit=true",
        data: $('#J_agentAddForm').serialize(),
        dataType:'json',
        success: function (data) {
            if(data.success == true)
			{
                alert(data.msg);
                if(window.parent != window)
                    window.parent.location.href = 'http://www.dpanshi.com';
			}
			else
			{  
                alert(data.msg);
			}
        }
    });        
}
</script>
</body>
</html>