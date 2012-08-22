<?php

    namespace ActiveRecord;

    class MultiModel implements \ArrayAccess, \Iterator, \Countable {

        private $container = array();

        public function __construct($array) {
            $this->container = $array;
        }

        public function offsetSet($offset,$value) {

        }

        public function offsetExists($offset) {
            return isset($this->container[$offset]);
        }

        public function offsetUnset($offset) {
            unset($this->container[$offset]);
        }

        public function offsetGet($offset) {
            return isset($this->container[$offset]) ? $this->container[$offset] : null;
        }

        public function rewind() {
            reset($this->container);
        }

        public function current() {
            return current($this->container);
        }

        public function key() {
            return key($this->container);
        }

        public function next() {
            return next($this->container);
        }

        public function valid() {
            return $this->current() !== false;
        }

        public function count() {
            return count($this->container);
        }

        /**
         * Prepare
         * @author      prepares data to be put in a template
         *
         * @description takes the object data and puts it into an array
         *
         */
        public function prepare()
        {

            $return_array = array();
            foreach ($this as $object) {
                $return_array[] = $object->attributes();
            }

            return $return_array;
        }

    }
