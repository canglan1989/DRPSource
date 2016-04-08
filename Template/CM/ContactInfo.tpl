<div class="DContInner setPWDComfireCont">
    <form id="J_addContactInfoForm" action="" name="addContactInfoForm" class="addContactInfoForm">
        <div class="bd">
            <div class="tf">
                <label><em class="require">*</em>姓名：</label>
                <div class="inp">
                    <input class="contactName" type="text" name="contact_name"  valid="required customerName" value="{$contact_name}" maxlength="18" tabindex="1"/>
                    <input type="hidden" value="{$customer_id}" name="customer_id" class="customerID"  id="customer_id"/>
                  <!--  <input type="checkbox" class="checkInp" value="1" name="isCharge" style="margin-top:3px; vertical-align:middle"/> 是负责人</span>
                    -->
                </div>
                <span class="info">请正确输入联系人姓名</span>
                <span class="ok">&nbsp;</span><span class="err">请正确输入联系人姓名</span>
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
                <div class="inp"><input type="text" valid="mPhone" name="contact_mobile" value="{$contact_mobile}" class="mPhone"></div>
                <span class="info" style="display:inline">固定电话与手机号一项必填</span>
                <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
            </div>
            <div class="tf">
                <label><!--<em class="require">*</em>-->固定电话：</label>
                <div class="inp"><input type="text" valid="fPhone" name="contact_tel" class="fPhone" value="{$contact_tel}"></div>
                <span class="info">固话格式:0571-8888888</span>
                <span class="ok">&nbsp;</span><span class="err">请输入正确固定电话号</span>
            </div>
            <div class="tf">
                <label>传真号码：</label>
                <div class="inp"><input type="text" id="charge_fax" valid="faxPhone" name="contact_fax" class="faxPhone"  value="{$contact_fax}"></div>
                <span class="info">格式:0571-8888888</span>
                <span class="ok">&nbsp;</span><span class="err">请输入正确传真号码</span>
            </div>
            <div class="tf">
                <label>电子邮箱：</label>
                <div class="inp"><input type="text" id="charge_email" valid="email" name="contact_email" class="email" value="{$contact_email}"></div>
                <span class="info">请输入正确邮箱</span>
                <span class="ok">&nbsp;</span><span class="err">请输入正确邮箱</span>
            </div>                       
            <div class="tf">
                <label>职务：</label>
                <div class="inp"><input type="text" name="contact_position" value="{$contact_position}" ></div>
            </div>
            <div class="tf">
                <label>备注：</label>                            
                <div class="inp" ><textarea valid="businessPosition" id="direction" cols="40" name="contact_remark">{$contact_remark}</textarea></div>
                <span class="info">限制100字以内</span>
                <span class="ok">&nbsp;</span><span class="err">限制100字以内</span>
            </div>
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
            <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">确定</button></div> 
        </div>
    </form>
</div>                

<script language="javascript" type="text/javascript">
var _InDealWith = false;
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
   new Reg.vf($('#J_addContactInfoForm'),{
       extValid:{
           detailAddress:function(e){
               return (MM.getVal(MM.G('selProvince')).text!='省份')&&(MM.getVal(MM.G('selCity')).text!='市')&&(MM.getVal(MM.G('area_id')).text!='区/县')&&e!='请输入详细街道地址' && /\w|[^\x00-\xff]|(-|_|\.)/.test(e)
           },
           industry:function(e){
               return MM.getVal(MM.G('industry_pid')).text!='一级分类' && MM.getVal(MM.G('industry_id')).text!='二级分类'
           },
           businessModel:function(e){
               return (MM.getVal(MM.G('business_model')).text!='请选择')
           }
       },
       callback:function(customer_id){
           if (_InDealWith) 
       {
               IM.tip.warn("数据已提交，正在处理中！");
               return false;
       }
           if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
           var mode="addContactFront";
           if(industry_id)
           {//修改模式
               mode="modify1";
           }
           modeParam=$.getUrlParamValue("mode");
           if(modeParam)
           {
               mode="import";
           }
           _InDealWith = true;   
           $.ajax({
               type:'POST',
               dataType: "text",
               url:$.currentBasePathGet() + "?c=CMInfo&d=CM&a=" + mode,
               data:$('#J_addContactInfoForm').serialize(),
               success:function(data)
               {
                   if($.trim(data) == 1)
                   {
                               IM.tip.show('保存成功！');IM.dialog.hide();
                               JumpPage("/?d=CM&c=CMInfo&a=showDetailFront&customer_id="+$('#customer_id').val());
                   }
                   else
                   {
                       IM.tip.warn($.trim(data));
                   }
                    _InDealWith = false;   
               }
           });
   }});
   if(backUrl!="showBackInfoList")//只有前台需要自动匹配
   {
      /* $('#customer_name').autocomplete('/?d=CM&c=CMInfo&a=getCustomerName_ID', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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
   */
   }
});




    {/literal}
</script>                        