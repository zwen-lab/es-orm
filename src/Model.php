<?php
namespace Zwen\EsOrm;

use Zwen\EsOrm\Connectors\Connector;
use Zwen\EsOrm\Query\Builder as QueryBuilder;
use Zwen\EsOrm\Grammars\Grammar;

class Model{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

    /**
     * The index associated with the model.
     *
     * @var string
     */
    protected $index;

    /**
     * The type associated with the model.
     *
     * @var string
     */
    protected $type;

    /**
     * 获取index
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * 获取type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['increment', 'decrement'])) {
            return call_user_func_array([$this, $method], $parameters);
        }

        $query = $this->newQuery();

        return call_user_func_array([$query, $method], $parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static;

        return call_user_func_array([$instance, $method], $parameters);
    }

    public function newQuery() {
        return $this->newEloquentBuilder(
            $this->newBaseQueryBuilder()
        );
    }

    /**
     * 创建builder
     *
     * @param QueryBuilder $query
     * @return Builder
     */
    public function newEloquentBuilder(QueryBuilder $query)
    {
        $builder = new Builder($query);

        return $builder->setModel($this);
    }

    public function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();

        $grammar = new Grammar();

        return new QueryBuilder($conn, $grammar);
    }

    public function getConnection()
    {
        return new Connector();
    }
}
