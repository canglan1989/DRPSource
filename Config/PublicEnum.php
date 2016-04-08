<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：系统公共枚举类型
 * 创建人：wzx
 * 添加时间：2011-8-9 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 

/**
 * 员工状态 0聘用,1实习,2见习,3外派,4停薪留职,5试用,6隐藏,-1离职中,-9已离职,-10=已辞退,-11 已流失
 */
class EmployeeStates
{
    /**
     * 0 聘用
    */
    const Employ = 0;
    /**
     * 1 实习
    */        
    const Practice = 1;
    /**
     * 2 见习
    */    
    const Trainee = 2;
    /**
     * 3 外派
    */    
    const Assignment = 3;
    /**
     * 4 停薪留职
    */    
    const Leave_without_pay = 4;
    /**
     * 5 试用
    */    
    const Try_work = 5;
    /**
     * 6 隐藏
    */    
    const Hide = 6;
    /**
     * -1 离职中
    */    
    const Left_in = -1;
    /**
     * -9 已离职
    */    
    const Have_left = -9;
    /**
     * -10 已辞退
    */    
    const Have_been_dismissed = -10;
    /**
     * -11 已流失
    */
    const Has_lost = -11;        
}

/**
 * 审核状态
*/
class CheckStatus
{
    /**
     * 未提交 -2
    */
    const notPost = -2;
    /**
     * 审核未通过 -1
    */
    const notPass = -1;
    /**
     * 审核中 0
    */
    const auditting = 0;
    /**
     * 审核通过 1
    */
    const isPass = 1; 
    
    /**
     * @functional 类型文字备注   
    */ 
    public static function GetText($value)
    {
        switch($value)
        {
            case CheckStatus::notPost:
                return "未提交";
            break;            
            case CheckStatus::notPass:
                return "未通过";
            break;            
            case CheckStatus::auditting:
                return "审核中";
            break;            
            case CheckStatus::isPass:
                return "通过";
            break;           
                    
        }
        return "未知";
    }
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }

}

/**
* 订单扣款状态
*/
class OrderMoneyStatus
{
    /**
     * 冻结 0
    */
    const Frozen = 0;
    /**
     * 扣款 1
    */
    const Charge = 1;
    
    /**
     * 部分退款
    */
    const ReturnPart = 11; 
    
    /**
     * 全部退款
    */
    const ReturnAll = 12;
    /**
     * @functional 类型文字备注   
    */ 
    public static function GetText($value)
    {
        switch($value)
        {
            case OrderMoneyStatus::Frozen:
                return "冻结";
            break;            
            case OrderMoneyStatus::Charge:
                return "扣款";
            break;            
            case OrderMoneyStatus::ReturnPart:
                return "部分退款";
            break;            
            case OrderMoneyStatus::ReturnAll:
                return "全部退款";
            break;           
                    
        }
        return "未知";
    }
    
    /**
     * @functional 用于多选
    */
    public static function ToMultiSelectJson()
    {
        return "[{'value':'冻结','key':'0'},{'value':'扣款','key':'1'},{'value':'部分退款','key':'11'},{'value':'全部退款','key':'12'}]";
    }      
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }
}

/**
 * 客户订单类型
*/
class CustomerOrderTypes
{
    /**
     * 退单 -1
    */
    const backOrder = -1;
    /**
     * 新签 1
    */
    const newOrder = 1;
    /**
     * 续签 2
    */
    const continueOrder = 2;
    /**
     *  赠品 3
    */
    const gift = 3;
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }

    /**
     * @functional 类型文字备注   
    */ 
    public static function GetText($value)
    {
        switch($value)
        {
            case CustomerOrderTypes::backOrder:
                return "退单";
            break;            
            case CustomerOrderTypes::newOrder:
                return "新签";
            break;            
            case CustomerOrderTypes::continueOrder:
                return "续签";
            break;            
            case CustomerOrderTypes::gift:
                return "赠品";
            break;           
                    
        }
        return "未知";
    }
}


