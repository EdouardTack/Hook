<?php

namespace EdouardTack\Hook\Helper;

class HookHelper {

    /**
     * Transforms a camelCasedString to an under_scored_one
     *
     * @param string $cameled
     *
     * @return string under_scored_one string
     */
    public static function unCamelize(string $cameled) {
        return implode('_', array_map('strtolower', preg_split('/([A-Z]{1}[^A-Z]*)/', $cameled, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY)));
    }

    /**
     * Transforms an under_scored_string to a camelCasedOne
     *
     * @param string $cameled
     *
     * @return string camelCasedOne string
     */
    public static function camelize(string $cameled) {
        return lcfirst(implode('', array_map('ucfirst', array_map('strtolower', explode('_', $cameled)))));
    }

}
