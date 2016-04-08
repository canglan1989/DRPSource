<?php /* Smarty version 2.6.26, created on 2013-01-23 21:33:21
         compiled from Agent/ExpectMoneyList.tpl */ ?>
﻿<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs--> 
<!--S table_filter-->
<div class="table_filter marginBottom10">
  <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
      <div class="table_filter_main_row">
        <div class="ui_title">代理商代码：</div>
        <div class="ui_text">
          <input class="inpCommon" type="text" name="tbxAgentNo" style="vertical-align:top;" id="tbxAgentNo" value="<?php echo $this->_tpl_vars['agentNo']; ?>
"/>
        </div>
        <div class="ui_title">代理商名称：</div>
        <div class="ui_text">
          <input class="" style="width:200px;" type="text" name="tbxAgentName" id="tbxAgentName"/>
        </div>
        <div class="ui_title">预计到账类型：</div>
        <div class="ui_comboBox">
          <select id="cbExpectMoneyType" name="cbExpectMoneyType">
            <option value="-100">请选择</option>
            <option value="1">承诺</option>
            <option value="2">备份</option>
          </select>
        </div>
        <div class="ui_title">操作日期：</div>
        <div class="ui_text">
          <input id="tbxCreateSDate" type="text" class="inpCommon inpDate" name="tbxCreateSDate" onclick="WdatePicker(<?php echo '{maxDate:\'#F{$dp.$D(\\\'tbxCreateEDate\\\')}\'})'; ?>
"/>
          至
          <input id="tbxCreateEDate" type="text" class="inpCommon inpDate" name="tbxCreateEDate" onclick="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'tbxCreateSDate\\\')}\'})'; ?>
"/>
        </div>
      </div>
      <div class="table_filter_main_row">
        <div class="ui_title">所属人：</div>
        <div class="ui_text">
          <input class="inpCommon" type="text" name="tbxChannelUserName" style="vertical-align:top;" id="tbxChannelUserName" value=""/>
        </div>
        <div class="ui_title">所属人所在组：</div>
        <div class="ui_comboBox">
          <select id="cbChannelUserGroup" name="cbChannelUserGroup">
            <option value="-100">请选择</option>
            
                <?php $_from = $this->_tpl_vars['arrayData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
                
            <option value="<?php echo $this->_tpl_vars['data']['account_no']; ?>
"><?php echo $this->_tpl_vars['data']['account_name']; ?>
</option>
            
                <?php endforeach; endif; unset($_from); ?>
                
          </select>
        </div>
        <div class="ui_title">预计到帐日期：</div>
        <div class="ui_text">
          <input id="tbxExpectMoneySDate" type="text" class="inpCommon inpDate" name="tbxExpectMoneySDate" onclick="WdatePicker(<?php echo '{maxDate:\'#F{$dp.$D(\\\'tbxExpectMoneyEDate\\\')}\'})'; ?>
"/>
          至
          <input id="tbxExpectMoneyEDate" type="text" class="inpCommon inpDate" name="tbxExpectMoneyEDate" onclick="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'tbxExpectMoneySDate\\\')}\'})'; ?>
"/>
        </div>
        <div class="ui_button ui_button_search">
          <button type="button" class="ui_button_inner" onclick="QueryData();">搜索</button>
        </div>
      </div>
    </div>
  </form>
</div>
<!--E table_filter--> 
<!--S list_table_head-->
<div class="list_table_head">
  <div class="list_table_head_right">
    <div class="list_table_head_mid">
      <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> <?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
      <a class="ui_button ui_link" href="javascript:;" onclick="pageList.reflash()"> <span class="ui_icon ui_icon_fresh"> </span> 刷新 </a> </div>
  </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
  <div id="J_ui_table" class="ui_table">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <thead class="ui_table_hd">
        <tr>
          <th style="width:90px;" title="代理商代码"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">代理商代码</div>
            </div>
          </th>
          <th style="width:190px;" title="代理商名称"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">代理商名称</div>
            </div>
          </th>
          <th style="width:110px;"  title="所属人"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">所属人</div>
            </div>
          </th>
          <th title="所属人所在组"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">所属人所在组</div>
            </div>
          </th>
          <th style="width:88px;" class="TA_r" title="预计到账金额"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">预计到账金额</div>
            </div>
          </th>
          <th title="预计到账时间"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">预计到账时间</div>
            </div>
          </th>
          <th style="width:100px;" title="预计到账类型"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">预计到账类型</div>
            </div>
          </th>
          <th style="width:70px;" class="TA_r" title="预计达成率"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">预计达成率</div>
            </div>
          </th>
          <th style="width:120px;" title="操作人"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">操作人</div>
            </div>
          </th>
          <th style="width:140px;" title="操作时间"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">操作时间</div>
            </div>
          </th>
        </tr>
      </thead>
      <tbody class="ui_table_bd" id="pageListContent">
      </tbody>
    </table>
  </div>
  <!--E ui_table--> 
</div>
<!--E list_table_main--> 
<!--S list_table_foot-->
<div class="list_table_foot">
<div id="divPager" class="ui_pager"></div>

<!--E list_table_foot--> 
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<script type="text/javascript">
 <?php echo '
 $(function(){
	'; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['ExpectMoneyListBody']; ?>
"; 
	<?php echo '
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.init();
 });
 
 function QueryData()
 {
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 '; ?>

 </script> 