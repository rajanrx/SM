<?php

namespace SM\Unit\Lib\Config;

use PHPUnit\Framework\TestCase;
use SM\Lib\Config\Config;

class ConfigTest extends TestCase
{
    public function testCanLoadConfig()
    {
        $config = Config::get();
        $this->assertNotNull($config);
        $this->assertNotNull($config['params']['movie']);
    }

    public function testCanLoadSpecificParams()
    {
        $config = Config::get('params.movie.filters.next_show_in_seconds');
        $this->assertNotNull($config);
        $this->assertEquals(1800, $config);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Param does not exists
     */
    public function testExceptionIsThrownIfInvalidParamIsPassed()
    {
        $config = Config::get('invalid.param.request');
    }
}
