<form id="J_backForm" name="J_backForm">
  <div class="DContInner tableFormCont">
    <div class="bd">
      <div class="ft">
        <label> <em class="require">*</em>下级账户名：</label>
        <select id="cbAccountName" name="cbAccountName">
            <option value="-100">请选择</option>          
            {foreach from=$arraySubAccount item=data key=index}        
            <option value="{$data.user_id}">{$data.user_name} {$data.e_name}</option>          
            {/foreach}        
        </select>
      </div>
      <div class="list_table_main">
        <div class="ui_table ui_table_nohead">
          <table width="620" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
              <tr>
                <th><div class="ui_table_thcntr"></div></th>
                <th colspan="2"><div style="text-align:center">保证金</div></th>
                <th colspan="2"><div style="text-align:center">预存款</div></th>
                <th colspan="2"><div style="text-align:center">返点/销奖</div></th>
              </tr>
              <tr>
                <th><div class="ui_table_thcntr"></div></th>
                <th><div class="ui_table_thcntr" style="text-align:center">可用余额</div></th>
                <th><div class="ui_table_thcntr" style="text-align:center;width:100px">转款金额</div></th>
                <th><div class="ui_table_thcntr" style="text-align:center">可用余额</div></th>
                <th><div class="ui_table_thcntr" style="text-align:center;width:100px">转款金额</div></th>
                <th><div class="ui_table_thcntr" style="text-align:center">可用余额</div></th>
                <th><div class="ui_table_thcntr" style="text-align:center;width:100px">转款金额</div></th>
              </tr>
            </thead>
            <tbody class="ui_table_bd" id="ListContent">            
            {foreach from=$arrayAgentAccount item=data key=index}
            <tr>
              <td><div class="ui_table_tdcntr">{$data.product_type_name}</div></td>
              <td><div id="divGuaMoney_{$data.product_type_id}" class="ui_table_tdcntr" style="text-align:right;">{$data.gua_money}</div></td>
              <td><div class="ui_table_tdcntr" style="text-align:right;">
                  <input name="tbxGuaMoney" onblur="CalculateMoneyAmount()" type="text" id="tbxGuaMoney_{$data.product_type_id}" onkeyup='return FloatNumber(this)' value="0" style="text-align:right;width:65px;" maxlength="8"/>
                </div></td>
              <td><div id="divPreMoney_{$data.product_type_id}" class="ui_table_tdcntr" style="text-align:right;">{$data.pre_money}</div></td>
              <td><div class="ui_table_tdcntr" style="text-align:right;">
                  <input name="tbxPreMoney" onblur="CalculateMoneyAmount()" type="text" id="tbxPreMoney_{$data.product_type_id}" onkeyup='return FloatNumber(this)' value="0" style="text-align:right;width:65px;" maxlength="8"/>
                </div></td>
              <td><div id="divRewMoney_{$data.product_type_id}" class="ui_table_tdcntr" style="text-align:right;">{$data.rew_money}</div></td>
              <td><div class="ui_table_tdcntr" style="text-align:right;">
                <input name="tbxRewMoney" onblur="CalculateMoneyAmount()" type="text" id="tbxRewMoney_{$data.product_type_id}" onkeyup='return FloatNumber(this)' value="0" style="text-align:right;width:65px;" maxlength="8"/>
              </div></td>
            </tr>
            {/foreach}
            <tr>
              <td><div class="ui_table_tdcntr">合 计：</div></td>
              <td colspan="6"><div class="ui_table_tdcntr"> <span id="spanMoneyAmount" style="text-align:right;width:100px;">0</span> </div></td>
            </tr>
            <tr>
              <td><div class="ui_table_tdcntr">备 注：</div></td>
              <td colspan="6"><div class="ui_table_tdcntr">
                  <textarea name="tbxRemark" id="tbxRemark" cols="40" style="width:450px;height:80px" ></textarea>
                  <span class="c_info">限200字内</span> </div></td>
            </tr>
            </tbody>
            
          </table>
        </div>
      </div>
      <div class="ft">
        <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>
        <div class="ui_button ui_button_confirm">
          <button class="ui_button_inner" type="submit">确 定</button>
        </div>
      </div>
    </div>
  </div>
</form>