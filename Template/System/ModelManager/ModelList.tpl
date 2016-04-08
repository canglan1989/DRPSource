<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
  <!--E crumbs--> 
  <!--S table_filter-->
  <div class="table_filter marginBottom10">
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
      <div id="J_table_filter_main" class="table_filter_main">      
        <div class="table_filter_main_row">      
        <div class="ui_title"> 根模块：
          {foreach from=$arrayRootModelGroup item=data key=index} <a href="javascript:;" 
          onclick="JumpPage('/?d=System&c=ModelGroup&a=ModelGroupList&pid={$data.mgroup_id}&isAgent={$data.is_agent}')">{$data.mgroup_name}</a> {/foreach} </div>
        <div class="ui_title"> &nbsp;&nbsp;&nbsp;&nbsp;上级模块组： </div>
        <div class="ui_text">
          <select onchange="ChangeData()" name="cbModelGroup" id="cbModelGroup"  style="width:150px;" >            
          {foreach from=$arryModelGroup item=data key=index}          
            <option value="{$data.mgroup_id}" {if $pModelID == $data.mgroup_id }selected="selected"{/if}>{$data.mgroup_name}</option>            
          {/foreach}        
          </select>
        </div>
      </div>
      </div>
    </form>
  </div>
  <!--E table_filter--> 
  <!--S list_link-->
{if $isDepEvn == 1}
  <div class="list_link marginBottom10">
    <a class="ui_button" onclick="AddModel()" href="javascript:;" m="ModelGroupList" v="4" ispurview="true"  style="margin:0;">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner">
        <div class="ui_icon ui_icon_add"></div>
        <div class="ui_text">添加模块</div>
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
<a href="javascript:;" onclick="ChangeData()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
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
            <th style="width:150px"> <div class="ui_table_thcntr">
                <div class="ui_table_thtext"> 模块名</div>
              </div></th>
            <th style="width:150px"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">代号</div>
              </div></th>
            <th style="width:150px"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">显示名</div>
              </div></th>
            <th style="width:50px"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">排序</div>
              </div></th>
            <th style="width:60px">
            	<div class="ui_table_thcntr">
                	<div class="ui_table_thtext">状态</div>
                </div>
                </th>
            <th><div class="ui_table_thcntr">
                <div class="ui_table_thtext">页面</div>
              </div></th>
              <th style="width:60px"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">菜单</div>
              </div></th>
              <th style="width:80px"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">添加日期</div>
              </div></th>
            <th style="width:130px"> <div class="ui_table_thcntr">
                <div class="ui_table_thtext">操作</div>
              </div>
            </th>            
          </tr>
        </thead>
        <tbody class="ui_table_bd">        
        {foreach from=$arrayModel item=data key=index}
        <tr class="{sdrclass rIndex=$index}">
          <td><div class="ui_table_tdcntr">{$data.model_name}</div></td>
          <td><div class="ui_table_tdcntr">{$data.model_code}</div></td>
          <td><div class="ui_table_tdcntr">{$data.show_name}</div></td>
          <td><div class="ui_table_tdcntr">{$data.sort_index}</div></td>
          <td><div class="ui_table_tdcntr">
          <a href="javascript:;" onclick="LockData({$data.model_id})">
            {if $data.is_lock == 0}<span style="color:#028100;">正常</span>{else}<span style="color:#EE5F00;">关闭</span>{/if}</a>
            </div></td>
          <td><div class="ui_table_tdcntr">{$data.model_page}</div></td>
          <td><div class="ui_table_tdcntr">{if $data.is_menu ==1}是{else}<span style="color:#EE5F00;">否</span>{/if}</div></td>
          <td><div class="ui_table_tdcntr">{$data.create_time|date_format:"%Y-%m-%d"}</div></td>
          <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
              <li><a href="javascript:;" onclick="JumpPage('{au d="System" c="ModelRight" a="ModelRightList"}&mid={$data.model_id}')">权限</a></li>
              {if $isDepEvn ==1}
              <li><a m="ModelGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="Model" a="ModelModify"}&id={$data.model_id}')">编辑</a></li>
              <li><a m="ModelGroupList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('{au d="System" c="Model" a="ModelDel"}&id={$data.model_id}',{literal}{{/literal}id:{$data.model_id}{literal}}{/literal} ,'删除模块',this)">删除</a></li>
              {/if}
              {if $iIsAgent == 0}
                <li><a m="PositionRightList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="Model" a="ModelRightPosition"}&id={$data.model_id}')" title="权限对应职位">职位</a></li>
                <li><a m="UserRightList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="System" c="Model" a="ModelRightUser"}&id={$data.model_id}')" title="权限对应用户">用户</a></li>
              {/if}
        </tr>
        {/foreach}
          </tbody>        
      </table>
    </div>
    <!--E ui_table--> 
  </div>
  <!--E list_table_main--> 
  <!--S list_table_foot-->
  <div class="list_table_foot"><div class="ui_pager"></div></div>
{literal} 
<script language="javascript" type="text/javascript">
function AddModel()
{
    {/literal} 
    var url = '{au d="System" c="Model" a="ModelModify"}&pid={$pModelID}&isAgent={$iIsAgent}';
    {literal} 
    JumpPage(url);
}
function DelModel(id)
{
     if(!confirm("您确定要删除吗？"))
        return ;
    {/literal} 
    var url = '{au d="System" c="Model" a="ModelDel"}';
    {literal} 
    url += "&id="+id;
    var retValue = $PostData(url,"id="+id);

    if(parseInt(retValue) == 0)
    {
        //todo 刷新页面
        ChangeData();
    }
    else
    {
        IM.tip.warn(retValue);
    }
}

function ChangeData()
{
    obj = $DOM("cbModelGroup");
    {/literal}
    JumpPage("/?d=System&c=Model&a=ModelList&pid="+obj.value+"&isAgent={$iIsAgent}");
    {literal} 
}

function LockData(id)
{
    var retValue = $PostData("/?d=System&c=Model&a=LockModel","id="+id);

    if(parseInt(retValue) == 0)
    {
        //todo 刷新页面
        ChangeData();
    }
    else
    {
        IM.tip.warn(retValue);
    }
}

</script> 
{/literal} 