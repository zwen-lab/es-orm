<?php
namespace Zwen\EsOrm;

use Closure;
use Zwen\EsOrm\Query\Builder as QueryBuilder;
use Zwen\EsOrm\Grammars\Grammar;
use Zwen\SqlDsl\EsParser;

class Connection implements ConnectionInterface
{
    /**
     * The active es connection used for search
     *
     * @var
     */
    protected $client;

    /**
     * The database connection configuration options.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Create a new database connection instance..
     *
     * @param $client
     */
    public function __construct($client, array $config = [])
    {
        $this->client = $client;

        $this->config = $config;
    }

    /**
     * Run a select statement against the index.
     *
     * @param array $dsl
     * @return mixed|void
     *
     * @throws \Exception
     */
    public function select(array $dsl)
    {
        try{
            $result = $this->getClient()->search($dsl);
        }catch (\Exception $e){
            //todo

            throw $e;
        }

        return $result;
    }

    /**
     * 设置查询的索引
     *
     * @param string $table
     * @return \Zwen\EsOrm\Query\Builder
     */
    public function table(string $table)
    {
        return $this->query()->from($table);
    }

    /**
     * Get a new query builder instance.
     *
     * @return QueryBuilder
     */
    public function query()
    {
        return new QueryBuilder($this, $this->getQueryGrammar(), $this->getEsParse());
    }

    /**
     * Get the query grammar used by the connection.
     */
    public function getQueryGrammar()
    {
        return new Grammar();
    }

    /**
     * Get a new es parse instance
     */
    public function getEsParse()
    {
        $esVersion = $this->config['version'] ?? '';

        return new EsParser($esVersion);
    }

    /**
     * Get the current es connection.
     *
     * @return
     */
    public function getClient()
    {
        if($this->client instanceof Closure){
            return $this->client = call_user_func($this->client);
        }

        return $this->client;
    }
}
