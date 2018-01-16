<?php
/**
 * Created by PhpStorm.
 * User: dongyuxiang
 * Date: 15/01/2018
 * Time: 16:44
 */

namespace Db\Traits;


use Illuminate\Database\Eloquent\Model;

trait ConditionParser
{
    /**
     * 条件解析
     * @param array $condition
     * @return array
     */
    protected function conditionParse(array $condition = []): array
    {
        $where = [];

        array_forget($condition, '_extends');

        foreach ($condition as $key => $value) {
            if (strpos($key, '{') !== false && strpos($key, '}') !== false) {
                $key = str_replace(['{', '}', '>>', '<<'], ['[', ']', '>=', '<='], $key);
            }

            if (gettype($value) === 'string' && strpos($value, ',') !== false || strpos($value, '**') !== false) {
                $value = array_filter(explode(',', $value));
                $value = str_replace('**', ',', $value);
            }

            $type = gettype($value);

            preg_match('/(#?)([a-zA-Z0-9_\.]+)(\[(?<operator>\>|\>\=|ge|\<|\<\=|le|\!|\<\>|\>\<|\!?~|\!?@|\!?#)\])?/i',
                $key,
                $match);

            $column = $match[2];

            if (isset($match['operator'])) {
                $operator = strtolower($match['operator']);

                if ($operator === 'ge' || $operator === 'le') {
                    if ($type === 'array' || $type === 'double' || $type === 'string') {
                        if ($operator === 'ge') {
                            $where['where'][] = [$column, '>=', $value];
                        } else {
                            $where['where'][] = [$column, '<=', $value];
                        }
                    }
                } elseif ($operator === '!') {
                    switch ($type) {
                        case 'integer':
                        case 'double':
                        case 'string':
                            $where['where'][] = [$column, '!=', $value];
                            break;
                        case 'boolean':
                            $where['where'][] = [$column, '!=', $value ? '1' : '0'];
                            break;
                    }
                } elseif ($operator === '@' || $operator === '!@') {
                    // 对只传一个值调用方不加,做兼容
                    if (strpos($value, ',') === false) {
                        $type = 'array';
                        $value = [$value];
                    }
                    if ($type === 'array') {
                        if ($operator === '@') {
                            $where['whereIn'][] = [$column, $value];
                        } else {
                            $where['whereNotIn'][] = [$column, $value];
                        }
                    }
                } elseif ($operator === '#' || $operator === '!#') {
                    if ($type === 'NULL') {
                        if ($operator === '#') {
                            $where['whereNull'][] = [$column, $value];
                        } else {
                            $where['whereNotNull'][] = [$column, $value];
                        }
                    }
                } elseif ($operator === '<>' || $operator === '><') {
                    if ($type === 'array') {
                        if ($operator === '<>') {
                            $where['whereBetween'][] = [$column, $value];
                        } else {
                            $where['whereNotBetween'][] = [$column, $value];
                        }
                    }
                } elseif ($operator === '~' || $operator === '!~') {
                    if (!preg_match('/(\[.+\]|_|%.+|.+%)/', $value)) {
                        $value = '%' . $value . '%';
                    }
                    $operator = ($operator === '!~' ? 'not ' : '') . 'like';

                    $where['where'][] = [$column, $operator, $value];

                } else {
                    $where['where'][] = [$column, $operator, $value];
                }

            } else {

                switch ($type) {
                    case 'integer':
                    case 'double':
                    case 'string':
                        $where['where'][] = [$column, '=', $value];
                        break;
                    case 'boolean':
                        $where['where'][] = [$column, '=', $value ? '1' : '0'];
                }

            }
        }

        return $where;

    }


    /**
     * 查询器处理
     * @param array $condition
     * @param $builder
     * @return Model
     */
    protected function builderPrepare(array $condition = [], &$builder)
    {
        foreach ($condition as $key => $value) {
            switch ($key) {
                case 'where':
                    $builder = $builder->$key($value);
                    break;
                case 'whereIn':
                case 'whereNotIn':
                case 'whereBetween':
                case 'whereNotBetween':
                    array_map(function ($item) use ($key, &$builder) {
                        $builder = $builder->$key($item[0], $item[1]);
                    }, $value);
                    break;
                case 'whereNull':
                case 'whereNotNull':
                    array_map(function ($item) use ($key, &$builder) {
                        $builder = $builder->$key($item);
                    }, $value);
                    break;
            }
        }

        return $builder;
    }
}