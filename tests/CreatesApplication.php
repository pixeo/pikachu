<?php

namespace Tests;

use LaravelZero\Framework\Application;

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