/**
 * 订单状态
*/
class OrderStatus
{
    /**
     * 未提交 -2
    */
    const notPost = -2;
    /**
     * 审核未通过 -1
    */
    const notPass = -1;
    /**
     * 审核中 0
    */
    const auditting = 0;
    /**
     * 审核通过 1
    */
    const isPass = 1;     
    /**
     * 订单处理中 2 
    */
    const taskNotBegin = 2;
    /**
     * 订单处理中 3
    */
    const taskBegin = 3;    
    /**
     * 订单处理完毕 50
    */
    const taskEnd = 50; 
        
    /**
     * 已退单
    */
    const backed = 60;
    
    /**
     * 已续签
    */
    const haveContinueOrder = 70;
    /**
     * @functional 类型文字备注   
    */ 
    public static function GetText($value)
    {
        switch($value)
        {
            case OrderStatus::notPost:
                return "未提交";
            break;            
            case OrderStatus::notPass:
                return "审核未通过";
            break;            
            case OrderStatus::auditting:
                return "审核中";
            break;            
            case OrderStatus::isPass:
                return "审核通过";
            break;                     
            case OrderStatus::taskNotBegin:
                return "订单未处理";
            break;            
            case OrderStatus::taskBegin:
                return "订单处理中";
            break;            
            case OrderStatus::taskEnd:
                return "订单处理完毕";
            break;   
            case OrderStatus::backed:
                return "已退单";
            break;    
            case OrderStatus::haveContinueOrder:
                return "已续签";
            break;                   
                    
        }
        return "未知";
    }
}

/**
 * 客户资质类型
*/
class CustomerPermits
{
    /**
     * 营业执照 1
    */
    const BusinessLicense = 1;

    /**
     * 法人身份证 2
    */
    const CorporatePhoto = 2; 
}

/**
 * 支付方式
*/
class PayTypes
{
    /**
     * 银行汇款
    */
    const BankTransfer = 8;
    /**
     * 网银支付
    */
    const OnlineBankingPayment = 7;
    /**
     * 现金
    */
    const Cash = 1;
    /**
     * 快钱
    */
    const QuickMoney = 11;
    /**
     * 其他
    */
    const Others = 15;    
    
    /**
     * @functional 用于多选
    */
    public static function ToMultiSelectJson()
    {
        return "[{'value':'银行汇款','key':'8'},{'value':'网银支付','key':'7'},{'value':'其他','key':'15'}]";//{'value':'现金','key':'1'},{'value':'快钱','key':'11'},
    }      
}

/**
 * 产品分类(大类)
*/
class ProductGroups
{
    /**
     * 增值
    */
    const ValueIncrease  = 0;
    /**
     * 网盟
    */
    const NetworkAlliance = 1;
    
}

/**
 * 产品类别
*/
class ProductTypes
{
    /**
     * 盘邮
    */
    const py = "py";
    
    /**
     * 网营门户
    */
    const wymh = "wymh";
    
    /**
     * 诚信认证
    */
    const cxrz = "cxrz";
    
    /**
     * 网盟
    */
    const wm = "wm";
    
    /**
     * 网营专家
    */
    const wyzj = "wyzj";
    
    /**
     * Link
    */
    const link = "link";
    /**
     * 可信认证
    */
    const kxrz = "kxrz";
        
}

//代理商签约状态:0未提交 1流程中，2已签约，3已解除签约，4已失效
class AgentPactStatus
{
    /**
     * 未提交 0
    */
    const notPost  = 0;
    /**
     * 流程中 1
    */
    const notSign  = 1;
    /**
     * 已签约 2
    */
    const haveSign = 2;
    /**
     * 已解除签约 3
    */
    const removeSign = 3;
    /**
     * 已失效 4
    */
    const failSign = 4;    
}


