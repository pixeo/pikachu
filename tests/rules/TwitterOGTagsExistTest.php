<?php

namespace Tests\Rules;

use Tests\BrowserKitTestCase;
use App\Rules\TwitterOGTagsExist;

class TwitterOGTagsExistTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('TwitterOGTagsExistPassed');
        $rule = new TwitterOGTagsExist();
        static::assertTrue($rule->check(...$args));

        $args = $this->createArgumentsFromBlob('TwitterOGTagsExistFailed');
        $rule = new TwitterOGTagsExist();
        static::assertFalse($rule->check(...$args));
    }
}
