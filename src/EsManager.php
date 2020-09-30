<?php
namespace Zwen\EsOrm;

use Elasticsearch\ClientBuilder;

class EsManager{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The active connection instances
     *
     * @var
     */
    protected $connection = null;

    /**
     * 连接配置
     *
     * @var
     */
    protected $config;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get a database connection instance.
     *
     * @return |null
     */
    public function connection()
    {
        if($this->connection == null){
            $this->connection = $this->makeConnection();
        }

        return $this->connection;
    }

    /**
     * Make the database connection instance.
     *
     * @return Connection
     */
    protected function makeConnection()
    {
        $config = $this->getConfig();

        $client = function () use ($config) {
            return ClientBuilder::create()->setHosts($config['host'])->build();
        };

        return new Connection($client, $config);
    }

    /**
     * 获取es连接相关配置
     *
     * @return array
     */
    protected function getConfig() :array
    {
        return $this->app['config']['elasticsearch'];
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->connection(), $method], $parameters);
    }
}
