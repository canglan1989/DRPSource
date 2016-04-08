<?php
/**
 * @functional JSON格式操作类
 * @author     wangkai
 * @copyright  盘石
 */
require_once __DIR__ . '/../../Class/BLL/CommonBLL.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/IndustryBLL.php';
require_once __DIR__ . '/../../Class/BLL/ConstDataBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerAgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaBLL.php';
require_once __DIR__ . '/../Common/Alert.php';
require_once __DIR__ . '/../../Class/BLL/DepartmentBLL.php';

class CommonAction extends ActionBase
{
    private $commonBLL = '';
    //将日期类型数据进行转化格式，如果为0000-00-00，则显示空
    static public function GetDate($date)
    {
        if ($date == "0000-00-00") {
            $date = "";
        } else {
            $date = date("Y-m-j", strtotime($date));
        }
        return $date;
    }
    //新增时获取客户编号
    static public function GetCustomerNo($iAreaId)
    {
        //获取最大客户编号+1
        $customerBLL = new CustomerBLL();
        $arryInfo = $customerBLL->getMaxCustomerNo($iAreaId);
        if (isset($arryInfo) && count($arryInfo) == 1) {
            $maxCustomerNo = $arryInfo[0]["maxCustomerNo"];
        } else {
            $maxCustomerNo = "00000001";
        }
        return "concat('{$iAreaId}',LPAD('{$maxCustomerNo}',8,'0'))";
    }

    //判断该代理商下是否已存在该客户
    static public function IsExistCustomerInAgent($customer_id, $agent_id)
    {
        $customerAgentBLL = new CustomerAgentBLL();
        $data = $customerAgentBLL->select("agent_customer_id", "`customer_id` = {$customer_id} and `agent_id`={$agent_id}",
            "customer_id");
        if (count($data) != 0) {
            return true;
        } else {
            return false;
        }
    }
    //判断是否已经存在该客户名称
    static public function IsExistCustomerName($customerName)
    {
        $customerBLL = new CustomerBLL();
        $data = $customerBLL->selectOnlyCustomer("customer_id", "`customer_name` = '" .
            $customerName . "'", "customer_id");
        if (count($data) != 0) {
            return true;
        } else {
            return false;
        }
    }
    //用户修改时用 除该客户ID外是否有其他相同的客户名
    static public function IsExistCustomerNameExceptTheID($customerName, $customerID)
    {
        $customerBLL = new CustomerBLL();
        $data = $customerBLL->selectOnlyCustomer("cm.customer_id",
            "cm.`customer_name` = '" . $customerName . "' and cm.customer_id <> " . $customerID,
            "customer_id");
        if (count($data) != 0) {
            return true;
        } else {
            return false;
        }
    }
    public function BindConstData()
    {
        $constTypeName = trim($_POST['constTypeName']);
        $dataBLL = new ConstDataBLL();
        $const = $dataBLL->select("`c_value` as `value`,`c_name` as `innerHTML`",
            "`data_type` = '" . $constTypeName . "'", "`sort_index`");
        die(json_encode($const));
    }
    public function ProvinceGet()
    {
        $commonBLL = new CommonBLL();
        $province = $commonBLL->ProvinceGet();
        die(json_encode($province));
    }
    public function CityGet()
    {
        $province = trim($_POST['provinceCode']);
        $commonBLL = new CommonBLL();
        $city = $commonBLL->CityGet($province);
        die(json_encode($city));
    }
    public function AreaGet()
    {
        $city = trim($_POST['cityCode']);
        $commonBLL = new CommonBLL();
        $area = $commonBLL->AreaGet($city);
        die(json_encode($area));
    }
    public function IndustryFirstLevelGet()
    {
        $industryBLL = new IndustryBLL();
        $industry = $industryBLL->select("`industry_id` as `value`,`industry_name` as `innerHTML`",
            "`industry_pid` = 0", "`sort_index`");
        die(json_encode($industry));
    }

    public function IndustrySecondLevelGet()
    {
        $firstLevelCode = trim($_POST['firstLevelCode']);
        $industryBLL = new IndustryBLL();
        $industry = $industryBLL->select("`industry_id` as `value`,`industry_name` as `innerHTML`",
            "`industry_pid` = " . $firstLevelCode, "`sort_index`");
        die(json_encode($industry));
    }
    public function GetFullAreaName()
    {
        $areaID = trim($_POST['areaID']);
        $areaBLL = new AreaBLL();
        $arrArea = $areaBLL->select("`area_fullname`", "`area_id` = " . $areaID,
            "`sort_index`");
        if (isset($arrArea) && count($arrArea) == 1) {
            die($arrArea[0]["area_fullname"]);
        } else {
            die("0");
        }
    }
    public function GetFullIndustryName()
    {
        $industryID = trim($_POST['industryID']);
        $industryBLL = new IndustryBLL();
        $arrIndustry = $industryBLL->select("`industry_fullname`", "`industry_id` = " .
            $industryID, "`sort_index`");
        if (isset($arrIndustry) && count($arrIndustry) == 1) {
            die($arrIndustry[0]["industry_fullname"]);
        } else {
            die("0");
        }
    }
    /**
     * 取得公司和部门数据 在客户端 分拆
     */
    public function GetDepartment()
    {
        $objCompany = new DepartmentBLL();
        $arrayCompany = $objCompany->select(T_Department::dept_id . "," . T_Department::
            dept_no . "," . T_Department::dept_name . "," . T_Department::dept_type . "," .
            T_Department::data_type, "", "dept_no");
        exit(json_encode($arrayCompany));
    }
}
