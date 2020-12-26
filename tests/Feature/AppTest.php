<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppTest extends TestCase
{
    public function testStart()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testFirstLocalePage()
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
        $this->assertEquals(app()->getLocale(), 'en');
    }

    public function testSecondLocalePage()
    {
        $response = $this->get('/pl');

        $response->assertStatus(200);
        $this->assertEquals(app()->getLocale(), 'pl');
    }

    public function testAboutPage()
    {
        $response = $this->get(route('about', app()->getLocale()));

        $response->assertStatus(200);
    }

    public function testPrivacyPolicyPage()
    {
        $response = $this->get(route('privacy-policy', app()->getLocale()));

        $response->assertStatus(200);
    }
}
