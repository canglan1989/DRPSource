<?php

/**
 * Description of index
 *
 * @author 许亮
 */
header("Content-type: text/html; charset=utf-8");
require __DIR__ . '/../Common/Session.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
if (!defined("SYS_CONFIG"))
{
    //读取配置文件
    $arrSysConfig = require_once __DIR__ . '/../../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}

$objSession = new Session($arrSysConfig['SESSION']['RAW_SESSION_NAME']);
if ($objSession->get($arrSysConfig['SESSION_INFO']['USER_ID']) === false)
{
    $objSession->set($arrSysConfig['SESSION_INFO']['USER_ID'], $arrSysConfig['GUEST_UID']);
}

echo ("<script type='text/javascript'>location.href='/?d=Map&a=showList';</script>");
?>