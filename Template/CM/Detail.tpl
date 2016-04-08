<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;">客户管理</a><span>&gt;</span><a href="/?d=CM&c=CMInfo&a=showBackInfoList">客户资料管理</a><span>&gt;</span>客户信息查看</div>
<!--E crumbs-->     
<!--S form_edit-->                  
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>客户信息查看</h2></div></div></div>
        <span class="declare">"<em class="require">*</em>"为必填信息</span>
    </div>
    <div class="form_addition">
    	<div class="form_addition_inner">
        	<div class="ui_title">代理商类型为：</div>
        	<div class="ui_text">资料查看</div>
        </div>
    </div>
    <!--S form_bd-->
    <div class="form_bd">
    <form id="J_agentAddForm" action="" name="agentAddForm" class="agentAddForm" method="post" enctype="multipart/form-data"><input id="customer_id" name="customer_id" type="hidden" value="{$customer_id}"/>
    	<div class="form_block_hd"><h3 class="ui_title">企业信息</h3></div>
        <!--S form_block_bd--> 
        <div class="form_block_bd">
       		<div class="blockLeft">
        		<div class="tf" id="customer_name">
                	<label><em class="require">*</em>客户名：</label>
                    <div class="inp">{$customer_name}</div>
                </div>
                <div class="tf" id="area_id">
                	<label><em class="require">*</em>地区：</label>
                    <div class="inp">{$province_name}->{$city_name}->{$area_name}:{$address}</div>
                </div>
                <div class="tf" id="industry_id">
                	<label><em class="require">*</em>行业：</label>
                    <div class="inp">{$industry_fullname}</div>
                </div>
                <div class="tf" id="business_model">
                	<label><em class="require">*</em>经营模式：</label>
                    <div class="inp">{$business_model}</div>
                </div>
                <div class="tf" id="main_business">
                	<label>主营业务：</label>
                    <div class="inp">{$main_business}</div>
                </div>
                <div class="tf" id="major_markets">
                	<label>主要市场：</label>
                    <div class="inp">{$major_markets}</div>
                </div>
                <div class="tf" id="company_profile">
                	<label>公司简介：</label>
                    <div class="inp">{$company_profile}</div>
                </div>
                <div class="tf" id="company_scope">
                	<label>公司规模：</label>
                    <div class="inp">{$company_scope}</div>
                </div>                    
                <div class="tf" id="reg_status">
                	<label>注册状态：</label>
                    <div class="inp">{$reg_status}</div>
                </div>
			</div>
            <div class="blockRight">
                <div class="tf" id="reg_date">
                	<label>注册时间：</label>
                    <div class="inp">{$reg_date}</div>
                </div>
                <div class="tf" id="website">
                	<label>公司网址：</label>
                    <div class="inp">{$website}</div>
                </div>
                <div class="tf" id="reg_place">
                	<label>注册地址：</label>
                    <div class="inp">{$reg_place}</div>
                </div>
                <div class="tf" id="postcode">
                	<label>邮政编码：</label>
                    <div class="inp">{$postcode}</div>
                </div>
                <div class="tf" id="customer_from">
                	<label>客户来源：</label>
                    <div class="inp">{$customer_from}</div>
                </div>
                
                <div class="tf" id="net_extension_about">
                	<label>网络推广情况：</label>
                    <div class="inp">{$net_extension_about}</div>
                </div>
                <div class="tf" id="business_scope">
                	<label>经营范围：</label>
                    <div class="inp">{$business_scope}</div>
                </div>
                <div class="tf" id="annual_sales">
                	<label>年销售额：</label>
                    <div class="inp">{$annual_sales}元</div>
                </div>
                <div class="tf" id="reg_capital">
                	<label>注册资金：</label>
                    <div class="inp">{$reg_capital}元</div>
                </div>
            </div>
        </div>
        <!--E form_block_bd-->
        
        <!--S form_block_hd-->
        <div class="form_block_hd"><h3 class="ui_title">联系人信息</h3></div>
        <!--E form_block_hd--> 
        <!--S form_block_bd--> 
        <div class="form_block_bd">
        	<div class="blockLeft">
        		<div class="tf" id="contact_name">
                	<label><em class="require">*</em>姓名：</label>
                    <div class="inp">{$contact_name}</div>
                </div>
                <div class="tf" id="contact_sex">
                	<label>性别：</label>
                    <div class="inp">{$contact_sex_name}</div>
                </div>
                <div class="tf" id="contact_tel">
                	<label><em class="require">*</em>手机号：</label>
                    <div class="inp">{$contact_tel}</div>
                </div>
                <div class="tf" id="contact_mobile">
                	<label>固定电话：</label>
                    <div class="inp">{$contact_mobile}</div>
                </div>
                <div class="tf" id="contact_fax">
                	<label>传真号码：</label>
                    <div class="inp">{$contact_fax}</div>
                </div>
                <div class="tf" id="contact_email">
                	<label>电子邮箱：</label>
                    <div class="inp">{$contact_email}</div>
                </div>
            </div>
            <div class="blockRight">
                <div class="tf" id="contact_position">
                	<label>职位：</label>
                    <div class="inp">{$contact_position}</div>
                </div>
                <div class="tf" id="contact_importance">
                	<label>重要程度：</label>
                    <div class="inp">{$contact_importance}</div>
                </div>
                <div class="tf" id="contact_net_awareness">
                	<label>网络意识：</label>
                    <div class="inp">{$contact_net_awareness}</div>
                </div>                                                                        
                <div class="tf" id="contact_remark">
                	<label>备注：</label>
                    <div class="inp">{$contact_remark}</div>
                </div>   
            </div>                     
         </div>
        <!--E form_block_bd-->
        <div class="form_block_ft">
        	<div class="agentAuditBlock">
                <div class="tf">
                        <label>审核状态：</label>
                        <div class="inp">{$check_status_name}
                        </div>
                </div>
                <div class="tf">
                        <label>审核备注：</label>
                        <div class="inp">{$check_remark}</div>
                </div>
            </div>
            <div class="tf tf_submit">
				<label>&nbsp;</label>
				<div class="inp">
					<div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="JumpPage('{au d="CM" c="CMInfo" a="showBackInfoList"}')">返回</a></div>
				</div>
            </div>
        </div>   
        <!--E form_block_ft-->           
    </form>
    </div>
    <!--E form_bd--> 
</div>
<!--E form_edit-->  