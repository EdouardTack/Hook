<?php

namespace EdouardTack\Hook\Registry;

use Exception;
use EdouardTack\Hook\Exception\UnavailableHookException;
use EdouardTack\Hook\Helper\HookHelper;

class HookRegistry {

    /**
     * Registered Hook
     * @var array
     */
    public $registerHooks = [];

    /**
     * Availables types
     * Base availables ['action', 'filter']
     * We can add some Hook types with method ******
     * ---- $hook->******()
     *
     * @var array
     */
    private $_types = ['action', 'filter'];

    /**
     *
     */
    public function __call(string $name, array $arguments) {
        list($get, $type, $name) = explode('_', HookHelper::unCamelize($name));

        if (!in_array($type, $this->getTypes()))
            throw new UnavailableHookException("Type : " . $type . " is not availble. Types available are " . implode(', ', $this->getTypes()));

        if (isset($this->registerHooks[$type][$name]))
            return $this->registerHooks[$type][$name];
        else
            return false;
    }

    /**
     *
     */
    public function set(string $registerName, string $name, $callback, int $priority) {
        $this->registerHooks[$registerName][$name][$priority][] = $callback;
    }

    /**
     *
     */
    public function get() {

    }

    /**
     *
     */
    public function getTypes(string $name = null) {
        if (is_null($name))
            return $this->_types;

        return $this->_types[$name];
    }

    /**
     *
     */
    public function setType(string $value) {
        if (!is_string($value))
            throw new UnavailableHookException("Type : " . $value . " must be a string !");

        $this->_types[] = strtolower($value);
    }

}
