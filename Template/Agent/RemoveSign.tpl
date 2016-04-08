    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商签约管理<span>&gt;</span>解除签约</div>
    <!--E crumbs-->

    <div class="form_edit">
            <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>解除签约</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
            </div>
			<!--S form_bd-->
            <div class="form_bd">
                <form id="removeSignForm" action="" name="removeSignForm" class="removeSignForm" method="post">
                <input type="hidden" value="{$iPactID}" name="PactID">
                <input type="hidden" value="{$agentID}" name="agentID">
                <div class="bd" style="padding:10px 20px;">                                   
                                确定要取消和该代理商的合作关系？                                                           
                </div>                                                                          
                <div class="bd">                                                                 
                    <div class="tf">                                                              
                    <label style="width:50px"><em class="require">*</em>备注：</label>                               
                    <div class="inp"><textarea name="comment" cols="50" valid="required businessPosition"></textarea></div>
                    <span class="info">限制100字以内</span>                                                              
                    <span class="ok">&nbsp;</span><span class="err">限制100字以内</span>                                                                
                    </div>                                                                                               
                </div>                                                                                                    
                <div class="ft">                                                                                           
                    <div class="ui_button ui_button_confirm"><button type="button" class="ui_button_inner" id="removeSubmit">确 定</button></div>
                    <div class="ui_button ui_button_cancel"><a href="javascript:;" onclick="PageBack()" class="ui_button_inner">取消</a></div>                                                                                                                                         
                </div>                                                                                                                                              
                </form>
            </div>
    </div>
    <!--E form_edit-->              
{literal}
<script>
    $("#removeSubmit").click(function(){
	$.ajax({
	    {/literal}url:'{au d=Agent c=AgentMove a=RemoveSign}'{literal},
	    data:$("#removeSignForm").serialize(),
	    type:"post",
	    success:function(data){
	        if(data!=0)
		{
		    IM.tip.show('操作成功');
		    {/literal}var redirectUrl="{au d=Agent c=AgentMove a=HasSignedIndex}";{literal}
            JumpPage(redirectUrl);
		}
		else
		    IM.tip.warn('系统出错');
		
	    }
	});
    })
</script>
{/literal}

