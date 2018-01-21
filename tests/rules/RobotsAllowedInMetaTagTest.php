<?php

namespace Tests\Rules;

use Tests\BrowserKitTestCase;
use App\Rules\RobotsAllowedInMetaTag;

class RobotsAllowedInMetaTagTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('RobotsAllowedInMetaTagPassed');
        $rule = new RobotsAllowedInMetaTag();
        static::assertTrue($rule->check(...$args));

        $args = $this->createArgumentsFromBlob('RobotsAllowedInMetaTagFailed');
        $rule = new RobotsAllowedInMetaTag();
        static::assertFalse($rule->check(...$args));
    }
}
