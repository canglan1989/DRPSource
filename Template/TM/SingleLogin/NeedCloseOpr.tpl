<div class="DContInner setPWDComfireCont">
    <form name="J_handleAudit" action="" id="J_handleAudit">
        <div class="bd">
            <div class="tf" >                                    
                <label>账号使用截止时间：</label>                             
                <div class="inp">
                <input id="J_editTimeE" value="{$EffectEndDate|date_format:"%Y-%m-%d"}" class="inpCommon inpDate" name="create_time_end" onClick="WdatePicker({literal}{minDate:'%y-%M-%d'}){/literal}"/>
                <input type="hidden" name="accountid" value="{$Aid}" />
                </div>                 
            </div>                                                                         
        </div>                                                                                    
        <div class="ft">     	    
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onclick="IM.dialog.hide()">取 消</a></div>                                                                        
            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>           
        </div>                                                                                                                              
    </form>                                                                                                                                  
</div>