<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}<span>&gt;</span>添加拜访小记</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>拜访小记操作</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <!--S form_bd-->
    <div class="form_bd">
        <form id="J_AddTelNoteForm" name="AddTelNoteForm" class="AddTelNoteForm" enctype="multipart/form-data">
            <div class="form_block_hd"><h3 class="ui_title">小记信息</h3></div>		
            <!--S form_block_bd--> 
            <div class="form_block_bd">
                <div class="tf">
                    <label>代理商名称：</label>
                    <div class="inp">{$AgentInfo->strAgentName}
                        <a href="javascript:void(0)" onclick="transferAgent();" >变更代理商</a>
                    </div>
                </div>
                {if $IsPact == 1}
                    <div class="tf">
                        <label>拜访类型：</label>
                        <div class="inp">
                            <input type="radio" name="visit_type" checked value="1" class="checkInp visit_type" />沟通 &nbsp;
                            <input type="radio" name="visit_type"  value="2" class="checkInp visit_type" />培训 
                        </div>
                    </div>
                    <div class="tf">
                        <label><em class="require">*</em>签约产品：</label>
                        <div class="inp">
                            <select name="productType" id="productType">
                                <option value="-100">请选择</option>
                                {foreach from=$ProductType item=data}
                                    <option value="{$data.aid}|{$data.product_type_name}" {if $ExpectInfo.product_id == $data.aid}selected{/if} >{$data.product_type_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div id="visit_type_1">
                        <div class="tf">
                            <label>预计到账评估:</label>
                            <div class="inp">
                                <input type="checkbox" name="hasIncome" id="hasIncome" value="1" checked  class="checkInp" />&nbsp;
                            </div>
                        </div>
                        <div class="tf"  id="incomeField"  >
                            <label>&nbsp;</label>
                            <div class="inp" >
                                <em class="require">*</em>预计到账时间：
                                <input id="incomeDate" type="text" value="{if empty($ExpectInfo.expect_time)}{$smarty.now|date_format:'%Y-%m-%d'}{else}{$ExpectInfo.expect_time|date_format:'%Y-%m-%d'}{/if}" class="inpCommon inpDate" name="incomeDate" onClick="WdatePicker({literal}{minDate:'%y-%M-%d'}){/literal}"/>
                                <em class="require">*</em>预计到账金额：
                                <input name="incomeMoney" value="{$ExpectInfo.expect_money}" class="inpCommon" />
                                预计到账类型：
                                <select name="incomeType">
                                    <option value="0" {if $ExpectInfo.expect_type == 0}selected{/if} >空白</option>
                                    <option value="1" {if $ExpectInfo.expect_type == 1}selected{/if} >承诺</option>
                                    <option value="2" {if $ExpectInfo.expect_type == 2}selected{/if}>备用</option>
                                </select>
                                <em class="require">*</em>预计达成率：
                                <input name="incomeRate" value="{$ExpectInfo.charge_percentage}" class="inpCommon"/>%
                            </div>
                        </div>
                    </div>
                    <div id="visit_type_2" style="display:none;">
                        <div class="table_attention tf">
                            <label>&nbsp;</label>
                            <div class="inp">
                                <span class="ui_link">温馨提示：文件格式必须是<span id="spanNote" style="color:red">文档</span>。文件大小限制：10M。</span>
                            </div>
                        </div>
                        <div class="tf">
                            <label>上传资料操作:</label>
                            <div class="inp">
                                附件类型：
                                <select onchange="DocTypeChanged()" name="cbDocType" id="cbDocType" valid="filetypeselect" style="width:165px;" >
                                    <option value="0">请选择</option>
                                    {foreach from=$arrayAgentDocType item=value key=key}
                                        <option value="{$key}">{$value}</option>
                                    {/foreach}
                                </select>
                                <span id="divType_c">作者：
                                    <input name="tbxAuthor" type="text" id="tbxAuthor" style="width:165px;" size="30" maxlength="20"/>
                                </span>
                                <span id="divType_q">资质类型：
                                    <select name="cbPermitType" id="cbPermitType" style="width:165px;" >
                                        <option selected="selected" value="-100">请选择</option>
                                        <option value="1">营业执照</option>
                                        <option value="2">税务登记证</option>
                                        <option value="3">法人身份证</option>
                                        <option value="4">组织机构代码证</option>
                                        <option value="5">般纳税人资格证</option>
                                    </select>
                                </span>
                                附件：
                                <input type="file"  name="fileUpload" id="fileUpload"  style="width:220px;"  />
                                <input type="hidden" name="tbxUploadFilePath" id="tbxUploadFilePath" />
                                <input type="hidden" name="filename" id="filename" />
                                <a href="javascript:void(0);" onclick="DoUploadFile()">上传</a>
                            </div>
                        </div>
                    </div>
                    <script language="javascript" type="text/javascript">
                        var agentId = '{$AgentInfo->iAgentId}';
                        {literal}      
function getPostDataInfo(){
    return "&tbxAgentID="+ agentId + "&cbDocType=" + $("#cbDocType").val() + "&cbPermitType=" + $("#cbPermitType").val() + "&tbxAuthor=" + $("#tbxAuthor").val();
}      
$(function(){
    $("#hasIncome").click(function(){
        var aaa = document.getElementById("hasIncome");
        if(aaa.checked){
            $("#incomeField").show(200);
        }else{
            $("#incomeField").hide(200);
        }
    });
        
        $(".visit_type").change(function(){
                if($(this).val() == "1"){
                    $("#visit_type_1").show(200);
                    $("#visit_type_2").hide(200);
                }else{
                    $("#visit_type_1").hide(200);
                    $("#visit_type_2").show(200);
                }
                return false;
        });
            
        return false;
});
    
var _InDealWith = false;
function UploadFile(){ 
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    _InDealWith = true;
    $.ajaxFileUpload({
    	url:"/?d=Agent&c=AgentDoc&a=UploadFile"+getPostDataInfo(),
    	secureuri:false,
    	fileElementId:"fileUpload",
    	dataType: 'text',
    	success: function (data){
            if(data.substring(0,1) != "{")
            {
    	       _InDealWith = false;
                IM.tip.warn(data);
                return;
            }
	    
            data = eval("("+data+")");

            if(data.success == false)
            {
    	       _InDealWith = false;
                IM.tip.warn(data.msg);
            }else{
                _InDealWith = false;
                 IM.tip.show("上传成功");   
                 $("#tbxUploadFilePath").val(data.msg);
                $("#filename").val(GetUploadFileName());
            }
    	}
    });
    _InDealWith = false;
}  
 

function GetUploadFileName()
{
    var filepath = $("#fileUpload").val();
    var arrayfilename = filepath.split('\\');
    return encodeURIComponent(arrayfilename[arrayfilename.length - 1]);            
}
    
    function DocTypeChanged()
{
    var obj = $DOM("cbDocType");
    $("#divType_c").hide();
    $("#divType_q").hide();
    if(obj.value == 3)
    {
        $("#spanNote").html("图片");
        $("#divType_q").show();
    }
    else
    {
        $("#spanNote").html("文档");
        $("#divType_c").show();
    }    
}
    
    
function DoUploadFile(){ 
    if($("#cbDocType").val() == 3 && $("#cbPermitType").val()<=0)
        {
            IM.tip.warn("请选择资质类型");
            return;
        }
        
        var filename = GetUploadFileName();
        var backData = $PostData("/?d=Agent&c=AgentDoc&a=IsExistFile","filename="+filename + getPostDataInfo());
        if(parseInt(backData) == 0)
        {
            UploadFile();
        }
        else if(parseInt(backData) == 1)
        {
            IM.dialog.show({
                width: 250,
                title: "提示",
                html: '数据加载中..',
                start: function () {
                    $('.DCont')[0].innerHTML = '<div class="DContInner delAccountCont">' +
                        '<div class="bd"><h4>文件已经存在，是否覆盖？</h4></div>' +
                        '<div class="ft">' +
                        '<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>' +
                        '<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" onclick="IM.dialog.ok();">确 定</button></div>' +
                        '</div></div>';
                },
                ok:function (){
                    IM.dialog.hide(); 
                    UploadFile();   
                }
            });
        }
        else
        {
            IM.tip.warn(backData);
        }
}
    
    DocTypeChanged();
                        {/literal}
                    </script> 
                {else}
                    <div class="tf">
                        <label><em class="require">*</em>意向产品：</label>
                        <div class="inp">
                            <select name="productType">
                                <option value="-100">请选择</option>
                                {foreach from=$ProductType item=data}
                                    <option value="{$data.aid}|{$data.product_type_name}" {if $ExpectInfo.product_id == $data.aid}selected{/if} >{$data.product_type_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="tf">
                        <label><em class="require">*</em>意向等级：</label>
                        <div class="inp">
                            <select name="intentionRating" id="intentionRating">
                                <option value="A" {if $ExpectInfo.inten_level == 'A'}selected{/if} >A</option>
                                <option value="B+" {if $ExpectInfo.inten_level == 'B+'}selected{/if} >B+</option>
                                <option value="B-" {if $ExpectInfo.inten_level == 'B-'}selected{/if} >B-</option>
                                <option value="C" {if $ExpectInfo.inten_level == 'C'}selected{/if} >C</option>
                                <option value="D" {if $ExpectInfo.inten_level == 'D'}selected{/if} >D</option>
                                <option value="E" {if $ExpectInfo.inten_level == 'E'}selected{/if} >E</option>
                            </select>
<!--                            <span id="incomeField" {if $ExpectInfo.inten_level > 'B+'} style="display:none;" {/if}>
                                <em class="require">*</em>预计到账时间：
                                <input id="incomeDate" type="text" value="{if empty($ExpectInfo.expect_time)}{$smarty.now|date_format:'%Y-%m-%d'}{else}{$ExpectInfo.expect_time|date_format:'%Y-%m-%d'}{/if}" class="inpCommon inpDate" name="incomeDate" onClick="WdatePicker({literal}{minDate:'%y-%M-%d'}){/literal}"/>
                                <em class="require">*</em>预计到账金额：
                                <input name="incomeMoney" value="{$ExpectInfo.expect_money}" class="inpCommon" />
                                预计到账类型：
                                <select name="incomeType">
                                    <option value="1" {if $ExpectInfo.expect_type == 1}selected{/if} >承诺</option>
                                    <option value="2" {if $ExpectInfo.expect_type == 2}selected{/if}>备用</option>
                                </select>
                                <em class="require">*</em>预计达成率：
                                <input name="incomeRate" value="{$ExpectInfo.charge_percentage}" class="inpCommon"/>
                            </span>-->
                        </div>
                    </div>
                    <div class="tf"  id="incomeField" {if $ExpectInfo.inten_level > 'B+'} style="display:none;" {/if}>
                        <label>&nbsp;</label>
                        <div class="inp" >
                            <em class="require">*</em>预计到账时间：
                            <input id="incomeDate" type="text" value="{if empty($ExpectInfo.expect_time)}{$smarty.now|date_format:'%Y-%m-%d'}{else}{$ExpectInfo.expect_time|date_format:'%Y-%m-%d'}{/if}" class="inpCommon inpDate" name="incomeDate" onClick="WdatePicker({literal}{minDate:'%y-%M-%d'}){/literal}"/>
                            <em class="require">*</em>预计到账金额：
                            <input name="incomeMoney" value="{$ExpectInfo.expect_money}" class="inpCommon" />
                            预计到账类型：
                            <select name="incomeType">
                                <option value="0" {if $ExpectInfo.expect_type == 0}selected{/if} >空白</option>
                                <option value="1" {if $ExpectInfo.expect_type == 1}selected{/if} >承诺</option>
                                <option value="2" {if $ExpectInfo.expect_type == 2}selected{/if}>备用</option>
                            </select>
                            <em class="require">*</em>预计达成率：
                            <input name="incomeRate" value="{$ExpectInfo.charge_percentage}" class="inpCommon"/>%
                        </div>
                    </div>      
                    <script language="javascript" type="text/javascript">
                        {literal}
$(function(){
    $("#intentionRating").change(function(){
        if(  $("#intentionRating").val() <= 'B+' ){//显示
            $("#incomeField").show(200);
        }else{//隐藏
            $("#incomeField").hide(200);
        }
            return false;
    });
        return false;
});
                        {/literal}
                    </script>       
                {/if}
                <div class="tf">
                    <label><em class="require">*</em>被访人：</label>
                    <div class="inp">
                        <input name="con_visitor" id="con_visitor" valid="required customerName" class="" value="{$ContactInfo.contact_name}" />
                        <input name="con_id" id="con_id" type="hidden" value="{$ContactInfo.aid}" />
                        <input name="agentId" id="agentId" type="hidden" value="{$AgentInfo->iAgentId}" />
                        <input name="appointid" id="appointid" type="hidden" value="{$AppointInfo->iAppointId}" />
                        <input type="checkbox" id="con_isChargePerson" {if $ContactInfo.isCharge == 0}checked {/if} class="checkInp" name="con_isChargePerson" />是负责人&nbsp;
                        <a id="con_btn" href="javascript:void(0)" onclick="showContactDetail()">展开联系人信息</a>
                    </div>
                    <span class="info">请输入被访人姓名</span><span class="ok">&nbsp;</span><span class="err">被访人姓名必填或格式错误</span>
                </div>
                <div class="tf">
                    <label>手机：</label>
                    <div class="inp">
                        <input name="con_mobile" id="con_mobile" value="{$ContactInfo.mobile}" valid="mPhone" class="" />
                    </div>
                    <span class="info">请输入手机号</span><span class="ok">&nbsp;</span><span class="err">手机号格式错误</span>
                </div>
                <div class="tf">
                    <label>固定电话：</label>
                    <div class="inp">
                        <input name="con_tel" id="con_tel" value="{$ContactInfo.tel}" valid="fPhone" class="" />
                    </div>
                    <span class="info">请输入固定电话</span><span class="ok">&nbsp;</span><span class="err">电话格式：XXXX-XXXXXXXX</span>
                </div>
                <div id="contactDetail" style="display:none;">
                    <div class="tf">
                        <label>职务：</label>
                        <div class="inp">
                            <input name="con_position" id="con_position" value="{$ContactInfo.position}" class="" />
                        </div>
                    </div>
                    <div class="tf">
                        <label>传真号码：</label>
                        <div class="inp">
                            <input name="con_fax" id="con_fax" value="{$ContactInfo.fax}" valid="faxPhone" class="" />
                        </div>
                        <span class="info">请输入传真</span><span class="ok">&nbsp;</span><span class="err">传真格式：XXXX-XXXXXXXX</span>
                    </div>
                    <div class="tf">
                        <label>电子邮箱：</label>
                        <div class="inp">
                            <input name="con_email" id="con_email" value="{$ContactInfo.email}" valid="email" class="" />
                        </div>
                        <span class="info">请输入电子邮箱</span><span class="ok">&nbsp;</span><span class="err">电子邮箱格式错误</span>
                    </div>
                    <div class="tf">
                        <label>QQ：</label>
                        <div class="inp">
                            <input name="con_qq" id="con_qq" value="{$ContactInfo.qq}" valid="QQ" class="" />
                        </div>
                        <span class="info">请输入QQ</span><span class="ok">&nbsp;</span><span class="err">QQ格式错误</span>
                    </div>
                    <div class="tf">
                        <label>MSN：</label>
                        <div class="inp">
                            <input name="con_msn" id="con_msn" value="{$ContactInfo.msn}" valid="email" class="" />
                        </div>
                        <span class="info">请输入MSN</span><span class="ok">&nbsp;</span><span class="err">MSN格式错误</span>
                    </div>
                    <div class="tf">
                        <label>微薄：</label>
                        <div class="inp">
                            <input name="con_weibo" id="con_weibo" value="{$ContactInfo.twitter}" valid="url" class="" />
                        </div>
                        <span class="info">请输入微薄地址</span><span class="ok">&nbsp;</span><span class="err">格式错误</span>
                    </div>
                    <div class="tf">
                        <label>备注：</label>
                        <div class="inp">
                            <input name="con_remark" id="con_remark" value="{$ContactInfo.agent_remark}" class="" />
                        </div>
                    </div>
                </div>
                <div class="tf">
                    <label><em class="require">*</em>拜访日期：</label>
                    <div class="inp">
                        <input  type="text" class="inpDate" value="{$AppointInfo->strSappointTime|date_format:"%Y-%m-%d %H:%M"}" name="visit_time" id="visit_time" onClick="WdatePicker({literal}{maxDate:'%y-%M-%d 23:59',dateFmt: 'yyyy-MM-dd HH:mm',isShowClear:false}){/literal}"/>至
                        <input  type="text" class="inpDate" value="{$AppointInfo->strEappointTime|date_format:"%H:%M"}" name="visit_time_end" id="visit_time_end" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'visit_time\')}',maxDate:'23:59',dateFmt: 'HH:mm',isShowClear:false}){/literal}"/>
                    </div>
                </div>
                <div class="tf">
                    <label>拜访计划：</label>
                    <div class="inp">{$AppointInfo->strTitle}</div>
                    <input name="visit_plan" type="hidden" value="{$AppointInfo->strTitle}" />
                </div>
                <div class="tf">
                    <label><em class="require">*</em>拜访结果：</label>
                    <div class="inp">
                        <textarea name="visit_content_new" id="visit_content_new" style="width:500px;height:250px;"  >{if $IsSureAppoint == 1}{$AppointInfo->strTitle}{/if}</textarea>
                    </div>
                </div>
                <div class="tf">
                    <label>&nbsp;</label>
                    <div class="inp">
                        <input id="goNext" type="checkbox" class="checkInp" name="goNext" />设置下次拜访预约
                    </div>
                </div>
                <!--E form_block_bd-->		
                <div class="tf tf_submit">
                    <label>&nbsp;</label>
                    <div class="inp">   
                        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确认</button></div>
                        <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">取消</a> </div>
                    </div>
                </div>
            </div>
            <!--E form_block_bd--> 
        </form>
    </div>
    <!--E form_bd--> 
    {literal} 
        <style>.tf label{width:160px;}</style>
        <script language="javascript" type="text/javascript">
    var showContactDetail = function(){
        $("#contactDetail").toggle(200,function(){
            if($("#con_btn").html() == '展开联系人信息'){
                $("#con_btn").html("隐藏联系人信息");
            }else{
                $("#con_btn").html("展开联系人信息");
            }
            return false;
        });
    };
    $(function(){
  var agentId = $("#agentId").val();
    
     $('#con_visitor').autocomplete('/?d=WorkM&c=TelWork&a=getContactInfoJson&agentid='+agentId ,
     {                                                             //页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 15, //只显示15行
                width: 150, //下拉列表的宽
                parse: function (Data) {//q 返回的数据 JSON 格式，在这里解析成列表         
                    var parsed = [];
                    if (Data == "" || Data.length == 0)
                        return parsed;
                    //alert(backData);
                    Data = MM.json(Data);
                    var value = Data.value;
                    //alert(value);
                    if (value == undefined)
                        return parsed;

                    for (var i = 0; i < value.length; i++) {
                        parsed[parsed.length] = {
                            data: value[i],
                            value: value[i].aid,
                            result: value[i].contact_name
                        }
                    }
                    return parsed;
                },
                formatItem: function (item) {//内部方法生成列表
                    //_id=item.id;
                    return "<div id='divUser" + item.aid + "'>" + item.contact_name + "</div>";
                }
            }).result(function (data, value) {//执行模糊匹配
                    ChangeContact(value);
                        return false;
            });
    
        return false;
    });
        
        
        
            var ChangeContact = function(data){
                        $("#con_id").val(data.aid);
                    if(data.isCharge == 0){
                        $("#con_isChargePerson").attr('checked',true);
                    }else{
                        $("#con_isChargePerson").attr('checked',false);
                    }
                     $("#con_mobile").val(data.mobile);
                    $("#con_tel").val(data.tel);
                    $("#con_position").val(data.position);
                    $("#con_fax").val(data.fax);
                    $("#con_email").val(data.email);
                    $("#con_qq").val(data.qq);
                    $("#con_msn").val(data.msn);
                    $("#con_weibo").val(data.twitter);
                    $("#con_remark").val(data.agent_remark);   
    return false;
}
    
         new Reg.vf($('#J_AddTelNoteForm'),{
                    callback:function(data){     
                       // if(!IM.IsSending(true)){return false;};
                        $.ajax({
                            url:'/?d=WorkM&c=VisitAppoint&a=AddVisitNote',
                            data:data,
                            type:"post",
                            dataType:"json",
                            success:function(data){
                                //IM.IsSending(false);
                                if(data.success){
                                    IM.tip.show(data.msg);
                                   if(data.url == ""){
                                       PageBack();
                                    }else{
                                        JumpPage(data.url,false);
                                    }
                                    
                                }else{
                                    IM.tip.warn(data.msg);
                                }
                            },
                            error:function(){
                                IM.tip.warn("系统出错");
                            }
                        });
                    }
            });
                
var transferAgent = function(){
             IM.dialog.show({
            width:600,
            title:"变更代理商",
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get("/?d=WorkM&c=VisitAppoint&a=showTransferAgent",{},function(q){
                    $('.DCont')[0].innerHTML=q;
                        
                        $('#trans_agent_name').autocomplete('/?d=CM&c=CMTransfer&a=getAgentName_ID', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                        max: 5, //只显示5行
                        width: 150, //下拉列表的宽
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
                                    result: value[i].no +"("+ value[i].user_name +")("+value[i].name +")"
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return "<div>" + item.no +"("+ item.user_name +")("+item.name +")"+ "</div>";
                        }
                    }).result(function (data,value) {//执行模糊匹配
                        var id = value.id;
                        $("#trans_agent_id").val(id);
                            });
                        

                });
            }
        });  
}
    
                            var goTransfer = function(){
                            var agentid = $("#trans_agent_id").val();
                                var appointid = $("#appointid").val();
                                    IM.dialog.hide();
                                if(agentid > 0){
                                    JumpPage('/?d=WorkM&c=VisitAppoint&a=showAddVisitNote&appid='+appointid+'&agentid='+agentid);
}
};
    
    
        {/literal} 
    </script>