<?php

/*
 * Allow for PHPUnit 4.* while XML_Util is still usable on PHP 5.4
 */
if (!class_exists('PHPUnit_Framework_TestCase')) {
    class PHPUnit_Framework_TestCase extends \PHPUnit\Framework\TestCase {}
}

