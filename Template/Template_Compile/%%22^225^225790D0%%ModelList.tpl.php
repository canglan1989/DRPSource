<?php /* Smarty version 2.6.26, created on 2012-11-16 16:07:04
         compiled from System/ModelManager/ModelList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/ModelManager/ModelList.tpl', 88, false),array('function', 'au', 'System/ModelManager/ModelList.tpl', 101, false),array('modifier', 'date_format', 'System/ModelManager/ModelList.tpl', 99, false),)), $this); ?>
<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
  <!--E crumbs--> 
  <!--S table_filter-->
  <div class="table_filter marginBottom10">
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
      <div id="J_table_filter_main" class="table_filter_main">      
        <div class="table_filter_main_row">      
        <div class="ui_title"> 根模块：
          <?php $_from = $this->_tpl_vars['arrayRootModelGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?> <a href="javascript:;" 
          onclick="JumpPage('/?d=System&c=ModelGroup&a=ModelGroupList&pid=<?php echo $this->_tpl_vars['data']['mgroup_id']; ?>
&isAgent=<?php echo $this->_tpl_vars['data']['is_agent']; ?>
')"><?php echo $this->_tpl_vars['data']['mgroup_name']; ?>
</a> <?php endforeach; endif; unset($_from); ?> </div>
        <div class="ui_title"> &nbsp;&nbsp;&nbsp;&nbsp;上级模块组： </div>
        <div class="ui_text">
          <select onchange="ChangeData()" name="cbModelGroup" id="cbModelGroup"  style="width:150px;" >            
          <?php $_from = $this->_tpl_vars['arryModelGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>          
            <option value="<?php echo $this->_tpl_vars['data']['mgroup_id']; ?>
" <?php if ($this->_tpl_vars['pModelID'] == $this->_tpl_vars['data']['mgroup_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['data']['mgroup_name']; ?>
</option>            
          <?php endforeach; endif; unset($_from); ?>        
          </select>
        </div>
      </div>
      </div>
    </form>
  </div>
  <!--E table_filter--> 
  <!--S list_link-->
<?php if ($this->_tpl_vars['isDepEvn'] == 1): ?>
  <div class="list_link marginBottom10">
    <a class="ui_button" onclick="AddModel()" href="javascript:;" m="ModelGroupList" v="4" ispurview="true"  style="margin:0;">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner">
        <div class="ui_icon ui_icon_add"></div>
        <div class="ui_text">添加模块</div>
        </div>
    </a>
</div>
<?php endif; ?>
  <!--E list_link--> 
  <!--S list_table_head-->
  <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
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
        <?php $_from = $this->_tpl_vars['arrayModel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
        <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
          <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['model_name']; ?>
</div></td>
          <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['model_code']; ?>
</div></td>
          <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['show_name']; ?>
</div></td>
          <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['sort_index']; ?>
</div></td>
          <td><div class="ui_table_tdcntr">
          <a href="javascript:;" onclick="LockData(<?php echo $this->_tpl_vars['data']['model_id']; ?>
)">
            <?php if ($this->_tpl_vars['data']['is_lock'] == 0): ?><span style="color:#028100;">正常</span><?php else: ?><span style="color:#EE5F00;">关闭</span><?php endif; ?></a>
            </div></td>
          <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['model_page']; ?>
</div></td>
          <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['is_menu'] == 1): ?>是<?php else: ?><span style="color:#EE5F00;">否</span><?php endif; ?></div></td>
          <td><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</div></td>
          <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
              <li><a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'ModelRight','a' => 'ModelRightList'), $this);?>
&mid=<?php echo $this->_tpl_vars['data']['model_id']; ?>
')">权限</a></li>
              <?php if ($this->_tpl_vars['isDepEvn'] == 1): ?>
              <li><a m="ModelGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Model','a' => 'ModelModify'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['model_id']; ?>
')">编辑</a></li>
              <li><a m="ModelGroupList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Model','a' => 'ModelDel'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['model_id']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['model_id']; ?>
<?php echo '}'; ?>
 ,'删除模块',this)">删除</a></li>
              <?php endif; ?>
              <?php if ($this->_tpl_vars['iIsAgent'] == 0): ?>
                <li><a m="PositionRightList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Model','a' => 'ModelRightPosition'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['model_id']; ?>
')" title="权限对应职位">职位</a></li>
                <li><a m="UserRightList" v="2" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Model','a' => 'ModelRightUser'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['model_id']; ?>
')" title="权限对应用户">用户</a></li>
              <?php endif; ?>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
          </tbody>        
      </table>
    </div>
    <!--E ui_table--> 
  </div>
  <!--E list_table_main--> 
  <!--S list_table_foot-->
  <div class="list_table_foot"><div class="ui_pager"></div></div>
<?php echo ' 
<script language="javascript" type="text/javascript">
function AddModel()
{
    '; ?>
 
    var url = '<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Model','a' => 'ModelModify'), $this);?>
&pid=<?php echo $this->_tpl_vars['pModelID']; ?>
&isAgent=<?php echo $this->_tpl_vars['iIsAgent']; ?>
';
    <?php echo ' 
    JumpPage(url);
}
function DelModel(id)
{
     if(!confirm("您确定要删除吗？"))
        return ;
    '; ?>
 
    var url = '<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Model','a' => 'ModelDel'), $this);?>
';
    <?php echo ' 
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
    '; ?>

    JumpPage("/?d=System&c=Model&a=ModelList&pid="+obj.value+"&isAgent=<?php echo $this->_tpl_vars['iIsAgent']; ?>
");
    <?php echo ' 
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
'; ?>
 