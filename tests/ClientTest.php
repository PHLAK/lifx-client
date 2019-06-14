<?php

use PHLAK\LIFX\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    protected $lifx;

    protected function setUp()
    {
        $this->lifx = new Client('NOT_A_REAL_APP_TOKEN');
    }

    public function test_is_instance_of_lifx_client_object()
    {
        $this->assertInstanceOf(Client::class, $this->lifx);
    }
}
