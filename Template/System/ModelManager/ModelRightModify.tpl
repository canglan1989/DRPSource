<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S table_filter-->
<div class="table_filter marginBottom10">
    <div id="J_table_filter_main" class="table_filter_main"> 
        <div class="table_filter_main_row">
        模块名：<a href="javascript:;" onclick="JumpPage('/?d=System&c=ModelRight&a=ModelRightList&mid={$modelID}',true,true)">{$objModelInfo->strModelName}</a>
        </div>
    </div>
</div>
<!--E table_filter-->
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
    <form action="" method="post" name="form1" id="form1">  
      <div class="tf" style="padding-top:20px;">
        <label><em class="require">*</em>权限值：</label>
        <div class="inp">
          <select name="cbRightValue" id="cbRightValue" style="width:160px">
            {foreach from=$arrayRight item=data key=index}
            <option value="{$data}" {if $objModelRight->iRightValue == $data }selected="selected"{/if}>{$data}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="tf">
        <label><em class="require">*</em>权限名：</label>
        <div class="inp"><input name="tbxRightName" type="text" id="tbxRightName" size="30" style="width:160px;" maxlength="30"  value="{$objModelRight->strRightName}"   valid="required isNull" /></div>
        <span class="info">请输入实际意义的权限名称</span>
        <span class="ok">&nbsp;</span><span class="err">请输入实际意义的权限名称</span>
      </div>
      <div class="tf">
        <label>关闭此权限：</label>
        <input name="chkIsLock" class="checkInp" id="chkIsLock" type="checkbox" value="1" {if $objModelRight->iIsLock == 1} checked='checked' {/if} /> </div>
      <div class="tf">
        <label>权限描述：</label>
        <div class="inp">
          <textarea name="tbxRemark" cols="50" id="tbxRemark">{$objModelRight->strRightRemark}</textarea>
        </div>
      </div>
        <div class="tf tf_submit">
        <label>&nbsp;</label>
        <div class="inp">
            <div class="ui_button ui_button_confirm">
                <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
            </div>
            <div class="ui_button ui_button_cancel">
                <a class="ui_button_inner" onclick="JumpPage('/?d=System&c=ModelRight&a=ModelRightList&mid={$modelID}')" href="javascript:;">返 回</a>
            </div>
        </div>
      </div>
      </div>
    </form>
</div>
  {literal} 
  <script language="javascript" type="text/javascript">
    function v_isNull(e){return $.trim(e)!='';}                                       
    new Reg.vf($('#form1'),{extValid:{isNull:v_isNull},callback:function(data){
    //数据已提交，正在处理标识
    var _InDealWith = false;
        if (_InDealWith) 
        {
            IM.tip.show("数据已提交，正在处理中！"); 
            return false;
        }
        {/literal} 
        var mid = {$modelID};
        //提交数据
        var formValues = "id={$id}&mid=" + mid+"&"+$('#form1').serialize();
        {literal} 
        _InDealWith = true;
        var data = $PostData("/?d=System&c=ModelRight&a=ModelRightModifySubmit&mid="+mid,formValues);
        
        if(parseInt(data) != 0)
        {
            IM.tip.warn(data); 
            _InDealWith = false;
        }
        else
            JumpPage("/?d=System&c=ModelRight&a=ModelRightList&mid=" + mid);            
    }});
    </script> 
  {/literal}