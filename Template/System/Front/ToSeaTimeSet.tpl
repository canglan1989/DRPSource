<div class="DContInner setPWDComfireCont">
    <form id="J_newBankAccount" class="newProductForm" name="J_newBankAccount" >
        <div class="bd">
            <div style="margin:0 10px 10px;" class="table_attention"><span class="ui_link">最多可设置三个时间段</span></div>
            <div class="tf">
                <label>默认时间区间范围：</label>
                <div class="inp">{$BackTime}</div>
            </div> 
            <div class="tf" {if $Count < 1} style="display:none" {/if} id="value_div_1">
                <label>区间值：</label>
                <div class="inp">
                    <input id="value_begin_1" type="text" value="{$FrontValue.0.0}" class="inpCommon inpDate value_div_1" name="value_begin_1" onClick="WdatePicker({literal}{minDate:'00:00:00',maxDate:'#F{$dp.$D(\'value_end_1\')}',dateFmt:' HH:mm:ss'}){/literal}"/> 至
                    <input id="value_end_1" type="text" value="{$FrontValue.0.1}" class="inpCommon inpDate value_div_1" name="value_end_1" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'value_begin_1\')}',maxDate:'23:59:59', dateFmt:' HH:mm:ss'}){/literal}"/>
                    <a href="javascript:void(0)" onclick="delToSeaTime('value_div_1')">删除区间</a>
                </div>
            </div> 
            <div class="tf" {if $Count < 2} style="display:none" {/if}  id="value_div_2">
                <label>区间值：</label>
                <div class="inp">
                    <input id="value_begin_2" type="text" value="{$FrontValue.1.0}" class="inpCommon inpDate value_div_2" name="value_begin_2" onClick="WdatePicker({literal}{minDate:'00:00:00',maxDate:'#F{$dp.$D(\'value_end_2\')}',dateFmt:' HH:mm:ss'}){/literal}"/> 至
                    <input id="value_end_2" type="text" value="{$FrontValue.1.1}" class="inpCommon inpDate value_div_2" name="value_end_2" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'value_begin_2\')}',maxDate:'23:59:59', dateFmt:' HH:mm:ss'}){/literal}"/>
                    <a href="javascript:void(0)" onclick="delToSeaTime('value_div_2')">删除区间</a>
                </div>
            </div>
            <div class="tf" {if $Count < 3} style="display:none" {/if}   id="value_div_3">
                <label>区间值：</label>
                <div class="inp">
                    <input id="value_begin_3" type="text" value="{$FrontValue.2.0}" class="inpCommon inpDate value_div_3" name="value_begin_3" onClick="WdatePicker({literal}{minDate:'00:00:00',maxDate:'#F{$dp.$D(\'value_end_3\')}',dateFmt:' HH:mm:ss'}){/literal}"/> 至
                    <input id="value_end_3" type="text" value="{$FrontValue.2.1}" class="inpCommon inpDate value_div_3" name="value_end_3" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'value_begin_3\')}',maxDate:'23:59:59', dateFmt:' HH:mm:ss'}){/literal}"/>
                    <a href="javascript:void(0)" onclick="delToSeaTime('value_div_3')">删除区间</a>
                </div>
            </div><div class="tf">
                <label>&nbsp;</label>
                <div class="inp"><a count="{$Count}" href="javascript:void(0)" {if $Count == "3"}style="display:none;"{/if} id="addToSeaTimeBtn" onclick="AddToSeaTime()">添加时间段</a></div>
            </div>
                
        </div>
        <div id="divEmpInfo" class="bd bd_add" style="padding-bottom:0;padding-top:0;"></div>
        <div class="ft">		
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>
            <div class="ui_button ui_button_confirm"><button class="ui_button_inner" tabindex="3" type="submit">确定</button></div>
        </div>
    </form>
</div>