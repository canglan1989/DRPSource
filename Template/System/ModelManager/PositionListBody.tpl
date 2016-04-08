{foreach from=$arrayPosition item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.company_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.dept_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.post_name}</div></td>
    <td><div class="ui_table_tdcntr">{$data.level_name}({$data.m_value})</div></td>
    <td><div class="ui_table_tdcntr">{$data.create_time|date_format:"%Y-%m-%d"}</div></td>
    <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
        <li><a m="PositionRightList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="Position" a="PositionRightModify"}&id={$data.post_id}')">权限</a></li>
      </ul>
      </div>
    </td>    
  </tr>
{/foreach}