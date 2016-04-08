{foreach from=$arrayTableList item=data key=index}
    <tr class="{sdrclass rIndex=$index}">
        <td><div class="ui_table_tdcntr">{$data.table_name}</div></td>
        <td><div class="ui_table_tdcntr">
        <a href="javascript:;" onclick="CreateCode('{$data.table_name}','{$data.table_comment}')">生成</a>
        &nbsp;
        <a href="javascript:;" onclick="ShowCreateQueryTable('{$data.table_name}','{$data.table_comment}')">生成查询</a>
        </div></td>
        <td><div class="ui_table_tdcntr">{$data.table_comment}</div></td>
    </tr>
{/foreach}