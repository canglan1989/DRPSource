<?php /* Smarty version 2.6.26, created on 2013-03-12 11:00:04
         compiled from Agent/SignCheckIndex.tpl */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
    <!--S crumbs-->
    <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：签约管理<span>&gt;</span>部门签约审核</div>
    <!--E crumbs-->   
    <!--S table_filter-->
    <div class="table_filter marginBottom10">  
	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
			<div class="table_filter_main_row">  
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input id="agent_name" style="width:180px" type="text" name="agent_name"/></div>
                
                <div class="ui_title">代理产品：</div>                    
                    <div id="ui_comboBox_agentPro" onClick="IM.comboBox.init(<?php echo '{\'control\':\'agentPro\',data:MM.A(this,\'data\')}'; ?>
,this)" class="ui_comboBox ui_comboBox_def" key="" value="" data='<?php echo $this->_tpl_vars['arrProductType']; ?>
' style="width:100px;">
                        <div class="ui_comboBox_text" style="width:80px;">
                        	<nobr>全部</nobr>
                        </div>
                        <div class="ui_icon ui_icon_comboBox"></div>                        
                    </div>
                    <div class="ui_title">签约类型：</div>
                    <div class="ui_comboBox">
                        <select name="pactType" id="pactType">                                                                            
                            <option selected="selected" value="-1">全部</option>
                            <option value="1">新签</option>
                            <option value="2">续签</option>
                            <option value="3">解除签约</option>
                        </select>                                                        
                 	</div>
                    <div class="ui_title">审核状态：</div>
                    <div class="ui_comboBox">
                        <select name="checkType" id="checkType">                                                                            
                            <option selected="selected" value="-1">全部</option>
                            <option value="1">未审核</option>
                            <option value="2">审核通过</option>
                            <option value="6">审核退回</option>
                        </select>                                                        
                 	</div>
                    
                    <div class="ui_title">代理产品等级：</div>
                    <div class="ui_comboBox">
                        <select name="agentLevel" id="agentLevel">                                                                            
                            <option selected="selected" value="-1">全部</option>
                            <option value="0">无等级</option>
                            <option value="1">金牌</option>
                            <option value="2">银牌</option>
                        </select>                                                        
                 	</div>
            </div>
            <div class="table_filter_main_row">
            	<!--<div class="ui_title">战区名称：</div>
                    <div class="ui_text"><input class="inpCommon" name="areaName" id="areaName" type="text"></div> -->
					<div class="ui_title">提交人：</div>
                    <div class="ui_text"><input class="inpCommon" name="createName" id="createName" type="text"></div> 
					<div class="ui_title">提交时间：</div>
                    <div class="ui_text">
                                <input type="text" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'J_cTimeE\')).focus()},maxDate:\'#F{$dp.$D(\\\'J_cTimeE\\\')}\'}'; ?>
)" name="editTimeS" class="inpCommon inpDate" id="J_cTimeS"> 至
                                <input type="text" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_cTimeS\\\')}\'}'; ?>
)" name="editTimeE" class="inpCommon inpDate" id="J_cTimeE">
					</div>
            	<div class="ui_title">注册地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;">
                    <select class="pri" name="pri" id="selProvince"></select>
                    <select class="city" name="city" id="selCity"></select>
                    <select class="area" name="area" id="selArea"></select>
                </div>
                <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="searchPactList()">搜 索</button></div>
            </div>
	    </div>
	</form>
    </div>
    <!--E table_filter-->
    <!--S list_table_head-->
    <div class="list_table_head">
        	<div class="list_table_head_right">
            	<div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 代理商签约审核列表</h4>
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
		<th style="width:90px;" title="代理商编号">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">代理商编号</div>
		</div>
		</th>
		<th style="" title="单位名称">
		<div class="ui_table_thcntr ">
		    <div class="ui_table_thtext">代理商名称</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
		<th style="" title="注册地区">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">注册地区</div>
		</div>
		</th>
		<th style="width:80px;" title="代理产品等级">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">代理等级</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
		<th style="width:80px;" title="代理产品">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">代理产品</div>
		</div>
		</th>
		<th style="width:120px;" title="提交人">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">提交人</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
		<th style="width:130px;" title="提交时间">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">提交时间</div>
		</div>
		</th>
		<th style="width:80px;" title="签约类型">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">签约类型</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
		<th style="width:100px;" title="审核状态">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">审核状态</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
        	<th style="width:110px;" title="战区名称">
		<div class="ui_table_thcntr">
		    <div class="ui_table_thtext">战区名称</div>
		    <div class="ui_table_thsort"></div>
		</div>
		</th>
		<th style="width:86px;" title="操作">
		<div class="ui_table_thcntr ">
		    <div class="ui_table_thtext">操作</div>
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
		<div id="divPager" class="ui_pager">
		    
		</div>
	</div>	
    <!--E list_table_foot-->
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<script>
    <?php echo '
$(document).ready(function(){
    pageList.strUrl='; ?>
"<?php echo $this->_tpl_vars['strUrl']; ?>
"<?php echo ';
    pageList.init();
    $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
});
    
 function searchPactList()
 {
    var agentName   = $.trim($(\'#agent_name\').val());
    var provinceId  = $(\'#selProvince\').val();
    var cityId      = $(\'#selCity\').val();
    var areaId      = $(\'#selArea\').val();
    var productType = $(\'#ui_comboBox_agentPro\').attr(\'key\');
	var pactType    = $(\'#pactType\').val();
	var checkType   = $(\'#checkType\').val();
	var agentLevel  = $(\'#agentLevel\').val();
	var areaName    = $(\'#areaName\').val();
	var createName  = $(\'#createName\').val();
	var J_cTimeS    = $(\'#J_cTimeS\').val();
	var J_cTimeE    = $(\'#J_cTimeE\').val();
    pageList.page = 1;
    pageList.param = \'&agentName=\'+encodeURIComponent(agentName)+\'&provinceId=\'+provinceId+\'&cityId=\'+cityId+\'&areaId=\'+areaId+\'&productType=\'+productType+\'&createName=\'+encodeURIComponent(createName)+\'&areaName=\'+encodeURIComponent(areaName)+\'&pactType=\'+pactType+\'&checkType=\'+checkType+\'&agentLevel=\'+agentLevel+\'&J_cTimeS=\'+J_cTimeS+\'&J_cTimeE=\'+J_cTimeE;
    //pageList.init();
	pageList.first();
 }
    '; ?>

</script>