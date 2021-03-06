<?php
namespace Zwen\EsOrm\Support\Facades;

use Illuminate\Support\Facades\Facade;

class ES extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'es';
    }
}
