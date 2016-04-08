<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->   
<!--S table_filter-->
<div class="table_filter marginBottom10">  
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">
    <div id="J_table_filter_main" class="table_filter_main">    		
    	<div class="table_filter_main_row">
        	<div class="ui_title">票据号：</div>
            <div class="ui_text"><input type="text" name="operator" class="inpCommon"/></div>
            <div class="ui_title">快递号：</div>
            <div class="ui_text"><input type="text" name="amount" class="inpCommon"/></div>
            <div class="ui_title">快递状态：</div>
            <div class="ui_comboBox">
                <select name="invoiceState">
                <option selected="selected" value="全部">全部</option>
                <option value="已发送">已发送</option>
                <option value="已签收">已签收</option>
                </select>
            </div>	                    	
            <div class="ui_title">快递公司：</div>
            <div class="ui_text"><input type="text" name="receipt_title" style="width:200px;"/></div>
            <div class="ui_title">收件人：</div>
            <div class="ui_text"><input type="text" name="receipt_title" class="inpCommon"/></div>
        </div>
        <div class="table_filter_main_row">
            <div class="ui_title">发件时间：</div>
            <div class="ui_text">
                <input id="J_editTimeS" type="text" class="inpCommon inpDate" name="tbxPostSDate" onClick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE\')}'}){/literal}"/>
                至
                <input id="J_editTimeE" type="text" class="inpCommon inpDate" name="tbxPostEDate" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS\')}'}){/literal}"/>	
            </div>
            <div class="ui_button ui_button_search"><button class="ui_button_inner" type="submit">搜索</button></div>
		</div>
    </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_table_head-->
<div class="list_table_head">
	<div class="list_table_head_right">
    	<div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 票据邮寄管理列表</h4>
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
                        	<th title="编号" style="width:50px;">
                            	<div class="ui_table_thcntr">
                                	<div class="ui_table_thtext">编号</div>
                                </div>
                            </th>
                            <th title="快递号" style="width:100px">
                            	<div class="ui_table_thcntr">
                                	<div class="ui_table_thtext">快递号</div>
                                </div>
                            </th>
							<th title="快递状态" style="width:115px">
                            	<div class="ui_table_thcntr ">
                                	<div class="ui_table_thtext">快递状态</div>
                                </div>
                            </th>
                            <th title="快递公司">
                            	<div class="ui_table_thcntr ">
                                	<div class="ui_table_thtext">快递公司</div>
                                </div>
                            </th>         					
                           <th title="收件人" >
                            	<div class="ui_table_thcntr">
                                	<div class="ui_table_thtext">收件人</div>
                                </div>
                            </th>
                           <th title="发件时间" style="width:100px;">
                            	<div class="ui_table_thcntr">
                                	<div class="ui_table_thtext">发件时间</div>
                                </div>
                            </th>                                   
                            <th title="收件人" style="width:80px;">
                            	<div class="ui_table_thcntr">
                                	<div class="ui_table_thtext">收件人</div>
                                </div>
                            </th>
                            <th title="发件人联系方式" style="width:120px;">
                            	<div class="ui_table_thcntr">
                                	<div class="ui_table_thtext">发件人联系方式</div>
                                </div>
                            </th>                                    
                            <th style="width:100px;">
                            	<div class="ui_table_thcntr">
                                	<div class="ui_table_thtext">操作</div>
                                </div>
                            </th>
                       </tr>
                   </thead>
                   <tbody id="pageListContent" class="ui_table_bd">
                       <tr class="">
                            <td><div class="ui_table_tdcntr">1</div></td>                    
                            <td><div class="ui_table_tdcntr">USBDL12332S23</div></td>
                            <td><div class="ui_table_tdcntr">已发送</div></td>
                             <td><div class="ui_table_tdcntr">申通</div></td>
                            <td><div class="ui_table_tdcntr">斯蒂芬</div></td>
                            <td><div class="ui_table_tdcntr">2011-03-03 12:12:12</div></td>
                            <td><div class="ui_table_tdcntr">浙江盘石</div></td>
                            <td><div class="ui_table_tdcntr">15965425425</div></td>
                            <td>
                                <div class="ui_table_tdcntr">                                            
                                    <ul class="list_table_operation">
										<li><a onclick="InvoiceConfirm()" href="javascript:;">票据明细确认</a></li>
                                    </ul>                                            
                                </div>
                            </td>
                        </tr>                                                       
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
<script type="text/javascript" src="{$JS}pageCommon.js"></script>  
{literal} 
<script language="javascript" type="text/javascript">
 $(function(){   
   	{/literal}
	pageList.strUrl = "{$InvoicePostManagerBody}"; 
	{literal}
    
	pageList.param = '&'+$("#tableFilterForm").serialize();   
   	pageList.init();
 });
 
 function InvoiceConfirm()
 {
    
 }
</script>
{/literal} 