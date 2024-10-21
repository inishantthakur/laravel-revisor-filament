<?php

namespace Indra\RevisorFilament\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Indra\RevisorFilament\RevisorFilament
 */
class RevisorFilament extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Indra\RevisorFilament\RevisorFilament::class;
    }
}
