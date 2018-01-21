<?php

namespace Tests\Rules;

use App\Facades\RobotsFile;
use Tests\BrowserKitTestCase;
use App\Rules\RobotsAllowedInTxt;

class RobotsAllowedInTxtTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        RobotsFile::setContent('');
        $rule = new RobotsAllowedInTxt();
        $args = $this->createArgumentsFromMessage('PlainResponse');
        static::assertTrue($rule->check(...$args));

        RobotsFile::setContent('
 User-Agent: *
 Disallow: /
');
        $rule = new RobotsAllowedInTxt();
        static::assertFalse($rule->check(...$args));
    }
}
