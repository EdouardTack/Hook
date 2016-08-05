<?php

namespace EdouardTack\Hook\Exception;

use Exception;

class UnavailableHookException extends Exception {

    /**
     * Constructor.
     *
     * @param string $message The error message
     * @param int $code The code of the error, is also the HTTP status code for the error.
     * @param \Exception|null $previous the previous exception.
     */
    public function __construct(string $message, int $code = 0, Exception $previous = null) {
        parent::__construct('HOOK ERROR, message : "' . $message . '"', $code, $previous);
    }

}
