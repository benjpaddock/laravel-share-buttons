<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Evernote;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class EvernoteTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Evernote::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = Evernote::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://www.evernote.com/clip.action?url=https://mysite.com&t=Default+share+text';

        $this->assertEquals($expected, $result->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = Evernote::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://www.evernote.com/clip.action?url=https://mysite.com&t=Title';

        $this->assertEquals($expected, $result->getUrl());
    }
}
