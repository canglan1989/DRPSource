<div class="DContInner">
<form id="J_newLXXiaoJi" class="newLXXiaoJiForm" name="newLXXiaoJiForm" action="">
<div class="bd">
{foreach from=$arrayUserList item=data key=index}
     <div class="tf">
            <label>用户名：
            </label>
            <div class="inp">{$data.user_name} </div>
    </div>            
    <div class="tf">
        <label>
        姓名：
        </label>
        <div class="inp"> {$data.e_name}</div>
    </div>     
     <div class="tf">
        <label>公司：</label>
        <div class="inp">{$data.agent_name} </div>
    </div>
    <div class="tf">
        <label>部门：</label>
        <div class="inp">{$data.dept_name} </div>
    </div>
    <div class="tf">
        <label>上级：</label>
        <div class="inp">
        {if $supName!=""}<a onclick="AgentUserSupDetial({$supid})" href="javascript:;">{$supName}</a>{/if}        
        </div>
    </div>
     <div class="tf">
        <label>员工状态：</label>
        <div class="inp">{if $data.is_lock == 0}<span style="color:#028100;">正常</span>{else}<span style="color:#EE5F00;">停用</span>{/if}</div>
    </div>        
    <div class="tf">
        <label>手机：</label>
        <div class="inp">{$data.phone} </div>
    </div> 
    <div class="tf">
        <label>电话：</label>
        <div class="inp">{$data.tel}</div>
    </div>                                
{/foreach}
</div>
<div class="ft"><div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div></div>
</form> 
</div>