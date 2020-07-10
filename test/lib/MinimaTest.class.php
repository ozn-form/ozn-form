<?php

class MinimaTest
{

    function __construct()
    {
    }

    public function setUp()
    {
    }


    public function run()
    {

        $this->setUp();

        foreach ( get_class_methods(static::class) as $method) {
            if(preg_match("/^test/", $method))
            {
                $this->$method();
            }
        };
    }

    public function assertEquals($expect, $value)
    {
        $bt     = debug_backtrace();
        $method = $bt[1]['function'];
        $line   = $bt[0]['line'];

        if($expect === $value) {
            echo '.';
        } else {
            echo "\n\e[0;31m$line: $method Failure:\n-- expect[$expect]\n-- get[$value]\033[0m\n";
        }
    }
}