/**
 * 单据类型 单据类型 1保证金 2预存款 3保证金转预存款 4预存款转保证金
*/
class BillTypes
{
    /**
     * 0 未知
    */
    const Unknown = 0;
    /**
     * 1 保证金打款
    */
    const GuaranteeMoney = 1;
    /**
     * 2 预存款打款
    */
    const PreDeposits = 2;
    /**
     * 3 销奖
    */
    const SaleReward = 3;
    /**
     * 4 保证金转预存款
    */
    const GuaranteeMoney2PreDeposits = 4;
    /**
     * 5 预存款转保证金
    */
    const PreDeposits2GuaranteeMoney = 5;   
    /**
     * 6 销奖转预存款
    */
    const SaleReward2PreDeposits = 6; 
    
    /**
     * 9 保证金冻结
    * /
    const GuaranteeMoneyLock = 9;     
    /**
     * 10 保证金解冻
    
    const GuaranteeMoneyUnlock = 10;  */
    /**
     * 11 保证金退款
    */
    const GuaranteeMoneyBack = 11; 
    
    /**
     * 12 订单提交 金额冻结
    */
    const OrderFreeze = 12;
    
    /**
     * 12 订单提交 金额冻结
    */
    const OrderUnFreeze = 27;
    /**
     * 13 订单扣款
    */
    const OrderCharge = 13;
    
    /**
     * 14 订单退款
    */
    const ChargeBack = 14;
    
    /**
     * 15 罚款
    */
    const PunishMoney = 15;  
    /**
     * 16 退款
    */
    const BackMoney = 16;   

    /**
     * 17 网盟预存款打款
     */
    const UnitPreDeposits = 17;
    
    /**
     * 18 网盟返点 
    */
    const UnitSaleReward = 18;
    
    /**
     * 19 网盟转款扣款
     */
    const UnitOrderCharge = 19;
    /**
     * 20 转款
    */
    const MoveMoney = 20;
    
    /**
     * 21 网盟转款退款
    */
    const UnitBackMoney = 21;

    /**
     * 24 帐户间款项转入
    */
    const MoveMoneyIn = 24;
    
    /**
     * 25 帐户间款项转出
    */
    const MoveMoneyOut = 25;
    
    /**
     * 26 网盟返点扣款 
    */
    const UnitSaleCharge = 26;    
    
    /**
     * 24 上级帐户款项转入
    */
    const MoveMoneyInSub = 30;
    
    /**
     * 25 款项转出到下级
    */
    const MoveMoneyOutSup = 31;
    
       
    private function Data()
    {
        return array(
            BillTypes::Unknown => "未知",BillTypes::GuaranteeMoney => "保证金打款", BillTypes::PreDeposits => "预存款打款", 
            BillTypes::SaleReward => "销奖",BillTypes::SaleReward2PreDeposits => "销奖转预存款",
            //BillTypes::GuaranteeMoney2PreDeposits => "保证金转预存款",BillTypes::PreDeposits2GuaranteeMoney => "预存款转保证金",
            //BillTypes::GuaranteeMoneyLock => "保证金冻结",BillTypes::GuaranteeMoneyUnlock => "保证金解冻",
            BillTypes::GuaranteeMoneyBack => "保证金退款",BillTypes::OrderFreeze => "订单款项冻结",BillTypes::OrderUnFreeze => "订单款项解除冻结",
            BillTypes::OrderCharge => "订单扣款",BillTypes::ChargeBack => "订单退款",
            BillTypes::PunishMoney => "违规罚款",BillTypes::BackMoney => "预存款退款",
            BillTypes::UnitPreDeposits => "网盟预存款打款",BillTypes::UnitSaleReward => "网盟返点",
            BillTypes::UnitOrderCharge => "网盟转款扣款",
            BillTypes::MoveMoneyIn => "帐户间款项转入",BillTypes::MoveMoneyOut => "帐户间款项转出",
            BillTypes::MoveMoneyInSub => "上级帐户款项转入",BillTypes::MoveMoneyOutSup => "款项转出到下级",BillTypes::UnitSaleCharge => "网盟返点扣款",/**/
            BillTypes::UnitBackMoney => "网盟转款退款"
        );
    }
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }

    /**
     * @functional 类型文字备注   
    */ 
    public static function GetText($value)
    {
        $data = self::Data();
        if(array_key_exists($value, $data))
            return $data[$value];
        else
            return $data[BillTypes::Unknown];
    }
         
    /**
     * @functional 用于多选
    */
    public static function ToMultiSelectJson()
    {
        $strJson = "[";
        $data = self::Data();
        foreach($data as $key => $vlaue)
        {
            if($key != BillTypes::Unknown)
                $strJson .="{'value':'$vlaue','key':'$key'},";
        }
        
        $strJson = substr($strJson,0,strlen($strJson)-1);
        $strJson .= "]";
        return $strJson;
    } 
}


