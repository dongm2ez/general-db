<?php

namespace Dongm2ez\Db\Traits;

use Dongm2ez\Db\Constant\Query;

trait ListsGuardsTrait
{
    protected $symbolArr = Query::QUERY_SYMBOL_ALL;

    /**
     * 查询列表白名单过滤
     * @param array $params
     * @param array $listFillable
     * @return array
     */
    protected function listFillableFromArray(array $params, array $listFillable)
    {
        list($paramsKeys, $paramsValues) = array_divide($params);

        $fillableList = [];

        // 组合条件
        foreach ($listFillable as $key => $value) {
            if (empty($value)) {
                array_push($fillableList, $key);
            } elseif (is_numeric($key) && is_string($value)) {
                array_push($fillableList, $value);
                $fieldList = array_map(function ($symbol) use ($value) {
                    return $value . $symbol;
                }, $this->symbolArr);
                $fillableList = array_merge($fillableList, $fieldList);
            } else {
                for ($i = 0; $i < count($value); $i++) {
                    if ($value[$i] === '=') {
                        array_push($fillableList, $key);
                        continue;
                    }
                    $item = $key . '{' . $value[$i] . '}';
                    array_push($fillableList, $item);
                }
            }
        }

        // 移除值为空字符串的
        $params = array_filter($params, function ($v) {
            return $v != '';
        });
        // 只保留列表中有的
        $params = array_only($params, $fillableList);

        return $params;
    }

    /**
     * 查询列表黑名单过滤
     * @param array $params
     * @param array $listGuarded
     * @return array
     */
    protected function listGuardedFromArray(array $params, array $listGuarded)
    {
        list($paramsKeys, $paramsValues) = array_divide($params);

        $guardedList = [];

        // 组合查询条件
        foreach ($listGuarded as $key => $value) {
            if (count($value) === 0) {
                array_push($guardedList, $key);
            } elseif (is_numeric($key) && is_string($value)) {
                array_push($guardedList, $value);
                $fieldList = array_map(function ($symbol) use ($value) {
                    return $value . $symbol;
                }, $this->symbolArr);
                $guardedList = array_merge($guardedList, $fieldList);
            } else {
                for ($i = 0; $i < count($value); $i++) {
                    if ($value[$i] === '=') {
                        array_push($guardedList, $key);
                        continue;
                    }
                    $item = $key . '{' . $value[$i] . '}';
                    array_push($guardedList, $item);
                }
            }
        }

        // 移除值为空字符串的
        $params = array_filter($params, function ($v) {
            return $v != '';
        });
        // 移除列表中有的
        $params = array_where($params, function ($value, $key) use ($guardedList) {
            return !in_array($key, $guardedList);
        });

        return $params;
    }
}
