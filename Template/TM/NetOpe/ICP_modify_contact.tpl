<div class="DContInner">
                        <form id="J_taskDistForm">
                            <input id="order_id" value="{$order_id}" type="hidden"></input>
                            <div class="bd">
                                <div class="tf">                                    
                                    <label>姓名：</label>                             
                                    <div class="inp"><input type="text" value="{$icp_contact.contact_name}" name="contact_name"></div>
                                </div>
								<div class="tf">                                    
                                    <label>手机号：</label>                             
                                    <div class="inp"><input value="{$icp_contact.contact_mobile}" type="text" name="contact_mobile"></div>
                                </div>
								<div class="tf">                                    
                                    <label>固定电话：</label>                             
                                    <div class="inp"><input value="{$icp_contact.contact_tel}" type="text" name="contact_tel"></div>
                                </div>
                            </div>                                                                                     
                            <div class="ft">                                                                             
                                <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">取消</a></div>
                                <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="button" onclick="contact_modify();">确定</button></div>                      
                            </div>                                                                                                                              
                        </form>                                                                                                                                  
                    </div>