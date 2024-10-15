<?php

namespace Alsaloul\Taqnyat;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for easy access to the TaqnyatSms class.
 */
class TaqnyatSmsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TaqnyatSms::class;
    }
}
