<?php

namespace EdouardTack\Hook\Helper;

class HookHelper {

    /**
     *
     */
    public static function unCamelize(string $cameled) {
        return implode('_', array_map('strtolower', preg_split('/([A-Z]{1}[^A-Z]*)/', $cameled, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY)));
    }

}
