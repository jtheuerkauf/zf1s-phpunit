<?php
/**
 * Sample class that implements ArrayAccess copied from
 * http://www.php.net/manual/en/class.arrayaccess.php
 * with some minor changes
 * This class required for PHPUnit_Framework_Constraint_ArrayHasKey testing
 */

class SampleArrayAccess implements ArrayAccess
{
    private $container;

    public function __construct() {
        $this->container = array();
    }
    #[ReturnTypeWillChange]
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
    #[ReturnTypeWillChange]
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
    #[ReturnTypeWillChange]
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
    #[ReturnTypeWillChange]
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}
