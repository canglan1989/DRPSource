<?php /* Smarty version 2.6.26, created on 2012-11-16 16:12:53
         compiled from System/ModelManager/ModelRightPositionList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/ModelManager/ModelRightPositionList.tpl', 33, false),array('function', 'au', 'System/ModelManager/ModelRightPositionList.tpl', 64, false),)), $this); ?>
<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strTitle']; ?>
</div>
  <!--E crumbs--> 
  <!--S list_table_head-->
  <div class="list_table_head">
<div class="list_table_head_right">
<div class="list_table_head_mid">
<h4 class="list_table_title">
<span class="ui_icon list_table_title_icon"></span>
<?php echo $this->_tpl_vars['strTitle']; ?>

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
        <?php $_from = $this->_tpl_vars['arrayRightPositionList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
          <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['post_name']; ?>
</div></td>
            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_name']; ?>
</div></td>
            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['e_name']; ?>
</div></td>
            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['dept_fullname']; ?>
</div></td>
            <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['right_name']; ?>
</div></td>
            <td><div class="ui_table_tdcntr"><ul class="list_table_operation">    
            <li><a m="RoleManager" v="8" ispurview="true" href="javascript:;" onclick="DelPosition(<?php echo $this->_tpl_vars['data']['post_id']; ?>
,<?php echo $this->_tpl_vars['data']['right_id']; ?>
)">删除职位</a></li>
            </ul></div>
            </td>            
          </tr>
        <?php endforeach; endif; unset($_from); ?>
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
<?php echo ' 
<script language="javascript" type="text/javascript">

function DelPosition(post_id,right_id)
{
    if(!confirm("您确定要删除吗？"))
        return ;
    '; ?>
 
    var url = '<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'Position','a' => 'DelPostRight'), $this);?>
';
    <?php echo ' 
    
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
    '; ?>
 
    var id = '<?php echo $this->_tpl_vars['id']; ?>
';
    <?php echo ' 
    JumpPage(\'/?d=System&c=Model&a=ModelRightPosition&id=\'+id,false);
}
</script>
'; ?>
 