<div class="DContInner setPWDComfireCont">
  <form id="J_newLAgentModel" class="newLXXiaoJiForm" name="J_newLAgentModel" action="">
    {foreach from=$arrayAgentModel item=data key=index}
    <div class="bd">
      <div class="tf">
        <label>代理商名称：</label>
        <div class="inp">{$data.agent_name} </div>
      </div>
      <div class="tf">
        <label>代理商代码：</label>
        <div class="inp"> {$data.agent_no}</div>
        <input type="hidden" value="{$data.agent_id}" id="agent_id" name="agent_id" />
      </div>
      <div class="tf">
        <label>产品：</label>
        <div class="inp">{$data.product_series} </div>
        <input type="hidden" value="{$data.product_id}" id="product_id" name="product_id" />
      </div>
      <div class="tf">
        <label>代理模板 ：</label>
        <div class="inp">
          <input value="{$agentModel}" title="{$agentModel}" type="text" id="txtmodel_name" name="txtmodel_name" autocomplete="off" onblur="CheckModelName(this)" onkeyup="CheckModelName(this)"  maxlength="20"/>
        </div>
        <input type="hidden" value="{$a_price_model_id}" id="agent_price_model_id" name="agent_price_model_id"/>
      </div>
      <div class="tf">
        <label><em class="require">*</em>代理模板时间：</label>
        <div class="inp">
          <input id="tbxAgentSdate" class="inpDate" valid="required" name="tbxAgentSdate" value="{$data.agent_sdate}" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('tbxAgentEdate')).focus()},dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'tbxAgentEdate\')}'}){/literal}" type="text"/>
          至
          <input id="tbxAgentEdate" class="inpDate" valid="required" name="tbxAgentEdate" value="{$data.agent_edate}" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxAgentSdate\')}',dateFmt:'yyyy-MM-dd'}{/literal})" type="text"/>
        </div>
        <span class="info">请输入代理模板时间</span> <span class="ok">&nbsp;</span> <span class="err">请输入代理模板时间</span> </div>
      <div class="tf">
        <label><em class="require">*</em>代理价格 ：</label>
        <div class="inp">
          <input value="{$data.agent_price}" type="text" id="txtagent_price" name="txtagent_price" maxlength="10" style="width:100px;text-align:right" valid="required amount" />
        </div>
      </div>
      <div class="tf">
        <label><em class="require">*</em>预存款销奖扣款比例 ：</label>
        <div class="inp">
          <input value="{$data.deduction_pes}" type="text" id="txtdeduction_pes" onkeydown='return NumberOnly(event)' name="txtdeduction_pes" style="width:40px; text-align:center"  valid="required" maxlength="5" />
          :
          <input value="{$data.sale_bonus_pes}" type="text" id="txtsale_bonus_pes" name="txtsale_bonus_pes" onkeydown='return NumberOnly(event)' style="width:40px; text-align:center"  valid="required" maxlength="5" />
        </div>
        <span class="info">请输入预存款销奖扣款比例</span> <span class="ok">&nbsp;</span> <span class="err">请输入预存款销奖扣款比例</span> </div>
      <div class="tf">
        <label>促销模板：</label>
        <div class="inp">
          <input value="{$promModel}" title="{$promModel}" type="text" id="txtpromModel" name="txtpromModel" onblur="CheckModelName(this)" onkeyup="CheckModelName(this)" autocomplete="off" maxlength="20"/>
        </div>
        <input type="hidden" value="{$price_model_id}" id="prom_price_model_id" name="prom_price_model_id"/>
      </div>
      <div class="tf">
        <label>促销模板时间：</label>
        <div class="inp">
          <input id="tbxPromSdate" class="inpDate" name="tbxPromSdate" value="{$data.prom_sdate}" onfocus="WdatePicker({literal}{onpicked:function(){($dp.$('tbxPromEdate')).focus()},dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'tbxPromEdate\')}'}){/literal}" type="text"/>
          至
          <input id="tbxPromEdate" class="inpDate" name="tbxPromEdate" value="{$data.prom_edate}" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'tbxPromSdate\')}',dateFmt:'yyyy-MM-dd'}{/literal})" type="text"/>
        </div>
      </div>
      <div class="tf">
        <label>促销价格：</label>
        <div class="inp">
          <input value="{$data.prom_price}" type="text" id="txtprom_price" name="txtprom_price" maxlength="10" style="width:100px;text-align:right" valid="required amount" />
        </div>
      </div>
      <div class="tf">
        <label>促销预存款销奖扣款比例 ：</label>
        <div class="inp">
          <input value="{$data.pro_store_pes}" type="text" id="pro_store_pes" onkeydown='return NumberOnly(event)' name="pro_store_pes" style="width:40px; text-align:center"  maxlength="5" />
          :
          <input value="{$data.pro_sale_bonus_pes}" type="text" id="pro_sale_bonus_pes" name="pro_sale_bonus_pes" onkeydown='return NumberOnly(event)' style="width:40px; text-align:center"  maxlength="5" />
        </div>
        <span class="info">请输入预存款销奖扣款比例</span> <span class="ok">&nbsp;</span> <span class="err">请输入预存款销奖扣款比例</span> </div>
      <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
    </div>
    <div class="ft">
      <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
      <div class="ui_button ui_button_confirm">
        <button class="ui_button_inner" tabindex="7" type="submit">确定</button>
      </div>
    </div>
    {/foreach}
  </form>
</div>
{literal}
<style>
.tf label{width:150px;}
</style>
{/literal} 