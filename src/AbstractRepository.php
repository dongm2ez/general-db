<?php

namespace Dongm2ez\Db;

use Dongm2ez\Db\Constant\Query;
use Dongm2ez\Db\Traits\ConditionParser;
use Dongm2ez\Db\Traits\PaginationParser;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    use ConditionParser;
    use PaginationParser;

    const PAGE_NAME = '_page';

    /**
     * @var Model | null
     */
    protected $model = null;

    public function __construct()
    {
        $this->init();
    }

    /**
     * 获取通用列表
     * @param array $condition
     * @return array
     */
    public function getList(array $condition)
    {
        $model = $this->modelPrepare($condition);
        $extends = $this->extendsPrepare($condition);
        $condition = $this->conditionParse($condition);

        /** @var Model $builder */
        $builder = $this->model;
        if ($model['with']) {
            $builder = $builder->with($model['with']);
        }
        $builder = $this->builderPrepare($builder, $condition);
        $builder->orderBy($extends['sort'], $extends['order']);

        if (!empty($extends['group'])) {
            $builder->groupBy(explode(',', $extends['group']));
        }

        switch ($extends['type']) {
            case Query::QUERY_TYPE_RAW_ALL:
                $result = $builder->selectRaw(implode(',', $extends['fields']))->get()->toArray();
                break;
            case Query::QUERY_TYPE_ALL:
                $result = $builder->all($extends['fields'])->toArray();
                break;
            case Query::QUERY_TYPE_OFFSET:
                $result = $builder->offset($extends['page'])->limit($extends['limit'])->get($extends['fields'])->toArray();
                break;
            case Query::QUERY_TYPE_RAW_PAGE:
                $result = $builder->selectRaw(implode(',', $extends['fields']))->paginate($extends['limit'], $extends['fields'], self::PAGE_NAME, $extends['page']);
                $result = $this->formatPagination($result);
                break;
            default:
            case Query::QUERY_TYPE_PAGE:
                $result = $builder->paginate($extends['limit'], $extends['fields'], self::PAGE_NAME, $extends['page']);
                $result = $this->formatPagination($result);
        }

        return $result;
    }

    /**
     * 通用根据主键获取记录
     * @param int $id
     * @return array
     */
    public function getItemById(int $id)
    {
        /** @var Model $builder */
        $builder = $this->model;

        $builder = $builder->where('id', $id);

        $result = $builder->first();

        return $result->toArray();
    }

    /**
     * 获取通用单条记录
     * @param array $condition
     * @return array
     */
    public function getItem(array $condition)
    {
        $model = $this->modelPrepare($condition);
        $extends = $this->extendsPrepare($condition);
        $condition = $this->conditionParse($condition);
        /** @var Model $builder */
        $builder = $this->model;
        if ($model['with']) {
            $builder = $builder->with($model['with']);
        }
        $builder = $this->builderPrepare($condition, $builder);
        $builder->orderBy($extends['sort'], $extends['order']);

        if (!empty($extends['group'])) {
            $builder->groupBy(explode(',', $extends['group']));
        }
        $result = $builder->first($extends['fields']);
        $result = is_null($result) ? [] : $result->toArray();

        return $result;
    }

    /**
     * 通用更新
     * @param array $condition
     * @param array $data
     * @return bool
     */
    public function update(array $condition, array $data)
    {
        $condition = $this->conditionParse($condition);

        /** @var Model $builder */
        $builder = $this->model;
        $builder = $this->builderPrepare($condition, $builder);

        return $builder->update($data);
    }

    /**
     * 通用删除
     * @param array $condition
     * @throws \Exception
     * @return null|bool
     */
    public function delete(array $condition)
    {
        $condition = $this->conditionParse($condition);

        /** @var Model $builder */
        $builder = $this->model;
        $builder = $this->builderPrepare($condition, $builder);

        return $builder->delete();
    }

    /**
     * 实现此方法，将 $model 初始化为当前储藏库要使用的模型
     * @return mixed
     */
    abstract protected function init();
}
