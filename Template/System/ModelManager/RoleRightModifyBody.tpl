<table width="100%" cellspacing="0" cellpadding="0" border="0" id="UserRightList">
<thead class="ui_table_hd">
  <tr>
    <th width="30">
    <div class="ui_table_thcntr">
        <div class="ui_table_thtext">
        <input class="checkInp" type="checkbox" name="chkCheckAll" id="chkCheckAll" onclick="CheckAll(this);" value="0" />
        </div>
      </div>
    </th>
    <th width="200"><div class="ui_table_thcntr">
        <div class="ui_table_thtext">模块组/模块名</div>
      </div>
    </th>
    <th width="150"><div class="ui_table_thcntr">
        <div class="ui_table_thtext">权限名</div>
      </div>
    </th>
    <th width="80" style=""><div class="ui_table_thcntr">
        <div class="ui_table_thtext">分配状态</div>
      </div>
    </th>
    <th style="width:80px" > <div class="ui_table_thcntr">
        <div class="ui_table_thtext">操作</div>
      </div>
    </th>
    <th style=""><div class="ui_table_thcntr">
        <div class="ui_table_thtext">权限描述</div>
      </div>
    </th>
  </tr>
</thead>
<tbody class="ui_table_bd" id="list_table_body">
{foreach from=$arrayRoleRight item=data key=index}
{if $data.mgroup_name != ""} 
{if $index > 0 }
</tbody>
<tbody class="ui_table_bd">         
{/if}        
<tr class="ui_table_tr_tit {sdrclass rIndex=$index}">
  <td>
  <div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkGroupCheck" onclick="IM.table.selectSub(this.checked,this)" value="0" />
  </div></td>
  <td><div class="ui_table_tdcntr">  <b>{$data.mgroup_name}</b>  </div></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
{/if}
{if $data.model_name!= ""} 
<tr class="ui_table_tr_subtit {sdrclass rIndex=$index}">
  <td>
  <div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkModelCheck" onclick="IM.table.selectSub(this.checked,this,'.ui_table_tr_sub{$data.model_id}');" value="0" />
  </div></td>
  <td><div class="ui_table_tdcntr">  &nbsp;&nbsp;&nbsp;&nbsp;{$data.model_name}  </div></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
{/if}
<tr class="ui_table_tr_sub{$data.model_id} {sdrclass rIndex=$index}">
  <td><div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkCheck" id="chk_{$data.right_id}" value="{$data.right_id}" />
      <input name="tbxIsCheck" type="hidden" value="{$data.is_check}" id="tbx_{$data.right_id}" />              
  </div></td>
  <td></td>
  <td><div class="ui_table_tdcntr"> {$data.right_name} </div></td>
  <td><div class="ui_table_tdcntr" id="div_flag_{$data.right_id}"> {if $data.is_check == 1 }<span style='color:#028100'>已分配</span>{else}<span style='color:#EE5F00;'>未分配</span>{/if}  </div></td>
  <td><div class="ui_table_tdcntr"> <a m="RoleRightList" v="4" ispurview="true" href="javascript:;" onclick="CheckRight(this)" id="a_{$data.right_id}" >{if $data.is_check == 1}取消{else}分配{/if}</a> </div></td>
  <td><div class="ui_table_tdcntr"> {$data.right_remark}  </div></td>
</tr>
{/foreach}
</tbody>     
</table>