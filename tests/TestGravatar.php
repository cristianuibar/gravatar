<?php

use Uibar\Gravatar\Gravatar;
use Uibar\Gravatar\Facades\Gravatar as GravatarStatic;

class TestGravatar extends \PHPUnit_Framework_TestCase
{
    public function testGravatarGetFunction()
    {
        $gravatar = new Gravatar();

        $url = $gravatar->get('test@email.com');

        $this->assertNotEmpty($url);
    }

    public function testMethodChaining()
    {
        GravatarStatic::shouldReceive('email')->once()->andReturnSelf();
    }
}