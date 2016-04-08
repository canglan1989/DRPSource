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
      <div class="tf" style="padding-top:20px;">
        <label>客户名称：</label>
        <div class="inp">
        {$objAgContactRecodeInfo->strCustomerName}
        </div>
      </div>   
      <div class="tf">
        <label>对应联系预约：</label>
        <div class="inp">        
          {if $objAgContactRecodeInfo->iRecodeId > 0}{$objAgContactRecodeInfo->strInviteContactName} {$objAgContactRecodeInfo->strInviteContactMobile} {$objAgContactRecodeInfo->strInviteContactTel}{else}
              <select name="inviteitem" id="inviteitem">
                  <option value="0">无</option>
                  {foreach from=$InvitelList item=data}
                      <option value="{$data.recode_id}">{$data.invite_contact_name} {$data.invite_contact_mobile} {$data.invite_contact_tel}</option>
                  {/foreach}
              </select>
              
          {/if}
        </div>
      </div>
      <div class="tf">
        <label><em class="require">*</em>联系人：</label>
        <div class="inp">
          <input type="text" tabindex="1" maxlength="18" valid="required" name="tbxContactName" id="tbxContactName" class="contactName" value="{$objAgContactRecodeInfo->strContactName}" autocomplete="off"/>
        <span style="display:none"><input type="checkbox" value="1" name="chkIsManager" id="chkIsManager" class="checkInp" style="vertical-align:middle" {if $isManager == 1} checked="checked" {/if} /><em style="width:100px;cursor:pointer" onclick="ChangeIsManager()" >为负责人</em></span>
        </div>
        <span class="info">请输入联系人姓名</span> <span class="ok">&nbsp;</span><span class="err">请输入联系人姓名</span> </div>
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
             <label><em class="require">*</em>联系时间：</label>
            <div class="inp">
                <input type="text" id="tbxContactTime" valid="required" class="inpDate" name="tbxContactTime" value="{if $objAgContactRecodeInfo->iRecodeId > 0}{$objAgContactRecodeInfo->strContactTime|date_format:'%Y-%m-%d %H:%M'}{else}{$smarty.now|date_format:'%Y-%m-%d %H:%M'}{/if}" {literal}onfocus="WdatePicker({dateFmt:'yyyy-MM-dd H:mm',maxDate:'%y-%M-%d %H:%m:%s',isShowClear:false,readOnly:true})"/>
            </div>{/literal}
            <span class="info">请输入联系时间</span>
            <span class="ok">&nbsp;</span><span class="err">请输入联系时间</span>
        </div>
      <div class="tf">
        <label><em class="require">*</em>联系结果：</label>
        <div class="inp">
            <label style="margin-right:20px; text-align:left" title="与客户进行了有效沟通"><input class="checkInp" type="radio" id="chkContactResult1" name="chkContactResult" value="1" onclick="ContactResultClick()" /><span style="cursor:pointer" onclick="ContactResultClick()">有效的联系</span></label>
            <label style="margin-right:20px text-align:left;" title="没有联系上客户或者联系上后马上挂掉了"><input class="checkInp" type="radio" id="chkContactResult0" checked="checked" name="chkContactResult" value="0" onclick="ContactResultClick()"/><span style="cursor:pointer" onclick="ContactResultClick()">无效的联系</span></label>
        </div>
      </div>    
      <div class="tf result0">
        <label>为网盟推广：</label>
        <div class="inp">
            <input type="checkbox" value="1" name="chkAlliance0" id="chkAlliance0" class="checkInp" style="vertical-align:middle" checked="checked" />
        </div>
      </div>
      <div class="tf result0">
        <label><em class="require">*</em>无效联系的选项：</label>
        <div class="inp">
            <select name="cbContactResult" id="cbContactResult">                                
                <option value="-100">请选择</option>
                {foreach from=$arrayNotValid item=data key=index}
                <option value="{$data.c_value}">{$data.c_name}</option>
                {/foreach}
            </select>
        </div>
      </div>
      <div id="divDelCus" style="display:none" class="tf"><!--<div class="tf result0">-->
        <label onclick="DelCustomerClick()"><input type="checkbox" value="1" name="chkDelCustomer" id="chkDelCustomer" class="checkInp" style="vertical-align:middle" onclick="DelCustomerClick()" />
        <em id="emDelCustomer" class="require">*</em>删除客户：</label>
        <div class="inp">
            <input name="tbxDelCustomer" id="tbxDelCustomer" type="text"  value="" style="width:340px;" maxlength="80"/>
            <span id="spanDelCustomer" class="c_info">请输入删除原因</span>
        </div>
      </div>       
      <div class="tf result1">
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
      <div class="tf result1">
        <label><em class="require">*</em>联系内容：</label>
        <div class="inp">
          <textarea name="tbxContactRecode" cols="50" style="width:500px;height:80px;" id="tbxContactRecode"></textarea>
          <span class="c_info">限制500字以内</span><span class="ok">&nbsp;</span><span class="err">限制500字以内</span> </div>
      </div>
      <div class="tf result0">
        <label onclick="ToSeaClick()"><input type="checkbox" value="1" name="chkToSea" id="chkToSea" class="checkInp" style="vertical-align:middle" onclick="ToSeaClick()" />
        <em id="emToSea" class="require">*</em>踢人公海：</label>
        <div class="inp">
            <select name="cbToSea" id="cbToSea">                                
                <option value="-100">请选择屏蔽天数</option>
                {foreach from=$arrayToSeaProtectDate item=data key=index}
                <option {if $index == 0} selected="selected"{/if} value="{$data.d_value}">{$data.d_name}</option>
                {/foreach}
            </select>
        </div>
      </div>
      <div id="divNextInviteTime" class="tf">
        <label>下次联系时间：</label>
        <div class="inp">
        <input id="tbxInviteTime" type="text" class="inpDate" name="tbxInviteTime" onClick="WdatePicker({literal}{dateFmt:'yyyy-MM-dd H:mm',minDate:'#F{$dp.$D(\'tbxContactTime\')}'}){/literal}"/>
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
    
