<?php

namespace UKAddressFinder;

trait UAF_Singleton {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct() {}
    private function __clone() {}

    // Change visibility to public
    public function __wakeup() {}
}
