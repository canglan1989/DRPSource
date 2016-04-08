<?php
class Model_pub_customer{
    /**
     * 客户ID
     * @var int 
     */
    public $cid = -999;
    /**
     * 客户名称
     * @var string 
     */
    public $cname = '';
    /**
     * 属所地区
     * @var Int32
     */
    public $area_id = -999;
    /**
     * 所属行业
     * @var Int32
     */
    public $industry_id = -999;
    /**
     * 客户地址
     * @var string 
     */
    public $address = '';
    /**
     * 邮政编码
     * @var string 
     */
    public $postcode = '';

    /**
     * 经营模式
     * @var string 
     */
    public $business_mode = '';
    /**
     * 主营业务
     * @var string 
     */
    public $main_business = '';
    /**
     * 经营范围
     * @var string 
     */
    public $business_scope = '';
    /**
     * 主要市场
     * @var string 
     */
    public $major_markets = '';
    /**
     * 规模（人数）
     * @var Int32
     */
    public $person_num = -999;
    /**
     * 规模（年营业额，单位：万）
     * @var Int32
     */
    public $annual_sales = -999;
    /**
     * 注册状态
     * @var int
     */
    public $reg_status = '';
    /**
     * 注册资金
     * @var int 
     */
    public $reg_capital = '';
    /**
     * 注册时间
     * @var DateTime 
     */
    public $reg_date='0001-1-1 0:00:00';
    /**
     * 注册地址
     * @var string 
     */
    public $rep_address = '';
    /**
     * 法人姓名
     * @var string
     */
    public $legal_person_name = '';
    /**
     * 营业执照号
     * @var string
     */
    public $business_license = '';
    /**
     * 主要联系人
     * @var string
     */
    public $major_contact = '';
    /**
     * 联系人邮箱
     * @var string
     */
    public $email = '';
    /**
     * 联系人电话
     * @var string
     */
    public $tel = '';
    /**
     * 联系人手机
     * @var string
     */
    public $mobile = '';
    /**
     * 联系人QQ
     * @var string
     */
    public $qq = '';
    /**
     * 联系人MSN
     * @var string
     */
    public $msn = '';
    /**
     * 所属中心 2-中小企业中心 4-大企业中心 8-渠道中心
     * @var int
     */
    public $centers = -999;
    /**
     * 删除标识
     * @var int
     */
    public $del_flag=-999;
    /**
     * 最后更新时间
     * @var DateTime
     */
    public $updatetime='0001-1-1 0:00:00';
    /**
     * 创建时间
     * @var DateTime
     */
    public $addtime='0001-1-1 0:00:00';






    
    public function __set($name, $value) {
        throw new Exception('Property '.$name.' does not exist!');
    }
    
    public function __get($name){
        throw new Exception('Trying to access noexist property '.$name.'!');
    }
}
