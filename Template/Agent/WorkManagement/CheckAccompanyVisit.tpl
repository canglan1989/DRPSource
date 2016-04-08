 
        <form id="J_CheckForm" name="agentAddForm" class="agentAddForm">
        <!--S form_edit-->                  
        <div class="form_edit">
                       
            <!--S form_bd-->
            <div class="form_bd">    
            <input type="hidden" id="visitnoteid" name="visitnoteid" />
            
	            <div class="form_block_ft">
	                <div class="agentAuditBlock">
	                    <div class="tf">
	                            <label><em class="require">*</em>审核状态：</label>
	                            <div class="inp">
	                                <div class="ui_comboBox">
	                                    <select name="auditState" id="auditState">
	                                        <!--<option value="请选择审核状态">请选择审核状态</option>
	                                        <option value="0">未审核</option>-->
	                                        <option value="1">审核通过</option>
	                                        <option value="2">审核不通过</option>
	                                    </select>
	                                </div>
	                            </div>
	                    </div>
	                    <div class="tf">
	                            <label>审核信息：</label>
	                            <div class="inp"><textarea name="check_remark"  id="check_remark"></textarea></div>
	                    </div>
	                </div>
	                <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
                    <div class="tf tf_submit">
	                        <label>&nbsp;</label>
	                        <div class="inp">
	                            <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" id="checkAgent">确 认</button></div>
	                            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="IM.dialog.hide();">取消</a></div>
	                        </div>
	                </div>
	            </div>  
               
	            <!--E form_block_ft--> 
            </div>
            <!--E form_bd--> 
        </div>
        <!--E form_edit-->
         </form>