<?php

    namespace ActiveRecord;

    class MultiModel implements \ArrayAccess, \Iterator, \Countable
    {

        protected $container = array(); //, $dont_prepare_these_ids = array();

        /**
         * Construct
         * @author      Will
         * @description If there is nothing in array, make it an empty object
         * @param $array
         */
        public function __construct($array)
        {
            if (is_array($array)) {
                $this->container = $array;
            }

        }


        /**
         * @author          Will
         * @description     test if the container is empty or not
         *                  also did opposite just for clarity
         * @return bool
         */
        public function is_empty()
        {
            if (empty($this->container)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        /**
         * @author          Will
         * @description     test if the container is empty or not
         *                  also did opposite just for clarity
         * @return bool
         */
        public function is_not_empty()
        {
            if ($this->is_empty()) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        /**
         * Add Object to data array
         * @author Will
         * @param $model
         */
        public function add_object($model)
        {
            if (!is_array($this->container)) {
                $this->container = array();
            }

            $this->container[] = $model;

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
                if (!in_array($object->id, $this->dont_prepare_these_ids)) {
                    $return_array[] = $object->attributes();
                }
            }

            return $return_array;
        }

        /**
         * Dont show when prepared
         * @author      Will
         * @description Removes given id from prepare statement
         *
         */
        public function hide($id)
        {
            $this->lazy_load_dont_prepare_list();
            $this->dont_prepare_these_ids[$id] = $id;
        }

        /**
         * Show when prepared
         * @author      Will
         * @description Removes given id from prepare statement
         *
         */
        public function show($id)
        {
            if (isset($this->dont_prepare_these_ids)) {
                if (array_key_exists($id, $this->dont_prepare_these_ids)) {
                    unset($this->dont_prepare_these_ids[$id]);
                }
            }
        }

        /**
         * Lazy Load
         * @author Will
         */
        private function lazy_load_dont_prepare_list()
        {
            if (!isset($this->dont_prepare_these_ids)) {
                $this->dont_prepare_these_ids = array();
            }
        }

        /**
         * Recreate ArrayObject
         * @author Will
         */
        public function offsetSet($offset, $value)
        {

        }

        public function offsetExists($offset)
        {
            return isset($this->container[$offset]);
        }

        public function offsetUnset($offset)
        {
            unset($this->container[$offset]);
        }

        public function offsetGet($offset)
        {
            return isset($this->container[$offset]) ? $this->container[$offset] : NULL;
        }

        public function rewind()
        {
            reset($this->container);
        }

        public function current()
        {
            return current($this->container);
        }

        public function key()
        {
            return key($this->container);
        }

        public function next()
        {
            return next($this->container);
        }

        public function valid()
        {
            return $this->current() !== FALSE;
        }

        public function count()
        {
            return count($this->container);
        }

        /**
         * @author             Will
         * @description        creates a htmlstrap table from the object
         *
         * @retrun             \htmlstrap\table
         */
        public function tableize()
        {
            $complete_array = array();

            foreach ($this->container as $model) {

                $complete_array[] = $model->attributes_using_getters();

            }

            return new \htmlstrap\table($complete_array);
        }


    }
