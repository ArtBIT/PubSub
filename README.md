# PubSub
[![Build Status](https://travis-ci.org/ArtBIT/PubSub.svg?branch=master)](https://travis-ci.org/ArtBIT/PubSub) [![GitHub license](https://img.shields.io/github/license/ArtBIT/PubSub.svg)](https://github.com/ArtBIT/PubSub) [![GitHub stars](https://img.shields.io/github/stars/ArtBIT/PubSub.svg)](https://github.com/ArtBIT/PubSub)  [![awesomeness](https://img.shields.io/badge/awesomeness-maximum-red.svg)](https://github.com/ArtBIT/PubSub)

PubSub design pattern implemented in PHP

# Example Usage
```php
<?php

require_once(__DIR__ . '/src/pubsub.php');
use \artbit\PubSub;

// Subscribe to an event:
PubSub::subscribe("my.event", function($eventname, $payload) {
    print_r(func_get_args());
});

// Trigger an event:
PubSub::publish("my.event", ["type" => "sometype", "value" => "somevalue"]);

// This should result in
// Array
// (
//     [0] => my.event
//     [1] => Array
//         (
//             [type] => sometype
//             [value] => somevalue
//         )
// 
// )
// 
```

# License

[MIT](LICENSE)
