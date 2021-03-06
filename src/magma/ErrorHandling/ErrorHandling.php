<?php

declare(strict_types=1);

namespace Magma\ErrorHandling;

use ErrorException;
use Magma\Base\BaseView;

class ErrorHandling {

    /**
     * Error Handler. Covert all errors to exceptions by throwing an
     * ErrorException
     *
     * @return void
     */
    public static function errorHandler($severity, $message, $file, $line) {

        if (!error_reporting() && $severity) {
            return;
        }
        throw new ErrorException($message, 0, $file, $line);
    }

    /**
     * Exception Handler
     *
     * @return void
     * @throws Exception
     */
    public static function exceptionHandler($exception) {

        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }

        http_response_code($code);

        $error = true;

        if ($error) {
            echo "<h1>Fatal Error</h1>";
            echo "<p>Uncaught exception: " . get_class($exception) . "</p>";
            echo "<p>Message: " . $exception->getMessage() . "</p>";
            echo "<p>Stack Trace: " . $exception->getTraceAsString() . "</p>";
            echo "<p>Thrown in " . $exception->getFile() . " on line " . $exception->getLine() . "</p>";
        } else {
            $errorLog = LOG_DIR . "/" . date("m-d-Y H:i:s") . ".txt";
            ini_set('error_log', $errorLog);
            $message = "Uncaught exception: " . get_class($exception);
            $message .= "with message " . $exception->getMessage();
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in " . $exception->getFile() . " on line " . $exception->getLine();

            error_log($message);

            echo (new BaseView)->getTemplate("error/{$code}.html.twig", ["error_message" => $message]);
        }
    }
}