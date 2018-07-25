# PubSub
[![Build Status](https://travis-ci.org/ArtBIT/PubSub.svg?branch=master)](https://travis-ci.org/ArtBIT/PubSub) [![GitHub license](https://img.shields.io/github/license/ArtBIT/PubSub.svg)](https://github.com/ArtBIT/PubSub) [![GitHub stars](https://img.shields.io/github/stars/ArtBIT/PubSub.svg)](https://github.com/ArtBIT/PubSub)  [![awesomeness](https://img.shields.io/badge/awesomeness-maximum-red.svg)](https://github.com/ArtBIT/PubSub)

PubSub design pattern implemented in PHP

# Usage
Subscribe to an event:
```php
PubSub::subscribe("my.event", function($eventname, $payload) {
    print_r(func_get_args());
});
```

Trigger an event:
```php
PubSub::publish("my.event", ["type" => "sometype", "value" => "somevalue"]);
// This should result in
```

# License

[MIT](LICENSE)