/**
 * 票据类型
*/
class InvoiceTypes
{    
    /**
     * 0未知
    */
    const Unknown = 0;
    
    /**
     * 1发票
    */
    const Invoice = 1;
    
    /**
     * 5收据
    */
    const Receipt = 5;
}

class AgentCheckStatus{
     /**
     * 0 未审核
    */
    const UnCheck = 0;
    /**
     * 1 审核成功
    */
    const CheckSuccess = 1;
    /**
     * 2 审核失败
    */
    const CheckFailed = 2;
    
    /**
     * @functional 代理商账户类别文字备注
    */
    public static function GetText($value)
    {
        switch($value)
        {
            case AgentCheckStatus::UnCheck:
                return "未审核";
            break;
            case AgentCheckStatus::CheckSuccess:
                return "审核成功";
            break;
            case AgentCheckStatus::CheckFailed:
                return "审核失败";
            break;
        }
        return "未知";
    }
    
}


/**
 * 代理商账户类别
*/
class AgentAccountTypes
{
    /**
     * 0 未知
    */
    const Unknown = 0;
    /**
     * 1 保证金
    */
    const GuaranteeMoney = 1;
    /**
     * 2 预存款
    */
    const PreDeposits = 2;
    /**
     * 3 销奖
    */
    const SaleReward = 3;
    /**
     * 4 冻结账户
    */
    const Frozen = 4; 
    /**
     * 5 保证金转预存账户
    */
    const GuaranteeMoney2PreDeposits = 5;
    /**
     * 6 销奖转预存账户
    */
    const SaleReward2PreDeposits = 6;
    /**
     * 7 网盟预存款账户
    */
    const UnitPreDeposits = 7;
    /**
     * 8 网盟返点账户
    */
    const UnitSaleReward = 8;
            
    /**
     * @functional 用于多选
    */
    public static function ToMultiSelectJson()
    {
        return "[{'value':'保证金账户','key':'1'},{'value':'预存款账户','key':'2'},{'value':'销奖转预存账户','key':'6'},        
        {'value':'网盟预存款账户','key':'7'},{'value':'网盟返账户','key':'8'}]";//{'value':'保证金转预存账户','key':'5'},
    }   
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }

    
    /**
     * @functional 代理商账户类别文字备注
    */
    public static function GetText($value)
    {
        switch($value)
        {
            case AgentAccountTypes::GuaranteeMoney:
                return "保证金账户";
            break;
            case AgentAccountTypes::PreDeposits:
                return "预存款账户";
            break;
            case AgentAccountTypes::SaleReward:
                return "销奖账户";
            break;
            case AgentAccountTypes::Frozen:
                return "冻结账户";
            break;
            case AgentAccountTypes::GuaranteeMoney2PreDeposits:
                return "保证金转预存账户";
            break;
            case AgentAccountTypes::SaleReward2PreDeposits:
                return "销奖转预存账户";
            break;
            case AgentAccountTypes::UnitPreDeposits:
                return "网盟预存款账户";
            break;
            case AgentAccountTypes::UnitSaleReward:
                return "网盟返点账户";
            break;
    
        }
        return "未知";
    }
       
    
    /**
     * @functional 账户是否与产品相关 
    */
    public static function RelevantWithProduct($accountType)
    {
        /* 有些打款是不分产品的 现在都分 
        if($accountType == AgentAccountTypes::PreDeposits || $accountType == AgentAccountTypes::UnitPreDeposits || $accountType == AgentAccountTypes::UnitSaleReward)
            return false;
            */
        return true;
    }
}


