<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Pocket;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class PocketTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Pocket::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = Pocket::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://getpocket.com/edit?url=https://mysite.com&title=Default+share+text';

        $this->assertEquals($expected, $result->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = Pocket::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://getpocket.com/edit?url=https://mysite.com&title=Title';

        $this->assertEquals($expected, $result->getUrl());
    }
}
