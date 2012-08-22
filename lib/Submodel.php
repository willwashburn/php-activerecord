<?php

    namespace ActiveRecord;
 /**
     * Submodel
     * @author          Will
     * @description     Submodels support for the breaking up of large models.
     *                  Submodels go in a dir named after parent in models dir
     *                  filename is {submodel}.submodel.php
     */
    class Submodel
    {
        public $parent;

        /**
         * Construct
         * @author          Will
         * @description     Takes the this reference and puts it as parent
         */
        public function __construct($_this)
        {
            $this->parent = $_this;

        }


        /**
         * Magic Getter for submodel
         * @param $name
         * @return mixed
         */
        public function &__get($name)
        {

            // check for getter
            if (method_exists($this, "get_$name")) {
                $name  = "get_$name";
                $value = $this->$name();
                return $value;
            } else {
                return $this->$name;
            }
        }
    }