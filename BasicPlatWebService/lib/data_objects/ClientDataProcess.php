<?PHP
require_once __DIR__ .'/DataMenu.php';
require_once __DIR__ . "/../../../Class/BLL/CustomerBLL.php";
//require_once __DIR__ .'/Model_pub_customer.php';
header("Content-type: text/html; charset=utf-8");
if(!defined("SYS_CONFIG"))
{
    //读取配置文件
    $arrSysConfig = require_once __DIR__ . '/../../../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}
class ClientDataProcess
{
    

    /**
     * 客户端接受分发的消息进行数据处理方法——此方法需要客户端业务系统自行定义
     * @param string $from 消息来源枚举
     * @param string $op 操作类型枚举
     * @param string $dt 数据表类型枚举
     * @param $obj 数据对象, 根据对应的数据表，可以直接强制转换相应的类对象
     * @return int
     */
    
                
    public function DataProcess($from, $op, $dt, $paramobj){
        $reV = 0;
        switch ($dt) {
            case DataTable::PUB_CUSTOMER:
                $objCustomerBLL  = new CustomerBLL();
                $objCustomerInfo = new CustomerInfo();
                      
                if($op == OpType::ADD){
                    if(!isset($paramobj->cname) || $paramobj->cname == "")
                    {
                        //$reV = "客户名不能为空";
                        $reV = -2;
                        break;
                    }
                        
                    $arr_name = $objCustomerBLL->NameIsNoneBackAdd($paramobj->cname);
                    if(count($arr_name) > 0)
                    {
                        //$reV = "客户名已存在，请重新输入";
                        $reV = -3;
                        break; 
                    }
                    $objCustomerInfo->strCustomerName = $paramobj->cname;
                    
                    $newobjCustomerInfo = $this->GetCustomerObj($paramobj,$objCustomerInfo);
                    //$newobjCustomerInfo->strCreateTime = date('Y-m-d H:i:s',time());
                    
                    //var_dump($newobjCustomerInfo);
                    $reV = $objCustomerBLL->Insert($newobjCustomerInfo);
                }else if($op == OpType::MOD){
                    if($paramobj->cid <= 0)
                    {
                        //$rev = "客户ID不能为空";
                        $reV = -4;
                    }
                    else
                    {
                        $objCustomerInfo = $objCustomerBLL->getModelByPubID($paramobj->cid);
                        if($objCustomerInfo == null)
                            $reV = -5;//公共ID不存在
                        else
                        {
                            $newobjCustomerInfo = $this->GetCustomerObj($paramobj,$objCustomerInfo);
                         
                            $newobjCustomerInfo->strUpdateTime = $paramobj->updatetime;
                            $reV = $objCustomerBLL->updateByPubID($newobjCustomerInfo);
                        }
                        
                        //$reV = $objCustomerInfo->iCustomerId;
                        
                    }
                    
                }else if($op == OpType::DEL){
                    if($paramobj->cid <= 0)
                    {
                        //$reV = "客户ID不能为空"; 
                        $reV = -4;
                    }
                    $reV = $objCustomerBLL->deleteByID($paramobj->cid,"-10");//返回值？
                    //cid公共ID与drp里面的id是不是一样的？//客户端客户数据删除方法
                }

                break;

            //case ... other table
            default:
                break;
        }
        settype($reV, "integer");
        return $reV;
    }
    public function GetCustomerObj($paramobj,$objCustomerInfo)
    {
        
        $objCustomerInfo->iPubId = $paramobj->cid;
        $objCustomerInfo->strPostcode = $paramobj->postcode;
        $objCustomerInfo->strCustomerName = $paramobj->cname;
        $objCustomerInfo->iAreaId = $paramobj->area_id;
        $objCustomerInfo->iIndustryId = $paramobj->indus_id;//
        $objCustomerInfo->strBusinessModel = $paramobj->business_mode;
        $objCustomerInfo->strMainBusiness = $paramobj->main_business;
        $objCustomerInfo->strMajorMarkets = $paramobj->major_markets;
        
        $objCustomerInfo->strEmail = $paramobj->email;
        $objCustomerInfo->strMobile = $paramobj->mobile;
        $objCustomerInfo->strPhone = $paramobj->tel;
        $objCustomerInfo->strPostcode = $paramobj->postcode;
        $objCustomerInfo->strCompanyScope = $paramobj->person_num;
        $objCustomerInfo->strBusinessScope = $paramobj->business_scope;
        $objCustomerInfo->strAnnualSales = $paramobj->annual_sales;
        $objCustomerInfo->strRegStatus = $paramobj->reg_status;
        
        $objCustomerInfo->strRegCapital = $paramobj->reg_capital;
        $objCustomerInfo->strRegPlace = $paramobj->reg_address;// rep_address;
        $objCustomerInfo->strRegDate = $paramobj->reg_date;
        $objCustomerInfo->strLegalPersonName = $paramobj->legal_person;//legal_person_name;
        
        $objCustomerInfo->strBusinessLicense = $paramobj->business_license;
        $objCustomerInfo->iCustomerResource = $paramobj->centers;//所属中心
        
        return $objCustomerInfo;
    }

}
//$opmessage = '{"from":"erp","op":"mod","table":"pub_customer","param":{"cid":"2188099","cname":"aa","postcode":"344016"}}';

/*$opmessage = '{"from":"erp","op":"mod","table":"pub_customer","param":{"cid":4104,"cname":"测试234","area_id":-999,"indus_id":-999,"siteurl":"","address":"","postcode":"","business_mode":"","main_business":"","business_scope":"","major_markets":"","person_num":-999,"annual_sales":-999,"reg_status":-999,"reg_capital":-999,"reg_date":"0001-1-1 0:00:00","reg_address":"","legal_person":"","business_license":"","major_contact":"","email":"","tel":"","mobile":"","qq":"","msn":"","centers":-999,"del_flag":-999,"updatetime":"0001-1-1 0:00:00","addtime":"0001-1-1 0:00:00"}}';
$msg = json_decode($opmessage);
        $pform = $msg->from;
        $otype = $msg->op;
        $dtable = $msg->table;
        $paramobj = isset($msg->param) ? $msg->param : NULL;
//var_dump($paramobj);
$obj = new ClientDataProcess();
echo($obj->DataProcess("erp", $otype, "pub_customer", $paramobj));*/
?>