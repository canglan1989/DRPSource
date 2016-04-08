<div class="DContInner">
<form id="J_accountAreaBind" class="newProductForm" name="J_accountAreaBind" >  
    <div class="bd">
	<div class="tf">
		<label>  账号名： </label>
		<div class="inp">{$e_name}{$user_name}</div>
        <input type="hidden" id="acc_uid" name="acc_uid" value="{$id}" />
        <input type="hidden" id="account_group_id" name="account_group_id" value="{$account_group_id}" />
	</div>
    <div class="tf">
        <label>区域组名：</label>
        <div class="inp">
        <select id="cbAreaGroupName1" name="cbAreaGroupName1" onchange="SelectAreaGroup()">
        <option value="-100" selected="selected">=请选择区域组层级=</option>
        <option value="2">====一级区域组====</option>
        <option value="4">====二级区域组====</option>
        <option value="6">====三级区域组====</option>
        </select></div>
    </div> 
    
	<div class="tf" id="divArea">
        <label>区域组：</label>
        <div class="inp">
          <ul class="allGroupBlock">
          {foreach from=$arrayAreaGroup item=data key=index}
            <li>
              <input class='checkInp' type='checkbox' name='chkCheck' {if $data.is_check == 1} checked='checked' {/if} value="{$data.agroup_id}"/>{$data.agroup_name}
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
