<?php

declare(strict_types=1);

namespace Tests;

class DefaultTest extends BaseTestCase
{
    /**
     * Test that default endpoint show a help.
     */
    public function testApiHelp(): void
    {
        $response = $this->runApp('GET', '/');
        $result = (string) $response->getBody();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('endpoints', $result);
        $this->assertStringContainsString('Vehicles', $result);
        $this->assertStringContainsString('Starships', $result);
        $this->assertStringContainsString('time', $result);
        $this->assertStringContainsString('help', $result);
        $this->assertStringNotContainsString('error', $result);
        $this->assertStringNotContainsString('Failed', $result);
    }

    /**
     * Test Route Not Found.
     */
    public function testRouteNotFound(): void
    {
        $response = $this->runApp('GET', '/route-not-found');
        $result = (string) $response->getBody();
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('Page Not Found', $result);
        
    }
}