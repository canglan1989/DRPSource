<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
  <!--E crumbs-->
  <div class="table_filter marginBottom10">
    <div id="J_table_filter_main" class="table_filter_main"> 
        <div class="table_filter_main_row">
        模块名：<a href="javascript:;" onclick="JumpPage('/?d=System&c=Model&a=ModelList&pid={$objModelInfo->iMgroupId}&isAgent={$objModelInfo->iIsAgent}')">{$objModelInfo->strModelName}</a>{$objModelInfo->strModelCode}
        </div>
      </div>
  </div>
  <!--S list_link-->
{if $isDepEvn == 1}
  <div class="list_link marginBottom10">
    <a class="ui_button" onclick="AddRight({$modelID})" href="javascript:;" m="ModelGroupList" v="4" ispurview="true" style="margin:0;">
        <div class="ui_button_left"></div>
            <div class="ui_button_inner">
                <div class="ui_icon ui_icon_add"></div>
                <div class="ui_text">添加权限</div>
        </div>
    </a>
</div>
{/if}
  <!--E list_link--> 
  <!--S list_table_head-->
   <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
    </div>
    </div>
    </div>
  <!--E list_table_head--> 
  <!--S list_table_main-->
  <div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <thead class="ui_table_hd">
          <tr>
            <th><div class="ui_table_thcntr">
                <div class="ui_table_thtext">权限名</div>
              </div>
            </th>
            <th><div class="ui_table_thcntr">
                <div class="ui_table_thtext">权限值</div>
              </div></th>
            <th><div class="ui_table_thcntr">
                <div class="ui_table_thtext">状态</div>
              </div></th>
            <th><div class="ui_table_thcntr">
                <div class="ui_table_thtext">描述</div>
              </div></th>
            <th><div class="ui_table_thcntr">
                <div class="ui_table_thtext">操作</div>
              </div>
            </th>
          </tr>
        </thead>
        <tbody class="ui_table_bd">        
        {foreach from=$arrayModelRight item=data key=index}
        <tr class="{sdrclass rIndex=$index}">
          <td><div class="ui_table_tdcntr">{$data.right_name}</div></td>
          <td><div class="ui_table_tdcntr">{$data.right_value}</div></td>
          <td><div class="ui_table_tdcntr">{if $data.is_lock == 1}<span style="color:#EE5F00;">关闭</span>{else}<span style="color:#028100;">正常</span>{/if}</div></td>
          <td><div class="ui_table_tdcntr">{$data.right_remark}</div></td>
          <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
          {if $isDepEvn == 1}
          <li><a m="ModelGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="ModelRight" a="ModelRightModify"}&mid={$modelID}&id={$data.right_id}')">编辑</a></li>
          <li><a m="ModelGroupList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('{au d="System" c="ModelRight" a="ModelRightDel"}&id={$data.right_id}&mid={$modelID}',{literal}{{/literal}id:{$data.right_id}{literal}}{/literal} ,'删除模块',this)">删除</a></li>
          {/if}
        </ul></div></td>
        </tr>
        {/foreach}
          </tbody>        
      </table>
    </div>
    <!--E ui_table--> 
  </div>
  <!--E list_table_main--> 
  <!--S list_table_foot-->
  <div class="list_table_foot">
    <div class="ui_pager"> </div>
  </div>
{literal} 
<script language="javascript" type="text/javascript">
function AddRight(mid)
{
    {/literal} 
    var url = '{au d="System" c="ModelRight" a="ModelRightModify"}&mid={$modelID}';
    {literal} 
    JumpPage(url);
}

</script> 
{/literal} 