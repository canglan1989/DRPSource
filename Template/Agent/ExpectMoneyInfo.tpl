<div class="DContInner setPWDComfireCont">
    <div class="bd">  
        <div class="tf">
            <label>代理商名称：</label>
            <div class="inp">{$agent_name}</div>
        </div>
        <div class="tf">
            <label>意向等级/签约产品：</label>
            <div class="inp">
                {$inten_level}/{$product_type_name}
            </div>
        </div>
        <div class="tf">
            <label>预计到账时间：</label>
            <div class="inp">{$expect_time|date_format:'%Y-%m-%d'}</div>
        </div>
        <div class="tf">
            <label>预计到账金额：</label>
            <div class="inp">{$expect_money|string_format:'%.2f'} 元</div>
        </div>
        <div class="tf">
            <label>预计到账类型：</label>
            <div class="inp">{if $expect_type ==1}承诺{else}备份{/if}</div>
        </div>
        <div class="tf">
            <label>预计达成率：</label>
            <div class="inp">{$charge_percentage} %</div>
        </div>
        <div class="tf">
            <label>操作人：</label>
            <div class="inp">{$e_name}({$user_name})</div>
        </div>
        <div class="tf">
            <label>操作时间：</label>
            <div class="inp">{$create_time}</div>
        </div>
        <div class="tf_submit">		
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
        </div>
    </div>
</div>