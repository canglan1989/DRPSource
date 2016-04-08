<?php /* Smarty version 2.6.26, created on 2012-12-17 14:24:49
         compiled from Agent/EachsignDetialPager.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><s class="icon_crumbs"></s>当前位置当前位置：代理商管理<span>&gt;</span>签约管理<span>&gt;</span>签约明细<span>&gt;</span>签约记录</div>
<!--E crumbs-->
<div class="list_link marginBottom10">
    <a style="margin:0;" class="ui_button ui_button_dis" href="javascript:;" onclick="JumpPage('<?php echo $this->_tpl_vars['lastUrl']; ?>
');"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_return"></div><div class="ui_text">返回</div></div></a>
</div>
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 签约记录列表（合同号：<?php echo $this->_tpl_vars['arrPactInfo']['pact_number']; ?>
<?php echo $this->_tpl_vars['arrPactInfo']['pact_stage']; ?>
）</h4>
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
                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">签约类型</div></div></th>
                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">签约状态</div></div></th>
                <th class="TA_r"><div class="ui_table_thcntr"><div class="ui_table_thtext">保证金金额</div></div></th>
                <th class="TA_r"><div class="ui_table_thcntr"><div class="ui_table_thtext">预存款金额</div></div></th>
                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">提交人</div></div></th>
                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">战区名称</div></div></th>
                <th><div class="ui_table_thcntr"><div class="ui_table_thtext">提交时间</div></div></th>
        </tr>
        </thead>
        <tbody id="pageListContent" class="ui_table_bd">
             
        </tbody>
        <input type="hidden" name="pactId" id="pactId" value="<?php echo $this->_tpl_vars['pactId']; ?>
" />
        <input type="hidden" name="agentId" id="agentId" value="<?php echo $this->_tpl_vars['agentId']; ?>
" />
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
    '; ?>

	pageList.page = 1;
	pageList.strUrl="<?php echo $this->_tpl_vars['strUrl']; ?>
"; 
    <?php echo '
	pageList.param = \'&agentId=\'+$(\'#agentId\').val()+\'&pactId=\'+$(\'#pactId\').val();
	pageList.init();
 });
    '; ?>

</script>  