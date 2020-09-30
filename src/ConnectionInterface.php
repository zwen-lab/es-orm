<?php
namespace Zwen\EsOrm;

interface ConnectionInterface
{
    /**
     * 查询的index和type
     *
     * @return mixed
     */
    public function table(string $table);

    /**
     * Run a select statement against the index.
     *
     * @param array $dsl
     * @return mixed
     */
    public function select(array $dsl);
}
