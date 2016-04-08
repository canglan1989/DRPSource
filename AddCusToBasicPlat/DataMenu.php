<?php
/**
 * 系统平台枚举
 */
class PlatForm{
    const ERP = 'erp';
    const DRP = 'drp';
    const CRM = 'crm';
    const OTHER = 'other';
}

/**
 *  操作类型枚举
 */
class OpType{
    const ADD = 'add';
    const MOD = 'mod';
    const DEL = 'del';
    const SELECT = 'select';
    const OTHER = 'other';
}

/**
 *  数据表枚举
 */
class DataTable{
    const PUB_CUSTOMER = 'pub_customer';
    const PUB_USER = 'pub_user';
    const OTHER = 'other';
}
?>