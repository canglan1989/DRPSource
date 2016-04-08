<div class="DContInner ">
  <form id="J_accountGroup" class="accountGroupForm" name="accountGroupForm" action="">
    <div class="bd">
      <div class="tf">
        <label> <em class="require">*</em> 账号： </label>
        <div class="inp">
          <input class="accountName" type="text" valid="required" name="accountName" id="accountName" value="{$managerName}" autocomplete="off" maxlength="32"/>
          <input id="tbxAccountID" name="tbxAccountID" type="hidden" value="{$managerID}" />
          <input id="tbxID" name="tbxID" type="hidden" value="{$iAgroupManagerID}" />
        </div>
        <span class="info">请输入账号</span> <span class="ok">&nbsp;</span><span class="err">请输入账号</span> </div>
      <div class="tf">
        <label>全部区域：</label>
        <div class="inp">
          <ul class="allGroupBlock">
          {foreach from=$arrayAreaGroup item=data key=index}
            <li>
              <input name="chkGroup" type="checkbox" class="checkInp" value="{$data.agroup_id}" {if $data.is_check == 1} checked="checked" {/if} />{$data.agroup_name}
            </li>
          {if (($index+1)%4 == 0)}
          </ul>
          <ul class="allGroupBlock">
          {/if}
          {/foreach}
          </ul>
        </div>
      </div>
    </div>
    <div class="ft">
      <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a> </div>
      <div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确 定</button></div>
    </div>
  </form>
</div>
