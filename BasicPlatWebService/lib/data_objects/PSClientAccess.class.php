<?php
require_once 'lib/data_objects/ClientDataProcess.php';

/**
 * PHP WebService for PSClientAccesFace
 * PHP >= 5.2
 */
class PSClientAccess{
    /**
     * WebService接口解析方法
     * @param string $opmessage 
     * @return string
     */
    public function PSClientAccesFace($opmessage){
        $msg = json_decode($opmessage);
        $pform = $msg->from;
        $otype = $msg->op;
        $dtable = $msg->table;
        $paramobj = isset($msg->param) ? $msg->param : NULL;
        $process=new ClientDataProcess();
        return $process->DataProcess($pform, $otype, $dtable, $paramobj);
    }
    

}
?>