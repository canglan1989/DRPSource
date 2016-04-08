<table width="100%" cellspacing="0" cellpadding="0" border="0" id="PositionRightList"> 
   <thead class="ui_table_hd">
  <tr class="even">
    <th width="30"><div class="ui_table_thcntr ">
        <div class="ui_table_thtext">
        <input class="checkInp" type="checkbox" id="chkCheckAll" name="chkCheckAll" onclick="CheckAll(this);" value="0" />
        </div>
      </div>
    </th>
    <th width="200" ><div class="ui_table_thcntr">
        <div class="ui_table_thtext  indent_1">模块组/模块名</div>
      </div>
    </th>
    <th width="150"><div class="ui_table_thcntr">
        <div class="ui_table_thtext">权限名</div>
      </div>
    </th>
    <th width="80" style=""><div class="ui_table_thcntr">
        <div class="ui_table_thtext">权限状态</div>
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
{foreach from=$arrayPositionRight item=data key=index}
{if $data.mgroup_name != ""} 
{if $index > 0 }
</tbody>
<tbody class="ui_table_bd">         
{/if}        
<tr class="ui_table_tr_tit even {sdrclass rIndex=$index}">
  <td>
  <div class="ui_table_tdcntr ">
      <input class="checkInp" type="checkbox" name="chkGroupCheck" onclick="IM.table.selectSub(this.checked,this);" value="0" />
  </div></td>
  <td><div class="ui_table_tdcntr">  <strong>{$data.mgroup_name}</strong>  </div></td>
  <td><div class="ui_table_tdcntr">
     &nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
{/if}
{if $data.model_name!= ""} 
<tr class="ui_table_tr_subtit odd {sdrclass rIndex=$index}">
  <td>
  <div class="ui_table_tdcntr  indent_1">
      <input class="checkInp" type="checkbox" name="chkModelCheck" onclick="IM.table.selectSub(this.checked,this,'.ui_table_tr_sub{$data.model_id}');" value="0" />
  </div></td>
  <td><div class="ui_table_tdcntr  indent_2"> {$data.model_name}  </div></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
{/if}
<tr class="ui_table_tr_sub{$data.model_id} {sdrclass rIndex=$index} even" id="ui_table_tr_sub">
  <td><div class="ui_table_tdcntr">
      <input class="checkInp" type="checkbox" name="chkCheck" value="{$data.right_id}" id="chk_{$data.right_id}"/>
      <input name="tbxIsCheck" type="hidden" value="{$data.is_check}" id="tbx_{$data.right_id}"/>              
  </div></td>
  <td><div class="ui_table_tdcntr"> &nbsp; </div></td>
  <td><div class="ui_table_tdcntr">
     {$data.right_name}</td>
  <td><div class="ui_table_tdcntr"> {if $data.is_lock == 1 }<span style="color:#EE5F00;">停用</span>{else}<span style="color:#028100;">正常</span>{/if}  </div></td>
  <td><div class="ui_table_tdcntr" id="div_flag_{$data.right_id}"> {if $data.is_check == 1 }<span style='color:#028100'>已分配</span>{else}<span style='color:#EE5F00;'>未分配</span>{/if}  </div></td>
  <td><div class="ui_table_tdcntr"> <a href="javascript:;" onclick="CheckRight(this)" m="PositionRightList" v="4" ispurview="true" id="a_{$data.right_id}">{if $data.is_check == 1}取消{else}分配{/if}</a> </div></td>
  <td><div class="ui_table_tdcntr"> {$data.right_remark}  </div></td>
</tr>
{/foreach}
      
</tbody>    
</table>
      
     