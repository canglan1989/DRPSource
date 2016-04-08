<div id="J_ui_table" class="ui_table">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <thead class="ui_table_hd">
          <tr>
            <th style="width:100px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">账号名</div>
              </div></th>
            <th style="width:100px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">账号层级</div>
              </div></th>
            <th style="width:80px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">状态</div>
              </div></th>      
          </tr>
        </thead>
        <tbody class="ui_table_bd" id="pageListContent">
             {foreach from=$arrayAgentPacthCh item=data key=index}
              <tr>
                <td title="{$data.user_name}"><div class="ui_table_tdcntr">{$data.user_name}</div></td>
                <td title="{$data.account_level}"><div class="ui_table_tdcntr">{$data.account_level}级</div></td>
                <td><div class="ui_table_tdcntr" >{if $data.is_lock == 1}关闭{else}<span style="color:#028100;">正常</span>{/if}</div></td>
              </tr>
            {/foreach}
        </tbody>
  </table>
  <!--
<div class="ft">
      
<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">关闭</a></div>
 </div>-->
</div>