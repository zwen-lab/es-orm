<?php
namespace Zwen\EsOrm;

use Zwen\EsOrm\Query\Builder as QueryBuilder;

class Builder{
    /**
     * The base query builder instance.
     *
     * @var \Zwen\EsOrm\Query\Builder
     */
    protected $query;

    /**
     * The model being queried.
     *
     * @var \Zwen\EsOrm\Model
     */
    protected $model;


    /**
     * The relationships that should be eager loaded.
     *
     * @var array
     */
    protected $eagerLoad = [];

    /**
     * All of the registered builder macros.
     *
     * @var array
     */
    protected $macros = [];

    /**
     * A replacement for the typical delete function.
     *
     * @var \Closure
     */
    protected $onDelete;

    /**
     * The methods that should be returned from query builder.
     *
     * @var array
     */
    protected $passthru = [
        'insert', 'insertGetId', 'getBindings', 'toSql',
        'exists', 'count', 'min', 'max', 'avg', 'sum', 'getConnection',
    ];

    /**
     * Applied global scopes.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * Removed global scopes.
     *
     * @var array
     */
    protected $removedScopes = [];

    public function __construct(QueryBuilder $query)
    {
        $this->query = $query;
    }

    /**
     * Set a model instance for the model being queried.
     *
     * @param  \Zwen\EsOrm\Model  $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        $this->query->index($model->getIndex());
        $this->query->type($model->getType());
        $this->query->from($model->getIndex() . '/' . $model->getType());

        return $this;
    }

    /**
     * Dynamically handle calls into the query instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        /*if (isset($this->macros[$method])) {
            array_unshift($parameters, $this);

            return call_user_func_array($this->macros[$method], $parameters);
        }

        if (method_exists($this->model, $scope = 'scope'.ucfirst($method))) {
            return $this->callScope([$this->model, $scope], $parameters);
        }

        if (in_array($method, $this->passthru)) {
            return call_user_func_array([$this->toBase(), $method], $parameters);
        }*/

        call_user_func_array([$this->query, $method], $parameters);

        return $this;
    }
}
