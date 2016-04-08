<?php /* Smarty version 2.6.26, created on 2013-01-23 14:44:20
         compiled from Agent/WorkManagement/AddTelNote.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'Agent/WorkManagement/AddTelNote.tpl', 56, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
<span>&gt;</span>添加电话联系小记</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>电话联系小记操作</h2></div></div></div>
        <span class="declare">“<em class="require">*</em>”为必填信息</span>
    </div>
    <!--S form_bd-->
    <div class="form_bd">
        <form id="J_AddTelNoteForm" name="AddTelNoteForm" class="AddTelNoteForm">
            <div class="form_block_hd"><h3 class="ui_title">小记信息</h3></div>		
            <!--S form_block_bd--> 
            <div class="form_block_bd">
                <?php if ($this->_tpl_vars['IsSureAppoint'] == '0'): ?>
                <div class="tf">
                    <label>电话任务：</label>
                    <div class="inp">
                        <select name="appoint" id="appoint" >
                            <option value="0">请选择</option>
                            <?php $_from = $this->_tpl_vars['AppointList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                                <option value="<?php echo $this->_tpl_vars['data']['appoint_id']; ?>
" ><?php echo $this->_tpl_vars['data']['visitor']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                <div class="tf">
                    <label>代理商名称：</label>
                    <div class="inp"><?php echo $this->_tpl_vars['AgentInfo']->strAgentName; ?>

                    </div>
                </div>
                <?php if ($this->_tpl_vars['IsPact'] == 1): ?>
                    <div class="tf">
                        <label><em class="require">*</em>签约产品：</label>
                        <div class="inp">
                            <select name="productType" id="productType">
                                <option value="-100">请选择</option>
                                <?php $_from = $this->_tpl_vars['ProductType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                                    <option value="<?php echo $this->_tpl_vars['data']['aid']; ?>
|<?php echo $this->_tpl_vars['data']['product_type_name']; ?>
" <?php if ($this->_tpl_vars['ExpectInfo']['product_id'] == $this->_tpl_vars['data']['aid']): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['data']['product_type_name']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                    </div>
                    <div class="tf">
                        <label>预计到账评估:</label>
                        <div class="inp">
                            <input type="checkbox" name="hasIncome" id="hasIncome" value="1"  class="checkInp" />&nbsp;
                        </div>
                    </div>
                                <div class="tf"  id="incomeField"  style="display:none;" >
                                    <label>&nbsp;</label>
                                    <div class="inp" >
                                        <em class="require">*</em>预计到账时间：
                                        <input id="incomeDate" type="text" value="<?php if (empty ( $this->_tpl_vars['ExpectInfo']['expect_time'] )): ?><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ExpectInfo']['expect_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
<?php endif; ?>" class="inpCommon inpDate" name="incomeDate" onClick="WdatePicker(<?php echo '{minDate:\'%y-%M-%d\'})'; ?>
"/>
                                        <em class="require">*</em>预计到账金额：
                                        <input name="incomeMoney" value="<?php echo $this->_tpl_vars['ExpectInfo']['expect_money']; ?>
" class="inpCommon" />
                                        预计到账类型：
                                        <select name="incomeType">
                                            <option value="1" <?php if ($this->_tpl_vars['ExpectInfo']['expect_type'] == 1): ?>selected<?php endif; ?> >承诺</option>
                                            <option value="2" <?php if ($this->_tpl_vars['ExpectInfo']['expect_type'] == 2): ?>selected<?php endif; ?>>备用</option>
                                        </select>
                                        <em class="require">*</em>预计达成率：
                                        <input name="incomeRate" value="<?php echo $this->_tpl_vars['ExpectInfo']['charge_percentage']; ?>
" class="inpCommon"/>%
                                    </div>
                                </div> 
                    <script language="javascript" type="text/javascript">
                                    <?php echo '
$(function(){
    $("#hasIncome").change(function(){
        if( $("#hasIncome").attr("checked") == true ){//显示
            $("#incomeField").show(200);
        }else{//隐藏
            $("#incomeField").hide(200);
        }
            return false;
    });
        return false;
});
                                        '; ?>

                </script> 
                <?php else: ?>
                    <div class="tf">
                        <label><em class="require">*</em>意向产品：</label>
                        <div class="inp">
                            <select name="productType">
                                <option value="-100">请选择</option>
                                <?php $_from = $this->_tpl_vars['ProductType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                                    <option value="<?php echo $this->_tpl_vars['data']['aid']; ?>
|<?php echo $this->_tpl_vars['data']['product_type_name']; ?>
" <?php if ($this->_tpl_vars['ExpectInfo']['product_id'] == $this->_tpl_vars['data']['aid']): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['data']['product_type_name']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </div>
                    </div>
                    <div class="tf">
                        <label><em class="require">*</em>意向等级：</label>
                        <div class="inp">
                            <select name="intentionRating" id="intentionRating">
                                    <option value="A" <?php if ($this->_tpl_vars['ExpectInfo']['inten_level'] == 'A'): ?>selected<?php endif; ?> >A</option>
                                    <option value="B+" <?php if ($this->_tpl_vars['ExpectInfo']['inten_level'] == 'B+'): ?>selected<?php endif; ?> >B+</option>
                                    <option value="B-" <?php if ($this->_tpl_vars['ExpectInfo']['inten_level'] == 'B-'): ?>selected<?php endif; ?> >B-</option>
                                    <option value="C" <?php if ($this->_tpl_vars['ExpectInfo']['inten_level'] == 'C'): ?>selected<?php endif; ?> >C</option>
                                    <option value="D" <?php if ($this->_tpl_vars['ExpectInfo']['inten_level'] == 'D'): ?>selected<?php endif; ?> >D</option>
                                    <option value="E" <?php if ($this->_tpl_vars['ExpectInfo']['inten_level'] == 'E'): ?>selected<?php endif; ?> >E</option>
                            </select>
                        </div>
                    </div>
                                <div class="tf"  id="incomeField" <?php if ($this->_tpl_vars['ExpectInfo']['inten_level'] > 'B+'): ?> style="display:none;" <?php endif; ?>>
                                    <label>&nbsp;</label>
                                    <div class="inp" >
                                        <em class="require">*</em>预计到账时间：
                                        <input id="incomeDate" type="text" value="<?php if (empty ( $this->_tpl_vars['ExpectInfo']['expect_time'] )): ?><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ExpectInfo']['expect_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
<?php endif; ?>" class="inpCommon inpDate" name="incomeDate" onClick="WdatePicker(<?php echo '{minDate:\'%y-%M-%d\'})'; ?>
"/>
                                        <em class="require">*</em>预计到账金额：
                                        <input name="incomeMoney" value="<?php echo $this->_tpl_vars['ExpectInfo']['expect_money']; ?>
" class="inpCommon" />
                                        预计到账类型：
                                        <select name="incomeType">
                                            <option value="1" <?php if ($this->_tpl_vars['ExpectInfo']['expect_type'] == 1): ?>selected<?php endif; ?> >承诺</option>
                                            <option value="2" <?php if ($this->_tpl_vars['ExpectInfo']['expect_type'] == 2): ?>selected<?php endif; ?>>备用</option>
                                        </select>
                                        <em class="require">*</em>预计达成率：
                                        <input name="incomeRate" value="<?php echo $this->_tpl_vars['ExpectInfo']['charge_percentage']; ?>
" class="inpCommon"/>%
                                    </div>
                                </div>      
                    <script language="javascript" type="text/javascript">
                                    <?php echo '
$(function(){
    $("#intentionRating").change(function(){
        if(  $("#intentionRating").val() <= \'B+\' ){//显示
            $("#incomeField").show(200);
        }else{//隐藏
            $("#incomeField").hide(200);
        }
            return false;
    });
        return false;
});
                                        '; ?>

                </script>       
                <?php endif; ?>
                <div class="tf">
                    <label><em class="require">*</em>被访人：</label>
                    <div class="inp">
                        <input name="con_visitor" id="con_visitor" valid="required" class="" value="<?php echo $this->_tpl_vars['ContactInfo']['contact_name']; ?>
" />
                        <input name="con_id" id="con_id" type="hidden" value="<?php echo $this->_tpl_vars['ContactInfo']['aid']; ?>
" />
                        <input name="agentId" id="agentId" type="hidden" value="<?php echo $this->_tpl_vars['AgentInfo']->iAgentId; ?>
" />
                        <input name="appointid" id="appointid" type="hidden" value="<?php if ($this->_tpl_vars['IsSureAppoint'] == 1): ?><?php echo $this->_tpl_vars['AppointInfo']->iAppointId; ?>
<?php else: ?>0<?php endif; ?>" />
                        <input type="checkbox" id="con_isChargePerson" <?php if ($this->_tpl_vars['ContactInfo']['isCharge'] == 0): ?>checked <?php endif; ?> class="checkInp" name="con_isChargePerson" />是负责人&nbsp;
                        <a id="con_btn" href="javascript:void(0)" onclick="showContactDetail()">展开联系人信息</a>
                    </div>
                    <span class="info">请输入被访人姓名</span><span class="ok">&nbsp;</span><span class="err">被访人姓名必填</span>
                </div>
                <div class="tf">
                    <label>手机：</label>
                    <div class="inp">
                        <input name="con_mobile" id="con_mobile" value="<?php echo $this->_tpl_vars['ContactInfo']['mobile']; ?>
" valid="mPhone" class="" />
                    </div>
                    <span class="info">请输入手机号</span><span class="ok">&nbsp;</span><span class="err">手机号格式错误</span>
                </div>
                <div class="tf">
                    <label>固定电话：</label>
                    <div class="inp">
                        <input name="con_tel" id="con_tel" value="<?php echo $this->_tpl_vars['ContactInfo']['tel']; ?>
" valid="fPhone" class="" />
                    </div>
                    <span class="info">请输入固定电话</span><span class="ok">&nbsp;</span><span class="err">电话格式：XXXX-XXXXXXXX</span>
                </div>
                <div id="contactDetail" style="display:none;">
                    <div class="tf">
                        <label>职务：</label>
                        <div class="inp">
                            <input name="con_position" id="con_position" value="<?php echo $this->_tpl_vars['ContactInfo']['position']; ?>
" class="" />
                        </div>
                    </div>
                    <div class="tf">
                        <label>传真号码：</label>
                        <div class="inp">
                            <input name="con_fax" id="con_fax" value="<?php echo $this->_tpl_vars['ContactInfo']['fax']; ?>
" valid="faxPhone" class="" />
                        </div>
                        <span class="info">请输入传真</span><span class="ok">&nbsp;</span><span class="err">传真格式：XXXX-XXXXXXXX</span>
                    </div>
                    <div class="tf">
                        <label>电子邮箱：</label>
                        <div class="inp">
                            <input name="con_email" id="con_email" value="<?php echo $this->_tpl_vars['ContactInfo']['email']; ?>
" valid="email" class="" />
                        </div>
                        <span class="info">请输入电子邮箱</span><span class="ok">&nbsp;</span><span class="err">电子邮箱格式错误</span>
                    </div>
                    <div class="tf">
                        <label>QQ：</label>
                        <div class="inp">
                            <input name="con_qq" id="con_qq" value="<?php echo $this->_tpl_vars['ContactInfo']['qq']; ?>
" valid="QQ" class="" />
                        </div>
                        <span class="info">请输入QQ</span><span class="ok">&nbsp;</span><span class="err">QQ格式错误</span>
                    </div>
                    <div class="tf">
                        <label>MSN：</label>
                        <div class="inp">
                            <input name="con_msn" id="con_msn" value="<?php echo $this->_tpl_vars['ContactInfo']['msn']; ?>
" valid="email" class="" />
                        </div>
                        <span class="info">请输入MSN</span><span class="ok">&nbsp;</span><span class="err">MSN格式错误</span>
                    </div>
                    <div class="tf">
                        <label>微薄：</label>
                        <div class="inp">
                            <input name="con_weibo" id="con_weibo" value="<?php echo $this->_tpl_vars['ContactInfo']['twitter']; ?>
" valid="url" class="" />
                        </div>
                        <span class="info">请输入微薄地址</span><span class="ok">&nbsp;</span><span class="err">格式错误</span>
                    </div>
                    <div class="tf">
                        <label>备注：</label>
                        <div class="inp">
                            <input name="con_remark" id="con_remark" value="<?php echo $this->_tpl_vars['ContactInfo']['agent_remark']; ?>
" class="" />
                        </div>
                    </div>
                </div>
                <div class="tf">
                        <label><em class="require">*</em>联系时间：</label>
                        <div class="inp">
                            <input  type="text" class="inpDate" value="<?php if ($this->_tpl_vars['IsSureAppoint'] == 1): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['AppointInfo']->strSappointTime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
<?php else: ?><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
<?php endif; ?>" name="visit_time" id="visit_time" onClick="WdatePicker(<?php echo '{maxDate:\'%y-%M-%d %H:%m\',dateFmt: \'yyyy-MM-dd HH:mm\',isShowClear:false})'; ?>
"/>
                        </div>
                    </div>
                        <table>
                            <tr>
                                <td>
                                    <div class="tf">
                                        <label><em class="require">*</em>联系小记内容：</label>
                                        <div class="inp">
                                            <select name="visit_content" id="visit_content" style="width:220px;">
                                                <option value="0">自定义</option>
                                                <?php $_from = $this->_tpl_vars['ContactContent']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                                                    <option value="<?php echo $this->_tpl_vars['data']['c_id']; ?>
"><?php echo $this->_tpl_vars['data']['c_value']; ?>
</option>
                                                 <?php endforeach; endif; unset($_from); ?>
                                            </select>

                                        </div>
                                    </div>
                                </td>
                                <td rowspan="2">
                                    <div class="tf" id="new_content">
                                        <div class="inp">
                                            <textarea name="visit_content_new" id="visit_content_new" cols="35"  style="margin-left:15px;height:85px;" ><?php if ($this->_tpl_vars['IsSureAppoint'] == 1): ?><?php echo $this->_tpl_vars['AppointInfo']->strTitle; ?>
<?php endif; ?></textarea>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="tf">
                                        <label>行业动态：</label>
                                        <div class="inp">
                                            <textarea name="dynamics" cols="30" rows="15"><?php echo $this->_tpl_vars['AgentInfo']->strDynamics; ?>
</textarea>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        
                        <div class="tf">
                        <label>下次联系日期：</label>
                        <div class="inp">
                            <input id="incomeDate" type="text" class="inpCommon inpDate" name="next_visit_time" onClick="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'visit_time\\\')}\'})'; ?>
"/>
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
<?php echo ' 
    <style>.tf label{width:160px;}</style>
    <script language="javascript" type="text/javascript">
       
var showContactDetail = function(){
    $("#contactDetail").toggle(200,function(){
        if($("#con_btn").html() == \'展开联系人信息\'){
            $("#con_btn").html("隐藏联系人信息");
        }else{
            $("#con_btn").html("展开联系人信息");
        }
        return false;
    });
};
    
var ChangeContact = function(data){
                        $("#con_id").val(data.aid);
                    if(data.isCharge == 0){
                        $("#con_isChargePerson").attr(\'checked\',true);
                    }else{
                        $("#con_isChargePerson").attr(\'checked\',false);
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

$(function(){
    
     var agentId = $("#agentId").val();
         
    $("#visit_content").change(function(){
        if($("#visit_content").val() == "0"){
            $("#new_content").show(200);
        }else{
            $("#new_content").hide(200);
        }
        return false;
    });
        
    $("#appoint").change(function(){
        var appointid = $("#appoint").val();
         $.ajax({
             url:"/?d=WorkM&c=TelWork&a=getAppointInfo",
             data:{
                 \'appid\':appointid
            },
            dataType:"json",
            type:"post",
            success:function(data){
                if(data.status){
                    $("#con_visitor").val(data.visitor);
ChangeContact(data);
                    $("#appointid").val(data.appointid);
                    
                    $("#visit_time").val(data.sappoint_time.substr(0,10));
                    $("#visit_content_new").html(data.title);                                                        
                }
                return false;
            },
            error:function(){
                IM.tip.warn("获取数据出错");
                return false;
            }
         });
    });
    
    $(\'#con_visitor\').autocomplete(\'/?d=WorkM&c=TelWork&a=getContactInfoJson&agentid=\'+agentId ,
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
                    return "<div id=\'divUser" + item.aid + "\'>" + item.contact_name + "</div>";
                }
            }).result(function (data, value) {//执行模糊匹配
                    ChangeContact(value);
                        return false;
            });
    
    return false;
});
      
    
     new Reg.vf($(\'#J_AddTelNoteForm\'),{
                callback:function(data){     
                   // if(!IM.IsSending(true)){return false;};
                    $.ajax({
                        url:\'/?d=WorkM&c=TelWork&a=AddTelNote\',
                        data:data,
                        type:"post",
                        dataType:"json",
                        success:function(data){
                            //IM.IsSending(false);
                            if(data.success){
                                IM.tip.show(data.msg);
                                PageBack();
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
    '; ?>
 
    </script>