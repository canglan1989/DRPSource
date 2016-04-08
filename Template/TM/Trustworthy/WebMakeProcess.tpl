<div class="bd">
    <div class="list_table_main">
        <div class="ui_table ui_table_nohead">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <thead class="ui_table_hd">
                    <tr>
                        <th><div class="ui_table_thcntr"><div class="ui_table_thtext">步骤</div></div></th>
                <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作人</div></div></th>
                <th style="width:130px"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作时间</div></div></th>
                <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作结果</div></div></th>
                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">备注</div></div></th>
                </tr>
                </thead>
                <tbody class="ui_table_bd" id="ListContent">
                    {foreach from=$data item=arr}
                        <tr>
                            <td><div class="ui_table_tdcntr">{$arr.main_step_name}</div></td>
                            <td><div class="ui_table_tdcntr">{$arr.ope_name}</div></td>
                            <td><div class="ui_table_tdcntr">{if $arr.ope_time<>"0000-00-00 00:00:00"}{$arr.ope_time}{/if}</div></td>
                            <td><div class="ui_table_tdcntr">{$arr.result}</div></td>
                            <td><div class="ui_table_tdcntr">{$arr.remark}</div></td>
                        </tr>
                    {/foreach}
                </tbody>
            </table> 
        </div>
    </div>
                {$backhtml}
</div>