<?php /* Smarty version 2.6.26, created on 2012-11-16 16:12:29
         compiled from System/ModelManager/ModelRightList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sdrclass', 'System/ModelManager/ModelRightList.tpl', 60, false),array('function', 'au', 'System/ModelManager/ModelRightList.tpl', 67, false),)), $this); ?>
<!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
  <!--E crumbs-->
  <div class="table_filter marginBottom10">
    <div id="J_table_filter_main" class="table_filter_main"> 
        <div class="table_filter_main_row">
        模块名：<a href="javascript:;" onclick="JumpPage('/?d=System&c=Model&a=ModelList&pid=<?php echo $this->_tpl_vars['objModelInfo']->iMgroupId; ?>
&isAgent=<?php echo $this->_tpl_vars['objModelInfo']->iIsAgent; ?>
')"><?php echo $this->_tpl_vars['objModelInfo']->strModelName; ?>
</a><?php echo $this->_tpl_vars['objModelInfo']->strModelCode; ?>

        </div>
      </div>
  </div>
  <!--S list_link-->
<?php if ($this->_tpl_vars['isDepEvn'] == 1): ?>
  <div class="list_link marginBottom10">
    <a class="ui_button" onclick="AddRight(<?php echo $this->_tpl_vars['modelID']; ?>
)" href="javascript:;" m="ModelGroupList" v="4" ispurview="true" style="margin:0;">
        <div class="ui_button_left"></div>
            <div class="ui_button_inner">
                <div class="ui_icon ui_icon_add"></div>
                <div class="ui_text">添加权限</div>
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
        <?php $_from = $this->_tpl_vars['arrayModelRight']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
        <tr class="<?php echo SetSingleDoubleRowClass(array('rIndex' => $this->_tpl_vars['index']), $this);?>
">
          <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['right_name']; ?>
</div></td>
          <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['right_value']; ?>
</div></td>
          <td><div class="ui_table_tdcntr"><?php if ($this->_tpl_vars['data']['is_lock'] == 1): ?><span style="color:#EE5F00;">关闭</span><?php else: ?><span style="color:#028100;">正常</span><?php endif; ?></div></td>
          <td><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['right_remark']; ?>
</div></td>
          <td><div class="ui_table_tdcntr"><ul class="list_table_operation">
          <?php if ($this->_tpl_vars['isDepEvn'] == 1): ?>
          <li><a m="ModelGroupList" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'ModelRight','a' => 'ModelRightModify'), $this);?>
&mid=<?php echo $this->_tpl_vars['modelID']; ?>
&id=<?php echo $this->_tpl_vars['data']['right_id']; ?>
')">编辑</a></li>
          <li><a m="ModelGroupList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'ModelRight','a' => 'ModelRightDel'), $this);?>
&id=<?php echo $this->_tpl_vars['data']['right_id']; ?>
&mid=<?php echo $this->_tpl_vars['modelID']; ?>
',<?php echo '{'; ?>
id:<?php echo $this->_tpl_vars['data']['right_id']; ?>
<?php echo '}'; ?>
 ,'删除模块',this)">删除</a></li>
          <?php endif; ?>
        </ul></div></td>
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
<?php echo ' 
<script language="javascript" type="text/javascript">
function AddRight(mid)
{
    '; ?>
 
    var url = '<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'ModelRight','a' => 'ModelRightModify'), $this);?>
&mid=<?php echo $this->_tpl_vars['modelID']; ?>
';
    <?php echo ' 
    JumpPage(url);
}

</script> 
'; ?>
 