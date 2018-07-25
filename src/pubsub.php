<?php
    
namespace artbit;

class PubSub {
    private static $subscriptions = array();

    /**
     * Adds a a new subscription callback to the stack
     *
     * @param string   $eventname
     * @param mixed $callback
     * @return void
     */
    public static function subscribe($eventname, $callback) {
        if (is_callable($callback)) {
            if (!array_key_exists($eventname, self::$subscriptions)) {
                self::$subscriptions[$eventname] = array();
            }
            self::$subscriptions[$eventname][] = $callback;
        } else {
            $classname = __CLASS__;
            throw new \Exception("[$classname] is_callable should return true for \$callback");
        }
    }

    /**
     * Publish a new PubSub event
     *
     * @param string $eventname
     * @param array $payload
     * @return boolean false on error
     */
    public static function publish($eventname, $payload = array() ) {
        if (!array_key_exists($eventname, self::$subscriptions)) {
            // no subsribers
            return false;
        }
        // Notify all the subscribers
        foreach (self::$subscriptions[$eventname] as $callback) {
            call_user_func_array($callback, [$eventname, $payload]);
        }
    }

    /**
     * Unsubscribe from listening to an event
     *
     * @param string $eventname
     * @param mixed $callback
     * @return void
     */
    public static function unsubscribe($eventname, $callback) {
        if (is_callable($callback)) {
            if (array_key_exists($eventname, self::$subscriptions)) {
                $index = count(self::$subscriptions[$eventname]);
                while ($index--) {
                    $value = self::$subscriptions[$eventname][$index];
                    if ($value === $callback) {
                        array_splice(self::$subscriptions[$eventname], $index, 1);
                    }
                }
            }
        }
    }

    /**
     * Protected constructor to prevent creating a new instance via the `new` operator
     */
    protected function __construct() { }

    /**
     * Private clone method to prevent cloning of the instance
     */
    private function __clone() { }

}

?>
