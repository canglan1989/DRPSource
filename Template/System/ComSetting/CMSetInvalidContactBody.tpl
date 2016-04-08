{foreach from=$InvaildContactList item=data}
<tr class="">
    <td title=""><div class="ui_table_tdcntr">{$data.c_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.sort_index}</div></td>
    <td title=""><div class="ui_table_tdcntr"><ul class="list_table_operation">
                <li><a m="CustomerCommentParse" onclick="setInvalidContact({$data.c_id})" ispurview="true" v="64" onclick="" href="javascript:;">编辑</a></li>
                <li><a m="CustomerCommentParse" ispurview="true" v="64" onclick="delItem('/?d=System&c=ComSetting&a=DelInvaildContact&id={$data.c_id}','InvalidContactBody','/?d=System&c=ComSetting&a=getCMInvalidContactBody');" href="javascript:;">删除</a></li>
    </ul></div></td>
</tr>
{foreachelse}
<tr class="">
    <td clospan="3"><div class="ui_table_tdcntr">无选项值</div><td>
</tr>
 {/foreach}