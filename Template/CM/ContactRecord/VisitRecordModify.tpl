<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<div class="form_edit">
  <div class="form_hd">
    <div class="form_hd_left">
      <div class="form_hd_right">
        <div class="form_hd_mid">
          <h2>{$strTitle}</h2>
        </div>
      </div>
    </div>
    <span class="declare">“<em class="require">*</em>”为必填信息</span> </div>
  <div class="form_bd">
    <form id="from1" action="" name="from1">
    <input id="tbxID" name="tbxID" value="{$objAgContactRecodeInfo->iRecodeId}" type="hidden" />
    <input id="tbxInviteID" name="tbxInviteID" value="{$inviteID}" type="hidden" />    
    <input id="tbxCustomerID" name="tbxCustomerID" value="{$objAgContactRecodeInfo->iCustomerId}" type="hidden" />
        <input type="checkbox" value="1" name="chkIsManager" id="chkIsManager" class="checkInp" style="display:none" {if $isManager == 1} checked="checked" {/if} />
      <div class="tf" style="padding-top:20px;">
      <label>客户名称：</label>
      <div class="inp">
        {$objAgContactRecodeInfo->strCustomerName}
      </div>
      </div>
    <div class="tf">
      <label>拜访主题：</label>
      <div class="inp">
        {$objAgContactRecodeInfo->strVisitTheme}
      </div>
      </div>
    <div class="tf">
      <label> <em class="require">*</em>实际拜访时间：</label>
      <div class="inp">
      <input type="text" valid="required" class="inpDate" name="tbxContactTime" value="{$objAgContactRecodeInfo->strContactTime|date_format:'%Y-%m-%d %H:%M'}" {literal}onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>{/literal}
      -- 
      <input type="text" valid="required" class="inpCommon inpDate" name="tbxContactETime" value="{$objAgContactRecodeInfo->strContactETime|date_format:'%H:%M'}" {literal}onfocus="WdatePicker({dateFmt:'HH:mm'})"/>{/literal}
      </div>
      <span class="info">请输入实际拜访时间</span> <span class="ok">&nbsp;</span><span class="err">请输入实际拜访时间</span> 
      </div>
     <div class="tf">
      <label> <em class="require">*</em>被访人： </label>
      <div class="inp">
        <input type="text" tabindex="1" maxlength="18" valid="required" name="tbxContactName" id="tbxContactName" class="contactName" value="{$objAgContactRecodeInfo->strContactName}" autocomplete="off"/>
      </div>
      <span class="info">请输入被访人</span> <span class="ok">&nbsp;</span><span class="err">请输入被访人</span> </div> 
      <div class="tf">
        <label><em class="require">*</em>手机号：</label>
        <div class="inp">
          <input type="text" valid="mPhone" maxlength="20" name="tbxContactMobile" id="tbxContactMobile" class="mPhone" value="{$objAgContactRecodeInfo->strContactMobile}"/>
        </div>
        <span style="display: inline;" class="info">手机号或固定电话必须输入一项</span> <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span> </div>
      <div class="tf">
        <label>固定电话：</label>
        <div class="inp">
          <input type="text" valid="fPhone" name="tbxContactTel" id="tbxContactTel" maxlength="20" class="fPhone" value="{$objAgContactRecodeInfo->strContactTel}"/>
        </div>
        <span style="display: none;" class="info">固话格式:0571-8888888</span> <span style="display: none;" class="err">请输入正确固定电话号</span> </div>
      <div class="tf">
        <label onclick="IsAllianceClick()"><input type="checkbox" value="1" name="chkAlliance" id="chkAlliance" class="checkInp" style="vertical-align:middle" checked="checked" onclick="IsAllianceClick()"/>
        <em id="emAllianceClick" class="require">*</em>为网盟推广：</label>
        <div id="divIsAlliance" class="inp">
            <select onchange="AllianceChange()" name="cbAlliance" id="cbAlliance">                                
                <option value="-100|0">请选择意向等级</option>
                {foreach from=$arrayInvite item=data key=index}
                <option value="{$data.rating_id}|{$data.is_money_time}" {if $iHavePredictIncome == 1 && $objPredictIncomeInfo->iIntentionRating == $data.rating_id} selected="selected"{/if}>{$data.rating_name}</option>
                {/foreach}
            </select>
            <span id="spanIncomeMoney">
            {if $iHavePredictIncome == 0}
            预计到账时间：<input id="tbxIncomeDate" type="text" class="inpCommon inpDate" name="tbxIncomeDate" onClick="WdatePicker({literal}{dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'}){/literal}"/>
            预计到账金额：<input name="tbxIncomeMoney" id="tbxIncomeMoney" type="text"  value="" maxlength="8" onkeyup='return FloatNumber(this)' style="width:80px;text-align:right"/>元
            {else}
            预计到账时间：{$objPredictIncomeInfo->strIncomeDate}&nbsp;&nbsp;
            预计到账金额：{$objPredictIncomeInfo->iIncomeMoney}元
            {/if}
            </span>
        </div>
      </div>
      <div class="tf">
        <label><em class="require">*</em>拜访内容：</label>
        <div class="inp">
          <textarea name="tbxContactRecode" cols="50" style="width:500px;height:80px;" id="tbxContactRecode"></textarea>
          <span class="c_info">限制500字以内</span><span class="ok">&nbsp;</span><span class="err">限制500字以内</span> </div>
      </div>
      <div class="tf">
        <label>下次电话联系时间：</label>
        <div class="inp">
        <input id="tbxInviteTime" type="text" class="inpDate" name="tbxInviteTime" onClick="WdatePicker({literal}{dateFmt:'yyyy-MM-dd H:mm',minDate:'%y-%M-%d'}){/literal}"/>
        </div>
      </div>
      <div class="tf tf_submit">
        <label>&nbsp;</label>
        <div class="inp">
          <div class="ui_button ui_button_confirm">
            <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
          </div>
          <div class="ui_button ui_button_cancel"> <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a> </div>
        </div>
      </div>
    </form>
  </div>
