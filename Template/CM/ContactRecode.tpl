<div class="DContInner newLXXiaoJiCont">
    <form class="newLXXiaoJiForm" name="newLXXiaoJiForm" action="" id="J_newLXXiaoJi">
            <div class="bd">
            <div class="tf">
                    <label><em class="require">*</em>联系人：</label>
                <div class="inp">
                    <input type="text" tabindex="1" maxlength="18" valid="required customerName" name="contactName" id="contactName" class="contactName" value="{$contact_name}">
                    <input type="hidden" name="customer_id" id="customer_id" value="{$customer_id}">
                </div>
                <span class="info">请正确输入联系人姓名</span>
                <span class="ok">&nbsp;</span><span class="err">请正确输入联系人姓名</span>
            </div>
            <div class="tf">
                    <label><em class="require">*</em>手机号：</label>
                <div class="inp"><input type="text" valid="mPhone" name="mPhone" class="mPhone" value="{$contact_mobile}"></div>
                <span style="display: inline;" class="info">手机号或固定电话必须输入一项</span>
                                            <span class="ok">&nbsp;</span><span class="err">请输入正确手机号</span>
            </div>
            <div class="tf">
                    <label>固定电话：</label>
                <div class="inp"><input type="text" valid="fPhone" name="fPhone" class="fPhone" value="{$contact_tel}"></div>
                <span style="display: none;" class="info">固话格式:0571-8888888</span>
                                            <span style="display: none;" class="err">请输入正确固定电话号</span>
            </div>                                               
            <div class="tf">
                    <label><em class="require">*</em>意向评级：</label>
                <div class="inp">
                    <select name="intentionRating" tabindex="8">                                
                        <option value="0" selected="selected">A</option>
                        <option value="1">B</option>
                        <option value="2">C</option>
                        <option value="3">D</option>
                        <option value="4">E</option>
                    </select>
                </div>
            </div>
            <div class="tf">
                    <label><em class="require">*</em>联系时间：</label>{literal}
                <div class="inp"><input type="text" valid="required" class="inpDate" name="contactTime"{/literal} value="{$contactTime}" {literal}onfocus="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'})"></div>{/literal}
                <span class="info">请输入时间</span>
                <span class="ok">&nbsp;</span><span class="err">请输入时间</span>
            </div>
            <div class="tf">
                    <label><em class="require">*</em>联系记录：</label>
                <div class="inp"><textarea name="contactRecord" cols="40" valid="required businessPosition"></textarea></div>
                <span class="info">限制150字以内</span>
                <span class="ok">&nbsp;</span><span class="err">限制150字以内</span>
            </div>                        
        </div>
        <div class="ft">
            <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>
            <div class="ui_button ui_button_confirm"><button tabindex="7" class="ui_button_inner" type="submit" >确定</button></div> 
        </div>
    </form>
</div>
<script language="javascript" type="text/javascript">
   {literal}
      var _InDealWith = false;
      
      
      
       var customer_id = $("#customer_id").val();
       
       
       $('#contactName').autocomplete('/?d=CM&c=CMInfo&a=getContactName_ID&customer_id='+customer_id, {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                        max: 5, //只显示5行
                        width: 160, //下拉列表的宽
                        parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
                            var parsed = [];
                            if(backData == "" || backData.length == 0)
                                return parsed;                                
                            backData = MM.json(backData);
                            var value = backData.value;
                            if(value == undefined)
                                 return parsed;
                            for (var i = 0; i < value.length; i++) {
                                parsed[parsed.length] = {
                                    data: value[i],
                                    value: value[i].id,
                                    result: value[i].name
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return '<div>' + item.id +"("+item.name +")"+ '</div>';
                        }
                    }).result(function (data,value) {//执行模糊匹配
                        var eID = value.id;
                            IM.dialog.show({
                                width:600,
                                height:null,
                                title:'添加联系小记',
                                html:IM.STATIC.LOADING,
                                start:function(){
                                    $('.DCont').html($PostData("/?d=CM&c=CMInfo&a=showAddContactRecode&contact_id="+eID+"&customer_id="+customer_id));
                                }
                             })
//                       JumpPage("/?d=CM&c=CMInfo&a=showAddContactRecode&contact_id="+eID);//导入客户到自己账户下，非添加或修改
        		    });
                    
         
        
        new Reg.vf($('#J_newLXXiaoJi'),{callback:function(data){
            if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
                   _InDealWith = true;    
                    $.ajax({
        			type:'POST',
        			data:$('#J_newLXXiaoJi').serialize(),
        			url:'/?d=CM&c=CMInfo&a=getContactInfoNews',
        			success:function(data)
        			{
        			    if(data==1)
                                    {
                                        IM.tip.show('添加成功');
                                        JumpPage('/?c=CMInfo&d=CM&a=showDetailFront&customer_id='+customer_id);
                                        IM.dialog.hide();    
                                    }
                                    else
                                    {
                                        IM.tip.warn(data);   
                                    }
                                }
        		});
            
            }})
    {/literal}
</script>