$(function(){
    $("#inviteitem").change(function(){
        $.ajax({
            url:'/?d=CM&c=ContactRecord&a=getContactInfoByRecordID',
            type:'post',
            dataType:"json",
            data:{
                'recordid':$(this).val()
            },
            success:function(data){
                $("#tbxContactName").val(data.contact_name);
                $("#tbxContactMobile").val(data.contact_mobile);
                $("#tbxContactTel").val(data.contact_tel);
                    if(data.invite_time.length > 1){
                        data.invite_time = data.invite_time.substring(0,16);
                    }
                $("#tbxContactTime").val(data.invite_time);
                    $("#tbxID").val(data.recode_id);
                        $("#tbxInviteID").val(data.recode_id);
            }
        });
    });
});

function ChangeIsManager()
{
    $DOM("chkIsManager").checked = !$DOM("chkIsManager").checked;
}


function ContactResultClick()
{
    if($("#chkContactResult1")[0].checked == true)
    {
        $(".result0").hide();
        $(".result1").show();        
    }
    else
    {
        $(".result1").hide();
        $(".result0").show();   
    }
}


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

function ToSeaClick()
{
    if($DOM("chkToSea").checked == true)
    {
        $("#cbToSea").show();
        $("#emToSea").show();
        
        $DOM("chkDelCustomer").checked = false;
        DelCustomerClick();
        $("#tbxInviteTime").val("");
        $("#divNextInviteTime").hide();
    }
    else
    {
        $("#cbToSea").hide();
        $("#emToSea").hide();
        
        $("#divNextInviteTime").show();
    } 
}

function DelCustomerClick()
{
    if($DOM("chkDelCustomer").checked == true)
    {
        $("#tbxDelCustomer").show();
        $("#spanDelCustomer").show();
        $("#emDelCustomer").show();
        
        $DOM("chkToSea").checked = false;
        ToSeaClick();
        $("#tbxInviteTime").val("");
        $("#divNextInviteTime").hide();
    }
    else
    {
        $("#tbxDelCustomer").hide();
        $("#spanDelCustomer").hide(); 
        $("#emDelCustomer").hide(); 
        
        $("#divNextInviteTime").show();
    }
}


var _InDealWith = false;
$(function(){    
    ContactResultClick();
    DelCustomerClick();
    IsAllianceClick();
    ToSeaClick();
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
	    url:'/?d=CM&c=ContactRecord&a=ContactRecordModifySubmit',
	    data:$('#from1').serialize(),
	    type:"post",
	    success:function(backData){
	    	if(parseInt(backData) == 0)
            {
                IM.tip.show("添加联系小记成功");
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
        {
            $("#chkIsManager")[0].checked = true;            
        }            
        else
        {
            $("#chkIsManager")[0].checked = false;
        }
                    
    }
    
});                    
 
     
</script>
{/literal}