</div>
{literal}
<script language="javascript" type="text/javascript">

function IsAllianceClick()
{
    if($DOM("chkAlliance").checked == true)
    {
        $("#divIsAlliance").show();
        $("#emAllianceClick").show();        
    }
    else
    {
        $("#divIsAlliance").hide(); 
        $("#emAllianceClick").hide();   
    }
}

function AllianceChange()
{
    var alliance = $("#cbAlliance").val();
    alliance = alliance.split("|");
    if(parseInt(alliance[1]) == 1)
    {
        $("#spanIncomeMoney").show();
    }
    else
    {
        $("#spanIncomeMoney").hide();
    }
}


var _InDealWith = false;
$(function(){    
    IsAllianceClick();
    AllianceChange();    
    
});

function v_isNull(e){return $.trim(e)!='';}                                       
new Reg.vf($('#from1'),{extValid:{isNull:v_isNull},callback:function(data){
	//数据已提交，正在处理标识
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
            
    _InDealWith = true;
	$.ajax({
	    url:'/?d=CM&c=VisitRecord&a=VisitRecordModifySubmit',
	    data:$('#from1').serialize(),
	    type:"post",
	    success:function(backData){
	    	if(parseInt(backData) == 0)
            {
                _InDealWith = false;
                PageBack();
            }    
            else
            {
                _InDealWith = false;    
                IM.tip.warn(backData);                
            } 
	    }					
	});
}});

$('#tbxContactName').autocomplete('/?d=CM&c=CMInfo&a=getContactName_ID&customer_id='+$("#tbxCustomerID").val(), {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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
        return '<div>'+item.name + '</div>';
    }
}).result(function (data,value) {//执行模糊匹配

    var contactID = value.id;
    var returnData = $PostData("/?d=CM&c=ContactRecord&a=GetContactInfo&contactID="+contactID+"&customerID="+$("#tbxCustomerID").val());
    if(returnData != "")
    {
        var jsonObj = MM.json(returnData);
        $("#tbxContactName").val(jsonObj.contact_name);
        $("#tbxContactMobile").val(jsonObj.contact_mobile);
        $("#tbxContactTel").val(jsonObj.contact_tel);
        if(parseInt(jsonObj.isCharge) == 1)
            $("#chkIsManager")[0].checked = true;
        else
            $("#chkIsManager")[0].checked = false;        
    }
    
});                    
 
     
</script>
{/literal}