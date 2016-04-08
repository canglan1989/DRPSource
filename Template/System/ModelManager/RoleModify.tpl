<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：系统管理<span>&gt;</span>
<a href="javascript:;" onclick="JumpPage('/?d=System&c=Role&a=RoleList')">角色管理</a><span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<div class="form_edit">    	
<div class="form_hd">
    <div class="form_hd_left">
        <div class="form_hd_right">
            <div class="form_hd_mid">
                <h2>{$strTitle}</h2>
            </div>
        </div>
    </div>
    <span class="declare">
    “<em class="require">*</em>”为必填信息
    </span>
</div>
	<div class="form_bd">
    	<form id="J_newRoles" action="" name="newRolesForm" class="newRolesForm">
        <div class="form_block_bd">
            <div class="tf" style="padding-top:5px;">
            	<label style=" width:100px"><em class="require">*</em>角色名称：</label>
                <div class="inp">
                {if $objRole->iIsSystem == 1} 
                 {$objRole->strRoleName}
                {else}
                <label style="width:185px"><input name="tbxRoleName" type="text" id="tbxRoleName" size="30" style="width:180px" maxlength="8"  valid="required rolesName" value="{$objRole->strRoleName}"  valid="required isNull"/></label>
                {if $canChangeFinanceCheck == 1}
                <label id="spanIsFinance"><input name="chkIsFinance" class="checkInp" type="checkbox" id="chkIsFinance" value="1" {if $objRole->iIsFinance == 1}checked="checked"{/if} />财务功能角色</label>
                {else}
                <label id="spanIsFinance" style="display:none"><input name="chkIsFinance" class="checkInp" type="checkbox" id="chkIsFinance" value="1" {if $objRole->iIsFinance == 1}checked="checked"{/if} /></label>
                {if $objRole->iIsFinance == 1}财务功能角色{/if}{/if}
                </div>
                <span class="info">请输入角色名</span>
                <span class="ok">&nbsp;</span><span class="err">请输入角色名</span>                        
                {/if}
            </div>   
            <div class="tf">
               <label style=" width:100px">备注：</label>
               {if $objRole->iIsSystem == 1} 
                 {$objRole->strRoleRemark}
               {else}
               <textarea name="tbxRemark" cols="50" style="width:500px;height:100px;" id="tbxRemark">{$objRole->strRoleRemark}</textarea>
               {/if}
            </div>                              
        </div>
        <!--  
        <div class="form_block_hd "  {if $objRole->iIsSystem == 1} style="display:none" {/if}>
            <h3 class="ui_title">权限设置</h3>
        </div>-->
        <div class="form_block_bd setAuth">                     
        <!--<div id="divRight" {if $objRole->iIsSystem == 1} style="display:none" {/if}></div>-->
     <div class="tf">
		<label style="width:119px;">&nbsp;</label>
                    {if $objRole->iIsSystem != 1}
                <div class="ui_button ui_button_confirm">
                    <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
                </div>
                {/if}
                <div class="ui_button ui_button_no ui_button_cancel"><a onclick="PageBack()" href="javascript:;" class="ui_button_inner">返回</a> </div>
                  
        </div>
        </div>
    </form>
    </div>
</div>
<!--E sidenav_neighbour--> 
{literal}
<script language="javascript" type="text/javascript">
$(function(){        
	function v_isNull(e){return $.trim(e)!='';}                                       
	new Reg.vf($('#J_newRoles'),{extValid:{isNull:v_isNull},callback:function(data){
	   
		var rights = "";
        var isFinance = 0;
        var chkIsFinance = $("#chkIsFinance");
        if(chkIsFinance != null)
        {
            if(chkIsFinance[0].checked == true)
                isFinance = 1;
        }
        
		{/literal}
		var pData = "id={$iRoleId}&tbxRoleName="+$("#tbxRoleName").val()+"&tbxRemark="+$("#tbxRemark").val()+"&isFinance="+isFinance;        
		{literal}
        
		$.ajax({
			type:'POST',
			data:pData,
			url:'/?d=System&c=Role&a=RoleModifySubmit',
			success:function(data){
				if(parseInt(data) == 0){
					JumpPage("/?d=System&c=Role&a=RoleList");
				}else{
					IM.tip.warn(data);
				}
			}
		});
    }});
});

</script>
{/literal}