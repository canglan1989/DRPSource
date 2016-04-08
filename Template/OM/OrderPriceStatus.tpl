<div class="DContInner">
<form id="J_newLXXiaoJi" class="newLXXiaoJiForm" name="newLXXiaoJiForm" action="">
<div class="bd">
 <div class="tf">
        <label>款项状态：
        </label>
        <div class="inp">
        {if $act_price != 0 && $check_status >= 0}
        {if $is_charge == 1}
        扣款
        {else}
        冻结
        {/if}
        {else}
        未扣款
        {/if} 
        </div>
</div>  
{foreach from=$arrayMoney item=data key=index}
     <div class="tf">
            <label>{$data.account_type}：
            </label>
            <div class="inp">{$data.act_money} </div>
    </div>                                      
{/foreach}
</div>
<div class="ft"><div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div></div>
</form> 
</div>