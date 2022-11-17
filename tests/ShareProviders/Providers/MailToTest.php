<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\MailTo;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class MailToTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = MailTo::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'mailto:?subject=Default+share+text&body=https://mysite.com';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $provider = MailTo::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'mailto:?subject=Title&body=https://mysite.com';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
