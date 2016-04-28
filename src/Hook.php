<?php

namespace EdouardTack\Hook;

use Exception;
use EdouardTack\Hook\Exception\UnavailableHookException;
use EdouardTack\Hook\Registry\HookRegistry;

/**
 *
 */
class Hook implements HookInterface {

    /**
     *
     * @var \EdouardTack\Hook\Registry\HookRegistry
     */
    protected $_registry;

    /**
     *
     */
    public function __construct() {
        $this->_registry = new HookRegistry();
    }

    /**
     *
     */
    public function __call(string $name, array $arguments) {
        if (preg_match('#^(set)#', $name)) {
            $name = strtolower(substr($name, 3));
            $this->_registry->set($name, $arguments[0], $arguments[1], $arguments[2]);
        }
        else {
            $this->_set($name, $arguments);
        }
    }

    /**
     *
     * @throws \Exception
     */
    public function get(string $type, string $name) {
        if (!in_array($type, $this->getTypes()))
            throw new \Exception("Type : " . $type . " is not availble. Types available are " . implode(', ', $this->getTypes()));

        $this->{$type}($name);
    }

    /**
     *
     */
    public function addType(string $value) {
        try {
            $this->_registry->setType($value);
        }
        catch (UnavailableHookException $e) {
            echo $e->getMessage();
        }
    }


    /**
     *
     */
    protected function _set(string $type) {
        $args = static::_setArgs(func_get_args());
        $name = $args[0];
        unset($args[0]);
        try {
            if ($registriesHook = $this->_registry->{'get' . ucfirst($type) . ucfirst($name)}()) {
                // Order increasing
                ksort($registriesHook);
                foreach ($registriesHook as $priority => $callbacks) {
                    foreach ($callbacks as $callback) {
                        return call_user_func_array($callback, $args);
                    }
                }
            }
        }
        catch (UnavailableHookException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Associate settings with Closure
     *
     * @param array
     *
     * @return array
     */
    private static function _setArgs(array $args) {
        if (count($args) <= 1)
            return $args;

        $args = current(array_slice($args, 1));

        return $args;
    }

}
