<?php /* Smarty version 2.6.26, created on 2012-12-24 13:57:59
         compiled from Agent/channelAgentContact.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/channelAgentContact.tpl', 7, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商资料管理<span>&gt;</span>全部联系小记</div>
<!--E crumbs-->
<div class="form_edit">
  <div class="form_hd">
    <ul>
      <li> <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'pactAgentContact'), $this);?>
');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>签约代理商</h2>
            </div>
          </div>
        </div>
        </a> </li>
      <li class="cur"> <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'channelAgentContact'), $this);?>
');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>潜在代理商</h2>
            </div>
          </div>
        </div>
        </a> </li>
    </ul>
  </div>
  <!--S form_bd-->
  <div class="form_bd">
    <div class="form_block_bd"> 
      <!--S table_filter-->
      <div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
          <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">
              <div class="ui_title">代理商名称：</div>
              <div class="ui_text">
                <input id="agent_name" class="agent_name" type="text" name="companyName" style="vertical-align:top;"/>
              </div>
              <div class="ui_title">联系时间：</div>
              <div class="ui_text">
             	  <input id="contactSTime" type="text" class="inpCommon inpDate" name="contactSTime" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'contactETime\')).focus()},maxDate:\'#F{$dp.$D(\\\'contactETime\\\')}\'}'; ?>
)"/> 至
                 <input id="contactETime" type="text" class="inpCommon inpDate" name="contactETime" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'contactSTime\\\')}\'}'; ?>
)"/>
		      </div>
              <div class="ui_title">意向评级：</div>
              <div class="ui_comboBox">
                <select id="leval" name="leval">
                  <option value="">全部</option>
                  <option value="A">A</option>
                  <option value="B+">B+</option>
                  <option value="B-">B-</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                </select>
              </div>
              <div class="ui_title">操作人：</div>
              <div class="ui_comboBox">
                <input id="e_name" class="inpCommon" type="text" name="ctlUser" value="<?php echo $this->_tpl_vars['eName']; ?>
" style="vertical-align:top;"/>
              </div>
            </div>
            <div class="table_filter_main_row">
              <div class="ui_title">联系人：</div>
              <div class="ui_comboBox">
                <input id="contact_name" class="inpCommon" type="text" name="contact" style="vertical-align:top;"/>
              </div>
              <div class="ui_title">已邀约：</div>
              <div class="ui_comboBox">
                <select name="isInvite" id="isInvite" class="inpCommon" >
                  <option value="-1" selected>全部</option>
                  <option value="1" >是</option>
                  <option value="0" >否</option>
                </select>
              </div>
              <div class="ui_title">联系次数：</div>
              <div class="ui_text">
                <input class="inpCommon" type="text" name="tbxSContactCount" id="tbxSContactCount" style="width:80px;text-align:right" size="8" maxlength="3" onkeydown="return NumberOnly(event)"/>
                --
                <input class="inpCommon" type="text" name="tbxEContactCount" id="tbxEContactCount" style="width:80px;text-align:right" size="8" maxlength="3" onkeydown="return NumberOnly(event)"/>
              </div>
              <div class="ui_button ui_button_search"></span>
                <button type="button" class="ui_button_inner" onclick="searchChannelAgentContact()">搜索</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!--E table_filter-->
      <div class="list_link marginBottom10"> <a class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner">
          <div class="ui_icon ui_icon_export"></div>
          <div class="ui_text">导出Excel</div>
        </div>
        </a>
        <a class="ui_button" m="UnitMarketQuestionList" v="4" ispurview="true" onclick="UnitMarketQuestion()" href="javascript:;">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner">
          <div class="ui_text">网盟市场调查邮件发送</div>
        </div>
        </a>
       </div>
      <!--S list_table_head-->
      <div class="list_table_head">
        <div class="list_table_head_right">
          <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 联系小记列表</h4>
          </div>
        </div>
      </div>
      <!--E list_table_head--> 
      <!--S list_table_main-->
      <div class="list_table_main">
        <div id="J_ui_table" class="ui_table">
          <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
              <tr class="">
                <th title="全选/反选" style="width:30px">
                <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">
                    <input class="checkInp" type="checkbox" onClick="<?php echo 'IM.table.selectAll(this.checked);IM.table.checkAll(\'listid\');'; ?>
"/>
                    </div>
                </div>
                </th>
                <th title="代理商名称" style=""> <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">代理商名称</div>
                  </div>
                </th>
                <th title="联系次数" style="width:60px;"> <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">联系次数</div>
                  </div>
                </th>
                <th title="操作人" style="width:100px;"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">操作人</div>
                  </div>
                </th>
                <th title="被联系人" style="width:100px;"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">被联系人</div>
                  </div>
                </th>
                <th style="width:100px;" title="联系电话"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">联系电话</div>
                  </div>
                </th>
                <th title="联系时间" style="width:130px;"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">联系时间</div>
                  </div>
                </th>
                <th title="添加时间" style="width:130px;"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">添加时间</div>
                  </div>
                </th>
                <th title="已邀约" style="width:80px;"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">已邀约</div>
                  </div>
                </th>
                <th title="联系记录"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">联系记录</div>
                  </div>
                </th>
                <th style="width:80px;" title="意向评级"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">意向评级</div>
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
      <div class="list_table_foot">
        <div id="divPager" class="ui_pager"></div>
      </div>
    </div>
  </div>
  <!--E form_bd--> 
  <!--E sidenav_neighbour--> 
</div>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<script type="text/javascript">
 <?php echo '
 $(function(){
    $.setPurview();
	'; ?>

	pageList.strUrl = "<?php echo $this->_tpl_vars['strUrl']; ?>
"; 
	<?php echo '
	pageList.init();
 });
 function searchChannelAgentContact()
 {
	var agentName = $.trim($(\'#agent_name\').val());
    var contactSTime = $(\'#contactSTime\').val();
    var contactETime = $(\'#contactETime\').val();
    var cbLeval = document.getElementById("leval");
    var leval = encodeURIComponent(cbLeval.options[cbLeval.selectedIndex].value);
    var eName = $(\'#e_name\').val();
	var contactName = $(\'#contact_name\').val();
	pageList.param = \'&agentName=\'+encodeURIComponent(agentName)+\'&contactSTime=\'+contactSTime+\'&contactETime=\'+contactETime+\'&leval=\'+leval+\'&eName=\'+encodeURIComponent(eName)+\'&contactName=\'+encodeURIComponent(contactName)
    +\'&isInvite=\'+$("#isInvite").val()+\'&tbxSContactCount=\'+$("#tbxSContactCount").val()+\'&tbxEContactCount=\'+$("#tbxEContactCount").val();
	pageList.first();
 }
 
 
 function UnitMarketQuestion()
 {
    var chkID = document.getElementsByName("listid");
    var ids = "";
    
	for(var i = 0;i < chkID.length;i++)
	{
		if(chkID[i].checked)
        {
			ids += "," + chkID[i].value;
        }
	}
	
	if(ids.length > 1)
        ids = ids.substring(1, ids.length);
    else
    {
        IM.tip.warn("请选择代理商！");
        return ;
    }
    
    JumpPage("/?d=SendMail&c=SendMail&a=UnitMarketQuestionModify&agentIDs="+ids);
 }
 
 '; ?>

 </script> 