/**
 * 开票状态
*/
class InvoiceStates
{    
    /**
     * -3:红冲
    */
    const Red = -3;  
    
    /**
     * -2:作废
    */
    const Fail = -2;  
    /**
     * -1:退回
    */
    const Back = -1;
    
    /**
     * 0:未开票
    */
    const NotOpen = 0;
    
    /**
     * 1:部分开票
    */
    const PartOpen = 1;
    
    /**
     * 2:已开票
    */
    const AllOpen = 2;    
    
}
/**
 * 收支状态
*/
class ReceivablePayStates
{
    /**
     * -1:退回
    */
    const Back = -1;
    
    /**
     * 0:未生效 未到账
    */
    const NotEffect = 0;
    
    /**
     * 1:待收 底单入款
    */
    const Receivable = 1;
    
    /**
     * 2:已收 到账
    */
    const Received = 2;
    /**
     * 3:已认领
    * /
    const InAccount = 3;*/
    
    /**
     * 50:充值冲销
    */
    const Red = 50;
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }

    
    /**
     * @functional 收支状态文字备注
    */
    public static function GetText($value)
    {
        switch($value)
        {
            case ReceivablePayStates::Back:
                return "款项信息退回";
            break;  
            case ReceivablePayStates::NotEffect:
                return "未到账";
            break;  
            case ReceivablePayStates::Receivable:
                return "底单入款";
            break;  
            case ReceivablePayStates::Received:
                return "到账";
            break;  
            /*case ReceivablePayStates::InAccount:
                return "已认领";
            break;  */
            case ReceivablePayStates::Red:
                return "红冲";
            break;  
    
        }
        return "未知";
    }
    
    /**
     * @functional 用于多选
    */
    public static function ToMultiSelectJson()
    {
        return "[{'key':'0','value':'未到账'},{'key':'1','value':'底单入款'},{'key':'2','value':'到账'},{'key':'3','value':'已认领'},{'key':'50','value':'红冲'},{'key':'-1','value':'款项信息退回'}]";
    }   
}

/**
 * 客户表保护状态
 */
class CustomerDefendState{
    /**
     * 1:电话客户
     */
    const TelCustomer = 1;
    /**
     * 2:保护客户
     */
    const DefendCustomer = 2;
    /**
     * 3:自录客户
     */
    const AddMyselfCustomer = 3;
    /**
     * 4:正式客户
     */
    const HasOrderCustomer = 4;
    
    static function getText($value){
        switch($value)
        {
            case CustomerDefendState::TelCustomer:
                return "电话客户";
            break;  
            case CustomerDefendState::DefendCustomer:
                return "保护客户";
            break;  
            case CustomerDefendState::AddMyselfCustomer:
                return "自录客户";
            break;  
            case CustomerDefendState::HasOrderCustomer:
                return "正式客户";
            break;      
        }
        return "未知";
    }
}

class CustomerResource {
    /**
     * 0:后台录入
     */
    const BackAdd = 0;
    /**
     * 1:拉取
     */
    const FromSea = 1;
    /**
     * 2:其他
     */
    const Other = 2;
    /**
     * 3:自动注册
     */
    const AutoRegister = 3;
    /**
     * 4:厂商推荐
     */
    const PSOpr = 4;
    /**
     * 5:前台录入
     */
    const FrontAdd = 5;
    /**
     * 6:Excel导入
     */
    const ExcelAdd = 6;

