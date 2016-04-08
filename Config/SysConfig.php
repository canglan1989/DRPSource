<?php
return array('TEMPLATE' => array('TEMPLATE_DIR' => __DIR__ . '/../Template/', 'COMPILE_DIR' => __DIR__ . '/../Template/Template_Compile/'),
        'WAPTEMPLATE' => array('TEMPLATE_DIR' => __DIR__ . '/../Template_Wap/', 'COMPILE_DIR' => __DIR__ . '/../Template_Wap/Template_Compile/'),
    'SESSION' => array('RAW_SESSION_NAME' => 'PHPSESSID', 'NEW_SESSION_NAME' => 'drpweb'),
    'SESSION_INFO' => array('USER_ID' => 'userId', 'USER_NO' => 'userNo', 'USER_NAME' => 'userName',
    'AGENT_ID' => 'agentID','AGENT_NO' => 'agentNo','AGENT_NAME' => 'agentName',
    'E_ID' => 'employeeID', 'E_NAME' => 'employeeName','DEPT_ID' => 'deptID','USER_RIGHT' => 'userRight',
    'IS_FINANACE' => 'is_finance','FINANCE_UID' => 'finance_uid','FINANCE_NO' => 'finance_no'),
    'SECURE' => array('SUFFIX' => '$%^&*!#渠道业务系统#@!', //参数验证，干扰码
	'PREFIX' => '_' //参数连接符
    ),
    'MemThreshold' => 20, //内存使用阀值
    'ConfigTmpID' => 20110510, //参数配置ID,可以任意修改为其他数字
    'DEF_PAGE_SIZE' => 15,//默认每页行数
    'CHUNK_FILE_SIZE' => array('TOTAL_SIZE' => 5242880, 'MAX_SIZE' => 4194304),  //文件总容量:5M,块文件最大容量:4M
    'DEF_PWD'=>'888888',//前台账户默认密码
    'Direct_Income'=>0,//打款后直接充值 0否 1是
    'MEMCACHED' => array(array('127.0.0.1' => '11211')), //192.168.21.29 数据缓存服务器
    'RESOURCE_PATH' => array('CSS_PATH' => '/FrontFile/CSS/',
    'UPLOAD_PATH' => '/FrontFile/upload/',
	'IMAGE_PATH' => '/FrontFile/img/',
	'JS_PATH' => '/FrontFile/JS/'),
    'MEMKEYS' => array(//缓存key
	'SEND' => array('USER_SIGNATURE', 'USE_SYS_SIGNATURE', 'REQUEST_NOTIFY', 'SAVE_TO_HAS_SEND', 'SKIN'),
	'READ' => array('MAIL_PAGE_VIEW', 'AUTO_NOTIFY')
    ),
    'UPFILE_PATH' => array('CUSTOMER_PERMIT'=>'FrontFile/upload/customerPermit/', //上传文件路径
                            'BILL_ATTACHMENT'=>'FrontFile/upload/bill_attachment/',
                            'FM_REPRINT'=>'FrontFile/upload/fm_reprint/'
                            ),
    'DBCONFIG0' => array('CLASS' => 'MySqlHelp',	'DBHOST' => '192.168.32.215', 'DBPORT' => '3306',
	'DBUSER' => 'root','DBPWD' => '8812345',	'DBNAME' => 'psdrp3','DBCHARSET' => 'utf8'
    ),
    'DBCONFIG1' => array('CLASS' => 'MySqlHelp',	'DBHOST' => '192.168.32.215', 'DBPORT' => '3306',
	'DBUSER' => 'root','DBPWD' => '8812345',	'DBNAME' => 'psdrp3','DBCHARSET' => 'utf8'
    ),
    'DBCONFIG2' => array('CLASS' => 'MySqlHelp',	'DBHOST' => '192.168.20.35', 'DBPORT' => '3306',
	'DBUSER' => 'pscrm','DBPWD' => 'Pscrm@2011_2012',	'DBNAME' => 'psdrp','DBCHARSET' => 'utf8'
    ),
    "TM_Website_Preview"=>"v5.epanshi.com",//PSHO4640(徐旭东) 2012.05.07 10:53:09 目前drp就只有v5  如果以后来的v6,v7还是走drp  那到时候肯定得加字段区分   如果以后不走drp  那就不用管了  所以这个目前不确定  暂时只有一个v5
    "ServerDomain0"=>array("/^localhost/i"),//ERP Web站点域名 对跨域名操作的限制，空表示不限制，多个域名用逗号做分隔。array("/^localhost/i","/^drp.dpanshi.com/i")
    "ServerDomain1"=>array(""),
    "ServerDomain2"=>array("/^drp.dpanshi.com/i"),
    'SoapLocation0'=>array(//接口地址 开发
        'WYMH'=>'http://m2.epanshi.com/ws/wsfordrp.wsdl',//网营门户
        'WYMHLogin'=>'http://buildtest.epanshi.com:8080',//网营门户伪登录
        'SSO'=>'http://192.168.62.14/SSOSoapMetaService/WSDL/sso.wsdl',//单点
        'Email'=>'http://192.168.92.29/SoapAction/SoapServer.php',//邮箱
        'WM_AddUser'=>"http://192.168.62.14/SSOSoapMetaService/WSDL/index.php?wsdl"//网盟添加用户后通知单点
    ),
    'SoapLocation1'=>array(//接口地址 测试
        'WYMH'=>'http://m2.epanshi.com/ws/wsfordrp.wsdl',//网营门户
        'WYMHLogin'=>'http://buildtest.epanshi.com:8080',//网营门户伪登录
        'SSO'=>'http://192.168.62.14/SSOSoapMetaService/WSDL/sso.wsdl',//单点
        'Email'=>'http://192.168.92.29/SoapAction/SoapServer.php',//邮箱
        'WM_AddUser'=>"http://192.168.62.14/SSOSoapMetaService/WSDL/index.php?wsdl"//网盟添加用户后通知单点
    ),
    'SoapLocation2'=>array(//接口地址 正式
        'WYMH'=>'http://m3.epanshi.com/ws/wsfordrp.wsdl',//网营门户 
        'WYMHLogin'=>'http://b5.epanshi.com',//网营门户伪登录 
        'SSO'=>'http://sso.adpanshi.com/SSOSoapMetaService/WSDL/sso.wsdl',//单点 http://sso.adpanshi.com/SSOSoapMetaService/WSDL/sso.wsdl 
        'Email'=>'http://mail.adpanshi.com/SoapAction/SoapServer.php',//邮箱
        'WM_AddUser'=>"http://sso.adpanshi.com/SSOSoapMetaService/WSDL/index.php?wsdl"//网盟添加用户后通知单点
    ),
    'GUEST_UID'=>9999999999,//临时的用户ID，用于提供给公司DRP网站的代理商注册
    "ERP0" => array("Finance_WebService"=>"http://192.168.224.19:8090/DRP/ToFinance_Money_Invoice.asmx?wsdl",//调用ERP的 WebService 路径
                    "Permission_IP" => array("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/","/^127.0.0.1$/") //可允许调用 DRP 财务相关 WebService 的 IP 这里用正则表达式 /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/
                    ),
    "ERP1" => array("Finance_WebService"=>"http://192.168.224.19:8090/DRP/ToFinance_Money_Invoice.asmx?wsdl",//
                    "Permission_IP" => array("/^192.168.224.19$/","/^10.0.\d{1,3}\.\d{1,3}$/")),
    "ERP2" => array("Finance_WebService"=>"http://service.erp.adpanshi.com/drp/ToFinance_Money_Invoice.asmx?wsdl",
                    "Permission_IP" => array("/^192.168.20.50$/","/^122.224.234.175$/")),
    "Adhai0"=>array("UFO_WebService" => "http://t3.ufo.com/service/",//调用 Adhai 的 WebService 路径
            "Owner_Url" => "http://t3.owner.com",
            'DBCONFIG' => array('CLASS' => 'MySqlHelp','DBHOST' => '192.168.25.211','DBPORT' => '3306','DBUSER' => 'root','DBPWD' => '8812345','DBNAME' => 'adhai_local2','DBCHARSET' => 'utf8')
    ),
    "Adhai1"=>array("UFO_WebService" => "http://t3.ufo.com/service/","Owner_Url" => "http://t3.owner.com",
            'DBCONFIG' => array('CLASS' => 'MySqlHelp','DBHOST' => '192.168.32.215','DBPORT' => '3306','DBUSER' => 'root','DBPWD' => '8812345','DBNAME' => 'adhai_ufo','DBCHARSET' => 'utf8')
    ),
    "Adhai2"=>array("UFO_WebService" => "http://ufo.adyun.com/service/","Owner_Url" => "http://owner.adyun.com",
            'DBCONFIG' => array('CLASS' => 'MySqlHelp','DBHOST' => '192.168.20.35','DBPORT' => '3306','DBUSER' => 'pscrm','DBPWD' => 'Pscrm@2011_2012','DBNAME' => 'adhai_ufo','DBCHARSET' => 'utf8')
    ),
    "Adhai_Passport" => array("loginName"=>"ws_crm","loginPwd"=>"ws@crm"),
    "CRM0"=>array("Customer_WebService" => "http://crm.com:8080/WebService/PubCustomerInputSoap.php",
                    "User_WebService"=>"http://crm.com:8080/WebService/SysUserSoap.php"),
    "CRM1"=>array("Customer_WebService" => "http://192.168.32.215:2001/WebService/PubCustomerInputSoap.php",
                    "User_WebService"=>"http://192.168.32.215:2001/WebService/SysUserSoap.php"),
    "CRM2"=>array("Customer_WebService" => "http://crm.dpanshi.com/WebService/PubCustomerInputSoap.php",
                    "User_WebService"=>"http://crm.dpanshi.com/WebService/SysUserSoap.php"),
    "BasePlatform0"=>array("WebService"=>"http://192.168.95.59:8080/axis2/services/BasicPlatformService?wsdl"),//添加网盟账号调用接口地址
    "BasePlatform1"=>array("WebService"=>"http://192.168.95.59:8080/axis2/services/BasicPlatformService?wsdl"),
    "BasePlatform2"=>array("WebService"=>"http://bp.adyun.com:8080/axis2/services/BasicPlatformService?wsdl"),
    "SingleLogin0"=>array("Permission_IP" => array("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/","/^127.0.0.1$/") //可允许调用 DRP WebService 的 IP 这里用正则表达式 /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/
                    ,'WebService'=>'http://192.168.62.14/SSOSoapMetaService/WSDL/sso.wsdl'),
    "SingleLogin1"=>array("Permission_IP" => array("")),
    "SingleLogin2"=>array("Permission_IP" => array("")),
    "adyun0"=>array("UnitMarketQuestion_Service_Domain"=>"10.0.94.13:9092"),
    "adyun1"=>array("UnitMarketQuestion_Service_Domain"=>"10.0.94.13:9092"),
    "adyun2"=>array("UnitMarketQuestion_Service_Domain"=>"www.adyun.com"),//
    "verifyItem"=>array(1,3,5,7,9),
    'SYS_EVN'=>1//系统环境 0开发 1测试 2正式

);