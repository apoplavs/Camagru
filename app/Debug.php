<?php

/**
* Only for debugging
*/
class Debug
{

    /**
     * print_r  function for debug
     * @param $variable
     * @param null $var_name
     * @param null $line
     * @param null $method
     * @param null $class
     */
    public static function dd($variable, $var_name = null, $line = null, $method = null, $class = null) {
	    if (DEBUG) {
            echo "<pre>";
            if ($var_name) {
                echo $var_name . " = ";
            }
            print_r($variable);
            if ($line) {
                echo "</br>LINE='" . $line .  "'";
            }
            if ($method) {
                echo " METHOD='" . $method .  "'";
            }
            if ($class) {
                echo " CLASS='" . $class .  "'";
            }
            echo "</pre>";
            echo "</br>";
        }

	}

    /**
     * var_dump  function for debug
     * @param $variable
     * @param null $var_name
     * @param null $line
     * @param null $method
     * @param null $class
     */
    public static function vd($variable, $var_name = null, $line = null, $method = null, $class = null) {
        if (DEBUG) {
            echo "<pre>";
            if ($var_name) {
                echo $var_name . " = ";
            }
            var_dump($variable);
            if ($line) {
                echo "</br>LINE='" . $line .  "'";
            }
            if ($method) {
                echo " METHOD='" . $method .  "'";
            }
            if ($class) {
                echo " CLASS='" . $class .  "'";
            }
            echo "</pre>";
            echo "</br>";
        }

    }
}