    static function getText($value) {
        switch ($value) {
            case CustomerResource::BackAdd:
                return "后台录入";
                break;
            case CustomerResource::FromSea:
                return "拉取";
                break;
            case CustomerResource::Other:
                return "其他";
                break;
            case CustomerResource::AutoRegister:
                return "自动注册";
                break;
            case CustomerResource::PSOpr:
                return "厂商分配";
                break;
            case CustomerResource::FrontAdd:
                return "录入";
                break;
            case CustomerResource::ExcelAdd:
                return "导入";
                break;
        }
        return "未知";
    }

}

class CustomerResourcePerson {
    /**
     * 上级分配
     */
    const SupperAssign = 1;
    /**
     * 录入
     */
    const SelfAdd = 2;
    /**
     * 拉取
     */
    const DefendAdd = 3;

    static function getText($value) {
        switch ($value) {
            case CustomerResourcePerson::SupperAssign:
                return "上级分配";
                break;
            case CustomerResourcePerson::SelfAdd:
                return "录入";
                break;
            case CustomerResourcePerson::DefendAdd:
                return "拉取";
                break;
        }
        return "未知";
    }

}


/**
 * 客户审核信息
 */
class CustomerLogCheckType {
    /**
     * 新增
     */
    const Add = 1;
    /**
     * 修改
     */
    const Edit = 2;
    /**
     * 删除
     */
    const Del = 3;

    static function getText($value) {
        switch ($value) {
            case CustomerLogCheckType::Add:
                return "新增";
                break;
            case CustomerLogCheckType::Edit:
                return "修改";
                break;
            case CustomerLogCheckType::Del:
                return "删除";
                break;
        }
        return "未知";
    }

}

/**
 * 系统通用设置
*/
class ComSettings
{
    /**
     * 账户余额(订单下单)设置 保证金
    */
    const Order_GuaAccountBalance = "Order_GuaAccountBalance";
    
    /**
     * 账户余额(订单下单)设置 预存款
    */
    const Order_PreAccountBalance = "Order_PreAccountBalance";
    
    /**
     * 账户余额(订单下单)设置 保证金
    */
    const UnitOrder_GuaAccountBalance = "UnitOrder_GuaAccountBalance";
    
    /**
     * 账户余额(订单下单)设置 预存款
    */
    const UnitOrder_PreAccountBalance = "UnitOrder_PreAccountBalance";
    
    /**
     * 代理商账户余额提醒 保证金
    */
    const Gua_BalanceWarning = "Gua_BalanceWarning";
        
    /**
     * 代理商账户余额提醒 预存款
    */
    const Pre_BalanceWarning = "Pre_BalanceWarning";
    /**
     * 代理商提交签约保证金设置
    */
    const AgentSignGuaSet = "AgentSignGuaSet";
    
    /**
     * 代理商提交签约预存款设置
    */
    const AgentSignPreSet = "AgentSignPreSet";
          
    /**
     * 网盟转款最低金额限制
    */
    const UnitMinInMoney = "UnitMinInMoney";
    
    /**
     * 网盟转款比例   
     */
    const UnitPreReMoneyRate = "UnitPreReMoneyRate";
}

/**
 * 客户通用参数设置
*/
class CustomerDataConfig
{    
    /**
     * 允许拉取客户的时间段
     */
    const PullCustomerTime = "PullCustomerTime";

    /**
     *  电话客户（即从公海中拉取的客户）
     */
    const ProtectTime_Tel = "ProtectTime_Tel";

    /**
     * 未添加联系小记的自录客户
     */
    const ProtectTime_Self_No_Record = "ProtectTime_Self_No_Record";
    
    /**
     * 未添加联系小记的保护客户
     */
    const ProtectTime_Protect_No_Record = "ProtectTime_Protect_No_Record";

    /**
     * 距离上一次添加联系小记的自录客户
     */
    const ProtectTime_Self_Record = "ProtectTime_Self_Record";

    /**
     * 距离上一次添加联系小记的保护客户
     */
    const ProtectTime_Protect_Record = "ProtectTime_Protect_Record";

    /**
     * 正式客户
     */
    const ProtectTime_Formal = "ProtectTime_Formal";

