<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppTest extends TestCase
{
    public function testStart()
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function testFirstLocalePage()
    {
        $response = $this->get('/en');

        $response->assertOk();
        $this->assertEquals('en', app()->getLocale());
    }

    public function testSecondLocalePage()
    {
        $response = $this->get('/pl');

        $response->assertOk();
        $this->assertEquals('pl', app()->getLocale());
    }

    public function testAboutPage()
    {
        $response = $this->get(route('about', app()->getLocale()));

        $response->assertOk();
    }

    public function testPrivacyPolicyPage()
    {
        $response = $this->get(route('privacy-policy', app()->getLocale()));

        $response->assertOk();
    }
}
