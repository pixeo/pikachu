<?php

namespace Tests\Rules;

use Tests\BrowserKitTestCase;
use App\Rules\MetaDescriptionExists;

class MetaDescriptionExistsTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('MetaDescriptionExistsPassed');
        $rule = new MetaDescriptionExists();
        static::assertTrue($rule->check(...$args));
        static::assertEquals('A foo walks into a bar.', $rule->getDescription());

        $args = $this->createArgumentsFromBlob('MetaDescriptionExistsFailed');
        $rule = new MetaDescriptionExists();
        static::assertFalse($rule->check(...$args));
    }
}
