<?php
/**
 * Created by PhpStorm.
 * User: dongyuxiang
 * Date: 15/01/2018
 * Time: 18:05
 */

namespace Dongm2ez\Db\Constant;


class Query
{
    /**
     * 分页相关配置
     */
    const PAGE_DEFAULT_SIZE = 15;
    const PAGE_MAX_SIZE = 200;

    /**
     * Query 参数名称配置
     */
    const QUERY_PARAM_PAGE = '_page';
    const QUERY_PARAM_LIMIT = '_limit';
    const QUERY_PARAM_SORT = '_sort';
    const QUERY_PARAM_ORDER = '_order';
    const QUERY_PARAM_GROUP = '_group';
    const QUERY_PARAM_FIELDS = '_fields';
    const QUERY_PARAM_TYPE = '_type'; // 扩展字段, 用于区别查询结果集类型
    const QUERY_PARAM_VERSION = '_version'; // 用于接口的版本控制


    const QUERY_PARAM_ALL = [
        self::QUERY_PARAM_PAGE,
        self::QUERY_PARAM_LIMIT,
        self::QUERY_PARAM_SORT,
        self::QUERY_PARAM_ORDER,
        self::QUERY_PARAM_GROUP,
        self::QUERY_PARAM_FIELDS,
        self::QUERY_PARAM_TYPE,
        self::QUERY_PARAM_VERSION,
    ];

    const QUERY_TYPE_PAGE = 'page';
    const QUERY_TYPE_RAW_PAGE = 'raw_page';
    const QUERY_TYPE_OFFSET = 'offset';
    const QUERY_TYPE_ALL = 'all';
    const QUERY_TYPE_RAW_ALL = 'raw_all';

    const QUERY_SYMBOL_GREATER = '{>}';
    const QUERY_SYMBOL_GREATER_EQUAL = '{ge}';
    const QUERY_SYMBOL_LESS = '{<}';
    const QUERY_SYMBOL_LESS_EQUAL = '{le}';
    const QUERY_SYMBOL_NON = '{!}';
    const QUERY_SYMBOL_IN = '{@}';
    const QUERY_SYMBOL_NOT_IN = '{!@}';
    const QUERY_SYMBOL_IS_NULL = '{#}';
    const QUERY_SYMBOL_IS_NOT_NULL = '{!#}';
    const QUERY_SYMBOL_BETWEEN = '{<>}';
    const QUERY_SYMBOL_NOT_BETWEEN = '{><}';


    const QUERY_SYMBOL_ALL = [
        self::QUERY_SYMBOL_GREATER,
        self::QUERY_SYMBOL_GREATER_EQUAL,
        self::QUERY_SYMBOL_LESS,
        self::QUERY_SYMBOL_LESS_EQUAL,
        self::QUERY_SYMBOL_NON,
        self::QUERY_SYMBOL_IN,
        self::QUERY_SYMBOL_NOT_IN,
        self::QUERY_SYMBOL_IS_NULL,
        self::QUERY_SYMBOL_IS_NOT_NULL,
        self::QUERY_SYMBOL_BETWEEN,
        self::QUERY_SYMBOL_NOT_BETWEEN,
    ];
}