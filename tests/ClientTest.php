<?php

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function test_it_is_instance_of_lifx_client_object()
    {
        $lifx = new LIFX\Client('NOT_A_REAL_APP_TOKEN');

        $this->assertInstanceOf('LIFX\Client', $lifx);
    }

    public function test_it_cant_be_initialized_without_an_app_token()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');

        $lifx = new LIFX\Client();
    }
}
