<?php
require __DIR__ .'/ConnectClass.php';
require __DIR__ .'/DataMenu.php';

header("Content-type: text/html; charset=utf-8");
class CenterFace{
    /**
     * 公共平台数据同步接口方法
     * @param PlatForm $from 系统平台枚举
     * @param OpType $op 操作类型枚举
     * @param mixed $obj 操作的数据对象
     * 
     * @example
     * {"from":"erp","op":"add","table":"pub_customer","param":{"cid":0,"cname":"333333","postcode":"344016"}}
     */
    public static function ToCenterFace($from, $op, $obj){
        //构造报文
        $msg = array();
        $msg['from'] = $from;
        $msg['op'] = $op;
        $msg['table'] = str_replace("Model_","",get_class($obj));
        
        if($obj != NULL){
            $msg['param'] = is_object($obj) ? get_object_vars($obj) : $obj;
        }
        $msg_json = json_encode($msg);
        
        //发送socket消息
        return ConnectClass::SendCenterMessage($msg_json);
    }
}
?>