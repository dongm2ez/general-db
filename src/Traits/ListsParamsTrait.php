<?php
/**
 * Created by PhpStorm.
 * User: dongyuxiang
 * Date: 16/01/2018
 * Time: 16:44
 */

namespace Dongm2ez\Db\Traits;


use Dongm2ez\Db\Constant\Query;

trait ListsParamsTrait
{
    /**
     * 分页参数格式化
     * @author Dong Yuxiang<dongyuxiang@eventmosh.com>
     * @param $params
     * @return array
     */
    protected function listParamsFormat(&$params)
    {
        $page = (int)isset($params['page_no']) ? $params['page_no'] : 0;
        $size = (int)isset($params['page_size']) ? $params['page_size'] : 0;
        $page = ($page > 0) ? $page : 1;
        $size = ($size > 0 && $size <= Query::PAGE_MAX_SIZE) ? $size : Query::PAGE_DEFAULT_SIZE;


        $page = (int)array_get($params, Query::QUERY_PARAM_PAGE, $page);
        $limit = (int)array_get($params, Query::QUERY_PARAM_LIMIT, $size);
        $sort = array_get($params, Query::QUERY_PARAM_SORT, 'id');
        $order = array_get($params, Query::QUERY_PARAM_ORDER, 'DESC');
        $group = array_get($params, Query::QUERY_PARAM_GROUP, '');
        $type = array_get($params, Query::QUERY_PARAM_TYPE, Query::QUERY_TYPE_PAGE);
        $version = array_get($params, Query::QUERY_PARAM_VERSION, '');

        $with = array_get($params, Query::QUERY_MODEL_WITH, '');

        $fields = array_get($params, Query::QUERY_PARAM_FIELDS);
        $fields = $fields ? (is_array($fields) ? $fields : explode(',', $fields)) : ['*'];

        array_forget($params, Query::QUERY_PARAM_ALL);

        $extends = [
            'page' => $page,
            'limit' => $limit,
            'sort' => $sort,
            'order' => $order,
            'group' => $group,
            'fields' => $fields,
            'type' => $type,
            'version' => $version
        ];

        $model = [
            'with' => $with
        ];

        return ['_extends' => $extends, '__model' => $model];
    }
}