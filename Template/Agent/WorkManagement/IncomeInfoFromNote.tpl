<div class="DContInner setPWDComfireCont">
    <div class="bd">  
        <div class="tf">
            <label>代理商名称：</label>
            <div class="inp">{$AgentInfo->strAgentName}</div>
        </div>
        <div class="tf">
            <label>{if $NoteInfo->iContactType == 0}意向等级{else}签约产品{/if}：</label>
            <div class="inp">
                {if $NoteInfo->iContactType == 0}
                    {$NoteInfo->strAfterlevel}
                {else}
                    {$NoteInfo->strProductName}
                {/if}
            </div>
        </div>
        <div class="tf">
            <label>预计到账时间：</label>
            <div class="inp">{$NoteInfo->strExpectTime|date_format:'%Y-%m-%d'}</div>
        </div>
        <div class="tf">
            <label>预计到账金额：</label>
            <div class="inp">{$NoteInfo->iExpectMoney|string_format:'%.2f'} 元</div>
        </div>
        <div class="tf">
            <label>预计到账类型：</label>
            <div class="inp">{if $NoteInfo->iExpectType ==1}承诺{else}备份{/if}</div>
        </div>
        <div class="tf">
            <label>预计达成率：</label>
            <div class="inp">{$NoteInfo->iChargePercentage} %</div>
        </div>
        <div class="tf">
            <label>操作人：</label>
            <div class="inp">{$NoteInfo->strCreateUserName}</div>
        </div>
        <div class="tf">
            <label>操作时间：</label>
            <div class="inp">{$NoteInfo->strCreateTime}</div>
        </div>
        <div class="tf_submit">		
            <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
        </div>
    </div>
</div>

