<div class="DContInner setPWDComfireCont">
<form id="J_newBankAccount" class="newProductForm" name="J_newBankAccount" >
  <div class="bd">
    <div class="tf">
      <label> <em class="require">*</em> 请选择屏蔽天数： </label>
      <div class="inp">
          <select name="sheldtime" id="sheldtime" valid="selected">
              <option value="0" >请选择</option>
              {foreach from=$ToSeaList key=key item=data}
                  <option {if $key == 0} selected="selected"{/if}  value="{$data.d_value}">{$data.d_name}</option>
              {/foreach}
          </select>
      </div>
      <span class="info">请选择屏蔽天数</span> <span class="ok">&nbsp;</span><span class="err">请选择屏蔽天数</span> 
      </div>  
  </div>
  <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    <div class="ft">		
		<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
		<div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="7" type="submit">确定</button></div>
	</div>
</form>
</div>