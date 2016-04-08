<?php /* Smarty version 2.6.26, created on 2012-11-28 18:28:04
         compiled from Agent/showAddContactInfo.tpl */ ?>
<div class="DContInner">
<form id="J_newLXXiaoJi" action="" name="newLXXiaoJiForm" class="newLXXiaoJiForm">
    <div class="bd">
        <div class="tf">
            <label><em class="require">*</em>联系人：</label>
            <div class="inp">
                <input class="contact_name" type="text" name="contact_name" id="contact_name"  valid="required customerName" maxlength="18" tabindex="1" value="<?php echo $this->_tpl_vars['contact_name']; ?>
"/>
                <input type="hidden" name="agentId" id="agentId" value="<?php echo $this->_tpl_vars['agentId']; ?>
">
                <input type="hidden" name="isPact" id="isPact" value="<?php echo $this->_tpl_vars['isPact']; ?>
">
                <input type="hidden" name="isCharge" id="isCharge" value="<?php echo $this->_tpl_vars['isCharge']; ?>
"> <!--用来比较前后的负责人是否变-->
                <input name="ischarge" type="checkbox" class="checkInp" id="ischarge" style="margin-top:3px; vertical-align:middle" value="1" <?php if ($this->_tpl_vars['ischarge'] == 100): ?>checked="checked"<?php endif; ?>/> 是负责人</span>
            </div>
            <span class="info">请正确输入联系人姓名</span>
            <span class="ok">&nbsp;</span><span class="err">请正确输入联系人姓名</span>
        </div>
        <div class="tf">
            <label><em class="require">*</em>手机号：</label>
            <div class="inp"><input class="mPhone" type="text" name="mobile"   valid="mPhone" id="mobile" value="<?php echo $this->_tpl_vars['mobile']; ?>
"/></div>
            <span class="info" style="display:inline">手机号或固定电话必须输入一项</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
        </div>
        <div class="tf">
            <label>固定电话：</label>
            <div class="inp"><input class="fPhone" type="text" name="phone"   valid="fPhone" id="phone" value="<?php echo $this->_tpl_vars['tel']; ?>
"/></div>
            <span class="info" style="display: none;">固话格式:0571-8888888</span>
            <span class="ok">&nbsp;</span><span class="err" style="display: none;">请输入正确固定电话号</span>
        </div> 
        <div class="tf">
            <label>已邀约：</label>
            <div class="inp">
            <input name="isInvite" type="checkbox" class="checkInp" id="isInvite" style="margin-top:3px; vertical-align:middle" value="1" 
            <?php if ($this->_tpl_vars['isInvite'] == 1): ?>checked="checked"<?php endif; ?>/>
            </div>
        </div>   
        <?php if ($this->_tpl_vars['isSigned'] == 0): ?>                                           
        <div class="tf">
            <label><em class="require">*</em>意向评级：</label>
            <div class="inp">
                <select tabindex="8" name="leval" id="leval">                                
                    <option  value="0">未评级</option>
                    <option value="A" <?php if ($this->_tpl_vars['arrExpect']['inten_level'] == 'A'): ?> selected="selected" <?php endif; ?>>A</option>
                    <option value="B+" <?php if ($this->_tpl_vars['arrExpect']['inten_level'] == "B+"): ?> selected="selected" <?php endif; ?>>B+</option>
                    <option value="B-">B-</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
        </div>
        <?php endif; ?>
        <div class="tf">
            <label>预计到账金额：</label>
            <div class="inp"><input type="text"  name="expectMoney" id="expectMoney" value="<?php echo $this->_tpl_vars['arrExpect']['expect_money']; ?>
" valid="amount"></div>
            <span class="info">请输入金额</span>
            <span class="ok">&nbsp;</span><span class="err">请输入金额</span>
        </div>
        <div class="tf">
            <label>预计到账时间：</label>
            <div class="inp"><input type="text" onfocus="WdatePicker()" name="expectTime" class="inpDate"  value="<?php echo $this->_tpl_vars['arrExpect']['expect_time']; ?>
"></div>
            <span class="info">请输入时间</span>
            <span class="ok">&nbsp;</span><span class="err">请输入时间</span>
        </div>
        <div class="tf">
            <label>预计到账概率：</label>
            <div class="inp"><input type="text"  name="expectPercent" id="expectPercent" style="width:50px;" value="<?php echo $this->_tpl_vars['arrExpect']['charge_percentage']; ?>
