<div class="DContInner addCheckUserCont">
<form id="J_addCheckUser" action="" name="addCheckUserForm" class="addCheckUserForm">
    <div class="bd">
        <div class="tf">
            <label><em class="require">*</em>审核人：</label>
            <div class="inp">
                <input class="checkName" type="text" name="checkName"  valid="required checkName" maxlength="" tabindex="1"/>
                <input type="checkbox" class="checkInp" value="0" name="isCheckPerson" style="margin-top:3px; vertical-align:middle" id="ischeckPerson"/> 是负责人</span>
            </div>
            <span class="info">请正确输入审核人姓名</span>
            <span class="ok">&nbsp;</span><span class="err">请正确输入审核人姓名</span>
            
        </div>               
        <div class="tf">
            <label>状态：</label>
            <select id="status" name="status">
                <option value="1">全部</option>
                <option value="2">暂停分配</option>
                <option value="3">允许分配</option>
       	    </select>
       </div>        
    </div>
<div class="ft">
    <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
    <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" tabindex="7">确定</button></div> 
</div>
</form>
</div>                

                        