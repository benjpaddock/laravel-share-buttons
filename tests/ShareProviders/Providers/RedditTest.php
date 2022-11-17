<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Reddit;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class RedditTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Reddit::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = Reddit::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://www.reddit.com/submit?title=Default+share+text&url=https://mysite.com';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $provider = Reddit::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://www.reddit.com/submit?title=Title&url=https://mysite.com';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
