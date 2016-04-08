<?php
/**
 * 
 * 整个web的入口点
 * @author wangkai
 *
 */
require __DIR__ . '/Action/Common/JSON.php';
require __DIR__ . '/Action/Common/Utility.php';
require __DIR__ . '/Action/Common/Session.php';
//缓存操作类
require_once __DIR__ . '/Class/Common/DALCache.php';

class App
{
    function __construct()
    {
        date_default_timezone_set("Asia/Shanghai");
        $strDirectoryName = ucfirst(isset($_GET['d']) ? Utility::GetForm('d',$_GET) : 'Index');
        $strClassName = ucfirst(isset($_GET['c']) ? Utility::GetForm('c',$_GET) : 'Index') . 'Action';
        $strActionName = lcfirst(isset($_GET['a']) ? Utility::GetForm('a',$_GET) : 'index');

        try {
            if (file_exists(__DIR__ . '/Action/' . $strDirectoryName . '/' . $strClassName .
                '.php')) {
                require_once (__DIR__ . '/Action/' . $strDirectoryName . '/' . $strClassName .
                    '.php');
            } else {
                exit('Action Error!<a href="javascript:;" onclick="PageBack()">返回</a>');
            }
        }
        catch (exception $e) {
            echo $e->getMessage();
            exit('<a href="javascript:;" onclick="PageBack()">返回</a>');
        }

        if (!defined("SYS_CONFIG")) {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }

        if ($strDirectoryName != 'Login') {
            $bExit = false;
            //判断是否登录超时
            $objSession = new Session($arrSysConfig['SESSION']['RAW_SESSION_NAME']);
            if ($objSession->get($arrSysConfig['SESSION_INFO']['USER_ID']) === false) {
                $bExit = true;
            } else {
                $uid = $objSession->get($arrSysConfig['SESSION_INFO']['USER_ID']);
                if ($uid == "") {
                    $bExit = true;
                } else {
                    settype($uid, "integer");
                    if ($uid <= 0)
                        $bExit = true;
                }
            }

            if ($bExit) {
                session_regenerate_id(true);
                $strURL = Utility::curPageURL();

                if (strstr($strURL, "?") == false) //exit($strURL."+");//
                    exit ("<script type='text/javascript'>location.href='/?d=Login&a=LoginOut';</script>");
                else //exit($strURL."-"); //
                    exit ("<script type='text/javascript'>alert('\u767b\u5f55\u8d85\u65f6\uff0c\u8bf7\u91cd\u65b0\u767b\u5f55\uff01');location.href='/?d=Login&a=LoginOut';</script>");
                exit();
            }

        }

        $actionObj = new $strClassName();
        $actionObj->setSysConfig($arrSysConfig);
        $actionObj->setDirectoryName($strDirectoryName);
        $actionObj->setClassName($strClassName);
        $actionObj->setActionName($strActionName);
        $actionObj->init();

        if (method_exists($actionObj, $strActionName)) {
            $actionObj->$strActionName();
        } else {
            exit("Action error!  未找到响应地址！<a href=\"javascript:;\" onclick=\"PageBack()\">返回</a>");
        }
    }
}
$theApp = new App();