    /**
     * 自录客户
     */
    const Allow_Count_Self = "Allow_Count_Self";

    /**
     * 电话客户
     */
    const Allow_Count_Tel = "Allow_Count_Tel";

    /**
     * 保护客户
     */
    const Allow_Count_Protect = "Allow_Count_Protect";

    /**
     * 到公海屏蔽天数
     */
    const ToSeaProtectDate = "ToSeaProtectDate";

    /**
     * 无效联系选项
     */
    const Invalid_Contact = "Invalid_Contact";
    
}

/**
 * 代理商通用参数设置
*/
class AgentCommSet
{    
    /**
     * 个人库数量的限制
     */
    const Agent_Count_Limit = "Agent_Count_Limit";
    
    /**
     * 联系小记选项设置
     */
    const Agent_Contact_Content = "Agent_Contact_Content";
    
}

/**
 * 代理商资料流转记录
*/
class AgentMoveTypes
{
    /**
     * 资料转移
    */
    const Move = 1;
    /**
     * 合同转移
    */
    const PactMove = 2;
    /**
     * 共享
    */
    const Share = 3;
    /**
     * 取消共享
    */
    const Unshare = 4;
    /**
     * 拉取
    */
    const OutSea = 5;
    /**
     * 踢除
    */
    const InSea = 6;
        
       
    public static function Data()
    {
        return array(
            AgentMoveTypes::Move => "资料转移",AgentMoveTypes::PactMove => "合同转移", 
            AgentMoveTypes::Share => "共享", AgentMoveTypes::Unshare => "取消共享",
            AgentMoveTypes::OutSea => "拉取",AgentMoveTypes::InSea => "踢除"
        );
    }
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }

    /**
     * @functional 类型文字备注   
    */ 
    public static function GetText($value)
    {
        $data = self::Data();
        if(array_key_exists($value, $data))
            return $data[$value];
        
        return "未知";
    }
         
    /**
     * @functional 用于多选
    */
    public static function ToMultiSelectJson()
    {
        $strJson = "[";
        $data = self::Data();
        foreach($data as $key => $vlaue)
        {
            $strJson .="{'value':'$vlaue','key':'$key'},";
        }
        
        $strJson = substr($strJson,0,strlen($strJson)-1);
        $strJson .= "]";
        return $strJson;
    } 
}

class AgentIncomeType{
    /**
     * 空白
     */
    const NoSelected = 0;
    /**
     * 承诺
     */
    const Promise = 1;
    /**
     * 备份
     */
    const BackUp = 2;
    
    static function getText($value) {
        switch ($value) {
            case AgentIncomeType::NoSelected:
                return "空白";
                break;
            case AgentIncomeType::Promise:
                return "承诺";
                break;
            case AgentIncomeType::BackUp:
                return "备份";
                break;
        }
        return "未知";
    }
}

/**
 * 陪访审核状态
*/
class AccompanyVisitCheckStatus
{
    /**
     * 不质检 -2
    */
    const withoutaudit = -2;
    /**
     * 质检未通过 -1
    */
    const notPass = -1;
    /**
     * 未质检 0
    */
    const auditting = 0;
    /**
     * 质检通过 1
    */
    const isPass = 1; 
    /**
     * 不质检 2
     */
    const unNeedCheck = 2;
           
    public static function Data()
    {
        return array(
            //AccompanyVisitCheckStatus::withoutaudit => "不质检",必须质检
            AccompanyVisitCheckStatus::notPass => "质检未通过", 
            AccompanyVisitCheckStatus::auditting => "未质检", 
            AccompanyVisitCheckStatus::isPass => "质检通过",
            AccompanyVisitCheckStatus::unNeedCheck => "不质检"
        );
    }
    
    /**
     * @functional 类型文字备注   
    */ 
    public static function GetText($value)
    {
        $data = self::Data();
        if(array_key_exists($value, $data))
            return $data[$value];
            
        return "未知";
    }
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }

}