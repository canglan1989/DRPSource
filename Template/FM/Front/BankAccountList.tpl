  <!--E crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
    <!--S table_filter-->
   
    <!--E table_filter-->
    <!--S list_link-->
    <div class="list_link marginBottom10">
        <a class="ui_button" style="margin:0" onclick="addBankAccount(0)" href="javascript:;" v="4" ispurview="true" m="BankAccountList">
            <div class="ui_button_left"></div>
                <div class="ui_button_inner">
                <div class="ui_icon ui_icon_open"></div>
                <div class="ui_text">银行账户添加</div>
            </div>
        </a>
   </div>
    <!--E list_link-->
    <!--S list_table_head-->
    <div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
                	<tr>
                    	<th style="width:100px;" title="开户行">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">开户行</div>
                            </div>
                        </th>
                        <th style="width:100px;" title="账户名称">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">账户名称</div>
                            </div>
                        </th>
                        <th style="width:100px;" title="账号">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">账号</div>
                            </div>
                        </th>
                        <th style="width:50px;" title="操作">
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
    <div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
  </div>         
    <!--S list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal} 
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    {/literal}
	pageList.strUrl="{$BankAccountListBody}"; 
	{literal}
	pageList.init();
});
function addBankAccount(agent_bank_id){
        var _data = agent_bank_id;
        var title = "";
        if(parseInt(_data) > 0)
            title = "账户编辑";
        else title = "账户添加";
                
        IM.dialog.show({
            width: 500,
    	    height: null,
    	    title: title,
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=FM&c=BankAccount&a=BankAccountModify&id="+agent_bank_id, {}, function (backData) {
    			$('.DCont')[0].innerHTML = backData;
                	new Reg.vf($('#J_newBankAccount'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
                	var formValues = $('#J_newBankAccount').serialize();                
                 	$.ajax({
	                        type: "POST",
	                        dataType: "text",
	                        url: "/?d=FM&c=BankAccount&a=BankAccountModifySubmit&id="+agent_bank_id,
	                        data: formValues,
	                        success: function (q) {
					q=MM.json(q);
					if(q.success){
						JumpPage("/?d=FM&c=BankAccount&a=BankAccountList");
						IM.dialog.hide();
						IM.tip.show(q.msg);
					}else{
						IM.tip.warn(q.msg);
					}     
				}                        
	                    });
                    }});
            });
      
       }});
}    
</script>
{/literal}