<?php

namespace artbit;
require_once __DIR__ . '/../src/pubsub.php';

/**
 * PubSubTest
 */
class PubSubTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers \artbit\PubSub::subscribe
     * @covers \artbit\PubSub::publish
     */
    public function test_pubsub_subscribe() {
        $eventname = __FUNCTION__;
        $count_callbacks = 0;
        $callback = function($eventname) use(&$count_callbacks) { $count_callbacks++; };

        // Subscribe 
        $num_subscribers = 4;
        for ($i = 0; $i<$num_subscribers; $i++) {
            PubSub::subscribe($eventname, $callback);
        }
        PubSub::subscribe("{$eventname}.other", $callback);

        $count_callbacks = 0;
        PubSub::publish($eventname);
        $this->assertEquals($num_subscribers, $count_callbacks, "Callback should have ran $num_subscribers times");

        $count_callbacks = 0;
        PubSub::publish("{$eventname}.other");
        $this->assertEquals(1, $count_callbacks, 'Other callback should have been triggered');
    }

    /**
     * @expectedException \Exception
     * @covers \artbit\PubSub::subscribe
     */
    public function test_invalid_callback() {
        $eventname = __FUNCTION__;
        PubSub::subscribe($eventname, 1);
    }

    /**
     * @covers \artbit\PubSub::subscribe
     * @covers \artbit\PubSub::unsubscribe
     * @covers \artbit\PubSub::publish
     */
    public function test_pubsub_unsubscribe() {
        $eventname = __FUNCTION__;
        $count_callbacks = 0;
        $callback = function($eventname) use(&$count_callbacks) { $count_callbacks++; };

        // Subscribe 
        $num_subscribers = 4;
        for ($i = 0; $i<$num_subscribers; $i++) {
            PubSub::subscribe($eventname, $callback);
        }
        PubSub::subscribe("{$eventname}.other", $callback);
        PubSub::unsubscribe($eventname, $callback);

        $count_callbacks = 0;
        PubSub::publish($eventname);
        $this->assertEquals(0, $count_callbacks, 'All callbacks should have been unsubscribed');

        PubSub::publish("{$eventname}.other");
        $this->assertEquals(1, $count_callbacks, 'Other callback should not have been unsubscribed');
    }

    /**
     * @covers \artbit\PubSub::subscribe
     * @covers \artbit\PubSub::publish
     */
    public function test_multi() {
        $eventname = __FUNCTION__;
        $counters = array();
        $event_a = "{$eventname}.a";
        $event_b = "{$eventname}.b";
        $event_c = "{$eventname}.c";
        PubSub::subscribe($event_a, function($eventname, $payload) use(&$counters, $event_a) { $counters[$event_a]++; });
        PubSub::subscribe($event_b, function($eventname, $payload) use(&$counters, $event_b) { $counters[$event_b]++; });
        PubSub::subscribe($event_c, function($eventname, $payload) use(&$counters, $event_c) { $counters[$event_c]++; });

        $counters[$event_a] = 0;
        $counters[$event_b] = 0;
        $counters[$event_c] = 0;
        PubSub::publish($event_a);
        $this->assertEquals(1, $counters[$event_a], 'Callback did not execute the correct number of times');
        PubSub::publish($event_a);
        $this->assertEquals(2, $counters[$event_a], 'Callback did not execute the correct number of times');
        PubSub::publish($event_b);
        $this->assertEquals(1, $counters[$event_b], 'Callback did not execute the correct number of times');
        $this->assertEquals(0, $counters[$event_c], 'Event c was not triggered at all and trigger count should be 0');

        PubSub::publish("event_that_nobody_listens_to");
    }

    /**
     * @covers \artbit\PubSub::subscribe
     * @covers \artbit\PubSub::publish
     */
    public function test_complex_callables() {
        $eventname = __FUNCTION__;
        $obj = new DummyCaller();
        PubSub::subscribe($eventname, array($obj, 'callback'));
        PubSub::publish($eventname);
        PubSub::publish($eventname);
        PubSub::publish($eventname);
        $this->assertEquals(3, $obj->counter, 'Callback did not execute the correct numbe of times');
    }

}

class DummyCaller {
    var $counter = 0;
    function callback() {
        $this->counter++;
    }
}

