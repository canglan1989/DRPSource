{foreach from=$arrayModelGroup item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr {if $data.rootModel == 0}indent_2{/if}">
    {if $data.rootModel != 0}
    <strong>{$data.mgroup_name}</strong>
    {else}
    <a href="javascript:;" onclick="JumpPage('{au d="System" c="Model" a="ModelList"}&pid={$data.mgroup_id}&isAgent={$iIsAgent}')">{$data.mgroup_name}</a>
    {/if}            
    </div></td>
    <td><div class="ui_table_tdcntr">{$data.mgroup_code}</div></td>
    <td style="align:right;"><div class="ui_table_tdcntr">{$data.sort_index}</div></td>
    <td><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="LockData({$data.mgroup_id})">
    {if $data.is_lock == 0}<span style="color:#028100;">正常</span>{else}<span style="color:#EE5F00;">关闭</span>{/if}</a>
    </div></td>
    <td><div class="ui_table_tdcntr">{$data.mgroup_remark}</div></td>
    <td><div class="ui_table_tdcntr">{$data.create_time|date_format:"%Y-%m-%d"}</div></td>
    <td><div class="ui_table_tdcntr">
      <ul class="list_table_operation">
      {if $isDepEvn ==1}
      {if $data.rootModel == 0}
        <li><a m="ModelGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="ModelGroup" a="ModelGroupModify"}&isAgent={$iIsAgent}&id={$data.mgroup_id}')">编辑</a></li>
        <li><a m="ModelGroupList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('{au d="System" c="ModelGroup" a="ModelGroupDel"}&id={$data.mgroup_id}&mgroupNo={$data.mgroup_no}',{literal}{{/literal}id:{$data.mgroup_id}{literal}}{/literal} ,'删除模块',this)">删除</a></li>
        {else}
       <li><a m="ModelGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="ModelGroup" a="ModelGroupModify"}&isAgent={$iIsAgent}&pno={$data.mgroup_no}')" >添加子模块</a></li>
       {/if}
      {/if}
       </ul>
       </div>
    </td>            
  </tr>
{/foreach}
        