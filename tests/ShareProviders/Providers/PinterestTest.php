<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Pinterest;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class PinterestTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = new Pinterest();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_pinterest_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://pinterest.com/pin/create/button/?url=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
