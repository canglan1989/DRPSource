<?php /* Smarty version 2.6.26, created on 2013-03-08 09:46:23
         compiled from CM/ContactRecord/ContactRecordList.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->           
<div class="table_filter marginBottom10">  
	<form name="tableFilterForm" id="tableFilterForm" method="post" action="">
    <div id="J_table_filter_main" class="table_filter_main">    		
    	<div class="table_filter_main_row">
        	<div class="ui_title">客户ID：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerID" id="tbxCustomerID" value="<?php echo $this->_tpl_vars['CustomerID']; ?>
" style="width:60px;" /></div>                         	        	

        	<div class="ui_title">客户名称：</div>
            <div class="ui_text"><input type="text" name="tbxCustomerName" id="tbxCustomerName" value="<?php echo $this->_tpl_vars['CustomerName']; ?>
" style="width:200px;"/></div>	                         	        	

            <div class="ui_title">网盟意向等级：</div>
                <?php echo '
                    <div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({\'control\':\'IntentionRating\',data:MM.A(this,\'data\')},this)" 
                    '; ?>

                    class="ui_comboBox ui_comboBox_def" key="<?php echo $this->_tpl_vars['rating_id']; ?>
" value="<?php echo $this->_tpl_vars['rating_text']; ?>
" control="IntentionRating" data="<?php echo $this->_tpl_vars['strIntentionRatingJson']; ?>
" style="width:100px;">
                    <div class="ui_comboBox_text" style="width:80px;">
                        <?php if ($this->_tpl_vars['rating_id'] != ""): ?>
                            <nobr><?php echo $this->_tpl_vars['rating_text']; ?>
</nobr>
                        <?php else: ?>
                            <nobr>全部</nobr>
                        <?php endif; ?>
                    </div>
                    <div class="ui_icon ui_icon_comboBox"></div>                        
                </div>
            <div class="ui_title">联系时间：</div>
            <div class="ui_text">
                <input id="tbxSContactTime" type="text" class="inpCommon inpDate" name="tbxSContactTime" value="<?php echo $this->_tpl_vars['bdate']; ?>
" onClick="WdatePicker(<?php echo '{maxDate:\'#F{$dp.$D(\\\'tbxEContactTime\\\')}\'})'; ?>
"/>
                至
                <input id="tbxEContactTime" type="text" class="inpCommon inpDate" name="tbxEContactTime"  value="<?php echo $this->_tpl_vars['edate']; ?>
" onClick="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'tbxSContactTime\\\')}\'})'; ?>
"/>	
            </div> 
        </div>
	   <div class="table_filter_main_row">	
            <div class="ui_title">联系人：</div>
            <div class="ui_text"><input type="text" name="CreateName" class="inpCommon" value="<?php echo $this->_tpl_vars['CreateUserName']; ?>
" /></div>
            <div class="ui_title">有效联系：</div>
            <div class="ui_comboBox">
                <select id="cbIsvalidContact" name="cbIsvalidContact">
                <option value="-100" <?php if ($this->_tpl_vars['IsVaileContact'] == '3'): ?>selected<?php endif; ?>>请选择</option>
                <option value="0" <?php if ($this->_tpl_vars['IsVaileContact'] == '1'): ?>selected<?php endif; ?>>是</option>
                <option value="1" <?php if ($this->_tpl_vars['IsVaileContact'] == '2'): ?>selected<?php endif; ?>>否</option>
                </select>
            </div>
            <div class="ui_title">回访状态：</div>
            <div class="ui_comboBox">
                <select id="cbRevisitStatus" name="cbRevisitStatus">
                <option value="-100">请选择</option>
                <option value="1">已回访</option>
                <option value="0">未回访</option>
                </select>
            </div>
            	                         	        	
           <div class="ui_button ui_button_search"><button class="ui_button_inner" type="button" onclick="QueryData()" >搜 索</button></div>	
        </div>
    </div>
    </form>
</div>

<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> <?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
            <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a> 
        </div>
    </div>			           
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
	<div class="ui_table" id="J_ui_table">                    	
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        	<thead class="ui_table_hd">
            	<tr class="">
                   <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">客户ID</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">客户名称</div></div></th>
                   <th width="50"><div class="ui_table_thcntr"><div class="ui_table_thtext">网盟意向等级</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系人</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">被联系人</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系电话</div></div></th>
                   <th width="100"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系手机</div></div></th>
                   <th width="70"><div class="ui_table_thcntr"><div class="ui_table_thtext">有效联系</div></div></th>
                   <th><div class="ui_table_thcntr"><div class="ui_table_thtext">联系内容</div></div></th>  
                   <th width="80"><div class="ui_table_thcntr"><div class="ui_table_thtext">联系时间</div></div></th>
                   <th width="60"><div class="ui_table_thcntr"><div class="ui_table_thtext">回访状态</div></div></th> 
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
    <div class="ui_pager" id="divPager">    	
    </div>
</div>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>  
<?php echo '
<script type="text/javascript">
$(function(){    
	'; ?>

	pageList.strUrl = "<?php echo $this->_tpl_vars['ContactRecordListBody']; ?>
"; 
	<?php echo '    
	pageList.param = \'&\'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
    pageList.init();
});


function QueryData()
{
    pageList.param = \'&\'+$("#tableFilterForm").serialize()+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key");
    pageList.first();
}

function GetRecordDetail(id)
{
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: "小记明细",
	    html: IM.STATIC.LOADING,
	    start: function () {
		MM.get("/?d=CM&c=ContactRecord&a=GetContactRecordDetail&id="+id, {}, function (backData) {
		    $(\'.DCont\')[0].innerHTML = backData;
            
        });
      }
});
}
</script>
'; ?>