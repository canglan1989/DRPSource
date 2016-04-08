<?php /* Smarty version 2.6.26, created on 2012-11-14 16:02:34
         compiled from FM/Backend/ContractCheckPager.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<div class="table_attention marginBottom10">
    <label>提醒信息：</label>
    <span class="ui_link">未审核：(<em><?php echo $this->_tpl_vars['unCheckNum']; ?>
</em>)</span>
</div> 
<!--E crumbs-->   
<div class="table_filter marginBottom10">  
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">  
            <div class="table_filter_main_row">	    			
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input type="text" name="agentName" style="width:200px;"  id="agentName"></div>
                <div class="ui_title">注册地区：</div>
                <div class="ui_comboBox">
                    <select id="selProvince" name="pri" class="pri"></select>
                    <select id="selCity" name="city" class="city"></select>
                    <select id="selArea" name="area" class="area"></select>
                </div>
                <div class="ui_title">代理产品：</div>                    
                <div id="ui_comboBox_agentPro" onClick="IM.comboBox.init(<?php echo '{\'control\':\'agentPro\',data:MM.A(this,\'data\')}'; ?>
,this)" class="ui_comboBox ui_comboBox_def" key="" value="" data='<?php echo $this->_tpl_vars['arrProductType']; ?>
' style="width:140px;">
                    <div style="width:120px;" class="ui_comboBox_text">
                        <nobr>全部</nobr>
                    </div>
                    <div class="ui_icon ui_icon_comboBox"></div>                        
                </div>
                <div class="ui_title">代理商产品等级：</div>
                <div class="ui_comboBox">
                    <select id="agentLevel" name="agentLevel">                        
                        <option value="-1" selected="selected">全部</option>
                        <!--<option value="0">无等级</option>-->
                        <option value="1">金牌</option>
                        <option value="2">银牌</option>
                    </select>
                </div>                                                        
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title">审核状态：</div>
                <div class="ui_comboBox">
                    <select id="checkStatus" name="checkStatus">                                                
                        <option value="-1" selected="selected">全部</option>
                        <option value="0">未审核</option>
                        <option value="1">审核通过</option>
                        <option value="2">审核退回</option>
                    </select>                                                        
                </div>
                <div class="ui_title">提交人：</div>
                <div class="ui_text"><input type="text" name="createName" class="inpCommon" id="createName"></div>
                <div class="ui_title">提交时间：</div>
                <div class="ui_text">
                    <input type="text" id="J_editTimeS" class="inpCommon inpDate" name="editTimeS" onFocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'J_editTimeE\')).focus()},maxDate:\'#F{$dp.$D(\\\'J_editTimeE\\\')}\'}'; ?>
)"> 至
                    <input type="text" id="J_editTimeE" class="inpCommon inpDate" name="editTimeE" onFocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS\\\')}\'}'; ?>
)">
                </div>                     
                <div class="ui_title">签约类型：</div>
                <div class="ui_comboBox">
                    <select name="pactType" id="pactType">
                        <option selected="selected" value="-1">全部</option>
                        <option value="1">签约</option>
                        <option value="3">解除签约</option>
                    </select>                                                        
                </div>
                <div class="ui_button ui_button_search"><button onClick="searchContractList()" class="ui_button_inner" type="button">搜索</button></div>
            </div>
        </div>
    </form>
</div>

<div class="list_link marginBottom10">
    <a href="javascript:;" onclick="ExportExcel()" class="ui_button"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_export"></div><div class="ui_text">导出Excel</div></div></a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>签约审核列表</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
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
                    <th style="width:90px;" title="代理商ID">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商ID</div>
            </div>
            </th>                					
            <th title="代理商名称">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商名称</div>
            </div>
            </th>
            <th title="注册地区">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">注册地区</div>
                <div class="ui_table_thsort" sort="sort_area_fullname"></div>
            </div>
            </th>
            <th style="width:" title="虚拟合同号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">虚拟合同号</div>
                <div class="ui_table_thsort" sort="sort_pact_number"></div>
            </div>
            </th>
            <th style="width:80px;"  title="签约类型">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">签约类型</div>
                <div class="ui_table_thsort" sort="sort_pact_type"></div>
            </div>
            </th>
            <th style="width:100px;" title="代理产品等级">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理产品等级</div>
                <div class="ui_table_thsort" sort="sort_agent_level"></div>
            </div>
            </th>
            <th style="width:100px;"  title="代理产品">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理产品</div>
                <div class="ui_table_thsort" sort="sort_product_type_name"></div>
            </div>
            </th>
            <th style="width:110px;"  title="提交人">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">提交人</div>
                <div class="ui_table_thsort" sort="sort_user_name"></div>
            </div>
            </th>

            <th style="width:130px" title="提交时间">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">提交时间</div>
                <div class="ui_table_thsort" sort="sort_create_time"></div>
            </div>
            </th>

            <th style="width:80px;" title="审核状态">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">审核状态</div>
                <div class="ui_table_thsort" sort="sort_contract_check"></div>
            </div>
            </th>                                                                        
            <th title="" style="width:65px;">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">操作</div>
            </div>
            </th>
            </tr>
            </thead>
            <tbody id="pageListContent" class="ui_table_bd">

            </tbody>
        </table>
    </div>
    <!--E ui_table-->
</div>
<!--E list_table_main-->           
<!--S list_table_foot-->
<div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
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
    
 function searchContractList()
 {
    var agentName   = $.trim($(\'#agentName\').val());
    var provinceId  = $(\'#selProvince\').val();
    var cityId      = $(\'#selCity\').val();
    var areaId      = $(\'#selArea\').val();
    var productType = $.trim(MM.A(MM.G(\'ui_comboBox_agentPro\'),\'key\'));                 
	var pactType    = $(\'#pactType\').val();
	var checkStatus = $(\'#checkStatus\').val();
	var agentLevel  = $(\'#agentLevel\').val();
	var createName  = $(\'#createName\').val();
	var J_cTimeS    = $(\'#J_editTimeS\').val();
	var J_cTimeE    = $(\'#J_editTimeE\').val();
    pageList.page = 1;
    pageList.param = \'&agentName=\'+encodeURIComponent(agentName)+\'&provinceId=\'+provinceId+\'&cityId=\'+cityId+\'&areaId=\'+areaId+\'&productType=\'+productType+\'&createName=\'+encodeURIComponent(createName)+\'&pactType=\'+pactType+\'&agentLevel=\'+agentLevel+\'&J_cTimeS=\'+J_cTimeS+\'&J_cTimeE=\'+J_cTimeE+\'&checkStatus=\'+checkStatus;
    //pageList.init();
	pageList.first();
 }
 
 function QueryData()
 {
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 
 function ExportExcel()
{
    window.open("/?d=FM&c=ContractCheck&a=ExportContractCheckList" + pageList.param + "&sortField=" + pageList.sortField);
}
    '; ?>

</script>