<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strTitle}</div>
  <!--E crumbs--> 
  <!--S list_table_head-->
  <div class="list_table_head">
<div class="list_table_head_right">
<div class="list_table_head_mid">
<h4 class="list_table_title">
<span class="ui_icon list_table_title_icon"></span>
{$strTitle}
</h4>
<a href="javascript:;" onclick="ReflashPage()" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
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
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">职位</div></div></th>
            <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">用户名</div></div></th>
            <th style="width:100px"><div class="ui_table_thcntr"><div class="ui_table_thtext">员工名</div></div></th>
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">部门</div></div></th>
            <th><div class="ui_table_thcntr"><div class="ui_table_thtext">权限名</div></div></th>
            <th style="width:150px;"><div class="ui_table_thcntr"><div class="ui_table_thtext">操作</div></div></th>            
          </tr>
        </thead>
        <tbody class="ui_table_bd">
        {foreach from=$arrayRightPositionList item=data key=index}
          <tr class="{sdrclass rIndex=$index}">
            <td><div class="ui_table_tdcntr">{$data.post_name}</div></td>
            <td><div class="ui_table_tdcntr">{$data.user_name}</div></td>
            <td><div class="ui_table_tdcntr">{$data.e_name}</div></td>
            <td><div class="ui_table_tdcntr">{$data.dept_fullname}</div></td>
            <td><div class="ui_table_tdcntr">{$data.right_name}</div></td>
            <td><div class="ui_table_tdcntr"><ul class="list_table_operation">    
            <li><a m="RoleManager" v="8" ispurview="true" href="javascript:;" onclick="DelPosition({$data.post_id},{$data.right_id})">删除职位</a></li>
            </ul></div>
            </td>            
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
  <!--E list_table_foot--> 
{literal} 
<script language="javascript" type="text/javascript">

function DelPosition(post_id,right_id)
{
    if(!confirm("您确定要删除吗？"))
        return ;
    {/literal} 
    var url = '{au d="System" c="Position" a="DelPostRight"}';
    {literal} 
    
    var retValue = $PostData(url,"id="+post_id+"&delRightIDs="+right_id);
    if(parseInt(retValue) == 0)
    {
        //todo 刷新页面
        ReflashPage();
    }
    else
    {
        IM.tip.warn(retValue); 
    }
}

function ReflashPage()
{
    {/literal} 
    var id = '{$id}';
    {literal} 
    JumpPage('/?d=System&c=Model&a=ModelRightPosition&id='+id,false);
}
</script>
{/literal} 