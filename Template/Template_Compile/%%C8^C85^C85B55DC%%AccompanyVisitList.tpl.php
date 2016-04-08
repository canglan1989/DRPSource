<?php /* Smarty version 2.6.26, created on 2013-01-28 10:43:47
         compiled from Agent/WorkManagement/AccompanyVisitList.tpl */ ?>
<!--E crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">
  <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
      <div class="table_filter_main_row">
        <div class="ui_title">制定人：</div>
        <div class="ui_text" id="low2">
          <input id="create_name" class="user_name" type="text" name="create_name" style="vertical-align:top;" onfocus="AutoComplete('create_name')"/>
        </div>
        <div class="ui_title">小记制定时间：</div>
        <div class="ui_text">
          <input id="J_editTimeS" class="inpDate" name="create_timeb" value="<?php echo $this->_tpl_vars['arrayData']['0']['sappoint_time']; ?>
" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'J_editTimeE\')).focus()},dateFmt:\'yyyy-MM-dd\',maxDate:\'#F{$dp.$D(\\\'J_editTimeE\\\')}\'})'; ?>
" type="text"/>
          至
          <input id="J_editTimeE" class="inpDate" name="create_timee" value="<?php echo $this->_tpl_vars['arrayData']['0']['eappoint_time']; ?>
" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS\\\')}\',dateFmt:\'yyyy-MM-dd\'}'; ?>
)" type="text"/>
        </div>
        <div class="ui_title">邀请人：</div>
        <div class="ui_comboBox">
          <input id="inviter" class="inpCommon" type="text" name="inviter" style="vertical-align:top;" onfocus="AutoComplete('inviter')"/>
        </div>
      </div>
      <div class="table_filter_main_row">
        <div class="ui_title">代理商：</div>
        <div class="ui_text">
          <input type="hidden" value="<?php echo $this->_tpl_vars['agent_id']; ?>
" name="agent_id" />
          <input id="agent_name" class="agent_name" type="text" name="agent_name" style="vertical-align:top;"/>
        </div>
        <div class="ui_title">审查状态：</div>
        <div class="ui_comboBox">
          <select id="auditState" name="auditState">
            <option value="-100" selected="selected">全部</option>
            <option value="0">未审查</option>
            <option value="1">审查通过</option>
            <option value="2">审查不通过</option>
          </select>
        </div>
        <div class="ui_title">被访人姓名：</div>
        <div class="ui_comboBox">
          <input id="visitor" class="inpCommon" type="text" name="visitor" style="vertical-align:top;"/>
        </div>
        <div class="ui_title">数据类型：</div>
        <div class="ui_comboBox">
          <select id="datatype" name="datatype">
            
                                    
                                    <?php if ($this->_tpl_vars['all'] == 64): ?>
            <option value="1" selected="selected">全部</option>
            <?php endif; ?>                                    
                                    <?php if ($this->_tpl_vars['self'] == 2): ?>
            <option value="-100" >本人</option>
            <?php endif; ?>                                    
                                    <?php if ($this->_tpl_vars['low'] == 16): ?>
            <option value="2">下级</option>
            <option value="3">下级和本人</option>
            <?php endif; ?>
                                
          </select>
        </div>
        <div class="ui_button ui_button_search"></span>
          <button type="button" class="ui_button_inner" onclick="searchAccompanyVisit()">查询</button>
        </div>
      </div>
    </div>
  </form>
</div>
<!--E table_filter--> 
<!--S list_link-->
<div class="list_link marginBottom10"> <a class="ui_button" style="margin:0" onclick="JumpPage('/?d=WorkM&c=AccompanyVisit&a=AddAccompanyVisitStep1')" href="javascript:;" >
  <div class="ui_button_left"></div>
  <div class="ui_button_inner">
    <div class="ui_icon ui_icon_open"></div>
    <div class="ui_text">添加陪访小记</div>
  </div>
  </a> </div>
