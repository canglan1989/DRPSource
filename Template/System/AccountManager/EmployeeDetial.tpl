<div class="DContInner">
<form id="J_newLXXiaoJi" class="newLXXiaoJiForm" name="newLXXiaoJiForm" action="">
<div class="bd">
{foreach from=$arrayUserList item=data key=index}          
      <!--<div class="tf">
        <label>公司：</label>
        <div class="inp">{$data.company_name}</div>
    </div>-->     
     <div class="tf">
            <label>
            账号名：
            </label>
            <div class="inp">{$data.e_workno}</div>
    </div>        
    <div class="tf">
        <label>
        姓名：
        </label>
        <div class="inp">{$data.e_name}</div>
    </div>  
     <div class="tf">
        <label>性别 ：</label>
        <div class="inp">{if $data.e_sex==0}男 {else}女{/if}  </div>
    </div>
       <div class="tf">
        <label>部 门：</label>
        <div class="inp">{$data.dept_fullname}</div>
    </div>
    <div class="tf">
        <label>职 位 ：</label>
        <div class="inp">{$data.post_name} </div>
    </div>
    <div class="tf">
        <label>上级：</label>
        <div class="inp">
        {if $supPosition!=""}<a onclick="UserSupDetial({$sup_uid})" href="javascript:;">{$supPosition}</a>{/if}
        </div>
    </div> 
    <div class="tf">
        <label>员工状态：</label>
        <div class="inp">{if $data.e_status == 0}聘用{/if}
                        {if $data.e_status == 1}实习{/if}
                        {if $data.e_status == 2}见习{/if}
                        {if $data.e_status == 3}外派{/if}
                        {if $data.e_status == 4}停薪留职{/if}
                        {if $data.e_status == 5}试用{/if}
                        {if $data.e_status == -1}离职中{/if}
                        {if $data.e_status == -9}已离职{/if}
                        {if $data.e_status == -10}已辞退{/if}
                        {if $data.e_status == -11}已流失{/if}</div>
    </div>   
    <div class="tf">
        <label>手机 ：</label>
        <div class="inp">{$data.e_mobile}</div>
    </div>
     <div class="tf">
        <label>公司电话 ：</label>
        <div class="inp">{$data.e_phone}</div>
    </div>
    <div class="tf">
        <label>分 机 号：</label>
        <div class="inp">{$data.e_tel_extension}</div>
    </div> 
    <div class="tf">
        <label>Email：</label>
        <div class="inp">{$data.e_email}</div>
    </div>               
{/foreach}
</div>
<div class="ft">
	<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
  </div>
</form> 
</div>