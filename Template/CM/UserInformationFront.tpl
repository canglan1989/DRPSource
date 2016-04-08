		        <div class="DContInner">
                <form id="J_newLXXiaoJi" action="" name="newLXXiaoJiForm" class="newLXXiaoJiForm">
                	<div class="bd">
                        <div class="tf">
                        	<label><em class="require">*</em>账号名：</label>
                            <div class="inp">{$arrUserInformationInfo.0.user_id}</div>
                        </div>
                      
                        <div class="tf">
                        	<label>上级：</label>
                            <div class="inp">
                            <a href="javascript:;" onClick="AgentUserSupDetial({$arrUserInformationInfo.0.user_id})" href="javascript:;">{$arrSuperiorInformationInfo}</a>
                            </div>
                        </div>
                        <div class="tf">
                        	<label>账号状态：</label>
                            <div class="inp">{$arrUserInformationInfo.0.is_lock_name}</div>
                        </div>
                        <div class="tf">
                        	<label>公司：</label>
                            <div class="inp">{$arrUserInformationInfo.0.agent_name}</div>
                        </div>
                        <div class="tf">
                        	<label><em class="require">*</em>姓名：</label>
                            <div class="inp">{$arrUserInformationInfo.0.user_name}</div>
                        </div>                      
                        <div class="tf">
                        	<label>联系电话：</label>
                            <div class="inp">{$arrUserInformationInfo.0.tel}/{$arrUserInformationInfo.0.phone}</div>
                        </div>
                        <div class="tf">
                        	<label>角色：</label>
                            <div class="inp"></div>
                        </div>
                    </div>
                    <div class="ft">
                        <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
                        
                    </div>
                </form>
                </div>
      <script type="text/javascript">
      {literal}
      function showSuperiorInfor($arrUserInformationInfo.0.user_no){
         IM.dialog.show({
            width:500,
            height:null,
            title:'审核状态查询',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=CM&c=CMInfo&a=showSuperiorInfo&user_no="+$arrUserInformationInfo.0.user_no,""));
            }
         })
    }
      
      {/literal}
      </script>          
                        