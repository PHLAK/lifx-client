<p align="center">
  <img src="lifx-php.png" alt="LIFX Client" width="500">
</p>

<p align="center">
  <a href="https://packagist.org/packages/PHLAK/lifx-client"><img src="https://img.shields.io/packagist/v/PHLAK/lifx-client.svg" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/PHLAK/lifx-client"><img src="https://img.shields.io/packagist/dt/PHLAK/lifx-client.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/PHLAK/lifx-client"><img src="https://img.shields.io/packagist/l/PHLAK/lifx-client.svg" alt="License"></a>
  <a href="https://travis-ci.org/PHLAK/lifx-client"><img src="https://img.shields.io/travis/PHLAK/lifx-client.svg" alt="Build Status"></a>
  <a href="https://styleci.io/repos/82958655"><img src="https://styleci.io/repos/82958655/shield?branch=master&style=flat" alt="StyleCI"></a>
  <br>
  <a href="https://join.slack.com/t/phlaknet/shared_invite/enQtNzk0ODkwMDA2MDg0LWI4NDAyZGRlMWEyMWNhZmJmZjgzM2Y2YTdhNmZlYzc3OGNjZWU5MDNkMTcwMWQ5OGI5ODFmMjI5OWVkZTliN2M"><img src="https://img.shields.io/badge/Join_our-Slack-611f69.svg" alt="Join our"></a>
  <a href="https://github.com/users/PHLAK/sponsorship"><img src="https://img.shields.io/badge/Become_a-Sponsor-cc4195.svg" alt="Become a Sponsor"></a>
  <a href="https://patreon.com/PHLAK"><img src="https://img.shields.io/badge/Become_a-Patron-e7513b.svg" alt="Become a Patron"></a>
  <a href="https://paypal.me/ChrisKankiewicz"><img src="https://img.shields.io/badge/Make_a-Donation-006bb6.svg" alt="One-time Donation"></a>
</p>

<p align="center">
   PHP client library for the LIFX API (v1) -- by,
   <a href="https://www.ChrisKankiewicz.com">Chris Kankiewicz</a> (<a href="https://twitter.com/PHLAK">@PHLAK</a>)
</p>

Introduction
------------

LIFX Client is a LIFX API client library for PHP built with GuzzleHttp.

Refer to the full [LIFX API documentation](https://api.developer.lifx.com)
for more information about each method and it's available parameters.

Requirements
------------

  - [PHP](https://php.net) >= 7.1

Install with Composer
---------------------

```bash
composer require phlak/lifx-client
```

Initializing the Client
-----------------------

First, import LIFX:

```php
use PHLAK\LIFX;
```

Then instantiate the class with your LIFX OAuth 2 access token. You can generate
an access token from your [account settings](https://cloud.lifx.com/settings)
page:

```php
$lifx = new LIFX\Client('YOUR_APP_TOKEN');
```

Usage
-----

List one or more lights via a selector:

```php
$lifx->listLights($selector = 'all');
```

Set the state of one or more lights via a selector:

```php
$lifx->setState($selector, array $params);
```

Set multiple states across multiple selectors:

```php
$lifx->setStates(array $states, array $defaults = []);
```

Toggle the power of one or more lights via a selector:

```php
$lifx->togglePower($selector, $duration = 1);
```

Cause one or more lights to breathe via a selector:

```php
$lifx->breatheEffect($selector, $color, array $params = []);
```

Cause one or more lights to pulse via a selector:

```php
$lifx->pulseEffect($selector, $color, array $params = []);
```

Make the light(s) cycle to the next or previous state in a list of states:

```php
$lifx->cycle($selector, array $states, array $params = []);
```

Get a list of available scenes:

```php
$lifx->listScenes();
```

Activate a scene:

```php
$lifx->activateScene($sceneUuid, $duration = 1.0);
```

Validate a color string:

```php
$lifx->validateColor($string);
```

Handling Exceptions
-------------------

```php
use GuzzleHttp\Exception\ClientException;

try {
    $lifx->togglePower('id:123456789abcd');
} catch (ClientException $exception) {
    // Handle this exception here...
}
```

See the [GuzzleHttp exceptions](http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions)
documentation for more details.

Changelog
---------

A list of changes can be found on the [GitHub Releases](https://github.com/PHLAK/lifx-client/releases) page.

Troubleshooting
---------------

For general help and support join our [Slack Workspace](https://join.slack.com/t/phlaknet/shared_invite/enQtNzk0ODkwMDA2MDg0LWI4NDAyZGRlMWEyMWNhZmJmZjgzM2Y2YTdhNmZlYzc3OGNjZWU5MDNkMTcwMWQ5OGI5ODFmMjI5OWVkZTliN2M).

Please report bugs to the [GitHub Issue Tracker](https://github.com/PHLAK/lifx-client/issues).

Copyright
---------

This project is licensed under the [MIT License](https://github.com/PHLAK/lifx-client/blob/master/LICENSE).