" valid="amount"><span>%</span></div>
            <span class="info">请输入概率</span>
            <span class="ok">&nbsp;</span><span class="err">请输入概率</span>
        </div>
        <div class="tf">
            <label>预计到账类型：</label>
            <div class="inp">
                <select tabindex="8" name="type" id="type">                                
                    <option  value="0"></option>
                    <option value="1" <?php if ($this->_tpl_vars['arrExpect']['type'] == 1): ?> selected="selected" <?php endif; ?> >承诺</option>
                    <option value="2" <?php if ($this->_tpl_vars['arrExpect']['type'] == 2): ?> selected="selected" <?php endif; ?>>备份</option>                  
                </select>
            </div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>联系时间：</label>
            <div class="inp"><input type="text" onfocus="WdatePicker()" name="contactTime" class="inpDate" valid="required data" ></div>
            <span class="info">请输入时间</span>
            <span class="ok">&nbsp;</span><span class="err">请输入时间</span>
        </div>
        <div class="tf">
            <label><em class="require">*</em>联系记录：</label>
            <div class="inp"><textarea valid="required businessPosition" style="width:360px" cols="40" name="contactInfo" id="contactInfo"></textarea></div>
            <span class="info">限制500字以内</span>
            <span class="ok">&nbsp;</span><span class="err">限制500字以内</span>
        </div>                        
        <div class="tf">
            <label>传真号码：</label>
            <div class="inp"><input class="faxPhone" type="text" name="fax" valid="faxPhone" id="fax" value="<?php echo $this->_tpl_vars['fax']; ?>
"/></div>
            <span class="info">格式：0571-88888888</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确传真号码</span>
        </div>
        <div class="tf">
            <label>电子邮箱：</label>
            <div class="inp"><input class="email" type="text" name="email" id="email" valid="email" value="<?php echo $this->_tpl_vars['email']; ?>
"/></div>
            <span class="info">请输入正确邮箱</span>
            <span class="ok">&nbsp;</span><span class="err">请输入正确邮箱</span>
        </div>                        
        <div class="tf">
            <label>职务：</label>
            <div class="inp"><input class="office" type="text" name="position" id="position" value="<?php echo $this->_tpl_vars['position']; ?>
"/></div>
        </div>
        <div class="tf">
            <label>MSN：</label>
            <div class="inp"><input class="MSN" type="text" name="msn" id="msn" value="<?php echo $this->_tpl_vars['msn']; ?>
"/></div>
        </div>
        <div class="tf">
            <label>QQ：</label>
            <div class="inp"><input class="QQ" type="text" name="qq" id="qq" value="<?php echo $this->_tpl_vars['qq']; ?>
"/></div>
        </div> 
    </div>
    <div class="ft">
        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
        <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">确定</button></div> 
    </div>
</form>
</div>
<script language="javascript" type="text/javascript">
   <?php echo '
      var _InDealWith = false;
      
      
      
       var agentId = $("#agentId").val();
       var isPact = $("#isPact").val();
       
       $(\'#contact_name\').autocomplete(\'/?d=Agent&c=Agent&a=getContactName_ID&agentId=\'+agentId, {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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
                                    value: value[i].aid,
                                    result: value[i].contact_name
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return \'<div>\' + item.aid +"("+item.contact_name +")"+ \'</div>\';
                        }
                    }).result(function (data,value) {//执行模糊匹配
                        var eID = value.aid;
                        var eNAME = value.contact_name;
                            IM.dialog.show({
                                width:600,
                                height:null,
                                title:\'添加联系小记\',
                                html:IM.STATIC.LOADING,
                                start:function(){
                                    $(\'.DCont\').html($PostData("/?d=Agent&c=Agent&a=showAddContactInfo&contact_name="+encodeURIComponent(eNAME)+"&agentId="+agentId+"&isPact="+isPact)); //【中文传值】encodeURIComponent转换一下
                                }
                             })
//                       JumpPage("/?d=CM&c=CMInfo&a=showAddContactRecode&contact_id="+eID);//导入客户到自己账户下，非添加或修改
        		    });
                    
         
        
        new Reg.vf($(\'#J_newLXXiaoJi\'),{callback:function(data){
		var agentlevel = $(\'#leval\').val();
		if(agentlevel == 0)
		{
			IM.tip.warn("请选择意向评级！");
			return false;
		}
            if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
            var _InDealWith = false;
			return false;
		}
                   _InDealWith = true;    
                    $.ajax({
        			type:\'POST\',
        			data:$(\'#J_newLXXiaoJi\').serialize(),
        			url:\'/?d=Agent&c=Agent&a=AddContactInfo1&isPact=\'+isPact,
        			success:function(q)
        			{
        			    if(q==1)
                                    {
                                        IM.tip.show(\'添加成功\');
                                        JumpPage(\'/?d=Agent&c=Agent&a=showAgentinfoAddContact&agentId=\'+agentId);
                                        IM.dialog.hide();    
                                    }
                                    else
                                    {
                                        IM.tip.warn(q);   
                                    
                                    }
                                }
        		});
            
            }})
    '; ?>

</script>
        