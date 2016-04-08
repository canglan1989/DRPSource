<?php /* Smarty version 2.6.26, created on 2013-03-08 09:44:58
         compiled from CM/PublicPool/showCustomerInfoList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/PublicPool/showCustomerInfoList.tpl', 68, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->   
<!--<div class="table_attention marginBottom10">
    <label>温馨提示：
            电话客户可保留<?php echo $this->_tpl_vars['ProtectTel']; ?>
天；
            未添加联系的自录客户可保留<?php echo $this->_tpl_vars['ProtectSelfNo']; ?>
天；
            未添加联系的保护客户可保留<?php echo $this->_tpl_vars['ProtectDefendNo']; ?>
天；<br />
            距离上一次添加联系小记的自录客户可保留<?php echo $this->_tpl_vars['ProtectSelfHas']; ?>
天；
            距离上一次添加联系小记的保护客户可保留<?php echo $this->_tpl_vars['ProtextDefendHas']; ?>
天；
            正式客户可保留<?php echo $this->_tpl_vars['ProtectFormat']; ?>
天</label>
</div>  -->
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" name="tableFilterForm" id="tableFilterForm">
    <div class="table_filter_main" id="J_table_filter_main">
    	<div class="table_filter_main_row">
            <div class="ui_title">客户名称：</div>
            <div class="ui_text"><input class="inpCommon" type="text" name="customer_name" style="vertical-align:top;"/></div>
            
            <div class="ui_title">地区：</div>
                <div class="ui_comboBox"><select id="selProvince" class="pri" name="pri"><option value="-1">省份</option></select>
                <select id="selCity" class="city" name="city"><option value="-1">市</option></select>
                <select id="area_id" class="area" name="area"><option value="-1">区/县</option></select></div>
                
            <div class="ui_title">来源：</div>
            <div class="ui_text">
                <select name="resource">
                    <option value = "-1" >全部</option>
                    <option value = "4" >厂商分配</option>
                    <option value = "6" >导入</option>
                    <option value = "5" >录入</option>
                </select>
            </div>
            
            <div class="ui_title">行业：</div>
                <div class="ui_comboBox" name = "industryId" id = "industryId">
                <select id="industry_pid" name="industry_pid"></select>
                <select id="industry_id" name="industry_id"></select>
                </div>
        </div>
        <div class="table_filter_main_row">    
            <div class="ui_title">所属账号：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="belong_user" style="vertical-align:top;"/>
            </div>
            <div class="ui_title">数据状态：</div>
            <div class="ui_text">
                <select name="is_shield">
                    <option value="0">全部</option>
                    <option value="1">正常</option>
                    <option value="2">屏蔽</option>
                </select>
            </div>
            <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="QueryData()">搜 索</button></div>                   
        </div>
    </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div class="list_link marginBottom10">
    <a class="ui_button" m="CustomerInfo" ispurview="true" v="4" onclick="IM.customer.customerMove3('','','客户转移')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div><div class="ui_text">客户转移</div></div></a>
<!--    <a class="ui_button" onClick="IM.customer.customerMove2()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_move"></div><div class="ui_text">客户转移</div></div></a>-->
    <a class="ui_button" m="CustomerInfo" ispurview="true" v="32" onClick="ShieldCustomer()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">屏蔽操作</div></div></a>
    <a class="ui_button" m="CustomerInfo" ispurview="true" v="32" onClick="UnShield()" href="javascript:;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">取消屏蔽</div></div></a>
    <a class="ui_button ui_button_dis" m="CustomerInfo" ispurview="true" v="8" href="javascript:;" onClick="DelCustomer()"  style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">删除操作</div></div></a>  
<!--     <a class="ui_button ui_button_dis" href="javascript:;" onClick="IM.account.delOper('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'delFrontClient'), $this);?>
',<?php echo '{}'; ?>
,'客户删除',null,250,null,false)"  style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_del"></div><div class="ui_text">删除</div></div></a>  -->
</div>
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
                    <th title="全选/反选" style="width:30px">
                    <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">
                    <input onClick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');" class="checkInp" type="checkbox"/>
                </div>
            </div>
            </th>
            <th style="width:50px"  title="客户ID">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">客户ID</div>
            </div>
            </th>
            <th style="" title="客户名称">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">客户名称</div>
            </div>
            </th>
            <th style="" title="地区">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">地区</div>
            </div>
            </th>
            <th  title="行业">
            <div class="ui_table_thcntr" >
                <div class="ui_table_thtext">行业</div>
            </div>
            </th>
            <!--客户来源来另外的一张表cm_customer_agent里面 -->
            <th  title="来源">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">来源</div>
            </div>
            </th>

            <th  title="审核状态">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">审核状态</div>
            </div>
            </th>

            <th  title="录入时间">
            <div class="ui_table_thcntr" sort="sort_cm_customer.create_time" >
                <div class="ui_table_thtext">录入时间</div>
                <div class="ui_table_thsort"></div>
            </div>
            </th>
            <th  title="联系小记次数">
            <div class="ui_table_thcntr" sort="sort_cm_customer_ex.record_count">
                <div class="ui_table_thtext">联系小记次数</div><div class="ui_table_thsort"></div>
            </div>
            </th>
            <th  title="显示状态">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">显示状态</div>
            </div>
            </th>
            <th  title="所属账号">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">所属账号</div>
            </div>
            </th>
            <th  title="操作">
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
<div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
<!--E list_table_foot-->
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>
<script type="text/javascript">
<?php echo '
$(function(){
  $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"area_id",iAddPleaseSelect:false,iAddPleaseSelect:true});
     $("#industry_pid").BindIndustryFirstLevelGet({secondLevelID:"industry_id",iAddPleaseSelect:true});
    '; ?>

	pageList.strUrl="<?php echo $this->_tpl_vars['BodyUrl']; ?>
"; 
<?php echo '
	pageList.param = "&"+$(\'#tableFilterForm\').serialize();
	pageList.init();
});

function QueryData()
{
    pageList.param = \'&\'+$("#tableFilterForm").serialize();
    pageList.first();
} 
    
function ShieldCustomer(){
    var CustomerIDs = IM.table.getListID();
    if(CustomerIDs.length == 0){
        IM.tip.warn("请选择批量拉取的数据");
            return false;
    }
    CustomerID =CustomerIDs.join(\',\');
    IM.dialog.show({
            width: 400,
    	    height: null,
    	    title: "踢入公海",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=CM&c=CMPublicPool&a=showToSeaPage", {}, function (backData) {
    			$(\'.DCont\')[0].innerHTML = backData;
                	new Reg.vf($(\'#J_newBankAccount\'),{isEncode:false,
                            extValid:{
                                selected:function(){
                                    return MM.getVal(MM.G(\'sheldtime\')).text!=\'请选择\';
                                }
                            },
                        callback:function(formdata){////formdata 表单提交数据 对象数组格式
                	var formValues = $(\'#J_newBankAccount\').serialize();                
                 	$.ajax({
	                        type: "POST",
	                        dataType: "text",
	                        url: "/?d=CM&c=CMPublicPool&a=ShieldCustomer&customerlist="+CustomerID,
	                        data: formValues,
	                        success: function (q) {
					q=MM.json(q);
					if(q.success){
						IM.tip.show(q.msg);
                                                IM.dialog.hide();
                                                pageList.reflash();
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
            });
      
       }});
}
    
function UnShield(){
     var CustomerIDs = IM.table.getListID();
    if(CustomerIDs.length == 0){
        IM.tip.warn("请选择批量拉取的数据");
            return false;
    }
    CustomerID =CustomerIDs.join(\',\');               
                 	$.ajax({
	                        type: "POST",
	                        dataType: "text",
	                        url: "/?d=CM&c=CMPublicPool&a=UnShield",
	                        data: {
                                    \'customerlist\':CustomerID
                                },
	                        success: function (q) {
					q=MM.json(q);
					if(q.success){
						IM.tip.show(q.msg);
                                                IM.dialog.hide();
                                                pageList.reflash();
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
}
    
    function DelCustomer(){
    var CustomerIDs = IM.table.getListID();
    if(CustomerIDs.length == 0){
        IM.tip.warn("请选择客户");
            return false;
    }
    CustomerID =CustomerIDs.join(\',\');
    IM.dialog.show({
            width: 600,
    	    height: null,
    	    title: "删除客户",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=CM&c=CMInfo&a=showDelFrontClient", {}, function (backData) {
    			$(\'.DCont\')[0].innerHTML = backData;
                	new Reg.vf($(\'#J_newBankAccount\'),{
                        callback:function(formdata){////formdata 表单提交数据 对象数组格式              
                 	$.ajax({
	                        type: "POST",
	                        dataType: "text",
	                        url: "/?d=CM&c=CMInfo&a=delFrontClient",
	                        data: {
                                    \'customerids\':CustomerID,
                                    \'delreason\':$("#del_reason").val()
                                },
	                        success: function (q) {
					q=MM.json(q);
					if(q.success){
						IM.tip.show(q.msg);
                                                IM.dialog.hide();
                                                pageList.reflash();
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
            });
      
       }});
}
'; ?>

</script>