<div class="list_link marginBottom10"> <a class="ui_button" onclick="pageList.ExportExcel()" href="javascript:;">
  <div class="ui_button_left"></div>
  <div class="ui_button_inner">
    <div class="ui_icon ui_icon_export"></div>
    <div class="ui_text">导出Excel</div>
  </div>
  </a> </div>
<!--E list_link--> 
<!--S list_table_head-->
<div class="list_table_head">
  <div class="list_table_head_right">
    <div class="list_table_head_mid">
      <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span><?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
      <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> </div>
  </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
  <div id="J_ui_table" class="ui_table">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <thead class="ui_table_hd">
        <tr>
          <th width="50" title="编号"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">编号</div>
                <div class="ui_table_thsort" sort="sort_visitnoteid"></div>
            </div>
          </th>
          <th width="70" title="制定人"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">制定人</div>
                <div class="ui_table_thsort" sort="sort_e_name"></div>
            </div>
          </th>
          <th width="" title="制定时间"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">制定时间</div>
                <div class="ui_table_thsort" sort="sort_create_time"></div>
            </div>
          </th>
          <th title="邀请人"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">邀请人</div>
                <div class="ui_table_thsort" sort="sort_visitor"></div>
            </div>
          </th>
          <th title="拜访时间"> <div class="ui_table_thcntr">
              <div class="ui_table_thtext">拜访时间</div>
            </div>
          </th>
          <th title="代理商名称"> <div class="ui_table_thcntr" >
              <div class="ui_table_thtext">代理商名称</div>
                <div class="ui_table_thsort" sort="sort_agent_name"></div>
            </div>
          </th>
          <th title="被访人姓名"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">被访人姓名</div>
            </div>
          </th>
          <th title="被访人联系电话"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">被访人联系电话</div>
            </div>
          </th>
          <th title="陪访内容"> <div class="ui_table_thcntr " >
              <div class="ui_table_thtext">陪访内容</div>
                <div class="ui_table_thsort" sort="sort_content"></div>
            </div>
          </th>
          <th title="审查状态"> <div class="ui_table_thcntr ">
              <div class="ui_table_thtext">审查状态</div>
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
  <div id="divPager" class="ui_pager"> </div>
</div>
<!--S list_table_foot--> 
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<?php echo ' 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['AccompanyVisitListBody']; ?>
"; 
    pageList.param = "&"+$('#tableFilterForm').serialize();//get 获取！     
	<?php echo '
	pageList.init();
});

function searchAccompanyVisit()
{
	pageList.param = "&"+$(\'#tableFilterForm\').serialize();//get 获取！      
	pageList.first();
}

function AutoComplete(complete_id)
{
    $(\'#\'+complete_id).autocomplete(\'/?d=WorkM&c=AccompanyVisit&a=CompleteInviter\', {
    max: 15,
    width: 150,
    parse: function (Data) {
        var parsed = [];
        if (Data == "" || Data.length == 0)
            return parsed;
        Data = MM.json(Data);
        var value = Data.value;
        if (value == undefined)
            return parsed;

        for (var i = 0; i < value.length; i++) {
            parsed[parsed.length] = {
                data: value[i],
                value: value[i].id,
                result: value[i].name
            }
        }
        return parsed;
    },
    formatItem: function (item){
        return "<div id=\'divUser" + item.id + "\'>" + item.name + "</div>";
    }
    }).result(function (data, value) {
    //_id = value.id;
    //$("#create_name").val(_id);
    //var val = $(this).val();
    });
}
function ShowCheckDetial(id)//这里和RelateAccompanyList.tpl里面的重复
{
        IM.dialog.show({
            width: 600,
    	    height: null,
    	    title: "审查陪访小记",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    	       MM.get("/?d=WorkM&c=AccompanyVisit&a=CheckDetial&id="+id, {}, function (backData) {
    		    $(\'.DCont\')[0].innerHTML = backData;
                })
    	    }
            })
            
}
</script> 
'; ?>