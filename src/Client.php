<?php

namespace PHLAK\LIFX;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /** @const LIFX API base URI */
    const BASE_URI = 'https://api.lifx.com';

    /** @const API_VERSION LIFX API version */
    const API_VERSION = 'v1';

    /** @var object Instance of GuzzleHttp\Client object */
    protected $client;

    /**
     * LIFX\Client constructor method, runs on object creation.
     *
     * @param string $appToken LIFX OAuth2 access token. You can generate your
     *                         own token at https://cloud.lifx.com/settings
     * @param array  $options  Array of Guzzle HTTP client options
     */
    public function __construct(string $appToken, array $options = [])
    {
        $this->client = new GuzzleClient(array_merge_recursive([
            'base_uri' => self::BASE_URI . '/' . self::API_VERSION . '/',
            'headers' => [
                'Authorization' => 'Bearer ' . $appToken
            ]
        ], $options));
    }

    /**
     * List one or more lights via a selector.
     *
     * @param string $selector The selector to limit which light information is
     *                         returned (default: all)
     *
     * @return array Array of decoded JSON objects
     */
    public function listLights(string $selector = 'all')
    {
        $response = $this->client->get('lights/' . $selector);

        return json_decode($response->getBody());
    }

    /**
     * Set the state of one or more lights via a selector.
     *
     * @param string $selector The selector to limit which lights are
     *                         controlled
     * @param array  $params   Array of one or more parameters:
     *                         - power (string): 'on' or 'off'
     *                         - color (string): The color to set the light to
     *                         - brightness (float): Brightness [0.0 - 1.0]
     *                         - duration (float): Time in seconds the power
     *                         action will take [0 - 3155760000] (default: 1.0)
     *                         - infrared (float): The brightness of the
     *                         infrared channel [0.0 - 1.0]
     *
     * @return array Array of decoded JSON objects
     */
    public function setState(string $selector, array $params)
    {
        $response = $this->client->put('lights/' . $selector . '/state', [
            'json' => $params
        ]);

        return json_decode($response->getBody());
    }

    /**
     * Set multiple states across multiple selectors.
     *
     * @param array $states   Array of state hashes as per Set State (no more
     *                        than 50 entries)
     * @param array $defaults Optional array of default values to use when not
     *                        specified in each states[] object
     *
     * @return object Decoded JSON object
     */
    public function setStates(array $states, array $defaults = [])
    {
        $response = $this->client->put('lights/states', [
            'json' => [
                'states' => $states,
                'defaults' => $defaults
            ]
        ]);

        return json_decode($response->getBody());
    }

    /**
     * Toggle the power of one or more lights via a selector.
     *
     * @param string $selector The selector to limit which lights are toggled
     * @param int    $duration Time in seconds to spend performing the toggle
     *                         (default: 1)
     *
     * @return object Decoded JSON object
     */
    public function togglePower(string $selector, int $duration = 1)
    {
        $response = $this->client->post('lights/' . $selector . '/toggle', [
            'json' => [
                'duration' => $duration
            ]
        ]);

        return json_decode($response->getBody());
    }

    /**
     * Cause one or more lights to breathe via a selector.
     *
     * @param string $selector The selector to limit which lights will run
     *                         the effect
     * @param string $color    The color to use for the breathe effect
     * @param array  $params   Array of optional parameters:
     *                         - from_color (string): The color to start the
     *                         effect from (default: current bulb color)
     *                         - period (float): Time in seconds for one cycle
     *                         of the effect (default: 1.0)
     *                         - cycles (float): Number of times to repeat the
     *                         effect (default: 1.0)
     *                         - persist (bool): If false set the light back to
     *                         its previous value when effect ends, if true
     *                         leave the last effect color (default: false)
     *                         - power_on (bool): If true, turn the bulb on
     *                         if it is not already on (default: true)
     *                         - peak (float): Where in a period the color is at
     *                         its maximum [0.0 - 1.0] (default: 0.5)
     *
     * @return object Decoded JSON object
     */
    public function breatheEffect(string $selector, string $color, array $params = [])
    {
        $response = $this->client->post('lights/' . $selector . '/effects/breathe', [
            'json' => array_merge($params, [
                'color' => $color
            ])
        ]);

        return json_decode($response->getBody());
    }

    /**
     * Cause one or more lights to pulse via a selector.
     *
     * @param string $selector The selector to limit which lights will run
     *                         the effect
     * @param string $color    The color to use for the pulse effect
     * @param array  $params   Array of optional parameters:
     *                         - from_color (string): The color to start the
     *                         effect from (default: current bulb color)
     *                         - period (float): Time in seconds for one cycle
     *                         of the effect (default: 1.0)
     *                         - cycles (float): Number of times to repeat the
     *                         effect (default: 1.0)
     *                         - persist (bool): If false set the light back to
     *                         its previous value when effect ends, if true
     *                         leave the last effect color (default: false)
     *                         - power_on (bool): If true, turn the bulb on
     *                         if it is not already on (default: true)
     *
     * @return object Decoded JSON object
     */
    public function pulseEffect(string $selector, string $color, array $params = [])
    {
        $response = $this->client->post('lights/' . $selector . '/effects/pulse', [
            'json' => array_merge($params, [
                'color' => $color
            ])
        ]);

        return json_decode($response->getBody());
    }

    /**
     * Make the light(s) cycle to the next or previous state in a list of states.
     *
     * @param string $selector Selector to limit which lights are controlled
     * @param array  $states   Array of state hashes as per Set State (requires
     *                         2 to 5 entries)
     * @param array  $params   Array of optional parameters:
     *                         - defaults (array): Default values to use when
     *                         not specified in each states[] object
     *                         - direction (string): Direction in which to cycle
     *                         through the list. Can be 'forward' or 'backward'
     *                         (default: forward)
     *
     * @return object Decoded JSON object
     */
    public function cycle(string $selector, array $states, array $params = [])
    {
        $response = $this->client->post('lights/' . $selector . '/cycle', [
            'json' => array_merge($params, [
                'states' => $states
            ])
        ]);

        return json_decode($response->getBody());
    }

    /**
     * Get a list of available scenes.
     *
     * @return object Decoded JSON object
     */
    public function listScenes()
    {
        $response = $this->client->get('scenes');

        return json_decode($response->getBody());
    }

    /**
     * Activate a scene.
     *
     * @param string $sceneUuid The UUID for the scene you wish to activate
     * @param float  $duration  The time in seconds to spend performing the
     *                          scene transition (default: 1.0)
     *
     * @return object Decoded JSON object
     */
    public function activateScene(string $sceneUuid, float $duration = 1.0)
    {
        $response = $this->client->put('scenes/scene_id:' . $sceneUuid . '/activate', [
            'json' => ['duration' => $duration]
        ]);

        return json_decode($response->getBody());
    }

    /**
     * Validate a color string.
     *
     * @param string $string Color string to validate
     *
     * @return object Decoded JSON object
     */
    public function validateColor(string $string)
    {
        $response = $this->client->get('color', [
            'query' => ['string' => $string]
        ]);

        return json_decode($response->getBody());
    }
}
