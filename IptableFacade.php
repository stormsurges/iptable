<?php

namespace Surges\Iptable;

use Illuminate\Support\Facades\Facade;

class IptableFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Iptable';
    }
}
