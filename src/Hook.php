<?php

namespace EdouardTack\Hook;

use Exception;
use EdouardTack\Hook\Exception\UnavailableHookException;
use EdouardTack\Hook\Registry\HookRegistry;
use EdouardTack\Hook\Helper\HookHelper;

/**
 *
 */
class Hook implements HookInterface {

    /**
     * Instance
     * @var \EdouardTack\Hook\Registry\HookRegistry
     */
    protected $_hookRegistry;

    /**
     * Constructor
     * Instanstiate \EdouardTack\Hook\Registry\HookRegistry()
     *
     * @uses \EdouardTack\Hook\Registry\HookRegistry
     *
     * @return void
     */
    public function __construct() {
        $this->_hookRegistry = new HookRegistry();
    }

    /**
     * Call method
     * Call the right method when wa add a new hook or we we call a register hook
     *
     * @param string $name Unique hook name
     * @param array $arguments
     *
     * @return void
     */
    public function __call(string $name, array $arguments) {
        if (preg_match('#^(set)#', $name)) {
            $name = HookHelper::camelize(HookHelper::unCamelize(substr($name, 3)));
            $this->_hookRegistry->set($name, $arguments[0], $arguments[1], $arguments[2]);
        }
        else {
            return $this->_call($name, $arguments);
        }
    }

    /**
     * Add a new Type in Registry
     *
     * @uses \EdouardTack\Hook\Registry\HookRegistry
     * @throws UnavailableHookException
     * @param string $value The new type
     *
     * @return void
     */
    public function addType(string $value) {
        try {
            $this->_hookRegistry->setType($value);
        }
        catch (UnavailableHookException $e) {
            echo $e->getMessage();
        }
    }


    /**
     * Call the different method of a hook type and hook name
     *
     * @uses \EdouardTack\Hook\Registry\HookRegistry
     * @throws UnavailableHookException
     * @param string $type The name of unique hook name by type
     *
     * @return void
     */
    protected function _call(string $type) {
        $args = static::_setArgs(func_get_args());
        $name = $args[0];
        unset($args[0]);

        try {
            if ($registriesHook = $this->_hookRegistry->{'get_' . ucfirst($type) .'_' . ucfirst($name)}()) {
                // Order increasing
                ksort($registriesHook);
                $this->_hookRegistry->setRegisterArguments($args, $type, $name);
                $args = $this->_hookRegistry->getRegisterArguments($type, $name);
                foreach ($registriesHook as $priority => $callbacks) {
                    foreach ($callbacks as $callback) {
                        $args[1] = call_user_func_array($callback, $args);
                        $this->_hookRegistry->setRegisterArguments($args, $type, $name);
                    }
                }

                return $args[1];
            }
        }
        catch (UnavailableHookException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Associate settings with Closure
     *
     * @param array $args List of arguments
     *
     * @return array argumentw sithout first key
     */
    private static function _setArgs(array $args) {
        if (count($args) <= 1)
            return $args;

        $args = current(array_slice($args, 1));

        return $args;
    }

}
