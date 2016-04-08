<?php
/**
 * PHP WebService 测试客户端
 * 1. config.php中添加操作类和实体类
 * 2. 操作类和实体类以 <类名.class.php> 存储在 lib/data_objects 目录下
 * 3. 调用url：http://<domain>/<path>/<to>/service.php?class=<类名>&wsdl
 */

try {
    $client = new SoapClient("http://10.0.101.4:8080/BasicPlatWebService/service.php?class=PSClientAccess&wsdl");
    //$client = new SoapClient("http://localhost:8080/BasicPlatWebService/service.php?class=PSClientAccess&wsdl");
    
    $client->soap_defencoding = 'utf-8';
    $client->decode_utf8 = false;
    $client->xml_encoding = 'utf-8'; 
        
    echo $client->PSClientAccesFace('{"from":"erp","op":"add","table":"pub_customer_tmp","param":{"cid":"0","cname":"3x","postcode":"344016"}}');
} catch (Exception $fault){
    echo $fault;//"Error: ",$fault->faultcode,", string: ",$fault->faultstring;
}
?>