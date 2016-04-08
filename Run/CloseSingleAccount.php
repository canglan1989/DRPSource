<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once __DIR__ . '/../Class/BLL/TMSingleLoginBLL.php';
require_once __DIR__ . '/../Action/Common/Utility.php';

class CloseSingleAccount {

    function __construct() {
        if (!defined("SYS_CONFIG")) {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }
    }

    function CloseSingle() {
        $objTMSingleLoginBLL = new TMSingleLoginBLL();
        $objTMSingleLoginBLL->CloseAccount(Utility::Now());
    }

}

$objCloseSingleAccount = new CloseSingleAccount();
$objCloseSingleAccount->CloseSingle();

?>
