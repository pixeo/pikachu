<?php

namespace Tests;

use LaravelZero\Framework\Application;
use LaravelZero\Framework\Contracts\Application as ApplicationContract;

trait CreatesApplication
{
    /**
     * Creates the application and returns it.
     *
     * @return \LaravelZero\Framework\Contracts\Application
     */
    public function createApplication()
    {
        return new Application;
    }
}
