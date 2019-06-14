<?php

use PHLAK\LIFX\Client;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class ResoponseTest extends TestCase
{
    protected $lifx;

    protected function setUp()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"response": true}'),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        ]);

        $this->lifx = new Client('NOT_A_REAL_APP_TOKEN', [
            'handler' => HandlerStack::create($mock)
        ]);
    }

    public function test_it_can_list_lights()
    {
        $this->assertTrue($this->lifx->listLights()->response);
        $this->assertNull($this->lifx->listLights());

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->listLights();
    }

    public function test_it_can_set_state()
    {
        $this->assertTrue($this->lifx->setState('id:123456789', ['power' => 'on'])->response);
        $this->assertNull($this->lifx->setState('id:123456789', ['power' => 'on']));

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->setState('id:123456789', ['power' => 'on']);
    }

    public function test_it_can_set_states()
    {
        $this->assertTrue($this->lifx->setStates([
            ['selector' => 'id:123456789', 'power' => 'on'],
            ['selector' => 'id:987654321', 'power' => 'on']
        ])->response);

        $this->lifx->setStates([
            ['selector' => 'id:123456789', 'power' => 'on'],
            ['selector' => 'id:987654321', 'power' => 'on']
        ]);

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->setStates([
            ['selector' => 'id:123456789', 'power' => 'on'],
            ['selector' => 'id:987654321', 'power' => 'on']
        ]);
    }

    public function test_it_can_toggle_power()
    {
        $this->assertTrue($this->lifx->togglePower('id:123456789')->response);
        $this->assertNull($this->lifx->togglePower('id:123456789'));

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->togglePower('id:123456789');
    }

    public function test_it_can_breathe_effect()
    {
        $this->assertTrue($this->lifx->breatheEffect('id:123456789', 'purple')->response);
        $this->assertNull($this->lifx->breatheEffect('id:123456789', 'purple'));

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->breatheEffect('id:123456789', 'purple');
    }

    public function test_it_can_pulse_effect()
    {
        $this->assertTrue($this->lifx->pulseEffect('id:123456789', 'purple')->response);
        $this->assertNull($this->lifx->pulseEffect('id:123456789', 'purple'));

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->pulseEffect('id:123456789', 'purple');
    }

    public function test_it_can_cycle()
    {
        $this->assertTrue($this->lifx->cycle('id:123456789', [
            ['power' => 'on'],
            ['power' => 'off']
        ])->response);

        $this->assertNull($this->lifx->cycle('id:123456789', [
            ['power' => 'on'],
            ['power' => 'off']
        ]));

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->cycle('id:123456789', [
            ['power' => 'on'],
            ['power' => 'off']
        ]);
    }

    public function test_it_can_list_scenes()
    {
        $this->assertTrue($this->lifx->listScenes()->response);
        $this->assertNull($this->lifx->listScenes());

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->listScenes();
    }

    public function test_it_can_activate_a_scene()
    {
        $this->assertTrue($this->lifx->activateScene('55a0db9d-3ea7-4973-9b15-b149215bd4db')->response);
        $this->assertNull($this->lifx->activateScene('55a0db9d-3ea7-4973-9b15-b149215bd4db'));

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->activateScene('55a0db9d-3ea7-4973-9b15-b149215bd4db');
    }

    public function test_it_can_validate_a_color()
    {
        $this->assertTrue($this->lifx->validateColor('purple')->response);
        $this->assertNull($this->lifx->validateColor('purple'));

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $this->lifx->validateColor('purple');
    }
}
