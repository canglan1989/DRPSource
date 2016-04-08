<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：订单管理<span>&gt;</span>
    <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=MyOrderList')">增值产品订单库</a><span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<div class="form_edit">    	
    <div class="form_hd">
        <div class="form_hd_left">
            <div class="form_hd_right">
                <div class="form_hd_mid">
                    <h2>客户信息导入</h2>
                </div>
            </div>
        </div>
        <span class="declare">
            “<em class="require">*</em>”为必填信息
        </span>
    </div>
    <div class="form_bd">
        <form id="J_addOrder" action="" name="newOrderModifyForm" class="newOrderModifyForm">
            <div class="tf" style="padding-top:20px;">
                <label><em class="require">*</em>客户导入：</label>
                <div>
                    <input type="file"  name="upload_excel" />
                    <a href="#" >Excel模板下载</a>
                </div> 
            </div>
            <div class="tf tf_submit" style="padding:20px 0;">
                <label>&nbsp;</label>
                <div class="inp">
                    <div class="ui_button ui_button_confirm"> <button id="btnSave" type="submit" class="ui_button_inner">导 入</button></div>
                    <div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a></div>
                </div>
            </div>
        </form>                             
    </div> 
</div>
<!--E sidenav_neighbour--> 


