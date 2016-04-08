<div class="DContInner setPWDComfireCont">
<form id="addReplenish" action="" name="addReplenish" class="addContactInfoForm">
    <!--S form_block_bd-->
    <div class="bd">
    	<div class="tf">
        <label><em class="require">*</em>代理商名称：</label>
        <div class="inp">{$strAgentName}</div>
        </div>
        <div class="tf">
        <label><em class="require">*</em>主合同编号：</label>
        <div class="inp">{$strPactNumber}</div>
        </div>
        <div class="tf">
            <label><em class="require">*</em>代理的产品：</label>
            <div class="inp">
            <!--{literal}<div style="width:100px;" id="ui_comboBox_agentPro" data={/literal}'{$arrProductType}'{literal} value="" key="" control="agentPro" class="ui_comboBox ui_comboBox_def" onclick="IM.comboBox.init({'control':MM.A(this,'control'),data:MM.A(this,'data')},this)">{/literal}
            <div style="width:80px;" class="ui_comboBox_text">
                <nobr>请选择代理产品</nobr>
            </div>
            <div class="ui_icon ui_icon_comboBox"></div>
            </div>-->
            <select id="agent_pro" name="agent_pro">
            {foreach item=pro from=$arrProductType}
            	<option value="{$pro.aid}">{$pro.product_type_name}</option>
            {/foreach}
            </select>
           
            </div>
        </div>
        <div class="tf">
        <label><em class="require">*</em>代理等级：</label>
        <div class="inp">
            <select class="agentLevel" name="agentLevel">
            <option value="0">无等级</option>
            <option value="1">金牌</option>
            <option value="2">银牌</option>
            </select>
        </div>
        </div>
        <div class="tf">
        <label><em class="require">*</em>补签小记：</label>
        <div class="inp">
           <textarea id="replenish_remark" class="" name="replenish_remark" valid="required" cols="35"></textarea> 
        </div>
        <span class="info">请填写补签小记</span>
        <span class="err">请填写补签小记</span>
        </div>       
    </div>
     <div class="ft">
            <div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>
            <div class="ui_button ui_button_confirm"><button type="submit"  class="ui_button_inner" tabindex="7">补签</button></div> 
    	</div> 
</form>
</div>