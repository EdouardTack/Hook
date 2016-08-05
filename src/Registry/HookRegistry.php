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
    private $registerHooks = [];

    /**
     * Registered Hook
     * @var array
     */
    private $registerArgs = [];

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
     * Look for the function to call
     * when we call {HOOK}->TYPE();
     *
     * @param string $name Unique name of the HOOK
     * @param string $arguments Parameters send
     *
     * @return array What we have to execute
     */
    public function __call(string $name, array $arguments) {
        list($get, $type, $name) = explode('_', $name);
        $name = strtolower($name);

        if (!in_array(strtolower($type), $this->getTypes()))
            throw new UnavailableHookException("Type : " . $type . " is not availble. Types available are " . implode(', ', $this->getTypes()));

        $type = HookHelper::camelize(HookHelper::unCamelize($type));

        if (isset($this->registerHooks[$type][$name]))
            return $this->registerHooks[$type][$name];
        else
            return false;
    }

    /**
     * Add a new Hook on register Type
     *
     * @throws UnavailableHookException if the type isn't a string
     * @param string $registerName
     * @param string $name
     * @param array $callback
     * @param int $priority
     *
     * @return void
     */
    public function set(string $registerName, string $name, array $callback, int $priority) {
        if (in_array(strtolower($registerName), $this->getTypes()))
            $this->registerHooks[$registerName][$name][$priority][] = $callback;
        else
            throw new UnavailableHookException("Type : " . $registerName . " is not availble. Types available are " . implode(', ', $this->getTypes()));
    }

    /**
     * Different type of register hooks
     *
     * @param string $name Optional, filter on one type name
     *
     * @return mixed Array of type or filter type
     */
    public function getTypes(string $name = null) {
        if (is_null($name))
            return $this->_types;

        $key = array_search(strtolower($name), $this->_types);

        if ($key !== false)
            return $this->_types[$key];
        else
          return null;
    }

    /**
     * To register new type
     *
     * @throws UnavailableHookException if the type isn't a string
     * @throws UnavailableHookException if the type is register
     * @param string $name The new name type
     *
     * @return void
     */
    public function setType(string $name) {
        if (!is_string($name))
            throw new UnavailableHookException("Type : " . $name . " must be a string !");

        if ($this->getTypes($name))
            throw new UnavailableHookException("Type : " . $name . " already register !");

        $this->_types[] = strtolower($name);
    }

    /**
     * Add in array the arguments of hook
     *
     * @param array $arguments
     * @param string $type
     * @param string $name
     *
     * @return void
     */
    public function setRegisterArguments(array $arguments, string $type, string $name) {
        $this->registerArgs[$type][$name] = $arguments;
    }

    /**
     * Get the arguments of hook
     *
     * @param string $type
     * @param string $name
     *
     * @return string
     */
    public function getRegisterArguments(string $type, string $name) {
        return $this->registerArgs[$type][$name];
    }

}
