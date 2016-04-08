<?php

/**
 * @fnuctional: 单元测试
 * @copyright:  盘石
 * @author:     xdd
 * @date:       2012-5-4 16:13:44
 */
if (!defined("SYS_CONFIG")) {
    //读取配置文件
    $arrSysConfig = require_once __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}

        require_once __DIR__ . '/../AddCusToBasicPlat/AddCusToBasicPlatAction.php';
        require_once __DIR__ . '/../Class/BLL/CustomerBLL.php';

class Test
{  
    public function AddCustomToPub()
    {
        set_time_limit(0);

        $objAddCusToBasicPlatAction = new AddCusToBasicPlatAction();
        $objCustomerBLL = new CustomerBLL();
        $arrayData = $objCustomerBLL->selectTop(' cm.customer_id ',' cm.pub_id<=0 ',"","",1000);
        //没有做1000条数据限制的时候会报错
        
        foreach( $arrayData as $cid )
        {
            $objCustomerInfo = $objCustomerBLL->getModelByID($cid['customer_id']);
            $objAddCusToBasicPlatAction->AddCusToBasicPlat($objCustomerInfo,'add',$cid['customer_id']);
            print_r($cid);
        }
        exit("成功");
    }
    
    
}

//测试代码
$test = new Test();
$test->AddCustomToPub();

?>