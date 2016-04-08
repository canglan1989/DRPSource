<!--S crumbs-->

<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：邮件发送<span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<!--S list_table_head-->
<div class="form_edit">
  <div class="form_hd">
    <div class="form_hd_left">
      <div class="form_hd_right">
        <div class="form_hd_mid">
          <h2>{$strTitle}</h2>
        </div>
      </div>
    </div>
    <span class="declare"> “<em class="require">*</em>”为必填信息 </span> </div>
  <!--E list_table_head--> 
  <!--S list_table_main-->
  <div class="form_bd">
    <form id="J_MailModify">
        <div class="tf" style="padding-top:20px;">
        <label>
        <input type="hidden" id="tbxAgentID" name="tbxAgentID" value="{$agentIDs}" />
        收件人邮箱：</label>
        <div class="inp">{$mailTo}</div>
      </div>
      <div class="tf">
        <label>邮件内容(示例)：</label>
        <div class="inp" style="background-image:url({$img}unit_agent_qustion_mail_background.jpg)">
          <div> </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <div style="font-size: 14px; font-weight:bold"><span lang="AR-SA" xml:lang="AR-SA"><em> XXX公司</em>：</span><span lang="EN-US" xml:lang="EN-US"> </span></div>
          <div style="font-size: 14px; font-weight:bold">
            <p><span lang="EN-US" xml:lang="EN-US"></span> </p>
            <p><span lang="EN-US" xml:lang="EN-US">          您好！</span></p>
            <p>            盘石——让更多的客户找到你！</p>
            <p><span lang="EN-US" xml:lang="EN-US">            非常感谢您关注盘石网盟，盘石网盟致力于</span><span lang="EN-US" xml:lang="EN-US">帮助中国企业在任何时候、任何地方都能轻松开展网络营销，将商机和梦想延伸到世界各地！</span></p>
            <p><span lang="EN-US" xml:lang="EN-US">            目前盘石正在全国寻找在互联网领域能共同发展的合作伙伴，更好的体验盘石网盟产品服务，希望您为我们填写一份调查问卷！</span></p>
            <p><span lang="EN-US" xml:lang="EN-US">         </span></p>
            <p><span lang="EN-US" xml:lang="EN-US">            盘石网盟市场调查：</span><span lang="EN-US" xml:lang="EN-US"><a onclick="" href="javascript:;">问卷地址</a>          </span></p>
          </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <div> </div>
          <hr align="left" color="#b5c4df" size="1" />
          <div>
            <div> 
              <div>全国渠道中心   </div>
              <div>盘石  全球最大的中文网站联盟</div>
              <div>杭州市拱墅区祥园路45号北部软件园盘石互联网广告大厦（310015）</div>
              <div>愿景：百年盘石 坚如磐石  成为中国互联网广告行业持续领跑者 </div>
              <div>使命：让更多的客户找到你！</div>
              <div>七剑 盘石价值观：客户第一 \   学习成长 \  团队精神 \  激情快乐 \ 迎接变化 \  正直诚信 \ 勇担责任</div>
              <p style="color:red">本邮件载有秘密信息，请您恪守保密义务，勿向第三人透露。谢谢合作</p>
            </div>
          </div>
        </div>
      </div>
      <div class="tf" style="padding-top:20px;">
        <label><em class="require">*</em>发件人邮箱：</label>
        <div class="inp">
          <input type="text" class="" style="width:200px;" name="tbxMailFrom" value="dpanshi@adpanshi.com" id="tbxMailFrom" maxlength="64" valid="required isNull" />
        </div>
        <span class="info">请输入发件人邮箱</span> <span class="ok">&nbsp;</span><span class="err">请输入发件人邮箱</span> </div>
      <div class="tf">
        <label><em class="require">*</em>发件人邮箱密码：</label>
        <div class="inp">
          <input type="password" class="newPassword" style="width:200px;" name="tbxMailPwd" value="qudaozhongxin888" id="tbxMailPwd" maxlength="48" valid="required isNull" />
        </div>
        <span class="info">请输入发件人邮箱密码</span> <span class="ok">&nbsp;</span><span class="err">请输入发件人邮箱密码</span> </div>
      
      <div class="tf">
        <label><em class="require">*</em>问卷类型：</label>
        <div class="inp">
          <select name="cbQustionType" id="cbQustionType">
            <option value="-100">请选择</option>
            {foreach from=$arrayQustionType item=data key=index}
            <option value="{$data.q_id}">{$data.q_title}</option>
            {/foreach}
          </select>
        </div>
        <span class="info">请选择问卷类型</span> <span class="ok">&nbsp;</span><span class="err">请选择问卷类型</span> </div>
      <div class="tf tf_submit">
        <label>&nbsp;</label>
        <div class="inp">
          <div class="ui_button ui_button_confirm">
            <button id="butOK" class="ui_button_inner" type="submit">确定</button>
          </div>
          <div class="ui_button ui_button_cancel"> <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">取消</a> </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!--E list_table_main--> 
<!--S Main--> 
{literal} 
<script language="javascript" type="text/javascript">

var _InDealWith = false;
new Reg.vf($('#J_MailModify'),{callback:function(formData){
    //数据已提交，正在处理标识
	if (_InDealWith) 
	{
		IM.tip.warn("邮件正在发送中，请稍候！");
		return false;
	}
    _InDealWith = true;
    
    IM.dialog.show({
        width: 250,
        title: '',
        html: '<div class="loading2">邮件正在发送中，请稍候！</div>',
        hasBg: true
    });
    
    MM.ajax({
		data:$("#J_MailModify").serialize(),
		url: "/?d=SendMail&c=SendMail&a=UnitMarketQuestionModifySubmit",
		success:function(q){
		  
            _InDealWith = false;
            IM.dialog.hide();  
                      
			if(parseInt(q) == 0){
			     IM.tip.show("发送成功！");
                 PageBack();
			}else{
                 IM.tip.warn(q);
            }
            
		}
	});
}});

$(function(){
    var cbQustionType = $DOM("cbQustionType");
  if(cbQustionType.options.length == 2)
    {
        cbQustionType.options[1].selected = true;
    }
});
</script> 
{/literal}