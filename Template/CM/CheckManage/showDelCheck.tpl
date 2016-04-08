<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->     
<form id="J_agentAddForm" action="" name="agentAddForm" class="agentAddForm" method="post" enctype="multipart/form-data">
    <!--S form_edit-->
    <div class="form_edit">
        <div class="form_hd">
            <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
        </div>            
        <div class="form_bd">
            <!--S form_block_bd-->
            <div class="form_block_bd">
                <div class="form_block_ft">
                    <div class="agentAuditBlock">
                        <div class="tf">
                            <label>删除原因：</label>
                            <div class="inp">{$DelReason}
                            </div>
                        </div>
                        <div class="tf">
                            <label>审核状态：</label>
                            <div class="inp">
                                <div class="ui_comboBox">
                                    <select name="check_status" id="check_status">
                                        <option value="1">审核通过</option>
                                        <option value="-1">审核不通过</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tf">
                            <label>审核备注：</label>
                            <div class="inp"><textarea id="check_remark" name="check_remark" class=""></textarea></div>
                        </div>
                    </div>
                    <div class="tf tf_submit">
                        <label>&nbsp;</label>
                        <div class="inp">
                            <div class="ui_button ui_button_confirm"><button id="btnSave" type="submit" class="ui_button_inner">确 认</button></div>
                            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="PageBack()">取消</a></div>
                        </div>
                    </div>
                </div>
                <!--E form_block_ft-->
            </div>
            <!--E form_bd-->

        </div>
                            </div>
        <!--E form_edit-->
</form>
<script type="text/javascript">
//var change_values={$change_values};//被修改的信息
var Aid = {$smarty.get.aid};
    {literal}
//显示被修改的信息
$(function(){
//    if(change_values){
//        $.addModifiedCustomerInfo(change_values);//输出被修改的项
//    }
    new Reg.vf($('#J_agentAddForm'),{isEncode:false,
                        callback:function(formdata){////formdata 表单提交数据 对象数组格式
                	var formValues = $('#J_agentAddForm').serialize();                
                 	$.ajax({
	                        type: "POST",
	                        dataType: "json",
	                        url: "/?d=CM&c=CMVerify&a=DelCheckInfo&logid="+Aid,
	                        data: formValues,
	                        success: function (q) {
					if(q.success){
						IM.tip.show(q.msg);
                                                JumpPage(q.url);
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
//    $("#check_status").change(function(){
//        var checked=$(this).val()=="-1"?true:false;
//        $("form input:checkbox").each(function(){
//            this.checked=checked;
//        });
//    });
});
    {/literal}
</script>