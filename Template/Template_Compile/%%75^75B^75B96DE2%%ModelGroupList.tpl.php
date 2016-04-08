<?php /* Smarty version 2.6.26, created on 2012-11-27 15:15:27
         compiled from System/ModelManager/ModelGroupList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'System/ModelManager/ModelGroupList.tpl', 136, false),)), $this); ?>
 <!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
  <!--E crumbs--> 
  <!--S table_filter-->  
  <div class="table_filter marginBottom10">
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
      <div id="J_table_filter_main" class="table_filter_main">
        <div class="table_filter_main_row"> 
      	<div class="ui_text">查看模块：</div>      
        <div class="ui_comboBox">
        <select name="cbModelGroup" id="cbModelGroup" onchange="ChangeData(this)" style="width:150px;" >
          <option value="-100">==请选择根模块==</option>
          <?php $_from = $this->_tpl_vars['arryRootModelGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
          <option value="<?php echo $this->_tpl_vars['data']['mgroup_no']; ?>
" ><?php echo $this->_tpl_vars['data']['mgroup_name']; ?>
</option>
          <?php endforeach; endif; unset($_from); ?>
        </select>
        </div>
        </div>
      </div>
    </form>
  </div>
  <div class="list_link marginBottom10">
  <?php if ($this->_tpl_vars['isDepEvn'] == 1): ?>
  <!--E table_filter--> 
  <!--S list_link-->
     <a class="ui_button" onclick="AddModelGroup()" href="javascript:;" m="ModelGroupList" v="4" ispurview="true">
    <div class="ui_button_left"></div>
        <div class="ui_button_inner">
            <div class="ui_icon ui_icon_open"></div>
            <div class="ui_text">添加模块组</div>
        </div>
         </a>
 <a class="ui_button" onclick="JumpPage('/?d=System&c=Dev_ModelCreate&a=TablesList',true,true);ClearStockQueryData();" href="javascript:;">
    <div class="ui_button_left"></div>
        <div class="ui_button_inner">
            <div class="ui_icon ui_icon_open"></div>
            <div class="ui_text">生成模板</div>
        </div>
         </a>    
  <?php else: ?>
     <a class="ui_button" onclick="SynchronousGroup()" href="javascript:;" m="ModelGroupList" v="4" ispurview="true">
    <div class="ui_button_left"></div>
        <div class="ui_button_inner">
            <div class="ui_icon ui_icon_add"></div>
            <div class="ui_text">从开发库中将数据同步</div>
        </div>
         </a>         
  <?php endif; ?>
  
     <a class="ui_button" onclick="ClearModelPath()" href="javascript:;" m="ModelGroupList" v="4" ispurview="true">
    <div class="ui_button_left"></div>
        <div class="ui_button_inner">
            <div class="ui_text">清除菜单缓存</div>
        </div>
         </a>
    </div>
  <!--E list_link--> 
  <!--S list_table_head-->
  <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
       
<a href="javascript:;" onclick="ChangeData($('#cbModelGroup')[0])" class="ui_button ui_link"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>

    </div>
    </div>
 </div>
  <!--E list_table_head--> 
  <!--S list_table_main-->
  <div class="list_table_main">
    <div  class="ui_table">
       <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <thead class="ui_table_hd">
          <tr>
            <th style="width:170px">
            	<div class="ui_table_thcntr">
                	<div class="ui_table_thtext">模块组名</div>
                </div>
            </th>
            <th style="width:150px">
            	<div class="ui_table_thcntr">
                	<div class="ui_table_thtext">代号 </div>
                </div></th>
            <th style="width:50px">
            	<div class="ui_table_thcntr">
                	<div class="ui_table_thtext">排序</div>
                </div></th>
            <th style="width:70px">
            	<div class="ui_table_thcntr">
                	<div class="ui_table_thtext">状态</div>
                </div>
                </th>
            <th>
            	<div class="ui_table_thcntr">
                	<div class="ui_table_thtext">描述</div>
                </div></th>
            <th style="width:100px">
            	<div class="ui_table_thcntr">
                	<div class="ui_table_thtext">添加日期</div>
                </div></th>
            <th style="width:140px"><div class="ui_table_thcntr ">
                <div class="ui_table_thtext">操作</div>
              </div>
            </th>
          </tr>
        </thead>
        <tbody class="ui_table_bd" id="J_ui_table">
        </tbody>
      </table>
    </div>
    <!--E ui_table--> 
  </div>
  <!--E list_table_main--> 
  <!--S list_table_foot-->
  <div class="list_table_foot">
    <div class="ui_pager" > </div>
  </div>
  <!--E list_table_foot-->  
<?php echo ' 
<script language="javascript" type="text/javascript">
function ChangeData(obj)
{
    '; ?>

    var formValues="modelGroup="+obj.value+"&isAgent=<?php echo $this->_tpl_vars['iIsAgent']; ?>
";
     var returnData = $PostData("/?d=System&c=ModelGroup&a=ModelGroupListBody",formValues);
     $("#J_ui_table").html(returnData+"");     
    <?php echo ' 
}

ChangeData($("#cbModelGroup")[0]);

function AddModelGroup()
{
    '; ?>
 
    var url = '<?php echo getSmartyActionUrl(array('d' => 'System','c' => 'ModelGroup','a' => 'ModelGroupModify'), $this);?>
&isAgent=<?php echo $this->_tpl_vars['iIsAgent']; ?>
';
    <?php echo ' 
    JumpPage(url);
}

function LockData(id)
{
    var retValue = $PostData("/?d=System&c=ModelGroup&a=LockModel","id="+id);

    if(parseInt(retValue) == 0)
    {
        //todo 刷新页面
        ChangeData($("#cbModelGroup")[0]);
    }
    else
    {
        IM.tip.warn(retValue);
    }
}

function SynchronousGroup()
{
    var retValue = $PostData("/?d=System&c=ModelGroup&a=SynchronousGroup");

    if(parseInt(retValue) == 0)
    {
        //todo 刷新页面
        ChangeData($("#cbModelGroup")[0]);
        IM.tip.show("同步完成！");
    }
    else
    {
        IM.tip.warn(retValue);
    }
}

function ClearModelPath()
{
    var retValue = $PostData("/?d=System&c=ModelGroup&a=ClearModelPath");

    if(parseInt(retValue) == 0)
    {
        IM.tip.show("清除成功！");
    }
    else
    {
        IM.tip.warn(retValue);
    }
}
</script>
'; ?>
 