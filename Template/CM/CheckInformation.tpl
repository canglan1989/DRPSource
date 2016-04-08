
                <div class="DContInner setPWDComfireCont">
                <form id="J_addTaskForm" action="" name="addTaskForm" class="addTaskForm" >
                	<div class="bd">
                    
                  
                    
                        <div class="tf">
                        <label><em class="require">*</em>审核状态：</label>
                            <div class="inp">{$arrCheckStatusInfo.0.check_status_name}</div>  <!-- 数组打印出来形势是Array ( [0] => Array ( [check_remark] => [check_status_name] => 通过 ) ) -->
							
                        </div>
                        <div class="tf">
                        <label><em class="require">*</em>审核备注：</label>
                            <div class="inp">
				<textarea cols="50" class="comment" style="border:none;background:none;">{$arrCheckStatusInfo.0.check_remark}</textarea>
				</div>
						
                        </div>
                      
                    </div>
                    <div class="ft">
                        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
                       
                    </div>
                </form>
                </div>                
                









