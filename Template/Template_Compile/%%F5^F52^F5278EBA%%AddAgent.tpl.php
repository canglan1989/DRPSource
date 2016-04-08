<?php /* Smarty version 2.6.26, created on 2013-01-25 10:08:02
         compiled from Agent/AddAgent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/AddAgent.tpl', 2, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showChannelPager'), $this);?>
')" href="javascript:";>我的渠道</a><span>&gt;</span>添加代理商</div>
<!--E crumbs--> 
<!--S form_edit-->
<div class="form_edit">
  <div class="form_hd">
    <div class="form_hd_left">
      <div class="form_hd_right">
        <div class="form_hd_mid">
          <h2><?php echo $this->_tpl_vars['strTitle']; ?>
</h2>
        </div>
      </div>
    </div>
    <span class="declare">“<em class="require">*</em>”为必填信息</span> </div>
  <!--S form_bd-->
  <div class="form_bd">
    <form id="J_agentAddForm" name="agentAddForm" class="agentAddForm">
      <div class="form_block_hd">
        <h3 class="ui_title">企业信息</h3>
        <?php if ($this->_tpl_vars['iCanAddAgent'] == 0 && $this->_tpl_vars['isCheck'] == 0): ?><span id="spanNote" style="color:red">您好，您的个人库代理商数量已经超过限制。</span><?php endif; ?></div>
      <!--S form_block_bd-->
      <div class="form_block_bd">
        <div class="tf">
          <label><em class="require">*</em>代理商名称：</label>
          <div class="inp">
            <input class="companyName" type="text" name="agent_name" maxlength="48" valid="required agentName" tabindex="1" id="agent_name" onblur="IsExistSameName(this)"/>
            <input type="hidden" id="isCheck" name="isCheck" value="<?php echo $this->_tpl_vars['isCheck']; ?>
" />
          </div>
          <span class="info">请按照营业执照上的名称填写</span> <span class="ok">&nbsp;</span><span class="err">请按照营业执照上的名称填写</span> </div>
        <div class="tf ">
          <label><em class="require">*</em>联系地址：</label>
          <div class="inp">
            <select id="selProvince" class="pri" name="pri" tabindex="2">
            </select>
            <select id="selCity" class="city" name="city" tabindex="3">
            </select>
            <select id="selArea" class="area" name="area" tabindex="4">
            </select>
            <input class="detailAddress" type="text" name="address" valid="required detailAddress"  value="请输入详细街道地址" tabindex="5" onfocus="if(this.value=='请输入详细街道地址')this.value='';this.style['color']='#555555'" id="address"/>
          </div>
          <span class="info">该联系地址为邮寄地址，请仔细填写</span> <span class="ok">&nbsp;</span><span class="err">该联系地址为邮寄地址，请仔细填写</span> </div>
        <div class="tf">
          <label><em class="require">*</em>注册地区：</label>
          <div class="inp">
            <select id="regProvince" class="pri" name="regPri" tabindex="2">
            </select>
            <select id="regCity" class="city" name="regCity" tabindex="3">
            </select>
            <select id="regArea" class="area" name="regArea" tabindex="4" valid="required detailAddress2">
            </select>
          </div>
          <span class="info">请选择注册地区</span> <span class="ok">&nbsp;</span><span class="err">请选择注册地区</span> </div>
        <div class="tf tf2">
          <label>邮政编码：</label>
          <div class="inp">
            <input class="postcode" valid="postcode" type="text" name="postcode"  maxlength="6" tabindex="6"/>
          </div>
          <span class="info">请填写公司联系地址所在地的邮政编码</span> <span class="ok">&nbsp;</span><span class="err">请填写公司联系地址所在地的邮政编码</span> </div>
        <div class="tf tf2">
          <label><em class="require">*</em>所属行业：</label>
          <div class="inp">
            <select name="industry"  tabindex="8" id="company_scale">
              <option value="1">IT硬件</option>
              <option value="2">传媒</option>
              <option value="3">网络</option>
              <option value="4">广告</option>
              <option value="5">其他</option>
            </select>
          </div>
        </div>
        <div class="tf tf2">
          <label>法人姓名：</label>
          <div class="inp">
            <input class="LegalPersonName" type="text" name="legal_person"  valid="LegalPersonName"  tabindex="7" id="legal_person"/>
          </div>
          <span class="info">请按照营业执照上的名称填写</span> <span class="ok">&nbsp;</span><span class="err">请按照营业执照上的名称填写</span> </div>
        <div class="tf">
          <label>注册资金：</label>
          <div class="inp">
            <input type="text" id="reg_capital" name="reg_capital" valid="amount"/>
          </div>
          <span class="info">请选择注册资金</span> <span class="ok">&nbsp;</span><span class="err">请选择注册资金</span> </div>
        <div class="tf">
          <label>注册时间：</label>
          <div class="inp">
            <input type="text" class="registeredTime inpDate" name="reg_date" onClick="WdatePicker(<?php echo '{maxDate:\'%y-%M-%d\'}'; ?>
)" id="reg_date"/>
          </div>
        </div>
        <div class="tf">
          <label>公司规模：</label>
          <div class="inp">
            <select name="company_scale"  tabindex="8" id="company_scale">
              <option value="0">请选择</option>
              <option value="1">10-50人</option>
              <option value="2">50-100人</option>
              <option value="3">100人以上</option>
            </select>
          </div>
        </div>
        <div class="tf">
          <label>公司销售人数：</label>
          <div class="inp">
            <select name="sales_num"  tabindex="8" id="sales_num">
              <option value="0">请选择</option>
              <option value="1">10-50人</option>
              <option value="2">50-100人</option>
              <option value="3">100-300人</option>
              <option value="4">300-600人</option>
              <option value="5">600-1000人</option>
              <option value="6">1000人以上</option>
            </select>
          </div>
        </div>
        <div class="tf">
          <label>客服人数：</label>
          <div class="inp">
            <select name="service_num"  tabindex="8" id="service_num">
              <option value="0">请选择</option>
              <option value="1">1-5人</option>
              <option value="2">5-25人</option>
              <option value="3">25-60人</option>
              <option value="4">60-120人</option>
              <option value="5">120-200人</option>
              <option value="6">200-400人</option>
              <option value="7">400人以上</option>
            </select>
          </div>
        </div>
        <div class="tf">
          <label>企业客户数：</label>
          <div class="inp">
            <select name="customer_num"  tabindex="8" id="customer_num">
              <option value="0">请选择</option>
              <option value="1">100以下</option>
              <option value="2">100-300</option>
              <option value="3">300-600</option>
              <option value="4">600-1000</option>
              <option value="5">1000-1500</option>
              <option value="6">1500-2000</option>
              <option value="7">2000-3000</option>
              <option value="8">3000以上</option>
            </select>
          </div>
        </div>
        <div class="tf">
          <label>年销售额：</label>
          <div class="inp">
            <select class="turnoverYear" name="annual_sales"  tabindex="8" id="annual_sales">
              <option value="0">请选择</option>
              <option value="1">50万以下</option>
              <option value="2">50-100万</option>
              <option value="3">100-500万</option>
              <option value="4">500-1000万</option>
              <option value="5">1000万以上</option>
            </select>
          </div>
        </div>
        <div class="tf">
          <label>公司网站：</label>
          <div class="inp">http://
            <input type="text"  name="website" id="website" valid="url"/>
          </div>
          <span class="info">请输入有效网址 如:www.abc.com</span> <span class="ok">&nbsp;</span><span class="err">请输入有效网址</span> </div>
        <div class="tf">
          <label>营业执照注册号：</label>
          <div class="inp">
            <input  type="text" valid="" name="permitRegNo" id="permitRegNo"/>
          </div>
          <span class="info">请输入营业执照注册号</span> <span class="ok">&nbsp;</span><span class="err">请输入营业执照注册号</span> </div>
        <div class="tf">
          <label>企业税号：</label>
          <div class="inp">
            <input  type="text" valid="" name="revenueNo" id="revenueNo"/>
          </div>
          <span class="info">请输入企业税号</span> <span class="ok">&nbsp;</span><span class="err">请输入企业税号</span> </div>
        <div class="tf">
          <label>经营范围：</label>
          <div class="inp">
            <textarea name="direction" cols="50" id="direction" valid="businessPosition"></textarea>
          </div>
          <span class="info">限制400字以内</span> <span class="ok">&nbsp;</span><span class="err">限制400字以内</span> </div>
      </div>
      <!--E form_block_bd--> 
      <!--S form_block_hd-->
      <div class="form_block_hd">
        <h3 class="ui_title">联系人信息</h3>
      </div>
      <!--E form_block_hd--> 
      <!--S form_block_bd-->
      <div class="form_block_bd">
        <div class="form_block_left">
          <div class="tf">
            <label><em class="require">*</em>负责人姓名：</label>
            <div class="inp">
              <input class="principalName" type="text" name="charge_person"   valid="required principalName" id="charge_person"/>
            </div>
            <span class="info"></span> <span class="ok">&nbsp;</span><span class="err">请如实填写</span> </div>
          <div class="tf">
            <label><em class="require">*</em>职务：</label>
            <div class="inp">
              <input class="office" type="text" name="charge_positon" id="charge_positon" valid="required position"/>
              <span class="info"></span> <span class="ok">&nbsp;</span><span class="err">职务请填写2个字以上</span> 
            </div>
          </div>
          <div class="tf">
            <label><em class="require">*</em>手机号：</label>
            <div class="inp">
              <input class="mPhone" type="text" name="charge_phone"  id="charge_phone" valid="mPhone"/>
            </div>
            <span class="info" style="display:inline">手机号或固定电话必须输入一项</span> <span class="err">请输入正确手机号</span> </div>
          <div class="tf">
            <label>固定电话：</label>
            <div class="inp">
              <input class="fPhone" type="text" name="charge_tel"   valid="fPhone" id="charge_tel"/>
            </div>
            <span class="info">固话格式:0571-8888888</span> <span class="err">请输入正确固定电话号</span> </div>
          <div class="tf">
            <label>微博：</label>
            <div class="inp">
              <input class="twitter" type="text" name="charge_twitter" id="charge_twitter"/>
            </div>
            <span class="info" style="display:inline">多个微博请以","隔开</span> </div>
          <div class="tf">
            <label>角色：</label>
            <div class="inp">
              <input class="twitter" type="text" name="charge_role" id="charge_role"/>
            </div>
          </div>
        </div>
        <div class="form_block_right">
          <div class="tf">
            <label>传真号码：</label>
            <div class="inp">
              <input class="faxPhone" type="text" name="charge_fax" valid="faxPhone" id="charge_fax"/>
            </div>
            <span class="info">格式:0571-8888888</span> <span class="err">请输入正确传真号码</span> </div>
          <div class="tf">
            <label>电子邮箱：</label>
            <div class="inp">
              <input class="email" type="text" name="charge_email" valid="email" id="charge_email"/>
            </div>
            <span class="info">请输入正确邮箱</span> <span class="err">请输入正确邮箱</span> </div>
          <div class="tf">
            <label>QQ：</label>
            <div class="inp">
              <input class="QQ" type="text" name="charge_qq" id="charge_qq" valid="QQ"/>
            </div>
          </div>
          <div class="tf">
            <label>MSN：</label>
            <div class="inp">
              <input class="MSN" type="text" name="charge_msn" id="charge_msn"/>
            </div>
          </div>
          <div class="tf">
            <label>备注：</label>
            <div class="inp">
              <input class="charge_mark" type="text" name="charge_mark" id="charge_mark"/>
            </div>
          </div>
        </div>
        <div class="tf tf_submit">
          <label>&nbsp;</label>
          <div class="inp"> <?php if ($this->_tpl_vars['isCheck'] == 1 || $this->_tpl_vars['iCanAddAgent'] == 1): ?>
            <div class="ui_button ui_button_confirm">
              <button type="submit" class="ui_button_inner">确认</button>
            </div>
            <?php endif; ?>
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="PageBack();">取消</a> </div>
          </div>
        </div>
      </div>
      <!--E form_block_bd-->
    </form>
  </div>
  <!--E form_bd--> 
</div>
<!--E form_edit--> 
<script language="javascript" type="text/javascript">
    <?php echo '
//验证代理商数据
new Reg.vf($(\'#J_agentAddForm\'),{
        extValid:{
            detailAddress:function(e){
                return (MM.getVal(MM.G(\'selProvince\')).text!=\'省份\')&&(MM.getVal(MM.G(\'selCity\')).text!=\'市\')&&(MM.getVal(MM.G(\'selArea\')).text!=\'区/县\')&&e!=\'请输入详细街道地址\' && /\\w|[^\\x00-\\xff]|(-|_|\\.)/.test(e)
            },
            detailAddress2:function(e){
                return (MM.getVal(MM.G(\'regProvince\')).text!=\'省份\')&&(MM.getVal(MM.G(\'regCity\')).text!=\'市\')&&(MM.getVal(MM.G(\'regArea\')).text!=\'区/县\')
            }
        },
        callback:function(data){
        if(IM.checkPhone()){IM.tip.warn(\'手机或固话必填一项\');return false;}
        if(!IM.IsSending(true)){return false;};
        $.ajax({
                type:\'POST\',
                data:$(\'#J_agentAddForm\').serialize()+\'&fromType=0\',
                '; ?>

                url:'<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'AddAgent'), $this);?>
',
                <?php echo '
				dataType:\'json\',
                success:function(data)
                {
					IM.IsSending(false);
					if(data.success == true)
					{
						IM.tip.show(data.msg);
						JumpPage(data.url);
					}
					else
					{
						IM.tip.warn(data.msg);
					}
                }
            });
}});
$(function(){
    var isCheck = $("#isCheck").val();
	//绑定省市区联动菜单
    if(isCheck == 1)
    {
        $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});	
        $("#regProvince").BindProvince({selCityID:"regCity",selAreaID:"regArea",iAddPleaseSelect:true});
    }
    else
    {
        $("#selProvince").BindProvinceChannel({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});	
        $("#regProvince").BindProvinceChannel({selCityID:"regCity",selAreaID:"regArea",iAddPleaseSelect:true});
    }
	
});
//代理商资质上传
new IM.upload({id:\'J_upload0\',noticeId:\'J_uploadImg0\','; ?>
 url: '<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'FileUpload'), $this);?>
'<?php echo '});

function IsExistSameName(obj)
{
    var strName = obj.value;
    strName.replace(/ /g,"");
    if(strName != "")
    {
        var iExist = $PostData("/?d=Agent&c=Agent&a=IsExistSameName","id=0&strName="+encodeURIComponent(strName));
        if(iExist > 0)
            IM.tip.warn("该代理商名称已经存在！");
    }
}
'; ?>

</script>